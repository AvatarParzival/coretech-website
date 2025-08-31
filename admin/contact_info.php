<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_contact"])) {
  $location = $_POST['location'];
  $phone = $_POST['phone'];
  $email1 = $_POST['email1'];
  $email2 = $_POST['email2'];
  $hours = $_POST['hours'];

  $stmt = $conn->prepare("UPDATE contact_info SET location=?, phone=?, email1=?, email2=?, hours=? WHERE id=1");
  $stmt->bind_param("sssss", $location, $phone, $email1, $email2, $hours);
  $stmt->execute();

  header("Location: contact_info.php");
  exit;
}

$info = $conn->query("SELECT * FROM contact_info WHERE id=1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Info | CoreTech Admin</title>
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
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-address-book"></i> Contact Info</a>
        <a href="settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="ml-64 flex-1 p-10">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Contact Information</h1>

      <div class="bg-white p-6 rounded-xl shadow">
        <form method="post" class="grid grid-cols-1 gap-6">
          <input type="hidden" name="update_contact" value="1">

          <div>
            <label class="block mb-1 font-semibold">Location</label>
            <textarea name="location" class="w-full border p-2 rounded" required><?php echo $info['location']; ?></textarea>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Phone Number</label>
            <input type="text" name="phone" value="<?php echo $info['phone']; ?>" class="w-full border p-2 rounded" required>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Email Address 1</label>
            <input type="email" name="email1" value="<?php echo $info['email1']; ?>" class="w-full border p-2 rounded" required>
          </div>

          <div>
            <label class="block mb-1 font-semibold">Email Address 2</label>
            <input type="email" name="email2" value="<?php echo $info['email2']; ?>" class="w-full border p-2 rounded">
          </div>

          <div>
            <label class="block mb-1 font-semibold">Working Hours</label>
            <textarea name="hours" class="w-full border p-2 rounded" required><?php echo $info['hours']; ?></textarea>
          </div>

          <div class="flex justify-end mt-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Info</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
