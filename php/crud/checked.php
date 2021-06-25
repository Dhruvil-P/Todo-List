<?php

session_start();

if(isset($_POST['id'])){
    require '../db/db.php';

    $username = $_SESSION['username'];

    $id = $_POST['id'];

    if(empty($id)){
       echo 'error';
    }else {
        $user_id_query = $con->query("SELECT * FROM users WHERE username = '$username'");
        $users_row = $user_id_query->fetch(PDO::FETCH_ASSOC);
        $user_id = $users_row['id'];

        $todos = $con->query("SELECT * FROM todo_table WHERE user_id = $user_id AND id = $id");
        $todo = $todos->fetch(PDO::FETCH_ASSOC);
        $initialId = $todo['id'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $con->query("UPDATE todo_table SET checked=$uChecked WHERE id=$initialId");

        if($res){
            echo $checked;
        }else {
            echo "error";
        }
        $conn = null;
        exit();

        // if (!$checked){
        //     $updateQuery = $con->query("UPDATE todo_table SET checked = 1 WHERE id = $initialId");
        //     $checkedValueQuery = $updateQuery->fetch(PDO::FETCH_ASSOC);
        //     $checkedValue = $checkedValueQuery['checked'];

        //     if($checkedValue == 1){
        //         echo '1';
        //     }else {
        //         echo "error";
        //     }
        // }
        // $con = null;
        // exit();
    }
}else {
    header("Location: ../components/todo.php?mess=error");
}