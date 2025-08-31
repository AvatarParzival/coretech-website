<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_project"])) {
  $project_name = $_POST['project_name'];
  $description = $_POST['description'];

  $image = "";
  if (!empty($_FILES['image']['name'])) {
    $targetDir = "../assets/images/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $image = microtime(true) . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
  }

  $stmt = $conn->prepare("INSERT INTO portfolio (project_name, description, image) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $project_name, $description, $image);
  $stmt->execute();
  header("Location: portfolio.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_project"])) {
  $id = $_POST['id'];
  $project_name = $_POST['project_name'];
  $description = $_POST['description'];

  if (!empty($_FILES['image']['name'])) {
    $targetDir = "../assets/images/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $image = microtime(true) . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    $stmt = $conn->prepare("UPDATE portfolio SET project_name=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $project_name, $description, $image, $id);
  } else {
    $stmt = $conn->prepare("UPDATE portfolio SET project_name=?, description=? WHERE id=?");
    $stmt->bind_param("ssi", $project_name, $description, $id);
  }

  $stmt->execute();
  header("Location: portfolio.php");
  exit;
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM portfolio WHERE id=$id");
  header("Location: portfolio.php");
  exit;
}

$projects = $conn->query("SELECT * FROM portfolio ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stats | CoreTech Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex">
    <aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white h-screen p-6 fixed">
      <h2 class="text-2xl font-bold mb-8 flex items-center gap-2">
        <i class="fa-solid fa-key"></i> CoreTech Admin
      </h2>
      <nav class="space-y-4">
        <a href="dashboard.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-home"></i> Dashboard</a>
        <a href="site_settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Site</a>
        <a href="services.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-cogs"></i> Services</a>
        <a href="portfolio.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-briefcase"></i> Portfolio</a>
        <a href="team.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-users"></i> Team</a>
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-address-book"></i> Contact Info</a>
        <a href="settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="ml-64 flex-1 p-10">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Portfolio</h1>
        <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          <i class="fa-solid fa-plus"></i> Add Project
        </button>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2">Thumbnail</th>
              <th class="py-2">Project</th>
              <th class="py-2">Description</th>
              <th class="py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($p = $projects->fetch_assoc()): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2">
                <?php if($p['image']): ?>
                  <img src="../assets/images/<?php echo $p['image']; ?>" class="h-12 w-12 rounded object-cover">
                <?php else: ?>
                  <span class="text-gray-400">No Image</span>
                <?php endif; ?>
              </td>
              <td class="py-2 font-semibold"><?php echo $p['project_name']; ?></td>
              <td class="py-2"><?php echo substr($p['description'],0,60)."…"; ?></td>
              <td class="py-2 flex space-x-2">
                <button onclick="openViewModal('<?php echo addslashes($p['project_name']); ?>', '<?php echo addslashes($p['description']); ?>', '<?php echo $p['image']; ?>')" 
                        class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white transition">
                  <i class="fa-solid fa-eye"></i> View
                </button>
                <button onclick="openEditModal(<?php echo $p['id']; ?>, '<?php echo addslashes($p['project_name']); ?>', '<?php echo addslashes($p['description']); ?>')" 
                        class="px-3 py-1.5 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                  <i class="fa-solid fa-edit"></i> Edit
                </button>
                <a href="?delete=<?php echo $p['id']; ?>" onclick="return confirm('Delete this project?')" 
                   class="px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition">
                  <i class="fa-solid fa-trash"></i> Delete
                </a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Add New Project</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="add_project" value="1">
        <div class="mb-3">
          <label>Project Name</label>
          <input type="text" name="project_name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" rows="4" class="w-full border p-2 rounded" required></textarea>
        </div>
<div class="mb-3">
  <label>Thumbnail</label>
  <input type="file" name="image" id="add_image" class="w-full border p-2 rounded" accept="image/*" required>
  <img id="add_preview" class="mt-3 hidden w-full h-40 object-cover rounded border" />
</div>

        <div class="flex justify-end space-x-2">
          <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </div>
      </form>
    </div>
  </div>

  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Edit Project</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="edit_project" value="1">
        <input type="hidden" id="edit_id" name="id">
        <div class="mb-3">
          <label>Project Name</label>
          <input type="text" id="edit_name" name="project_name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
          <label>Description</label>
          <textarea id="edit_description" name="description" rows="4" class="w-full border p-2 rounded" required></textarea>
        </div>
<div class="mb-3">
  <label>Thumbnail (replace existing)</label>
  <input type="file" name="image" class="w-full border p-2 rounded" accept="image/*">
  <img id="edit_preview" class="mt-3 hidden w-full h-40 object-cover rounded border" />
</div>

        <div class="flex justify-end space-x-2">
          <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </div>
      </form>
    </div>
  </div>

  <div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button onclick="closeViewModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
      <img id="view_image" class="w-full h-48 object-cover rounded mb-4" src="">
      <h2 id="view_title" class="text-2xl font-bold mb-4"></h2>
      <p id="view_description" class="text-gray-700 whitespace-pre-line"></p>
    </div>
  </div>

  <script>
    function openEditModal(id, name, description) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_name').value = name;
      document.getElementById('edit_description').value = description;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function openViewModal(name, description, image) {
      document.getElementById('view_title').innerText = name;
      document.getElementById('view_description').innerText = description;
      document.getElementById('view_image').src = image ? "../uploads/portfolio/" + image : "";
      document.getElementById('viewModal').classList.remove('hidden');
    }

    function closeViewModal() {
      document.getElementById('viewModal').classList.add('hidden');
    }

    document.getElementById('viewModal').addEventListener('click', function(e) {
      if (e.target === this) closeViewModal();
    });

document.getElementById("add_image").addEventListener("change", function(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview = document.getElementById("add_preview");
      preview.src = e.target.result;
      preview.classList.remove("hidden");
    }
    reader.readAsDataURL(file);
  }
});

document.getElementById("editModal").addEventListener("change", function(event) {
  if (event.target.name === "image") {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        let preview = document.getElementById("edit_preview");
        if (!preview) {
          preview = document.createElement("img");
          preview.id = "edit_preview";
          preview.className = "mt-3 w-full h-40 object-cover rounded border";
          event.target.parentNode.appendChild(preview);
        }
        preview.src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  }
});
  </script>
</body>
</html>
