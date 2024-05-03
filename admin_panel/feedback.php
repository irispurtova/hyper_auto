<?php
    session_start();

    require "../connect.php";   
    
    if (isset($_GET['del'])) {
        $pr_del = $_GET['del'];

        $query = "DELETE FROM feedback WHERE id_fb = $pr_del";
        mysqli_query($connect, $query) or die(mysqli_error($connect));
    }
    
    if ($_SESSION['account'] == 'admin') {
        ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Отзывы</title>

                <link rel="stylesheet" href="css/feedback.css" type="text/css">
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
                        <div class="bread-crumbs"><a href="main.php">Главная</a> > Модерация отзывов</div>

                        <div class="table">
                            <table>
                                <tr>
                                    <th style="width: 34%">Товар</th>
                                    <th style="width: 10%">Имя</th>
                                    <th style="width: 24%">Текст отзыва</th>
                                    <th style="width: 6%">Оценка</th>
                                    <th style="width: 6%">Действие</th>
                                </tr>
                                <?php
                                $sql = "SELECT * FROM feedback ORDER BY id_fb DESC";
                                $res = mysqli_query($connect, $sql);
                                if (mysqli_num_rows($res) > 0) {
                                    foreach ($res as $row) {
                                        $id_fb = $row['id_fb'];
                                        $id_prod = $row['id_prod'];
                                        $name = $row['name'];
                                        $plus = $row['plus'];
                                        $minus = $row['minus'];
                                        $text = $row['text'];
                                        $ev = $row['ev']; ?>
                                        <tr>
                                            <?php
                                            $sql_prod = "SELECT * FROM products WHERE id = '$id_prod'";
                                            $res_prod = mysqli_query($connect, $sql_prod);
                                            if (mysqli_num_rows($res_prod) > 0) {
                                                foreach ($res_prod as $row_prod) {
                                                    $title = $row_prod['title']; ?>
                                                    <td><strong><?=$title;?></strong></td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                            <td><?=$name;?></td>
                                            <td style="text-align: left">
                                                <strong>Плюсы: </strong> <?=$plus;?> <br>
                                                <strong>Минусы: </strong> <?=$minus;?> <br>
                                                <strong>Отзыв: </strong> <?=$text;?> <br>
                                            </td>
                                            <td>
                                                <?php
                                                if ($ev == '5') {
                                                    ?>
                                                    <img src="../images/stars/s5.svg" alt="">
                                                    <?php
                                                } else if ($ev == '4') {
                                                    ?>
                                                    <img src="../images/stars/s4.svg" alt="">
                                                    <?php
                                                } else if ($ev == '3') {
                                                    ?>
                                                    <img src="../images/stars/s3.svg" alt="">
                                                    <?php
                                                } else if ($ev == '2') {
                                                    ?>
                                                    <img src="../images/stars/s2.svg" alt="">
                                                    <?php
                                                } else if ($ev == '1') {
                                                    ?>
                                                    <img src="../images/stars/s1.svg" alt="">
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><a href="?del=<?=$id_fb?>" onclick="return confirm('Вы уверены?');">Удалить</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                
                            </table>
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

