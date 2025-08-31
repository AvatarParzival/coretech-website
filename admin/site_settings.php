<?php
include("../includes/auth.php");
include("../includes/db.php");
$settingsQuery = $conn->query("SELECT * FROM settings WHERE id=1");
$siteSettings = $settingsQuery->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_settings"])) {
  $facebook   = $_POST['facebook'];
  $twitter    = $_POST['twitter'];
  $linkedin   = $_POST['linkedin'];
  $instagram  = $_POST['instagram'];
  $headline   = $_POST['headline'];
  $subheadline= $_POST['subheadline'];

  $stmt = $conn->prepare("UPDATE settings SET facebook=?, twitter=?, linkedin=?, instagram=?, headline=?, subheadline=? WHERE id=1");
  $stmt->bind_param("ssssss", $facebook, $twitter, $linkedin, $instagram, $headline, $subheadline);
  if ($stmt->execute()) {
    $success = "Site settings updated successfully!";
    $settingsQuery = $conn->query("SELECT * FROM settings WHERE id=1");
    $siteSettings = $settingsQuery->fetch_assoc();
  } else {
    $error = "Failed to update settings.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Site Settings | CoreTech</title>
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
        <a href="site_settings.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Site</a>
        <a href="services.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-cogs"></i> Services</a>
        <a href="portfolio.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-briefcase"></i> Portfolio</a>
        <a href="team.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-users"></i> Team</a>
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-address-book"></i> Contact Info</a>
        <a href="site_settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="ml-64 flex-1 p-10">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Site Settings</h1>

      <?php if(isset($success)): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"><?php echo $success; ?></div>
      <?php endif; ?>
      <?php if(isset($error)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?php echo $error; ?></div>
      <?php endif; ?>

      <div class="bg-white p-6 rounded-xl shadow">
        <form method="post" class="grid grid-cols-1 gap-6">
          <input type="hidden" name="update_settings" value="1">

          <div>
            <label class="block mb-1 font-semibold">Facebook</label>
            <input type="text" name="facebook" value="<?php echo htmlspecialchars($siteSettings['facebook'] ?? ''); ?>" class="w-full border p-2 rounded">
          </div>

          <div>
            <label class="block mb-1 font-semibold">Twitter</label>
            <input type="text" name="twitter" value="<?php echo htmlspecialchars($siteSettings['twitter'] ?? ''); ?>" class="w-full border p-2 rounded">
          </div>

          <div>
            <label class="block mb-1 font-semibold">LinkedIn</label>
            <input type="text" name="linkedin" value="<?php echo htmlspecialchars($siteSettings['linkedin'] ?? ''); ?>" class="w-full border p-2 rounded">
          </div>

          <div>
            <label class="block mb-1 font-semibold">Instagram</label>
            <input type="text" name="instagram" value="<?php echo htmlspecialchars($siteSettings['instagram'] ?? ''); ?>" class="w-full border p-2 rounded">
          </div>

          <hr class="my-2">

          <div>
            <label class="block mb-1 font-semibold">Hero Headline</label>
            <input type="text" name="headline" value="<?php echo htmlspecialchars($siteSettings['headline'] ?? ''); ?>" class="w-full border p-2 rounded" required>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Hero Sub-Headline</label>
            <textarea name="subheadline" rows="3" class="w-full border p-2 rounded" required><?php echo htmlspecialchars($siteSettings['subheadline'] ?? ''); ?></textarea>
          </div>

          <div class="flex justify-end mt-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Settings</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
