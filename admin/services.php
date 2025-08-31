<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_service"])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $stmt = $conn->prepare("INSERT INTO services (title, description) VALUES (?, ?)");
  $stmt->bind_param("ss", $title, $description);
  $stmt->execute();
  header("Location: services.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_service"])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $stmt = $conn->prepare("UPDATE services SET title=?, description=? WHERE id=?");
  $stmt->bind_param("ssi", $title, $description, $id);
  $stmt->execute();
  header("Location: services.php");
  exit;
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM services WHERE id=$id");
  header("Location: services.php");
  exit;
}

$services = $conn->query("SELECT * FROM services ORDER BY id DESC");
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
        <a href="services.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-cogs"></i> Services</a>
        <a href="portfolio.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-briefcase"></i> Portfolio</a>
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
        <h1 class="text-3xl font-bold text-gray-800">Manage Services</h1>
        <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          <i class="fas fa-plus"></i> Add Service
        </button>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2">Title</th>
              <th class="py-2">Description</th>
              <th class="py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($s = $services->fetch_assoc()): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2 font-semibold"><?php echo $s['title']; ?></td>
              <td class="py-2"><?php echo substr($s['description'],0,80)."…"; ?></td>
<td class="py-2 flex space-x-2">
  <button 
    onclick="openViewModal('<?php echo addslashes($s['title']); ?>', '<?php echo addslashes($s['description']); ?>')" 
    class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white transition"
    title="View Service">
    <i class="fas fa-eye"></i> View
  </button>

  <button 
    onclick="openEditModal(<?php echo $s['id']; ?>, '<?php echo addslashes($s['title']); ?>', '<?php echo addslashes($s['description']); ?>')" 
    class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition"
    title="Edit Service">
    <i class="fas fa-edit"></i> Edit
  </button>

  <a 
    href="?delete=<?php echo $s['id']; ?>" 
    onclick="return confirm('Delete this service?')" 
    class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition"
    title="Delete Service">
    <i class="fas fa-trash"></i> Delete
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
      <h2 class="text-xl font-bold mb-4">Add New Service</h2>
      <form method="post">
        <input type="hidden" name="add_service" value="1">
        <div class="mb-3">
          <label>Title</label>
          <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" rows="4" class="w-full border p-2 rounded" required></textarea>
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
      <h2 class="text-xl font-bold mb-4">Edit Service</h2>
      <form method="post">
        <input type="hidden" name="edit_service" value="1">
        <input type="hidden" id="edit_id" name="id">
        <div class="mb-3">
          <label>Title</label>
          <input type="text" id="edit_title" name="title" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
          <label>Description</label>
          <textarea id="edit_description" name="description" rows="4" class="w-full border p-2 rounded" required></textarea>
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
    
<button 
  onclick="closeViewModal()" 
  class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition"
  title="Close">
  <i class="fa-solid fa-xmark text-2xl"></i>
</button>

    <h2 id="view_title" class="text-2xl font-bold mb-4"></h2>
    <p id="view_description" class="text-gray-700 whitespace-pre-line"></p>
  </div>
</div>


  <script>
    function openEditModal(id, title, description) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_title').value = title;
      document.getElementById('edit_description').value = description;
      document.getElementById('editModal').classList.remove('hidden');
    }

  function openViewModal(title, description) {
    document.getElementById('view_title').innerText = title;
    document.getElementById('view_description').innerText = description;
    document.getElementById('viewModal').classList.remove('hidden');
  }

  function closeViewModal() {
    document.getElementById('viewModal').classList.add('hidden');
  }

  document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeViewModal();
    }
  });
  </script>
</body>
</html>