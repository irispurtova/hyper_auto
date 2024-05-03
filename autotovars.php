<?php
    session_start();
    require 'connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гиперавто</title>

    <link rel="stylesheet" href="css/header.css" type="text/css">
    <link rel="stylesheet" href="css/styles-categories.css" type="text/css">
</head>
<body>
    <div class="head">

        <div class="container">

        <div class="logo"><a href="index.php"><img src="images/hyperauto.svg" alt=""></a></div>

            <a href="user/basket.php">
                <div class="basket">

                    <div class="left"><img src="images/basket.svg" alt=""></div>

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
                    ?>
                    <a href="auth/unlogin.php">
                        <div class="auth">
                            Выйти
                        </div>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="auth.php">
                        <div class="auth">
                            Войти
                        </div>
                    </a>
                    <?php
                }
            ?>               
            
        </div>
    </div>

    <?php include 'menu.php'; ?>

    <div class="inner-bread-crumbs">
        <div class="container">
            <div class="bread-crumbs">
                <a href="index.php">Главная</a>
            </div>
        </div>
    </div>

    <div class="inner-header">
        <div class="container">
            <div class="header">
                <h1>Автомагазин / автотовары в Санкт-Петербурге</h1>
            </div>
        </div>
    </div>

    <div class="header-box-block"></div>

    <div class="category-list-block">
        <div class="container">
            <div class="blocks-categories">

                <?php
                    $sql = "SELECT * FROM subcategories WHERE id_cat = 1";
                    $result = mysqli_query($connect, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        foreach($result as $row) { 
                            $id_subcat = $row['id_subcat'];
                            $name = $row['subcat_name']; 
                            $source = $row['source']; ?>

                            <div class="block">

                                <div class="text">
                                    <a href="search.php?subcat=<?=$name;?>"><h2><?=$name;?></h2></a><br>
                                        <?php
                                        $sql_2 = "SELECT * FROM class WHERE id_subcat = $id_subcat";
                                        $res_2 = mysqli_query($connect, $sql_2);
                                        if(mysqli_num_rows($res_2) > 0) {
                                            foreach($res_2 as $row) { 
                                                $name_class = $row['name_class'];?>
                                                <a href="search.php?subcat=<?=$name;?>&class=<?=$name_class;?>"><p><?=$name_class;?></p></a> 
                                                <?php
                                            }
                                        } ?>
                                </div>

                                <div class="wrapper">
                                    <img src="<?=$source;?>" alt="">
                                </div>
                                
                            </div> <?php
                        }
                    }
                ?>
            </div>            
        </div>
    </div>
    
</body>
</html>