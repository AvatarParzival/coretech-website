<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_member"])) {
  $name = $_POST['name'];
  $role = $_POST['role'];
  $linkedin = $_POST['linkedin'];
  $website = $_POST['website'];

  if (!empty($linkedin) && !preg_match("~^(http|https)://~", $linkedin)) {
    $linkedin = "https://" . ltrim($linkedin, "/");
  }
  if (!empty($website) && !preg_match("~^(http|https)://~", $website)) {
    $website = "https://" . ltrim($website, "/");
  }

  $image = "";
  if (!empty($_FILES['image']['name'])) {
    $targetDir = "../assets/images";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $image = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
  }

  $stmt = $conn->prepare("INSERT INTO team (name, role, linkedin, website, image) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $role, $linkedin, $website, $image);
  $stmt->execute();
  header("Location: team.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_member"])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $role = $_POST['role'];
  $linkedin = $_POST['linkedin'];
  $website = $_POST['website'];

  if (!empty($linkedin) && !preg_match("~^(http|https)://~", $linkedin)) {
    $linkedin = "https://" . ltrim($linkedin, "/");
  }
  if (!empty($website) && !preg_match("~^(http|https)://~", $website)) {
    $website = "https://" . ltrim($website, "/");
  }

  if (!empty($_FILES['image']['name'])) {
    $targetDir = "../assets/images/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $image = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    $stmt = $conn->prepare("UPDATE team SET name=?, role=?, linkedin=?, website=?, image=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $role, $linkedin, $website, $image, $id);
  } else {
    $stmt = $conn->prepare("UPDATE team SET name=?, role=?, linkedin=?, website=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $role, $linkedin, $website, $id);
  }

  $stmt->execute();
  header("Location: team.php");
  exit;
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM team WHERE id=$id");
  header("Location: team.php");
  exit;
}

