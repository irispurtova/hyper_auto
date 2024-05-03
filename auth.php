<?php
    session_start();

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'admin') {
        header("location: admin_panel/main.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гиперавто</title>

    <link rel="stylesheet" href="css/auth.css" type="text/css">
</head>
<body>
    <div class="head">
        <div class="container">
            <div class="logo"><a href="index.php"><img src="images/hyperauto.svg" alt=""></a></div>            
        </div>
    </div>

    <div class="inner">
        <div class="container">
            <h1>Вход на сайт</h1>

            <div class="authorization">
                <form method="post" id="auth_form">
                    <div class="top">Вход</div>

                    <div class="center">
                        <input type="text" name="login" placeholder="Логин">
                        <input type="password" name="password" placeholder="Пароль">
                        <input type="button" value="Войти" onclick="loginAccount()">
                    </div>
                </form>
            </div>
        </div>

        <script>
            function loginAccount() {
                let form = document.getElementById('auth_form');
                let formData = new FormData(form);                
                var url = 'auth/login.php';                
                let xhr = new XMLHttpRequest();                
                xhr.open('POST', url);
                xhr.send(formData);
                xhr.onload = () => {
                    if (xhr.response == '') {
                        window.location.replace("index.php");
                    } else {
                        alert(xhr.response);
                    }
                }
            }
        </script>
    </div>
    
</body>
</html>