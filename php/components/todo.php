<?php

require '../db/db.php';

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header('location: login.php');
    exit;
}else{
    $username = $_SESSION['username'];

    if (isset($username)) { ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Todo List</title>
            <script src="https://kit.fontawesome.com/b462a633b4.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="../../styles/todo.css">
            <link rel="stylesheet" href="../../styles/nav.css">
        </head>
        <body>
        
            <div class="content">
                <?php require '../components/nav.php'; ?>
        
                <div class="user-info">
                    <i class="fas fa-user fa-2x"></i>
                    <span>
                    <?php echo $username; ?>
                    </span>
                </div>  
        
                <div class="todo-item-field">
                    <form action="../crud/add.php" method="post" autocomplete="off">
                    <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                            <div class="error">Todo cannot be empty!</div>
                            <input type="text" name="todo" placeholder="Enter your todo here.." autofocus>
                            <button type="submit">Add &nbsp; +</button>
                        <?php }
                        elseif (isset($_GET['mess']) && $_GET['mess'] == 'exists'){ ?>
                            <div class="error">Same todo already exists!</div>
                            <input type="text" name="todo" placeholder="Enter your todo here.." autofocus>
                            <button type="submit">Add &nbsp; +</button>
                        <?php } 
                        else{ ?>
                            <input type="text" name="todo" placeholder="Enter your todo here.." autofocus>
                            <button type="submit">Add &nbsp; +</button>
                        <?php } ?>
                    </form>
                </div>
                <?php
                    $user_id = $con->query("SELECT * FROM users WHERE username = '$username'");
                    $users_row = $user_id->fetch(PDO::FETCH_ASSOC);
                    $id = $users_row['id'];
        
                    $todos = $con->query("SELECT * FROM todo_table WHERE user_id = $id ORDER BY id DESC");
                ?>
                <div class="items-container">
                    <?php if ($todos->rowCount() <= 0) { ?>
                        <div class="items">
                            <img src="../../images/empty.jpg" alt="" width="50%">
                            <img src="../../images/empty(1).jpg" alt="" width="50%">
                        </div>
                    <?php } ?>
                    <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="items">
                            <i id="<?php echo $todo['id']; ?>" class="fas fa-trash-alt fa-2x delete"></i>
                            <?php if ($todo['checked']) { ?>
                                <i data-id="<?php echo $todo['id']; ?>" class="fas fa-check fa-2x check"></i>
                                <p class="checked"><?php echo $todo['todo_item']; ?></p>
                             <?php } else{ ?>
                                <i data-id="<?php echo $todo['id']; ?>" class="fas fa-check fa-2x check"></i>
                                <p><?php echo $todo['todo_item']; ?></p>
                            <?php } ?>
                            <p class="time"><?php echo $todo['time_created'] ?></p>
                        </div>
                        <?php } ?>
                </div>
        
                <script src="../../js/jquery-3.2.1.min.js"></script>
        
                <script>
                    $(document).ready(function(){
                    $('.delete').click(function(){
                        const id = $(this).attr('id');
        
                        $.post("../crud/delete.php",
                            {
                                id: id
                            },
                            (data) => {
                                if (data){
                                    $(this).parent().hide(600);
                                }
                            }
                        );
                    });
        
                    $('.check').click(function(e){
                        const id = $(this).attr('data-id');
        
                        $.post("../crud/checked.php",
                            {
                                id: id
                            },
                            (data) => {
                                if (data != 'error') {
                                    const p = $(this).next();
                                    if (data === '1') {
                                        p.removeClass('checked');
                                    }else{
                                        p.addClass('checked');
                                        $(this).css("color", "green");
                                    }
                                }
                            }
                        );
                    });
                });
            </script>
        
        </body>
        </html>
        
        <?php } 
    }
?>