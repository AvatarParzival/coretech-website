<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_stat"])) {
  $id = $_POST['id'];
  $value = $_POST['value'];

  $stmt = $conn->prepare("UPDATE stats SET value=? WHERE id=?");
  $stmt->bind_param("si", $value, $id);
  $stmt->execute();

  header("Location: stats.php");
  exit;
}

$result = $conn->query("SELECT * FROM stats ORDER BY id ASC");
$stats = [];
while($row = $result->fetch_assoc()){
  $stats[] = $row;
}

$icons = [
  "Projects Completed" => "fa-solid fa-trophy",
  "Client Satisfaction" => "fa-solid fa-smile",
  "Team Members" => "fa-solid fa-users",
  "Years Experience" => "fa-solid fa-clock"
];

$colors = [
  "Projects Completed" => "text-yellow-500",
  "Client Satisfaction" => "text-green-500",
  "Team Members" => "text-blue-500",
  "Years Experience" => "text-purple-500"
];
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
        <a href="team.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-users"></i> Team</a>
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-address-book"></i> Contact Info</a>
        <a href="settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="ml-64 flex-1 p-10">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Stats</h1>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <?php foreach ($stats as $s): 
          $icon = $icons[$s['title']] ?? "fa-solid fa-chart-pie";
          $color = $colors[$s['title']] ?? "text-blue-600";
        ?>
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <i class="<?php echo $icon; ?> <?php echo $color; ?> text-3xl mb-2"></i>
          <h3 class="text-2xl font-bold text-primary"><?php echo $s['value']; ?></h3>
          <p class="text-gray-600"><?php echo $s['title']; ?></p>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2">Title</th>
              <th class="py-2">Value</th>
              <th class="py-2 text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($stats as $s): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2 font-semibold"><?php echo $s['title']; ?></td>
              <td class="py-2"><?php echo $s['value']; ?></td>
              <td class="py-2 text-center">
                <button onclick="openEditModal(<?php echo $s['id']; ?>, '<?php echo addslashes($s['title']); ?>', '<?php echo addslashes($s['value']); ?>')" 
                        class="px-3 py-1.5 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                  <i class="fa-solid fa-edit"></i> Edit
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 id="edit_title" class="text-xl font-bold mb-4"></h2>
      <form method="post">
        <input type="hidden" name="update_stat" value="1">
        <input type="hidden" id="edit_id" name="id">
        <div class="mb-3">
          <label class="block mb-1">Value</label>
          <input type="text" id="edit_value" name="value" class="w-full border p-2 rounded" required>
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openEditModal(id, title, value) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_title').innerText = "Edit " + title;
      document.getElementById('edit_value').value = value;
      document.getElementById('editModal').classList.remove('hidden');
    }
  </script>
</body>
</html>