<?php
include("../includes/auth.php");
include("../includes/db.php");

// Always fetch admin first
$adminQuery = $conn->query("SELECT * FROM users WHERE role='admin' LIMIT 1");
$admin = $adminQuery->fetch_assoc();
$admin_id = $admin ? $admin['id'] : null;

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_settings"])) {
  $username = $_POST['username'];
  $mobile   = $_POST['mobile'];
  $dob      = $_POST['dob'];

  // Handle password update with old password verification
  if (!empty($_POST['old_password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
    if (empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
      $error = "All password fields are required to change password!";
    } else {
      $old_password     = $_POST['old_password'];
      $new_password     = $_POST['new_password'];
      $confirm_password = $_POST['confirm_password'];

      // Verify old password
      if (password_verify($old_password, $admin['password'])) {
        if ($new_password === $confirm_password) {
          $hashed = password_hash($new_password, PASSWORD_DEFAULT);
          $stmt = $conn->prepare("UPDATE users SET username=?, mobile=?, dob=?, password=? WHERE id=? AND role='admin'");
          $stmt->bind_param("ssssi", $username, $mobile, $dob, $hashed, $admin_id);
        } else {
          $error = "New passwords do not match!";
        }
      } else {
        $error = "Old password is incorrect!";
      }
    }
  } else {
    // Update everything except password
    $stmt = $conn->prepare("UPDATE users SET username=?, mobile=?, dob=? WHERE id=? AND role='admin'");
    $stmt->bind_param("sssi", $username, $mobile, $dob, $admin_id);
  }

  if (!isset($error)) {
    $stmt->execute();
    $success = "Settings updated successfully!";

    // Re-fetch after update
    $adminQuery = $conn->query("SELECT * FROM users WHERE role='admin' LIMIT 1");
    $admin = $adminQuery->fetch_assoc();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Settings | CoreTech</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex">
    <!-- Sidebar -->
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
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-address-book"></i> Contact Info</a>
        <a href="settings.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <!-- Main -->
    <main class="ml-64 flex-1 p-10">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Settings</h1>

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
            <label class="block mb-1 font-semibold">Role</label>
            <input type="text" value="<?php echo htmlspecialchars($admin['role'] ?? ''); ?>" class="w-full border p-2 rounded bg-gray-100 text-gray-600" readonly>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>" class="w-full border p-2 rounded" required>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Mobile</label>
            <input type="text" name="mobile" value="<?php echo htmlspecialchars($admin['mobile'] ?? ''); ?>" class="w-full border p-2 rounded" required>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Date of Birth</label>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($admin['dob'] ?? ''); ?>" class="w-full border p-2 rounded">
          </div>

          <hr class="my-2">

          <div>
            <label class="block mb-1 font-semibold">Old Password</label>
            <input type="password" name="old_password" class="w-full border p-2 rounded" autocomplete="current-password">
          </div>

          <div>
            <label class="block mb-1 font-semibold">New Password</label>
            <input type="password" name="new_password" class="w-full border p-2 rounded" autocomplete="new-password">
          </div>

          <div>
            <label class="block mb-1 font-semibold">Confirm New Password</label>
            <input type="password" name="confirm_password" class="w-full border p-2 rounded" autocomplete="new-password">
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