<?php include("includes/db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CoreTech Innovations</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2563eb',
            secondary: '#1e40af',
            accent: '#3b82f6',
            dark: '#0f172a',
            light: '#f8fafc'
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
    .hero-bg {
      background: linear-gradient(rgba(15,23,42,0.9), rgba(15,23,42,0.9)),
                  url('https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?auto=format&fit=crop&w=2070&q=80');
      background-size: cover; background-position: center;
    }
    .service-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,.1),0 10px 10px -5px rgba(0,0,0,.04);}
    .portfolio-item { transition: all 0.3s ease; }
    .portfolio-item:hover { transform: scale(1.03); }
    .team-member:hover .member-overlay { opacity: 1; }
  </style>
</head>
<body class="bg-light text-dark">

<nav class="fixed w-full bg-white shadow-md z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-20 items-center">
      <div class="flex items-center">
        <i class="fas fa-microchip text-primary text-2xl mr-2"></i>
        <span class="text-xl font-bold text-dark">CoreTech<span class="text-primary">Innovations</span></span>
      </div>
      <div class="hidden md:block">
        <div class="ml-10 flex items-baseline space-x-8">
          <a href="#home" class="hover:text-primary">Home</a>
          <a href="#about" class="hover:text-primary">About</a>
          <a href="#services" class="hover:text-primary">Services</a>
          <a href="#portfolio" class="hover:text-primary">Portfolio</a>
          <a href="#contact" class="hover:text-primary">Contact</a>
          <a href="admin/login.php" class="text-primary font-semibold">Admin Login</a>
        </div>
      </div>
      <div class="md:hidden">
        <button id="mobile-menu-button"><i class="fas fa-bars text-2xl"></i></button>
      </div>
    </div>
  </div>

  <div id="mobile-menu" class="hidden md:hidden bg-white">
    <a href="#home" class="block px-3 py-2 hover:text-primary">Home</a>
    <a href="#about" class="block px-3 py-2 hover:text-primary">About</a>
    <a href="#services" class="block px-3 py-2 hover:text-primary">Services</a>
    <a href="#portfolio" class="block px-3 py-2 hover:text-primary">Portfolio</a>
    <a href="#contact" class="block px-3 py-2 hover:text-primary">Contact</a>
    <a href="admin/index.php" class="block px-3 py-2 text-primary font-semibold">Admin Login</a>
  </div>
</nav>

<section id="home" class="relative hero-bg pt-40 pb-32 text-white text-center">
  <?php
    $settings = $conn->query("SELECT * FROM settings WHERE id = 1")->fetch_assoc();
  ?>
  <h1 class="text-5xl font-bold">
    <?= htmlspecialchars($settings['headline'] ?? 'Transforming Vision into Reality') ?>
  </h1>
  <p class="mt-6 text-xl max-w-2xl mx-auto">
    <?= htmlspecialchars($settings['subheadline'] ?? 'We create innovative technology solutions that drive growth and transform industries.') ?>
  </p>
</section>

<section class="py-20 bg-gray-100">
  <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center px-4">
    <?php
      include("includes/db.php");
      $result = $conn->query("SELECT * FROM stats ORDER BY id ASC");
      $stats = [];
      while($row = $result->fetch_assoc()){
        $stats[$row['title']] = $row['value'];
      }
    ?>

    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-4">
        <i class="fas fa-trophy text-primary text-2xl"></i>
      </div>
      <h3 class="text-4xl font-bold text-primary"><?= $stats['Projects Completed'] ?? '0' ?>+</h3>
      <p class="text-gray-600 mt-2">Projects Completed</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-4">
        <i class="fas fa-smile text-primary text-2xl"></i>
      </div>
      <h3 class="text-4xl font-bold text-primary"><?= $stats['Client Satisfaction'] ?? '0' ?>%</h3>
      <p class="text-gray-600 mt-2">Client Satisfaction</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-4">
        <i class="fas fa-users text-primary text-2xl"></i>
      </div>
      <h3 class="text-4xl font-bold text-primary"><?= $stats['Team Members'] ?? '0' ?>+</h3>
      <p class="text-gray-600 mt-2">Team Members</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-4">
        <i class="fas fa-clock text-primary text-2xl"></i>
      </div>
      <h3 class="text-4xl font-bold text-primary"><?= $stats['Years Experience'] ?? '0' ?>+</h3>
      <p class="text-gray-600 mt-2">Years Experience</p>
    </div>

  </div>
