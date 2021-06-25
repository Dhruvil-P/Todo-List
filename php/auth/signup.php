<?php
$showAlert = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    include '../db/db.php';
    
    $username = $_POST['uname'];
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];

    // $exists = false;
    $user_exists = $con->query("SELECT * FROM users WHERE username = '$username'");
    $numExistsRows = ($user_exists -> rowCount());

    if ($numExistsRows > 0) {
        // $exists = true;
        $showError = "Username already taken!";
    }else{
        // $exists = false;
        if (empty($username)) {
            $showError = "Username cannot be empty!";
        }
        elseif (empty($password) || empty($cpassword)) {
            $showError = "Passsword cannot be empty!";
        }
        elseif (($password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $con->query("INSERT INTO `users` (`username`, `password`, `date`) VALUES 
            ('$username', '$hash', current_timestamp());");
    
    
            if ($insert) {
                $showAlert = true;
            }
        }else{
            $showError = "Password didn't matched with confirm password!";
        }
    }
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../../styles/signup_style.css">
</head>
<body>
    <?php
    if ($showAlert) {
        echo '<div class="alert">
        <strong>Success!</strong>&nbspYour account has been created.
        </div>';    
    }
    if ($showError) {
        echo '<div class="error">
        <strong>Error!</strong>&nbsp'.$showError.'
        </div>';    
    }
    ?>

    <div class="home"><a href="../components/home.php">HOME</a></div>

    <div class="sign-up-circle">
        <p class="toggle-sign-in"><a href="./login.php">Login</a></p>
        <img src="../../images/Sign Up.svg" alt="Sign Up" class="sign-up-image">
    </div>

    <div class="sign-up-container">
        <h1>Create Account</h1>
        <form action="./signup.php" method="post" class="Main">
            <input type="text" name="uname" id="uname" placeholder="Username" autocomplete="off" maxlength="20">
            <input type="password" name="pass" id="pass" placeholder="Password" autocomplete="off" maxlength="20">
            <input type="password" name="cpass" id="con-pass" placeholder="Confirm Password" autocomplete="off" maxlength="20">
            <button type="submit" id="submit1">Create Account</button>
        </form>
    </div>

</body>
</html>