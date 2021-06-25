<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $loggedin = true;
}else{
    $loggedin = false;
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <script src="https://kit.fontawesome.com/b462a633b4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/nav.css">
</head>
<body>';
    require "./nav.php";    
    echo '<div class="animation">';
        if ($loggedin){
        echo '<a href="./todo.php" class="heading">Todo List</a>';
        }else{
        echo '<a href="#" class="heading">Todo List</a>';
        }
        echo '<div class="social-media">
            <a href="https://twitter.com/Dhruvil69422716">
                <i class="fab fa-twitter fa-3x twitter" ></i>
            </a>
            <a href="https://github.com/Dhruvil-P">
                <i class="fab fa-github fa-3x github"></i>            
            </a>
        </div>
        <div class="discord">
            <i class="fab fa-discord fa-3x discord-icon"></i>
            | DHRUVIL ✓#0785
        </div>
    </div>

    <script src="../../js/app.js"></script>
</body>
</html>';
?>