</section>

<section id="services" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center">Our Services</h2>
    <div class="w-20 h-1 bg-primary mx-auto mt-4 mb-12"></div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
      $services = $conn->query("SELECT * FROM services");
      while($s = $services->fetch_assoc()){
        echo "
        <div class='service-card bg-light rounded-xl p-8 shadow-md'>
          <div class='w-16 h-16 bg-primary rounded-full flex items-center justify-center mb-6'>
            <i class='fas fa-cogs text-white text-2xl'></i>
          </div>
          <h3 class='text-2xl font-semibold mb-4'>{$s['title']}</h3>
          <p class='text-gray-600 mb-6'>{$s['description']}</p>
        </div>";
      }
      ?>
    </div>
  </div>
</section>

<section id="methodology" class="py-20 bg-light">
  <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">

    <div class="relative">
      <img src="/assests/images" 
           alt="Our Methodology" 
           class="rounded-2xl shadow-xl">
    </div>

    <div>
      <span class="bg-primary/10 text-primary px-4 py-1 rounded-full text-sm font-semibold tracking-wide">OUR METHODOLOGY</span>
      <h2 class="text-3xl md:text-4xl font-bold mt-4 mb-6 leading-snug">
        Delivering Excellence<br>
        Through Proven Processes
      </h2>
      <p class="text-gray-600 mb-8">
        Our structured approach ensures every project is built on a foundation of research, innovation, and execution excellence.
      </p>

      <ul class="space-y-6">
        <li class="flex items-start">
          <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold mr-4">1</div>
          <div>
            <h4 class="font-semibold text-lg">Discovery & Analysis</h4>
            <p class="text-gray-600">Deeply understanding business objectives, challenges, and requirements.</p>
          </div>
        </li>
        <li class="flex items-start">
          <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold mr-4">2</div>
          <div>
            <h4 class="font-semibold text-lg">Strategic Planning</h4>
            <p class="text-gray-600">Crafting a roadmap with clear milestones and measurable outcomes.</p>
          </div>
        </li>
        <li class="flex items-start">
          <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold mr-4">3</div>
          <div>
            <h4 class="font-semibold text-lg">Agile Development</h4>
            <p class="text-gray-600">Iterative sprints that ensure flexibility, speed, and continuous improvement.</p>
          </div>
        </li>
        <li class="flex items-start">
          <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold mr-4">4</div>
          <div>
            <h4 class="font-semibold text-lg">Quality Assurance</h4>
            <p class="text-gray-600">Rigorous testing at every stage to meet the highest standards.</p>
          </div>
        </li>
        <li class="flex items-start">
          <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary font-bold mr-4">5</div>
          <div>
            <h4 class="font-semibold text-lg">Deployment & Support</h4>
            <p class="text-gray-600">Seamless implementation with ongoing optimization and support.</p>
          </div>
        </li>
      </ul>

      <p class="mt-10 font-semibold text-dark text-lg">
        Trusted by <span class="text-primary">150+ businesses</span> worldwide.  
        <a href="#contact" class="text-primary hover:underline">Let’s discuss your project.</a>
      </p>
    </div>

  </div>
</section>

