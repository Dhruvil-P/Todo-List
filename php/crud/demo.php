<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header('location: login.php');
    exit;
}else{
    include '../db-details/db.php';
    $username = $_SESSION['username'];

    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ToDo</title>
        <script src="https://kit.fontawesome.com/b462a633b4.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../../styles/todo.css">
        <link rel="stylesheet" href="../../styles/nav.css">
    </head>
    <body>';
        require './nav.php';
        $showError = false;

        echo '<div class="user-info">
            <i class="fas fa-user fa-2x"></i>
            <span>';
            echo $username;
            echo '</span>
        </div>    

        <div class="content">
            <div class="items-container">';

                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $id_query = "SELECT * FROM users WHERE username = '$username'";
                    $get_id = mysqli_query($con, $id_query);
                    $id_row = mysqli_fetch_assoc($get_id);
                    $id = $id_row['id'];
                
                    $todo_item = $_POST['todo-item'];

                    $existsSql = "SELECT * FROM todo_table WHERE todo_item = '$todo_item' AND user_id = $id";
                    $result = mysqli_query($con, $existsSql);
                    $numExistsRows = mysqli_num_rows($result);

                    if (empty($todo_item)){
                        $showError =  "A todo item cannot be empty!";
                    }
                    // elseif ($numExistsRows <= 0) {
                    //     $showError = "Same todo already exists!";
                    // }
                    elseif ($numExistsRows > 0) {
                        $showError = "Same todo already exists!";
                    }
                    else{
                        $sql = "INSERT INTO `todo_table` (`user_id`, `todo_item`, `time_created`) VALUES 
                        ('$id', '$todo_item', current_timestamp());";
                        $result = mysqli_query($con, $sql);
                    
                        $todo_query = "SELECT * from todo_table WHERE user_id = $id ORDER BY id DESC";
                        $get_todo = mysqli_query($con, $todo_query);      
                        
                        while ($row = mysqli_fetch_assoc($get_todo)){
                            echo '<div class="items">
                                <button><i class="fas fa-check fa-2x check"></i></button>';
                                if ($row['checked']){
                                    echo '<p class="checked">';
                                        echo $row['todo_item'];
                                    echo '</p>';
                                }
                                else{
                                    echo '<p>';
                                        echo $row['todo_item'];
                                    echo '</p>';
                                }
                            echo '<button type="submit" name="delete"><i class="fas fa-trash-alt fa-2x delete"></i></button>
                            <p class="time">'.$row['time_created'].'</p>
                            </div>';
                        }
                    }
                }
            echo '</div>

            <form action="./todo.php" method="post" class="todo-item-field">
                <input type="text" name="todo-item" id="" placeholder="Enter your todo here..." autocomplete="off">
                <button type="submit">Add</button>
            </form>';
            
            if ($showError != false){
            echo '<div class="error">
            <strong>Error!</strong>&nbsp'.$showError.'
            </div>';
            }
        echo '</div>

        <script src="../../js/app.js"></script>
    </body>
    </html>';
}
?></link>