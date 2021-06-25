<?php
$login = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    include '../db/db.php';
    
    $username = $_POST['uname2'];
    $password = $_POST['pass2'];

    $user_id = $con->query("SELECT * FROM users WHERE username = '$username'");
    $num_rows = ($user_id -> rowCount());

    if ($num_rows == 1) {
        while($row = ($user_id->fetch(PDO::FETCH_ASSOC))){
            if(password_verify($password, $row['password'])){
                $login = true;

                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                header("location: ../components/todo.php");
            }
            elseif (empty($password)) {
                $showError = "Passsword cannot be empty!";
            }
            else{
                $showError = "Invalid Credentials!";
            }
        }

    }
    elseif (empty($username)) {
        $showError = "Username cannot be empty!";
    }
    else{
        $showError = "Invalid Credentials!";
    }
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../styles/login_style.css">
</head>
<body>
    <?php
    if ($login) {
        echo '<div class="alert">
        <strong>Success!</strong>&nbspYou\'ve logged in!.
        </div>';    
    }
    if ($showError) {
        echo '<div class="error">
        <strong>Error!</strong>&nbsp'.$showError.'
        </div>';    
    }
    ?>

    <div class="home">
        <a href="../components/home.php">HOME</a>
    </div>
    
    <div class="sign-in-circle">
        <p class="toggle-sign-up"><a href="./signup.php">Create Account</a></p>
        <img src="../../images/Sign In.svg" alt="Sign In" class="sign-in-image">
    </div>

    <div class="sign-in-container">
        <h1>Login</h1>
        <form action="./login.php" method="post" class="Main">
            <input type="text" name="uname2" id="uname2" placeholder="Username" autocomplete="off" maxlength="20">
            <input type="password" name="pass2" id="pass2" placeholder="Password" autocomplete="off" maxlength="20">
            <button type="submit" id="submit2">Login</button>
        </form>
    </div>
</body>
</html>