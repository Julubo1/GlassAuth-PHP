<?php
// public/logout.php
session_start();

// 1. Alle sessie variabelen leegmaken
$_SESSION = [];

// 2. De sessie cookie vernietigen (als die bestaat)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. De sessie zelf vernietigen
session_destroy();

// 4. Terug naar de voordeur
header("Location: index.php");
exit;
?>
