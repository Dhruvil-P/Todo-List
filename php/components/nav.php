<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $loggedin = true;
}else{
    $loggedin = false;
}
echo '<div class="nav">
        <img src="../../images/Untitled (1).png" alt="">
        <ul>';

            if (!$loggedin){
            echo '<li><a href="./home.php">Home</a></li>
            <li><a href="../auth/login.php">Login</a></li>
            <li><a href="../auth/signup.php">Create Account</a></li>';
            }    

            if ($loggedin){
            echo '<li><a href="../auth/logout.php">Logout</a></li>';
            }
        
        echo '</ul>';
        
        if (!$loggedin){
        echo '<div class="pen-animation">
            <p>Welcome to the homepage</p>
        </div>';
        }else{
            echo '<div class="pen-animation">
            <p>Welcome to the todo page</p>
        </div>';
        }

    echo '</div>';
?>