<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Ongeldige inloggegevens.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GlassAuth Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }
        .blob { position: absolute; filter: blur(80px); opacity: 0.6; z-index: -1; animation: float 10s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="fixed inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="blob bg-green-200 w-[500px] h-[500px] top-[-100px] left-[-100px] rounded-full mix-blend-multiply"></div>
        <div class="blob bg-blue-200 w-[400px] h-[400px] bottom-[-50px] right-[-50px] rounded-full mix-blend-multiply"></div>
    </div>

    <div class="w-full max-w-md p-4">
        <div class="glass-card rounded-3xl p-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Welcome Back</h2>
            <p class="text-gray-400 text-sm text-center mb-8">Enter your details to access the dashboard.</p>

            <?php if($error): ?>
                <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 text-center font-bold"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email</label>
                        <input type="email" name="email" value="demo@example.com" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-100 focus:outline-none focus:ring-2 focus:ring-green-300 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Password</label>
                        <input type="password" name="password" value="admin123" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-100 focus:outline-none focus:ring-2 focus:ring-green-300 transition">
                    </div>
                    <button class="w-full bg-gray-800 text-white font-bold py-3 rounded-xl hover:bg-black transition shadow-lg mt-2">Sign In</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
