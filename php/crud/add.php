<?php

session_start();

if(isset($_POST['todo'])){
    require '../db/db.php';

    $username = $_SESSION['username'];

    $todo = $_POST['todo'];

    $user_id = $con->query("SELECT * FROM users WHERE username = '$username'");
    $users_row = $user_id->fetch(PDO::FETCH_ASSOC);
    $id = $users_row['id'];

    $todoCheck = $con->query("SELECT * FROM todo_table WHERE user_id = $id");
    $todo_row = $todoCheck->fetch(PDO::FETCH_ASSOC);
    $storedTodo = $todo_row['todo_item'];

    if(empty($todo)){
        header("Location: ../components/todo.php?mess=error");
    }elseif ($todo == $storedTodo){
        header("Location: ../components/todo.php?mess=exists");
    }
    else {
        $insertTodo = $con->query("INSERT INTO todo_table(`user_id`, `todo_item`, `time_created`, `checked`)
        VALUES('$id', '$todo', CURRENT_TIMESTAMP(), 0);");
        // $res = $stmt->execute([$todo]);

        if($insertTodo){
            header("Location: ../components/todo.php?mess=success"); 
        }else {
            header("Location: ../components/todo.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../components/todo.php?mess=error");
}