<section id="mvv" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-12">Our Values</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      <div class="p-8 bg-white rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
        <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-6">
          <i class="fas fa-bullseye text-blue-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-4">Our Mission</h3>
        <p class="text-gray-600">To empower businesses through innovative technology solutions that drive growth, efficiency, and competitive advantage in the digital age.</p>
      </div>

      <div class="p-8 bg-white rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
        <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-6">
          <i class="fas fa-eye text-blue-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-4">Our Vision</h3>
        <p class="text-gray-600">To be the most trusted technology partner for businesses worldwide, recognized for our commitment to excellence and client success.</p>
      </div>

      <div class="p-8 bg-white rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
        <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-blue-100 mb-6">
          <i class="fas fa-star text-blue-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-4">Our Values</h3>
        <p class="text-gray-600">Innovation, Integrity, Excellence, Collaboration, and Client-Centric Approach guide everything we do at CoreTech Innovations.</p>
      </div>

    </div>
  </div>
</section>

<section id="about" class="py-20 bg-light">
  <div class="max-w-7xl mx-auto px-4">

    <div class="text-center mb-12">
      <h2 class="text-4xl md:text-5xl font-bold text-dark">About Us</h2>
      <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
    </div>

    <div class="grid md:grid-cols-2 gap-12 items-center">
      <div>
        <h3 class="text-2xl md:text-3xl font-semibold mb-6 leading-snug text-dark">
          Trusted Technology Partner Since 2020
        </h3>

        <p class="text-gray-600 mb-8">
          CoreTech Innovations was founded with a simple goal: to help businesses leverage technology 
          to solve complex challenges and achieve their strategic objectives.
        </p>

        <div class="grid grid-cols-2 gap-6">
          <div class="p-4 bg-white rounded-lg shadow hover:shadow-md transition text-center">
            <i class="fas fa-trophy text-primary text-2xl mb-3"></i>
            <h4 class="font-semibold">Industry Recognition</h4>
            <p class="text-gray-600 text-sm">Award-winning innovation and service excellence.</p>
          </div>
          <div class="p-4 bg-white rounded-lg shadow hover:shadow-md transition text-center">
            <i class="fas fa-users text-primary text-2xl mb-3"></i>
            <h4 class="font-semibold">Expert Team</h4>
            <p class="text-gray-600 text-sm">50+ professionals with diverse technical expertise.</p>
          </div>
          <div class="p-4 bg-white rounded-lg shadow hover:shadow-md transition text-center">
            <i class="fas fa-globe text-primary text-2xl mb-3"></i>
            <h4 class="font-semibold">Global Reach</h4>
            <p class="text-gray-600 text-sm">Serving clients across 3 continents.</p>
          </div>
          <div class="p-4 bg-white rounded-lg shadow hover:shadow-md transition text-center">
            <i class="fas fa-cogs text-primary text-2xl mb-3"></i>
            <h4 class="font-semibold">Proven Methodology</h4>
            <p class="text-gray-600 text-sm">Agile processes ensuring quality and delivery.</p>
          </div>
        </div>
      </div>
      <div class="relative">
        <img src="assets/images/team-placeholder.jpg" alt="Our Team" class="rounded-2xl shadow-lg">
        <div class="absolute bottom-4 right-4 bg-primary text-white px-4 py-2 rounded-lg shadow-md font-semibold">
          5+ Years Experience
        </div>
      </div>
    </div>

  </div>
</section>

<section id="team" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center">Meet Our Experts</h2>
    <p class="text-gray-600 text-center max-w-2xl mx-auto mt-4">
      Our team of talented professionals brings diverse skills and experience to deliver exceptional results for our clients.
    </p>
    <div class="w-20 h-1 bg-primary mx-auto mt-4 mb-12"></div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      <?php
      $team = $conn->query("SELECT * FROM team");
      while($t = $team->fetch_assoc()){
        echo "
        <div class='team-member bg-white rounded-xl shadow-md overflow-hidden text-center p-6 transition hover:shadow-xl'>
          <img src='assets/images/{$t['image']}' alt='{$t['name']}' class='w-full h-64 object-cover rounded-lg'>
          <h4 class='text-xl font-semibold mt-4'>{$t['name']}</h4>
          <p class='text-primary mb-4'>{$t['role']}</p>
          <div class='flex justify-center gap-4'>
            
            <!-- LinkedIn -->
            <a href='{$t['linkedin']}' target='_blank' class='w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 hover:bg-blue-100 transition'>
              <i class='fab fa-linkedin-in text-blue-700 text-lg'></i>
            </a>
            
            <!-- Portfolio Website -->
            <a href='{$t['portfolio']}' target='_blank' class='w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 hover:bg-gray-300 transition'>
              <i class='fas fa-globe text-gray-800 text-lg'></i>
            </a>

          </div>
        </div>";
      }
      ?>
    </div>
  </div>
