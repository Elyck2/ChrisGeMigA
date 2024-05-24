<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styleSheet.css">
</head>
<body>
    <div class="banner">
        <h1 class="rubrik">Grupprums bokning</h1>
        <p>Välkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>