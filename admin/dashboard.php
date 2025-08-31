<?php
include("../includes/auth.php");
include("../includes/db.php");

$stats = [
  "services" => $conn->query("SELECT COUNT(*) AS c FROM services")->fetch_assoc()['c'],
  "portfolio" => $conn->query("SELECT COUNT(*) AS c FROM portfolio")->fetch_assoc()['c'],
  "team" => $conn->query("SELECT COUNT(*) AS c FROM team")->fetch_assoc()['c'],
  "messages" => $conn->query("SELECT COUNT(*) AS c FROM messages")->fetch_assoc()['c'],
];
$messages = $conn->query("SELECT * FROM messages ORDER BY date DESC LIMIT 5");
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
        <a href="dashboard.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fa-solid fa-home"></i> Dashboard</a>
        <a href="site_settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Site</a>
        <a href="services.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-cogs"></i> Services</a>
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
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Welcome, <?php echo $_SESSION['username']; ?> 👋</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
          <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full"><i class="fas fa-cogs text-xl"></i></div>
          <div><h3 class="text-lg font-semibold">Services</h3><p class="text-2xl font-bold"><?php echo $stats['services']; ?></p></div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
          <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-full"><i class="fas fa-briefcase text-xl"></i></div>
          <div><h3 class="text-lg font-semibold">Portfolio</h3><p class="text-2xl font-bold"><?php echo $stats['portfolio']; ?></p></div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
          <div class="w-12 h-12 flex items-center justify-center bg-purple-100 text-purple-600 rounded-full"><i class="fas fa-users text-xl"></i></div>
          <div><h3 class="text-lg font-semibold">Team</h3><p class="text-2xl font-bold"><?php echo $stats['team']; ?></p></div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
          <div class="w-12 h-12 flex items-center justify-center bg-red-100 text-red-600 rounded-full"><i class="fas fa-envelope text-xl"></i></div>
          <div><h3 class="text-lg font-semibold">Messages</h3><p class="text-2xl font-bold"><?php echo $stats['messages']; ?></p></div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Recent Messages</h2>
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2">Name</th>
              <th class="py-2">Email</th>
              <th class="py-2">Message</th>
              <th class="py-2">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while($m = $messages->fetch_assoc()): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2"><?php echo $m['name']; ?></td>
              <td class="py-2"><?php echo $m['email']; ?></td>
              <td class="py-2"><?php echo substr($m['message'],0,40).'...'; ?></td>
              <td class="py-2"><?php echo $m['date']; ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
