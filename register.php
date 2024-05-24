<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['uname'];
    $password = $_POST['psw'];

   

    $usersFile = 'users.txt';
    $userExists = false;

    if (file_exists($usersFile)) {
        $users = file($usersFile, FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($existingUsername, ) = explode(',', $user);
            if ($existingUsername === $username) {
                $userExists = true;
                break;
            }
        }
    }

    if ($userExists) {
        $error = "Användarnamnet är redan taget";
        header("Location: register.php?error=" . urlencode($error));
        exit();
    } else {
        // Spara användarnamn och lösenord (hashat)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        file_put_contents($usersFile, "$username,$hashedPassword\n", FILE_APPEND);
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styleSheet.css">
</head>
<body>
   <form action="register.php" method="post">
    <div class="banner">
        <h1 class="rubrik">Grupprums bokning - Registrera</h1>
        <form action="register.php" method="post">
            <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php } ?>
          
            <div class="container">
              <label for="uname"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="uname" required>
          
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" required>
          
              <button type="submit">Register</button>
            </div>
    </div>
    </form>
</body>
</html>
