<?php
    session_start();

    require '../connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'admin') {
        header("location: admin_panel/main.php");
    }

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }

    if (isset($_GET['del'])) {
        $pr_del = $_GET['del'];

        $sql_del = "DELETE FROM orders WHERE id_prod = $pr_del AND id_user = $id_user AND id_order IS NULL";
        $query = mysqli_query($connect, $sql_del);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гиперавто</title>

    <link rel="stylesheet" href="../css/header.css" type="text/css">
    <link rel="stylesheet" href="../css/basket.css" type="text/css">
</head>
<body>
    <div class="head">

        <div class="container">
            
        <div class="logo"><a href="../index.php"><img src="../images/hyperauto.svg" alt=""></a></div>

            <a href="basket.php">
                <div class="basket">

                    <div class="left"><img src="../images/basket.svg" alt=""></div>

                    <!-- количество всех товаров -->
                    <?php
                        $sql_count = "SELECT SUM(count_prod) AS total_count_prod FROM orders WHERE id_user = $id_user AND id_order IS NULL";
                        $result_count = $connect->query($sql_count);

                        if ($result_count->num_rows > 0) {
                            $row_count = $result_count->fetch_assoc();
                            $totalCountProd = $row_count["total_count_prod"]; ?>
                            
                            <?php
                        } else {
                            $totalCountProd = 0;
                        }
                    ?>

                    <div class="right">
                        <?php
                            if ($totalCountProd == 0) { ?>
                                <div class="text"><p><strong>В корзине</strong></p><p id="text_price_basket">пока нет товаров</p></div> <?php
                            } else { ?>
                                <div class="text"><p><strong>В корзине</strong></p><p id="text_price_basket"><?=$totalCountProd;?> товаров</p></div> <?php
                            }
                        ?>
                        
                    </div>

                </div>
            </a>

            <?php
                if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
                    $sql_user = "SELECT * FROM account WHERE login='user'";
                    $res_user = mysqli_query($connect, $sql_user);
                    if (mysqli_num_rows($res_user)>0) {
                        foreach ($res_user as $user) {
                            $name = $user['name'];
                            $tel = $user['telephone'];
                            $email = $user['email'];
                            $address = $user['address'];
                        }
                    }
                    ?>
                    <a href="../auth/unlogin.php">
                        <div class="auth">
                            Выйти
                        </div>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="../auth.php">
                        <div class="auth">
                            Войти
                        </div>
                    </a>
                    <?php
                }
            ?>            
            
        </div>
    </div>

    <div class="menu">
        <div class="container" style="padding: 0px">
            <ul>                
                <a href="../autotovars.php">
                    <li>
                        <div class="image"><img src="../images/1.svg" alt=""></div>
                        <div class="text">Автотовары</div>
                    </li>
                </a>   
                
                <a href="../autozapchasty.php">
                        <li>
                        <div class="image"><img src="../images/2.svg" alt=""></div>
                        <div class="text">Автозапчасти</div>
                    </li>
                </a>
                <a href="../shini.php">
                        <li>
                        <div class="image"><img src="../images/3.svg" alt=""></div>
                        <div class="text">Шины</div>
                    </li>
                </a>
                <a href="../masla.php">
                        <li>
                        <div class="image"><img src="../images/4.svg" alt=""></div>
                        <div class="text">Масла и смазки</div>
                    </li>
                </a>
                <a href="../accums.php">
                        <li>
                        <div class="image"><img src="../images/5.svg" alt=""></div>
                        <div class="text">Аккумуляторы</div>
                    </li>
                </a>
                <a href="../winter.php">
                    <li>
                        <div class="image"><img src="../images/6.svg" alt=""></div>
                        <div class="text">Зима</div>
                    </li>
                </a>
            </ul>
        </div>
    </div>

    <div class="inner-bread-crumbs">
        <div class="container">
            <div class="bread-crumbs">
                <a href="../index.php">Главная</a>
            </div>
        </div>
    </div>

    <div class="inner-header">
        <div class="container">
            <div class="header">
                <h1>Моя корзина</h1>

                <a href="basket.php"><h4 style="padding-top: 20px">Вернуться в корзину</h4></a>
            </div>
        </div>
    </div>

    <div class="inner-basket">
        <div class="container">
            <div class="content">
                <?php
                    $sql = "SELECT * FROM all_orders WHERE id_user = $id_user";
                    $res = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($res)>0) {?>

                    <div class="orders">
                    <?php
                        foreach ($res as $row) {
                            $id_order = $row['id_order'];
                            $totalPrice = $row['total']; 
                            $id_status = $row['status'];
                            
                            $sql_status = "SELECT * FROM order_status WHERE id = $id_status";
                            $res_status = mysqli_query($connect, $sql_status);
                            if (mysqli_num_rows($res_status)>0) {
                                foreach ($res_status as $row_status) {
                                    $status = $row_status['status'];
                                }
                            } ?> 
                            
                            <h2>Заказ №<?=$id_order;?> <span style="font-weight: 100">Статус заказа: <?=$status;?></span></h2>

                            
                            <?php
                            $sql1 = "SELECT * FROM orders WHERE id_order = $id_order";
                            $res1 = mysqli_query($connect, $sql1);
                            if (mysqli_num_rows($res1)>0) {
                                foreach ($res1 as $row1) {
                                    $id_prod = $row1['id_prod'];
                                    $count_prod = $row1['count_prod'];

                                    $sql2 = "SELECT * FROM products WHERE id = $id_prod";
                                    $res2 = mysqli_query($connect, $sql2);
                                    if (mysqli_num_rows($res2)>0) {
                                        foreach ($res2 as $row2) {
                                            $title = $row2['title'];

                                            $sql3 = "SELECT * FROM images WHERE id_product = $id_prod LIMIT 1";
                                            $res3 = mysqli_query($connect, $sql3);
                                            if (mysqli_num_rows($res3)>0) {
                                                foreach ($res3 as $row3) {
                                                    $img_source = $row3['source'];?>

                                                    <div class="order-item">
                                                        <div class="left" style="width: 100px; margin: 0px">
                                                            <img src="../admin_panel/<?=$img_source;?>" alt="" width="100px">
                                                        </div>
                                                        
                                                        <div class="right">
                                                            <p><?=$title;?></p>
                                                            <p><?=$count_prod;?> штук</p>
                                                        </div>
                                                        
                                                    </div>

                                                    
                                                        

                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            } ?>
                                <div class="totalPrice">
                                    <h3>Цена заказа: <?=$totalPrice;?> рублей</h3>
                                </div>
                            <?php
                        }
                    }?>
                    </div>
            </div>          
        </div>
    </div>
    
</body>
</html>