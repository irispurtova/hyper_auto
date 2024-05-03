<?php 

    session_start();
    require_once('../connect.php');

    if (isset($_POST['login'])) {
        $login = $_POST['login'];
    } 
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    
    if ($login == "admin" && $password == "admin"){
        $_SESSION['account'] = 'admin';
    } else {
        if (isset($login)&&isset($password)) {
            $sql = "SELECT * FROM users WHERE login = '$login' AND pass = '$password'";
            $res = mysqli_query($connect, $sql);
            if (mysqli_num_rows($res) > 0) {
                $_SESSION['account'] = 'user';
            } else {
                echo 'Неверные данные для входа';
            }
        }  else {
            echo 'Введите логин и пароль';
        }       
    }
?>