</section>

<section id="portfolio" class="py-20 bg-light">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center">Our Portfolio</h2>
    <div class="w-20 h-1 bg-primary mx-auto mt-4 mb-12"></div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
      $portfolio = $conn->query("SELECT * FROM portfolio");
      while($p = $portfolio->fetch_assoc()){
        echo "
        <div class='portfolio-item bg-white rounded-xl overflow-hidden shadow-md'>
          <div class='h-56 overflow-hidden'>
            <img src='assets/images/{$p['image']}' alt='{$p['project_name']}' class='w-full h-full object-cover hover:scale-110 transition'>
          </div>
          <div class='p-6'>
            <h3 class='text-xl font-semibold mb-2'>{$p['project_name']}</h3>
            <p class='text-gray-600 mb-4'>{$p['description']}</p>
          </div>
        </div>";
      }
      ?>
    </div>
  </div>
</section>

<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8 px-4">

    <div class="bg-light text-center p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-lightbulb text-white text-2xl"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2">Innovative Solutions</h3>
      <p class="text-gray-600">Cutting-edge technologies tailored to your needs.</p>
    </div>

    <div class="bg-light text-center p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-rocket text-white text-2xl"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2">Rapid Development</h3>
      <p class="text-gray-600">Fast delivery without compromising quality.</p>
    </div>

    <div class="bg-light text-center p-8 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300">
      <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-headset text-white text-2xl"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
      <p class="text-gray-600">We keep your systems running smoothly.</p>
    </div>

  </div>
</section>

