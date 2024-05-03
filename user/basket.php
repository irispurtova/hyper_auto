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

                <?php
                if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
                    ?>
                    <h4 style="padding-top: 20px"><a href="my_orders.php">Смотреть все заказы</a></h4>
                    <?php
                } else {
                    ?>
                    <a href="../auth.php">Войдите</a>, чтобы видеть заказы
                    <?php
                }
            ?>
            </div>
        </div>
    </div>

    <div class="inner-basket">
        <div class="container">
            <div class="content">

                <?php
                $sql = "SELECT * FROM orders WHERE id_user = $id_user AND id_order IS NULL";
                $res = mysqli_query($connect, $sql);
                if (mysqli_num_rows($res) > 0) {
                    foreach ($res as $row) {
                        $id_prod = $row['id_prod'];
                        $count_prod = $row['count_prod'];

                        $sql_products = "SELECT * FROM products WHERE id = $id_prod";
                        $res_products = mysqli_query($connect, $sql_products);
                        if (mysqli_num_rows($res_products) > 0) {
                            foreach ($res_products as $row_products) {
                                $title = $row_products['title'];
                                $code = $row_products['code'];
                                $article = $row_products['article'];
                                $price = $row_products['price']; 
                                
                                $sql_img = "SELECT * FROM images WHERE id_product = $id_prod";
                                $res_img = mysqli_query($connect, $sql_img);
                                if (mysqli_num_rows($res_img) > 0) {
                                    foreach ($res_img as $row_img) {
                                        $img = $row_img['source'];
                                    }
                                }
                                ?>

                                <div class="item">
                                    <a href=""><div class="img-item"><img src="../admin_panel/<?=$img;?>" alt=""></div></a>
                                    <div class="info">
                                        <a href=""><div class="name-item"><?=$title;?></div></a>
                                        <div class="descr">
                                            <div class="text-descr" style="margin-right: 5px">Код: <?=$code;?></div>
                                            <div class="text-descr">Артикул: <?=$article;?></div>
                                        </div>
                                    </div>
                                    <div class="amount-item">
                                        <button onclick="reduceCount(event, <?=$id_prod;?>)">-</button>
                                        <span id="quantity<?=$id_prod;?>"><?=$count_prod;?></span> шт 
                                        <button onclick="increaseCount(event, <?=$id_prod;?>)">+</button>
                                    </div>
                                    <div class="right-item">
                                        <div class="price-item<?=$id_prod;?>" id="price-item<?=$id_prod;?>"><?=$price;?>,00 ₽</div>
                                        <a href="?del=<?=$id_prod;?>"><div class="delete-item">Удалить</div></a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                } else {
                    echo 'Корзина пуста';
                }
                ?>                

            </div>
            <div class="order-space">
                <div class="order">
                    <div class="price-order">
                        Итого

                        <?php
                            $totalPrice = 0;
    
                            $sql = "SELECT * FROM orders WHERE id_user = $id_user AND id_order IS NULL";
                            $res = mysqli_query($connect, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                foreach ($res as $row) {
                                    $id_prod = $row['id_prod'];
                                    $count = $row['count_prod'];
                        
                                    $sql1 = "SELECT * FROM products WHERE id = $id_prod";
                                    $res1 = mysqli_query($connect, $sql1);
                                    if (mysqli_num_rows($res1) > 0) {
                                        foreach ($res1 as $row1) {
                                            $price = $row1['price'];
                        
                                            $totalPrice += $price * $count;
                                        }
                                    }
                                }
                            }
                        ?>

                        <div class="value" id="totalPrice"><?=$totalPrice;?> рублей</div>
                    </div>
                    <div class="order-button" onclick="openForm(event, <?=$totalPrice;?>)">Оформить заказ</div>
                </div>
            </div>            
        </div>

        <div class="forma" id="myForm" style="display: none">
            <form action="" method="post">
                <?php
                if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') { ?>
                    <input type="text" placeholder="<?=$name;?>" value="<?=$name;?>" id="name_user">
                    <input type="telephone" placeholder="<?=$tel;?>" value="<?=$tel;?>" id="tel_user">
                    <input type="email" placeholder="<?=$email;?>" value="<?=$email;?>" id="email_user">
                    <input type="text" placeholder="<?=$address;?>" value="<?=$address;?>" id="addr_user">
                <?php
                } else { ?>
                    <input type="text" placeholder="Ваше имя" id="name_user">
                    <input type="telephone" placeholder="Ваш телефон" id="tel_user">
                    <input type="email" placeholder="Ваш e-mail" id="email_user">
                    <input type="text" placeholder="Адрес" id="addr_user">
                <?php
                }
            ?>
                <input type="submit" name="" id="" value="Оформить заказ" onclick="addOrder(event)">
            </form>
        </div>

        <script>
            function openForm(event, totalPrice) {
                event.preventDefault();
                if (totalPrice != 0) {
                    var forma = document.getElementById("myForm"); 
                    forma.style.display = 'block';
                } else {
                    alert('Выберите товары для заказа!');
                }
                
            }

            function increaseCount(event, id) {
                var quantityElement = document.getElementById("quantity" + id); /*количество определенного товара в модальном*/
                var quantity = parseInt(quantityElement.textContent); /* перевод в int цены в модальном */

                quantity++;
                quantityElement.textContent = quantity;

                sendRequest(id, quantity);
                calcSum(id);
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
                }    
                
                calcSum(id);                    
            }

            function DeleteProduct(id) {
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location.reload();
                    }
                };
                xhttp.open("POST", "../server/DeleteProductFromBasket.php", true);
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
                xhttp.open("POST", "../server/addToBasket.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id_prod=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity));

                all_count(id);
            }

            function calcSum(id) {
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("totalPrice").textContent = this.responseText + ' рублей';
                    }
                };
                xhttp.open("POST", "../server/calcSum.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send();
            }

            function all_count(id) {
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("text_price_basket").textContent = this.responseText + ' товаров';
                    }
                };
                xhttp.open("POST", "../server/upd_all_tovars.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id_prod=" + encodeURIComponent(id));
            }

            function addOrder(event) {
                event.preventDefault();

                var name_user = document.getElementById('name_user').value;
                var tel_user = document.getElementById('tel_user').value;
                var email_user = document.getElementById('email_user').value;
                var addr_user = document.getElementById('addr_user').value;
                var totalPriceStr = document.getElementById('totalPrice').textContent;
                var parts = totalPriceStr.split(",");
                var totalPrice = parseInt(parts[0]);

                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                        window.location.reload();
                    }
                };
                xhttp.open("POST", "../server/addOrder.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("name_user=" + encodeURIComponent(name_user) +
                           "&tel_user=" + encodeURIComponent(tel_user) +
                           "&email_user=" + encodeURIComponent(email_user) +
                           "&addr_user=" + encodeURIComponent(addr_user) +
                           "&totalPrice=" + encodeURIComponent(totalPrice));
            }
        
        </script>
    </div>
    
</body>
</html>