<?php
include("../includes/auth.php");
include("../includes/db.php");

$messages = $conn->query("SELECT * FROM messages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Messages | CoreTech Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex">
    <aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white h-screen p-6 fixed">
      <h2 class="text-2xl font-bold mb-8 flex items-center gap-2">
        <i class="fas fa-key"></i> CoreTech Admin
      </h2>
      <nav class="space-y-4">
        <a href="dashboard.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-home"></i> Dashboard</a>
        <a href="site_settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fa-solid fa-sliders-h"></i> Site</a>
        <a href="services.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fas fa-cogs"></i> Services</a>
        <a href="portfolio.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fas fa-briefcase"></i> Portfolio</a>
        <a href="team.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fas fa-users"></i> Team</a>
        <a href="stats.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fas fa-chart-bar"></i> Stats</a>
        <a href="contact_info.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fas fa-address-book"></i> Contact Info</a>
        <a href="settings.php" class="flex items-center gap-3 p-2 rounded hover:bg-blue-600"><i class="fas fa-sliders-h"></i> Settings</a>
        <a href="messages.php" class="flex items-center gap-3 p-2 rounded bg-blue-600"><i class="fas fa-envelope"></i> Messages</a>
        <a href="logout.php" class="flex items-center gap-3 p-2 rounded hover:bg-red-600"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="ml-64 flex-1 p-10">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Messages</h1>

      <div class="bg-white rounded-xl shadow p-6">
        <?php if ($messages->num_rows > 0): ?>
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
              <?php while($msg = $messages->fetch_assoc()): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="py-2 font-semibold"><?php echo htmlspecialchars($msg['name']); ?></td>
                <td class="py-2 text-blue-600"><a href="mailto:<?php echo $msg['email']; ?>"><?php echo $msg['email']; ?></a></td>
                <td class="py-2"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                <td class="py-2 text-sm text-gray-500"><?php echo $msg['date']; ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-gray-500">No messages yet.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>
</html>