<section id="contact" class="py-20 bg-light">
  <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row gap-12">
    <div class="lg:w-1/2">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contact_submit"])) {
        $name = $conn->real_escape_string($_POST["name"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $message = $conn->real_escape_string($_POST["message"]);
        if ($conn->query("INSERT INTO messages (name,email,message) VALUES ('$name','$email','$message')")) {
          echo "<div class='mb-4 p-3 bg-green-100 text-green-700 rounded'>Message sent successfully!</div>";
        } else {
          echo "<div class='mb-4 p-3 bg-red-100 text-red-700 rounded'>Error sending message.</div>";
        }
      }
      ?>
      <form method="POST" class="contact-form bg-white p-8 rounded-xl shadow-md">
        <div class="mb-6"><label class="block mb-2">Your Name</label><input type="text" name="name" required class="w-full px-4 py-3 border rounded-lg"></div>
        <div class="mb-6"><label class="block mb-2">Email Address</label><input type="email" name="email" required class="w-full px-4 py-3 border rounded-lg"></div>
        <div class="mb-6"><label class="block mb-2">Your Message</label><textarea name="message" rows="5" required class="w-full px-4 py-3 border rounded-lg"></textarea></div>
        <button type="submit" name="contact_submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg">Send Message</button>
      </form>
    </div>
<?php $info = $conn->query("SELECT * FROM contact_info WHERE id=1")->fetch_assoc(); ?>

<div class="lg:w-1/2 bg-white p-8 rounded-xl shadow-md">
  <h3 class="text-2xl font-semibold mb-6">Contact Information</h3>
  <div class="space-y-8">

    <div class="flex items-start">
      <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
        <i class="fas fa-map-marker-alt text-white"></i>
      </div>
      <div class="ml-4">
        <h4 class="font-semibold">Our Location</h4>
        <p class="text-gray-600"><?php echo nl2br($info['location']); ?></p>
      </div>
    </div>

    <div class="flex items-start">
      <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
        <i class="fas fa-phone-alt text-white"></i>
      </div>
      <div class="ml-4">
        <h4 class="font-semibold">Phone Number</h4>
        <p class="text-gray-600"><a href="tel:<?php echo $info['phone']; ?>" class="text-primary"><?php echo nl2br($info['phone']); ?></a></p>
      </div>
    </div>

    <div class="flex items-start">
      <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
        <i class="fas fa-envelope text-white"></i>
      </div>
      <div class="ml-4">
        <h4 class="font-semibold">Email Address</h4>
        <p class="text-gray-600">
          <a href="mailto:<?php echo $info['email1']; ?>" class="text-primary"><?php echo $info['email1']; ?></a><br>
          <a href="mailto:<?php echo $info['email2']; ?>" class="text-primary"><?php echo $info['email2']; ?></a>
        </p>
      </div>
    </div>

    <div class="flex items-start">
      <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
        <i class="fas fa-clock text-white"></i>
      </div>
      <div class="ml-4">
        <h4 class="font-semibold">Working Hours</h4>
        <p class="text-gray-600"><?php echo nl2br($info['hours']); ?></p>
      </div>
    </div>

  </div>
</div>

</section>

<footer class="bg-dark text-white pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

      <div>
        <h3 class="text-2xl font-bold mb-4">CoreTech Innovations</h3>
        <p class="text-gray-400 mb-6">Transforming vision into reality with innovative technology solutions for the digital age.</p>
        <div class="flex space-x-4">
          <?php
          $settings = $conn->query("SELECT * FROM settings WHERE id=1")->fetch_assoc();
          echo "
          <a href='{$settings['facebook']}' target='_blank' class='w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white'><i class='fab fa-facebook-f'></i></a>
          <a href='{$settings['twitter']}' target='_blank' class='w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white'><i class='fab fa-twitter'></i></a>
          <a href='{$settings['linkedin']}' target='_blank' class='w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white'><i class='fab fa-linkedin-in'></i></a>
          <a href='{$settings['instagram']}' target='_blank' class='w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white'><i class='fab fa-instagram'></i></a>
          ";
          ?>
        </div>
      </div>

      <div>
        <h3 class="text-xl font-bold mb-4">Quick Links</h3>
        <ul class="space-y-2 text-gray-400">
          <li><a href="#home" class="hover:text-primary">Home</a></li>
          <li><a href="#about" class="hover:text-primary">About</a></li>
          <li><a href="#services" class="hover:text-primary">Services</a></li>
          <li><a href="#portfolio" class="hover:text-primary">Portfolio</a></li>
          <li><a href="#contact" class="hover:text-primary">Contact</a></li>
        </ul>
      </div>

      <div>
        <h3 class="text-xl font-bold mb-4">Our Services</h3>
        <ul class="space-y-2 text-gray-400">
          <?php
          $services = $conn->query("SELECT * FROM services LIMIT 5"); 
          while($s = $services->fetch_assoc()){
            echo "<li><a href='#services' class='hover:text-primary'>{$s['title']}</a></li>";
          }
          ?>
        </ul>
      </div>

      <div>
        <h3 class="text-xl font-bold mb-4">Newsletter</h3>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subscribe"])) {
          $email = $conn->real_escape_string($_POST["email"]);
          if ($conn->query("INSERT IGNORE INTO subscribers (email) VALUES ('$email')")) {
            echo "<div class='mb-3 p-2 bg-green-100 text-green-700 rounded'>Subscribed successfully!</div>";
          } else {
            echo "<div class='mb-3 p-2 bg-red-100 text-red-700 rounded'>Subscription failed.</div>";
          }
        }
        ?>
        <form method="POST" class="flex">
          <input type="email" name="email" placeholder="Enter your email" required class="w-full px-4 py-2 rounded-l-lg text-dark">
          <button type="submit" name="subscribe" class="px-4 bg-primary text-white rounded-r-lg">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="mt-12 border-t border-gray-700 pt-6 text-center text-gray-400">
      <p>&copy; <?php echo date('Y'); ?> CoreTech Innovations. All rights reserved.</p>
    </div>
  </div>
</footer>


<script>
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');
  mobileMenuButton.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

  <!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

</body>
</html>
