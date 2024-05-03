<?php
    session_start(); 

    require 'connect.php';
    require 'min_max_price.php';

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
    <link rel="stylesheet" href="css/search.css" type="text/css">
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
                        } else { ?>
                            <a href="index.php">Главная</a> <span style="color: #1aa34f"> > <?=$subcat;?></span> <?php
                        }
                    }
                ?>                
            </div>
        </div>
    </div>

    <div class="inner-header">
        <div class="container">
            <div class="header">
                <?php
                    if (isset($_GET['subcat'])) {
                        $subcat = $_GET['subcat']; 

                        if (isset($_GET['class'])) {
                            $class = $_GET['class']; ?>
                            <h1><?=$class;?> в Санкт-Петербурге</h1> <?php
                        } else { ?>
                            <h1><?=$subcat;?> в Санкт-Петербурге</h1> <?php
                        }                        
                    }
                ?>
                
            </div>
        </div>
    </div>

    <div class="inner">
        <div class="container">
            <div class="top-inner-block">
                <div class="sort">
                    <span   STYLE="MARGIN-RIGHT: 10PX">Сортировать </span>
                    <select name="" id="sort_select">
                        <option value="asc" name="sort_price_min">Сначала дешевые</option>
                        <option value="desc" name="sort_price_max">Сначала дорогие</option>
                    </select>
                </div>
                <div class="view">
                    <span>Вид </span>
                    <a href="" class="view_href" onclick="changeDirectionTable(event)"><img src="images/table.svg" alt=""></a>
                    <a href="" class="view_href" onclick="changeDirectionSetka(event)"><img src="images/setka.svg" alt=""></a>
                </div>
            </div>
        </div>       

        <div class="container container--inner">
            <div class="center-inner-block">
                <div class="list-blocks" style="flex-direction: column; width: 70%; margin: auto;">
                    <?php
                        if (isset($_GET['subcat'])) {
                            $subcat = $_GET['subcat']; 

                            if (isset($_GET['class'])) {
                                $class = $_GET['class']; 

                                $sql_class = "SELECT * FROM class WHERE name_class = '$class'";
                                $res_class = mysqli_query($connect, $sql_class);

                                if (mysqli_num_rows($res_class) > 0) {
                                    foreach ($res_class as $row_class) {
                                        $id_class = $row_class['id_class'];
                                    }
                                }

                                $sql = "SELECT * FROM products WHERE id_class = $id_class";
                                $sql_brand = "SELECT DISTINCT brand FROM products WHERE id_class = '$id_class'";

                            } else { 
                                $sql_subcat = "SELECT * FROM subcategories WHERE subcat_name = '$subcat'";
                                $res_subcat = mysqli_query($connect, $sql_subcat);

                                if (mysqli_num_rows($res_subcat) > 0) {
                                    foreach ($res_subcat as $row_subcat) {
                                        $id_subcat = $row_subcat['id_subcat'];
                                    }
                                }
                                
                                $sql = "SELECT * FROM products WHERE subcategory_id = $id_subcat";
                                $sql_brand = "SELECT DISTINCT brand FROM products WHERE subcategory_id = '$id_subcat'";
                            }

                            if (isset($_GET['minPrice']) || isset($_GET['maxPrice']) || isset($_GET['brands'])) {
                                
                                if (isset($_GET['minPrice'])) {
                                    $min_Price = $_GET['minPrice'];
                                } 

                                if (isset($_GET['maxPrice'])) {
                                    $max_Price = $_GET['maxPrice'];
                                } 

                                $sql .= " AND price BETWEEN $min_Price AND $max_Price";

                                if (isset($_GET['brands'])) {
                                    $brands = $_GET['brands'];
                                    $brandArray = explode(',', $brands);

                                    $brandCondition = implode("','", $brandArray);
                                    $brandCondition = "'".$brandCondition."'";

                                    $sql .= " AND brand IN ($brandCondition)";
                                }  
                                
                                if (isset($_GET['sort'])) {
                                    $sort = $_GET['sort'];
                                    $sql .= " ORDER BY price $sort";
                                }
                            }
                        }

                        $res = mysqli_query($connect, $sql);
                        if (mysqli_num_rows($res) > 0) {
                            foreach($res as $row) { 
                                $id = $row['id'];
                                $title = $row['title'];
                                $article = $row['article'];
                                $code = $row['code'];
                                $brand = $row['brand'];
                                $price = $row['price'];
                                $season = $row['season']; 
                                
                                $sql_img = "SELECT source FROM images WHERE id_product = $id LIMIT 1";
                                $res_img = mysqli_query($connect, $sql_img);
                                if (mysqli_num_rows($res_img) > 0) {
                                    foreach($res_img as $row_img) { 
                                        $img_src = $row_img['source'];
                                    }
                                }

                                ?>

                                <div class="block">
                                    <div class="image"><img src="admin_panel/<?=$img_src;?>" alt=""></div>
                                    <div class="description">
                                        <?php if (isset($subcat)) {
                                            if (isset($class)) { ?>
                                                <div class="title"><a href="tovar.php?id=<?=$id;?>&subcat=<?=$subcat;?>&class=<?=$class;?>"><?=$title;?></a></div>
                                                <?php
                                            } else { ?>
                                                <div class="title"><a href="tovar.php?id=<?=$id;?>&subcat=<?=$subcat;?>"><?=$title;?></a></div>
                                                <?php
                                            }
                                        }; ?>
                                        
                                        <div class="rating">
                                            <?php
                                                $sql_rating = "SELECT ROUND(AVG(ev)) AS average_ev FROM feedback WHERE id_prod = '$id'";
                                                $res_rating = $connect->query($sql_rating);

                                                if ($res_rating->num_rows > 0) {
                                                    $row = $res_rating->fetch_assoc();
                                                    $average_ev = $row["average_ev"]; 
                                                    
                                                    if ($average_ev == '5') {
                                                        ?>
                                                        <img src="images/stars/s5.svg" alt="">
                                                        <?php
                                                    } else if ($average_ev == '4') {
                                                        ?>
                                                        <img src="images/stars/s4.svg" alt="">
                                                        <?php
                                                    } else if ($average_ev == '3') {
                                                        ?>
                                                        <img src="images/stars/s3.svg" alt="">
                                                        <?php
                                                    } else if ($average_ev == '2') {
                                                        ?>
                                                        <img src="images/stars/s2.svg" alt="">
                                                        <?php
                                                    } else if ($average_ev == '1') {
                                                        ?>
                                                        <img src="images/stars/s1.svg" alt="">
                                                        <?php
                                                    } else {
                                                        echo 'оценок нет';
                                                    }
                                                } else {
                                                    echo "Нет результатов";
                                                }
                                            ?>
                                        </div>

                                        <div class="info">

                                            <div class="text">
                                                <div class="text-descr">Код <strong class="value"><?=$code;?></strong></div>
                                                <div class="text-descr">Артикул <strong class="value"><?=$article;?></strong></div>
                                                <div class="text-descr">Бренд <strong class="value"><?=$brand;?></strong></div>
                                            </div>
                                            
                                            <?php
                                                $sql_order = "SELECT * FROM orders WHERE id_prod = $id AND id_user = $id_user AND id_order IS NULL";
                                                $res_order = mysqli_query($connect, $sql_order);
                                                if (mysqli_num_rows($res_order) > 0) {
                                                    foreach ($res_order as $row_order) {
                                                        $count = $row_order['count_prod'];
                                                    }
                                                } else {
                                                    $count = 0;
                                                }
                                            ?>
                                            
                                            <div class="to-buy">
                                                <div class="price"><?=$price;?>,00 ₽</div>

                                                <?php
                                                    if ($count == 0) { ?>
                                                        <a href="" onclick="addToBasket(event, <?= $id; ?>, <?=$id_user;?>)" class="button-buy-link"><div class="button-buy">
                                                            <img src="images/basket-white.svg" alt="">Купить</div>
                                                        </a><?php
                                                    } else { ?>
                                                        <div class="count">
                                                            <button onclick="reduceCount1(event, <?=$id;?>)">-</button> 
                                                            <span class="quantity" id="quantity<?=$id;?>2"><?=$count;?></span> шт 
                                                            <button onclick="increaseCount1(event, <?=$id;?>)">+</button>
                                                        </div>
                                                    <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="basketModal<?=$id;?>">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModal('<?=$id;?>')">&times;</span>
                                        <h2 class="top"><img src="images/ok.svg" alt="" style="margin: 0px 10px 10px">Товар добавлен в корзину</h2>

                                        <div class="block" style="border: none">
                                            <div class="img"><img src="admin_panel/<?=$img_src;?>" alt=""></div>
                                            <div class="info">
                                                <h3 style="font-size: 15px"><?=$title;?></h3>
                                                <p style="padding: 10px; border-bottom: 1px solid #e8e8e8">
                                                    <span class="code">Код: <?=$code;?></span>
                                                    <span class="article">Артикул: <?=$article;?></span>
                                                </p>
                                                <div class="info-count-price" style="display: flex; padding-top: 10px">
                                                    <div class="price" id="priceElement<?=$id;?>">Цена: <br> <?=$price;?> ₽</div>
                                                    <div class="count" data-price="<?=$price;?>">
                                                        Количество: <br>
                                                        <button onclick="reduceCount(event, <?=$id;?>)">-</button> 
                                                        <?php
                                                            $sql11 = "SELECT * FROM orders WHERE id_prod = $id AND id_order IS NULL";
                                                            $res11 = mysqli_query($connect, $sql11);
                                                            if (mysqli_num_rows($res11) > 0) {
                                                                foreach ($res11 as $row11) {
                                                                    $count = $row11['count_prod']; 
                                                                }
                                                            }
                                                            $count++;
                                                        ?>
                                                        <span class="quantity" id="quantity<?=$id;?>"><?=$count;?></span> шт 
                                                        <button onclick="increaseCount(event, <?=$id;?>)">+</button>

                                                    </div>
                                                    <?php
                                                        if ($count!=1) { ?>
                                                            <div class="cost">Стоимость: <br> <span id="totalCost<?=$id;?>"><?php $r = $price*$count; echo $r?>,00</span> ₽</div>
                                                        <?php

                                                        } else { ?>
                                                            <div class="cost">Стоимость: <br> <span id="totalCost<?=$id;?>"><?=$price;?>,00</span> ₽</div>
                                                        <?php
                                                        }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <div class="to-basket">
                                                <p>
                                                    <!-- количество всех товаров -->
                                                    <?php
                                                        $sql_count = "SELECT SUM(count_prod) AS total_count_prod FROM orders WHERE id_order IS NULL";
                                                        $result_count = $connect->query($sql_count);

                                                        if ($result_count->num_rows > 0) {
                                                            $row_count = $result_count->fetch_assoc();
                                                            $totalCountProd = $row_count["total_count_prod"]; ?>
                                                            
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                    В корзине <span><strong id="in_basket<?=$id;?>"><?=$totalCountProd;?></strong></span> товара
                                                    
                                                </p>
                                                <p>
                                                    На сумму <span><strong id="in_basket_price<?=$id;?>"><?=$price;?>,00</strong></span> ₽
                                                </p>

                                                <a href="user/basket.php"><div class="button-buy">Перейти в корзину</div></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function addToBasket(event, id, id_user) {
                                        event.preventDefault();
                                        console.log(id_user);

                                        var modal = document.getElementById("basketModal" + id); /* модальное окно */
                                        modal.style.display = "block"; 

                                        var quantityElement = document.getElementById("quantity" + id); /*количество определенного товара в модальном*/
                                        var quantity = parseInt(quantityElement.textContent); /* перевод в int цены в модальном */ 
                                        
                                        sendRequest(id, quantity, id_user);
                                    }

                                    function increaseCount(event, id) {
                                        var quantityElement = document.getElementById("quantity" + id); /*количество определенного товара в модальном*/
                                        var quantity = parseInt(quantityElement.textContent); /* перевод в int цены в модальном */

                                        quantity++;
                                        quantityElement.textContent = quantity;

                                        sendRequest(id, quantity);
                                    }

                                    function reduceCount(event, id) {
                                        var quantityElement = document.getElementById("quantity" + id); /*количество определенного товара в модальном*/
                                        var quantity = parseInt(quantityElement.textContent); /* перевод в int цены в модальном */

                                        quantity--;
                                        quantityElement.textContent = quantity;

                                        if (quantity == 0) {
                                            window.location.reload();
                                        }

                                        sendRequest(id, quantity);
                                    }

                                    function increaseCount1(event, id) {
                                        var quantityElement1 = document.getElementById("quantity" + id + "2"); /*количество определенного товара в модальном*/
                                        var quantity1 = parseInt(quantityElement1.textContent); /* перевод в int цены в модальном */

                                        quantity1++;
                                        quantityElement1.textContent = quantity1;

                                        sendRequest(id, quantity1);
                                    }

                                    function reduceCount1(event, id) {
                                        var quantityElement1 = document.getElementById("quantity" + id + "2"); /*количество определенного товара в модальном*/
                                        var quantity1 = parseInt(quantityElement1.textContent); /* перевод в int цены в модальном */

                                        quantity1--;
                                        quantityElement1.textContent = quantity1;

                                        if (quantity1 == 0) {
                                            window.location.reload();
                                        }

                                        sendRequest(id, quantity1);
                                    }

                                    function sendRequest(id, quantity, id_user) {
                                        var xhttp = new XMLHttpRequest();

                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                console.log(this.responseText);
                                            }
                                        };
                                        xhttp.open("POST", "server/addToBasket.php", true);
                                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                        xhttp.send("id_prod=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity) + "&id_user=" + encodeURIComponent(id_user));

                                        calcSum(id);
                                        calculateTotal(id);
                                        all_count(id);
                                    }

                                    function calcSum(id) {
                                        var xhttp = new XMLHttpRequest();

                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                document.getElementById("in_basket_price" + id).textContent = this.responseText;
                                            }
                                        };
                                        xhttp.open("POST", "server/calcSum.php", true);
                                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                        xhttp.send();
                                    }

                                    function calculateTotal(id) {
                                        var quantityElement = document.getElementById("quantity" + id);
                                        var quantity = parseInt(quantityElement.innerText);

                                        var priceElement = document.getElementById("priceElement" + id);
                                        var priceText = priceElement.innerText;
                                        var price = parseFloat(priceText.replace(/\D/g, '')); 

                                        var total = quantity * price;

                                        var totalCostElement = document.getElementById("totalCost" + id);
                                        totalCostElement.innerText = total;
                                    }
                                    
                                    function all_count(id) {
                                        var xhttp = new XMLHttpRequest();

                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                document.getElementById("in_basket" + id).textContent = this.responseText;
                                                document.getElementById("text_price_basket").textContent = this.responseText + ' товаров';
                                            }
                                        };
                                        xhttp.open("POST", "server/upd_all_tovars.php", true);
                                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                        xhttp.send("id_prod=" + encodeURIComponent(id));
                                    }
                                    
                                    function closeModal(id) {
                                        var modal = document.getElementById("basketModal" + id);
                                        modal.style.display = "none"; 
                                        window.location.reload();
                                    }
                                
                                </script>
                
                                <?php
                            }
                        } else {
                            echo '<p style="padding: 20px">Товаров не найдено</p>';
                        }
                    ?>
                    
                </div>

                <script>
                    function changeDirectionTable(event) {
                        event.preventDefault();

                        var container = document.querySelector('.list-blocks');
                        var blocks = document.getElementsByClassName('block');
                        var info = document.getElementsByClassName('info');
                        var to_buy = document.getElementsByClassName('to-buy');

                        var containerStyle = window.getComputedStyle(container);

                        if (containerStyle.flexDirection === 'row') {
                            container.style.flexDirection = 'column';
                            
                            for (var i = 0; i < blocks.length; i++) {
                                blocks[i].style.flexDirection = 'row';
                                blocks[i].style.width = 'calc(100% - 40px)'; 
                                blocks[i].style.margin = 'auto';
                                info[i].style.flexDirection = 'row';
                                // to_buy[i].style.marginRight = '0px';
                            }
                        } 
                    }

                    function changeDirectionSetka(event) {
                        event.preventDefault();

                        var container = document.querySelector('.list-blocks');
                        var blocks = document.getElementsByClassName('block');
                        var info = document.getElementsByClassName('info');
                        var to_buy = document.getElementsByClassName('to-buy');

                        var containerStyle = window.getComputedStyle(container);

                        if (containerStyle.flexDirection === 'column') {
                            container.style.flexDirection = 'row';
                            container.style.flexWrap = 'wrap';

                            var containerWidth = container.offsetWidth;
                            var blockWidth = containerWidth / 3 - 42;

                            for (var i = 0; i < blocks.length; i++) {
                                blocks[i].style.flexDirection = 'column';
                                blocks[i].style.width = blockWidth + 'px'; 
                                blocks[i].style.margin = '0px';
                                info[i].style.flexDirection = 'column';
                                // to_buy[i].style.marginRight = '';
                            }
                        } 
                    }

                </script>

                <div class="filters-block">
                    <form method="get" id="search_form">
                        <div class="price">
                            <h2>Цена</h2>

                            <div class="blocks-price">
                                <input type="number" name="min_price" id="min_price" value="<?php if (isset($_GET['minPrice'])){ echo $_GET['minPrice']; }?>" placeholder="<?=$minPrice;?> ₽">
                                <span style="margin: 0px"> — </span>
                                <input type="number" name="max_price" id="max_price" value="<?php if (isset($_GET['maxPrice'])){ echo $_GET['maxPrice']; }?>" placeholder="<?=$maxPrice;?> ₽">
                            </div>                            
                        </div>

                        <div class="brand">
                            <h2 onclick="showBrand()" class="arrow">Бренд 
                                <span style="margin-right: 0px"><img src="images/ar-bottom.svg" id="imageid" style="width: 17px; height: 9px"></span>
                            </h2> 
                            
                            <div class="brand-menu" id="menu" style="display: none;">
                                <?php
                                    $res_brand = mysqli_query($connect, $sql_brand);
                                    $i = 1;

                                    if (mysqli_num_rows($res_brand) > 0) {
                                        foreach ($res_brand as $row_brand) {
                                            $brand_name = $row_brand['brand']; ?>

                                            <label id="check-style">
                                                <input type="checkbox" name="brands[]" value="<?=$brand_name;?>"> <?=$brand_name;?>
                                            </label>

                                            <br> <?php
                                            $i++;
                                        }
                                    }
                                ?>                          
                            </div>
                        </div>

                        <div class="button-submit">
                            <input type="submit" value="Подобрать">
                        </div>
                    </form>

                    <script>
                        var brand = document.getElementById('menu');

                        function showBrand() {
                            if (brand.style.display == 'none') {
                                brand.style.display = 'block';
                                document.getElementById("imageid").style.transform = "rotate(0deg)";
                            } else {
                                brand.style.display = 'none';
                                document.getElementById("imageid").style.transform = "rotate(180deg)";
                            }
                        }

                        document.getElementById('search_form').addEventListener('submit', function(event) {
                            event.preventDefault();

                            var minPrice = document.getElementById('min_price').value;
                            var maxPrice = document.getElementById('max_price').value;

                            if (minPrice == '') {
                                minPrice = <?=$minPrice;?>;
                            }

                            if (maxPrice == '') {
                                maxPrice = <?=$maxPrice;?>;
                            }

                            var selectedBrands = [];
                            var checkboxes = document.querySelectorAll('input[name="brands[]"]:checked');
                            checkboxes.forEach(function(checkbox) {
                                selectedBrands.push(checkbox.value);
                            });

                            var url = window.location.href;
                            var newUrl = url + (url.indexOf('?') !== -1 ? '&' : '?') + 'minPrice=' + encodeURIComponent(minPrice) + '&maxPrice=' + encodeURIComponent(maxPrice);
                            
                            if (selectedBrands.length > 0) {
                                newUrl += '&brands=' + encodeURIComponent(selectedBrands.join(','));
                            }

                            var sortOrder = document.getElementById('sort_select').value;
                            if (sortOrder !== '') {
                                newUrl += '&sort=' + sortOrder;
                            }
                            
                            window.location.href = newUrl;
                        });

                    </script>
                </div>
            </div>
        </div>           
        
    </div>
    
    
</body>
</html>