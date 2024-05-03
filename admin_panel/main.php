<?php
    session_start();

    require "../connect.php";    
    
    if ($_SESSION['account'] == 'admin') {
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Административная панель</title>

                <link rel="stylesheet" href="css/main.css" type="text/css">
            </head>
            <body>
                <div class="header">
                    <div class="inner">
                        <div class="logo">
                            <img src="images/logo.svg" alt="logo">
                        </div>
                        <div class="user">
                            АДМИН
                        </div>
                        <div class="log_out">
                            <a href="../auth/unlogin.php">Выход</a>
                        </div>
                    </div>
                </div>

                <div class="main">
                    <div class="inner">
                        <div class="blocks">
                            <div class="all_tovars" id="admin_block"><a href="all_tovars.php">ВСЕ ТОВАРЫ</a></div>
                            <div class="categories" id="admin_block"><a href="categories.php">КАТЕГОРИИ</a></div>
                            <div class="feedback" id="admin_block"><a href="feedback.php">ОТЗЫВЫ</a></div>
                            <div class="orders" id="admin_block"><a href="orders.php">ЗАКАЗЫ</a></div>
                        </div>            
                    </div>
                </div>
            </body>
            </html>

            <?php
    }
    else {    
        header('Location: ../index.php');
    }
?>

