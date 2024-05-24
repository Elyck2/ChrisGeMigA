<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['uname'];
    $password = $_POST['psw'];

    
    $usersFile = 'users.txt';
    $loginSuccessful = false;

    if (file_exists($usersFile)) {
        $users = file($usersFile, FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($existingUsername, $hashedPassword) = explode(',', $user);
            if ($existingUsername === $username && password_verify($password, $hashedPassword)) {
                $loginSuccessful = true;
                break;
            }
        }
    }

    if ($loginSuccessful) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Felaktigt användarnamn eller lösenord";
        header("Location: login.php?error=" . urlencode($error));
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
   <form action="login.php" method="post">
    <div class="banner">
        <h1 class="rubrik">Grupprums bokning</h1>
        <form action="login.php" method="post">
            <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php } ?>
          
            <div class="container">
              <label for="uname"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="uname" required>
          
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" required>
          
              <button type="submit">Login</button>
              
              <p>Har du inget konto? <a href="register.php">Registrera här</a></p>
            </div>
    </div>
    </form>
</body>
</html>