$members = $conn->query("SELECT * FROM team ORDER BY id DESC");
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
        <a href="portfolio.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-briefcase"></i> Portfolio</a>
        <a href="team.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-users"></i> Team</a>
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-address-book"></i> Contact Info</a>
        <a href="settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="ml-64 flex-1 p-10">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Team</h1>
        <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          <i class="fa-solid fa-plus"></i> Add Member
        </button>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2">Photo</th>
              <th class="py-2">Name</th>
              <th class="py-2">Role</th>
              <th class="py-2 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($m = $members->fetch_assoc()): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2">
                <?php if($m['image']): ?>
                  <img src="../assets/images/<?php echo $m['image']; ?>" class="h-12 w-12 rounded-full object-cover">
                <?php else: ?>
                  <span class="text-gray-400">No Photo</span>
                <?php endif; ?>
              </td>
              <td class="py-2 font-semibold"><?php echo $m['name']; ?></td>
              <td class="py-2"><?php echo $m['role']; ?></td>
              <td class="py-2 flex justify-center space-x-2">
                <button onclick="openViewModal('<?php echo addslashes($m['name']); ?>', '<?php echo addslashes($m['role']); ?>', '<?php echo $m['linkedin']; ?>', '<?php echo $m['website']; ?>', '<?php echo $m['image']; ?>')" 
                        class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white transition">
                  <i class="fa-solid fa-eye"></i> View
                </button>
                <button onclick="openEditModal(<?php echo $m['id']; ?>, '<?php echo addslashes($m['name']); ?>', '<?php echo addslashes($m['role']); ?>', '<?php echo $m['linkedin']; ?>', '<?php echo $m['website']; ?>', '<?php echo $m['image']; ?>')" 
                        class="px-3 py-1.5 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                  <i class="fa-solid fa-edit"></i> Edit
                </button>
                <a href="?delete=<?php echo $m['id']; ?>" onclick="return confirm('Delete this member?')" 
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
      <h2 class="text-xl font-bold mb-4">Add New Member</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="add_member" value="1">
        <div class="mb-3"><label>Name</label><input type="text" name="name" class="w-full border p-2 rounded" required></div>
        <div class="mb-3"><label>Role</label><input type="text" name="role" class="w-full border p-2 rounded" required></div>
        <div class="mb-3"><label>LinkedIn</label><input type="text" name="linkedin" placeholder="linkedin.com/in/username" class="w-full border p-2 rounded"></div>
        <div class="mb-3"><label>Website</label><input type="text" name="website" placeholder="coretechio.com" class="w-full border p-2 rounded"></div>
        <div class="mb-3"><label>Photo</label>
          <input type="file" name="image" id="add_image" accept="image/*" class="w-full border p-2 rounded" required>
          <img id="add_preview" class="mt-3 hidden w-32 h-32 object-cover rounded-full border" />
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
      <h2 class="text-xl font-bold mb-4">Edit Member</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="edit_member" value="1">
        <input type="hidden" id="edit_id" name="id">
        <div class="mb-3"><label>Name</label><input type="text" id="edit_name" name="name" class="w-full border p-2 rounded" required></div>
        <div class="mb-3"><label>Role</label><input type="text" id="edit_role" name="role" class="w-full border p-2 rounded" required></div>
        <div class="mb-3"><label>LinkedIn</label><input type="text" id="edit_linkedin" name="linkedin" class="w-full border p-2 rounded"></div>
        <div class="mb-3"><label>Website</label><input type="text" id="edit_website" name="website" class="w-full border p-2 rounded"></div>
        <div class="mb-3"><label>Photo (optional)</label>
          <input type="file" name="image" id="edit_image" accept="image/*" class="w-full border p-2 rounded">
          <img id="edit_preview" class="mt-3 hidden w-32 h-32 object-cover rounded-full border" />
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
      <button onclick="closeViewModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
      <img id="view_image" class="w-24 h-24 object-cover rounded-full mx-auto mb-4" src="">
      <h2 id="view_name" class="text-2xl font-bold text-center"></h2>
      <p id="view_role" class="text-gray-600 text-center mb-3"></p>
      <div class="flex justify-center gap-4">
        <a id="view_linkedin" href="#" target="_blank" class="text-blue-600 hover:text-blue-800"><i class="fa-brands fa-linkedin text-2xl"></i></a>
        <a id="view_website" href="#" target="_blank" class="text-gray-600 hover:text-gray-900"><i class="fa-solid fa-globe text-2xl"></i></a>
      </div>
    </div>
  </div>

  <script>

    document.getElementById("add_image").addEventListener("change", function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          const preview = document.getElementById("add_preview");
          preview.src = ev.target.result;
          preview.classList.remove("hidden");
        }
        reader.readAsDataURL(file);
      }
    });

    document.getElementById("edit_image").addEventListener("change", function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          const preview = document.getElementById("edit_preview");
          preview.src = ev.target.result;
          preview.classList.remove("hidden");
        }
        reader.readAsDataURL(file);
      }
    });

    function openEditModal(id, name, role, linkedin, website, image) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_name').value = name;
      document.getElementById('edit_role').value = role;
      document.getElementById('edit_linkedin').value = linkedin;
      document.getElementById('edit_website').value = website;

      const preview = document.getElementById("edit_preview");
      if (image) {
        preview.src = "../assets/images/" + image;
        preview.classList.remove("hidden");
      } else {
        preview.classList.add("hidden");
      }

      document.getElementById('editModal').classList.remove('hidden');
    }

    function openViewModal(name, role, linkedin, website, image) {
      document.getElementById('view_name').innerText = name;
      document.getElementById('view_role').innerText = role;
      document.getElementById('view_image').src = image ? "../assets/images/" + image : "";
      document.getElementById('view_linkedin').style.display = linkedin ? "inline-block" : "none";
      document.getElementById('view_linkedin').href = linkedin;
      document.getElementById('view_website').style.display = website ? "inline-block" : "none";
      document.getElementById('view_website').href = website;
      document.getElementById('viewModal').classList.remove('hidden');
    }

    function closeViewModal() {
      document.getElementById('viewModal').classList.add('hidden');
    }

    document.getElementById('viewModal').addEventListener('click', function(e) {
      if (e.target === this) closeViewModal();
    });
  </script>
</body>
</html>