<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<h1>Welkom, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
<a href="logout.php">Uitloggen</a>
