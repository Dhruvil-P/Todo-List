<?php

if(isset($_POST['id'])){
    require '../db/db.php';

    $id = $_POST['id'];

    if(empty($id)){
       echo 0;
    }else {
        $deleteTodo = $con->query("DELETE FROM todo_table WHERE id=$id");

        if($deleteTodo){
            echo 1;
        }else {
            echo 0;
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../components/todo.php?mess=error");
}