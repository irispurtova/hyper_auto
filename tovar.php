<?php
    session_start(); 

    require 'connect.php';

    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $row) {
            $title = $row['title'];
            $article = $row['article'];
            $code = $row['code'];
            $brand = $row['brand'];
            $price = $row['price'];
            $season = $row['season'];
            $subcategory_id = $row['subcategory_id']; 
            
            $sql_img = "SELECT source FROM images WHERE id_product = $id LIMIT 1";
            $res_img = mysqli_query($connect, $sql_img);
            if (mysqli_num_rows($res_img) > 0) {
                foreach($res_img as $row_img) { 
                    $img_src = $row_img['source'];
                }
            }
        }
    }

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
    <link rel="stylesheet" href="css/tovar.css" type="text/css">
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
                <?php
                if (isset($_GET['subcat'])) {
                        $subcat = $_GET['subcat']; 

                        if (isset($_GET['class'])) {
                            $class = $_GET['class']; ?>
                            <a href="index.php">Главная</a> <span style="color: #1aa34f"> > </span> <a href="search.php?subcat=<?=$subcat;?>"><?=$subcat;?></a> <span style="color: #1aa34f"> > <?=$class;?> </span> <?php
                        } else {                             
                            $sql_br_cr = "SELECT * FROM products WHERE id = $id";
                            $res_br_cr = mysqli_query($connect, $sql_br_cr);

                            if (mysqli_num_rows($res_br_cr) > 0) {
                                foreach ($res_br_cr as $row_class) {
                                    $id_class = $row_class['id_class'];

                                    $sql_1 = "SELECT * FROM class WHERE id_class = $id_class";
                                    $res_1 = mysqli_query($connect, $sql_1);

                                    if (mysqli_num_rows($res_1) > 0) {
                                        foreach ($res_1 as $row_1) {
                                            $name_class = $row_1['name_class'];?>
                                            <a href="index.php">Главная</a> <span style="color: #1aa34f"> > </span> <a href="search.php?subcat=<?=$subcat;?>"><?=$subcat;?></a> <span style="color: #1aa34f"> > <?=$name_class;?> </span> <?php
                                        }
                                    }
                                }
                            }
                            
                        }
                    }
                ?>                
            </div>
        </div>
    </div>

    <div class="inner">
        <div class="container">
            <div class="description">
                <div class="left">
                    <h1><?=$title;?></h1>
                    <div class="img-info">
                        <div class="img">
                            <img src="admin_panel/<?=$img_src;?>" alt="">
                        </div>
                        <div class="info">
                            <p>Код товара: <strong><?=$code;?></strong></p>
                            <p>Артикул: <strong><?=$article;?></strong></p> 
                            <p>Бренд: <strong><?=$brand;?></strong></p>
                        </div>
                    </div>
                    <div class="feedback">
                        <?php
                            $sql_count = "SELECT COUNT(*) AS row_count FROM feedback WHERE id_prod = '$id'";
                            $result_count = mysqli_query($connect, $sql_count);

                            if (mysqli_num_rows($result_count) > 0) {
                                foreach ($result_count as $row_count) {
                                    $count = $row_count['row_count'];
                                }
                            }                         
                            
                        ?>

                        <div class="top">
                            <h3 style="margin-left: 0px">Отзывы <span style="color: green"><?=$count;?></span></h3>
                            <a onclick="openModal('<?=$id;?>')"><div class="add-fb">Добавить отзыв</div></a>
                        </div>
                        
                        <div class="blocks">
                            <?php
                                $fb = "SELECT * FROM feedback WHERE id_prod = '$id'";
                                $res_fb = mysqli_query($connect, $fb);

                                if (mysqli_num_rows($res_fb) > 0) {
                                    foreach ($res_fb as $r_fb) {
                                        $name_fb = $r_fb['name'];
                                        $plus = $r_fb['plus'];
                                        $minus = $r_fb['minus'];
                                        $text = $r_fb['text'];
                                        $ev = $r_fb['ev']; ?>

                                        <div class="block">
                                            <?php
                                                if ($ev == '5') {
                                                    ?>
                                                    <img src="images/stars/s5.svg" alt="">
                                                    <?php
                                                } else if ($ev == '4') {
                                                    ?>
                                                    <img src="images/stars/s4.svg" alt="">
                                                    <?php
                                                } else if ($ev == '3') {
                                                    ?>
                                                    <img src="images/stars/s3.svg" alt="">
                                                    <?php
                                                } else if ($ev == '2') {
                                                    ?>
                                                    <img src="images/stars/s2.svg" alt="">
                                                    <?php
                                                } else if ($ev == '1') {
                                                    ?>
                                                    <img src="images/stars/s1.svg" alt="">
                                                    <?php
                                                }
                                            ?>
                                            <strong><?=$name_fb;?></strong>
                                            <h4 style="padding-top: 10px">Плюсы:</h4>
                                            <p><?=$plus;?></p>
                                            <h4 style="padding-top: 10px">Минусы:</h4>
                                            <p><?=$minus;?></p>
                                            <h4 style="padding-top: 10px">Отзыв:</h4>
                                            <p><?=$text;?></p>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                            
                        </div>
                    </div>

                    <h3 style="margin-left: 20px; margin-bottom: 20px">Похожие товары</h3>
                    <div class="same">
                        
                        <?php
                            $sql2 = "SELECT * FROM products WHERE subcategory_id = $subcategory_id AND id != $id LIMIT 4";
                            $res2 = mysqli_query($connect, $sql2);
                            if (mysqli_num_rows($res2) > 0) {
                                foreach($res2 as $row2) {
                                    $id_same = $row2['id'];
                                    $title_same = $row2['title'];
                                    $price_same = $row2['price'];

                                    $sql_img_same = "SELECT * FROM images WHERE id_product = $id_same LIMIT 1";
                                    $res_img_same = mysqli_query($connect, $sql_img_same);
                                    if (mysqli_num_rows($res_img_same) > 0) {
                                        foreach ($res_img_same as $row_img_same) {
                                            $source_img = $row_img_same['source'];
                                        }
                                    }?>
                                    <div class="item">
                                        <img src="admin_panel/<?=$source_img;?>" alt="" width="130px">
                                        <a href="tovar.php?id=<?=$id_same;?>"><p><?=$title_same;?></p></a>
                                        <p>Цена: <?=$price_same;?>,00 ₽</p>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="right">
                    <div class="price"><?=$price;?>,00 ₽</div>

                    <?php
                        $basket = "SELECT * FROM orders WHERE id_prod = $id AND id_user = $id_user AND id_order IS NULL";
                        $res_basket = mysqli_query($connect, $basket);

                        if (mysqli_num_rows($res_basket) > 0) {
                            foreach ($res_basket as $row_basket) {
                                $count = $row_basket['count_prod'];
                            }
                        } else {$count = 0;}

                        if ($count == 0) { ?>
                            <a onclick="addToBasket(event, <?= $id; ?>)" class="button-buy-link">
                                <div class="button-buy"><img src="images/basket-white.svg" alt="">Добавить в корзину</div>
                            </a>
                        <?php
                        } else {?>
                        <p>В корзине</p>
                            <div class="amount-item">
                                <button onclick="reduceCount(event, <?=$id;?>)">-</button> 
                                    <span id="quantity<?=$id;?>"><?=$count;?></span> шт 
                                <button onclick="increaseCount(event, <?=$id;?>)">+</button>
                            </div>
                        <?php
                        }
                    ?>

                    
                </div>
            </div>
        </div>         
        
    </div>

    <script>
        function addToBasket(event, id) {
            event.preventDefault();

            var quantity = 1;
            
            sendRequest(id, quantity);
        }

        function increaseCount(event, id) {
            var quantityElement = document.getElementById("quantity" + id); /*количество определенного товара в модальном*/
            var quantity = parseInt(quantityElement.textContent); /* перевод в int цены в модальном */

            quantity++;
            quantityElement.textContent = quantity;

            sendRequest(id, quantity);
            count_products();

            window.location.reload();
        }

        function reduceCount(event, id) {
            var quantityElement = document.getElementById("quantity" + id); /*количество определенного товара в модальном*/
            var quantity = parseInt(quantityElement.textContent); /* перевод в int цены в модальном */

            quantity--;
            quantityElement.textContent = quantity;

            if (quantity == 0) {
                DeleteProduct(id);                        
            } else {
                sendRequest(id, quantity);
                count_products();
            }  
            
            window.location.reload();
        }

        function DeleteProduct(id) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location.reload();
                }
            };
            xhttp.open("POST", "server/DeleteProductFromBasket.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("id_prod=" + encodeURIComponent(id));
        }

        function sendRequest(id, quantity) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            };
            xhttp.open("POST", "server/addToBasket.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("id_prod=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity));
        }

        function count_products() {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('text_price_basket').textContent = this.responseText + ' товаров';
                }
            };
            xhttp.open("POST", "server/count_products.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send();
        }
    </script>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2>Добавление отзыва <span class="close">&times;</span></h2>
            <h3 style="padding: 5px 0px"><?=$title;?></h3>

            <form action="" method="post" id="addFbForm">
                <input type="text" name="name" id="name" placeholder="Ваше имя" style="width: 450px" required>

                <h4 style="padding: 5px 0px">Плюсы:</h4>
                <textarea name="plus" id="" cols="30" rows="4" style="width: 450px; resize: none;" required></textarea>

                <h4 style="padding: 5px 0px">Минусы:</h4>
                <textarea name="minus" id="" cols="30" rows="10" style="width: 450px; resize: none;" required></textarea>

                <h4 style="padding: 5px 0px">Отзыв:</h4>
                <textarea name="text_feedback" id="" cols="30" rows="10" style="width: 450px; resize: none;" required></textarea>

                <input type="hidden" id="id_prod" name="id_prod">

                <div class="module-rating-stars">
                    <input type="radio" class="check" name="stars" id="one" value="1">
                    <input type="radio" class="check" name="stars" id="two" value="2">
                    <input type="radio" class="check" name="stars" id="three" value="3">
                    <input type="radio" class="check" name="stars" id="four" value="4">
                    <input type="radio" class="check" name="stars" id="five" value="5">
                    <label for="one" class="stars"></label>
                    <label for="two" class="stars"></label>
                    <label for="three" class="stars"></label>
                    <label for="four" class="stars"></label>
                    <label for="five" class="stars"></label>
                </div>

                <input type="submit" name="submit" value="Отправить" style="font-size: 18px">
            </form>

            
        </div>
    </div>

    <script>
        function openModal(id) {
            var modal = document.getElementById("myModal");
            var idprod = document.getElementById("id_prod");
            idprod.value = id;                             
            modal.style.display = "block";
        }

        document.getElementsByClassName("close")[0].onclick = function() {
            document.getElementById("myModal").style.display = "none";
        }

        document.getElementById("addFbForm").addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            var form = event.target;
            var formData = new FormData(form);
            
            var xhr = new XMLHttpRequest();
            xhr.open("POST", 'server/send_feedback.php', true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location.reload();
                } else {
                    console.log(this.responseText);
                }
            };
            xhr.send(formData);
        });

        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    
    
</body>
</html>