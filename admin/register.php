<?php
include("../includes/db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $mobile   = $_POST['mobile'];
    $dob      = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $invite_code = $_POST['invitation_code'];
    $stmt = $conn->prepare("SELECT * FROM invitation_codes WHERE code=? AND used=0");
    $stmt->bind_param("s", $invite_code);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO users (username, mobile, dob, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $mobile, $dob, $password);
        if ($stmt->execute()) {
            $conn->query("UPDATE invitation_codes SET used=1 WHERE code='$invite_code'");
            $success = "Registration successful! You can now login.";
        } else {
            $error = "Username already exists.";
        }
    } else {
        $error = "Invalid or already used invitation code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f0f9ff; }
    </style>
</head>
<body class="bg-blue-50">
    <div class="min-h-screen py-12 px-4 flex items-center justify-center">
        <div class="max-w-2xl w-full bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <a href="/index.php" class="mr-2 text-gray-800 hover:text-blue-600">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>

                <div class="text-center mb-6">
                    <i class="fas fa-key text-5xl text-black mb-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Admin Registration</h2>
                    <p class="text-gray-600">Create your administrator account</p>
                </div>

                <?php if (isset($success)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= $success ?></div>
                <?php elseif (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $error ?></div>
                <?php endif; ?>

                <form action="register.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1" for="username">Username</label>
                            <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1" for="mobile">Mobile</label>
                            <input type="text" id="mobile" name="mobile" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1" for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1" for="invitation_code">Invitation Code</label>
                            <input type="text" id="invitation_code" name="invitation_code" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1" for="password">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Register
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">Already registered? <a href="login.php" class="text-blue-600 hover:underline">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>