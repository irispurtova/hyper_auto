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
    <link rel="stylesheet" href="css/winter.css" type="text/css">
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
                <h1>Готовимся к зиме: аксессуары и советы водителям</h1>
            </div>

            <div class="img-header">
                <img src="images/zima/banner-zima.webp" alt="">
            </div>

            <div class="text-1">
                <p>Зима! Дети ждут её с радостью, автомобилисты — с опаской. Морозы, снегопады, скользкие дороги, агрессивные реагенты — всё это серьёзные вызовы и для машин, и для водителей. Поэтому зимой особенно важны хорошая подготовка автомобиля и умелые действия за рулём. В помощь автомобилистам — наша подборка полезных статей и зимних аксессуаров.</p>
            </div>

            <div class="text-2">
                <h2>Зимние шины</h2>

                <p>Хороший зацеп шин — основа уверенности на скользкой дороге. Выбирайте шипованные или фрикционные шины исходя из климата своего региона: где-то комфортнее ездить на «липучке», а где-то лучше встречать зиму на шипах.</p>
                <p>Контролируйте давление в шинах — зимой особенно важно, чтобы колёса были накачаны одинаково и вели себя предсказуемо. Фрикционные шины на льду работают лучше при слегка сниженном давлении, когда увеличено пятно контакта с дорогой. Шипованные шины спускать не стоит — шипам будет сложнее вгрызаться в лёд.</p>
                <p>В сильный снегопад выручат цепи противоскольжения. Они надеваются на ведущие колёса и значительно улучшают проходимость автомобиля — на цепях даже без 4WD можно уверенно ездить по заснеженным дорогам.</p>
            </div>
            
            <div class="block">
                <div class="item">
                    <a href="">
                    <img src="images/zima/fric_shiny.webp" alt="">
                    </a>
                    <a href="search.php" class="title">Фрикционные шины</a>
                </div>
                <div class="item">
                    <a href="">
                    <img src="images/zima/ship_shiny.webp" alt="">
                    </a>
                    <a href="" class="title">Шипованные шины</a>
                </div>
                <div class="item">
                    <a href="">
                    <img src="images/zima/cepy_protivoskols.webp" alt="">
                    </a>
                    <a href="" class="title">Цепи противоскольжения</a>
                </div>
                <div class="item">
                    <a href="">
                    <img src="images/zima/compressory.webp" alt="">
                    </a>
                    <a href="" class="title">Компрессоры и насосы</a>
                </div>
            </div>
            
            <div class="text-2">
                <h2>Аккумулятор и зимний запуск двигателя</h2>

                <p>Хороший аккумулятор — главное условие успешного зимнего запуска двигателя. Конечно, есть много других факторов: вязкость моторного масла, компрессия в цилиндрах, качество топлива, состояние свечей. Но чаще всего на морозе подводит именно батарея, поэтому заранее обновите АКБ при первых признаках проблем.</p>
                <p>Если аккумулятор разрядился случайно (например, из-за оставленного освещения), привести его в чувство можно стационарным зарядным устройством. Да и в качестве профилактики «взбодрить» АКБ перед зимой не помешает — в коротких городских поездках аккумулятор редко заряжается полностью.</p>
                <p>Экстренно «прикурить» разряженный аккумулятор можно от портативного пускового устройства — бустера. Или по старинке, с помощью пусковых проводов и отзывчивого водителя. Прочтите нашу статью о «прикуривании», чтобы сделать всё правильно и не сжечь бортовую электрику.</p>
            </div>

            <div class="block">
                <div class="item">
                    <a href="">
                    <img src="images/zima/akkum.webp" alt="">
                    </a>
                    <a href="" class="title">Аккумуляторы</a>
                </div>
                <div class="item">
                    <a href="">
                    <img src="images/zima/pusk_provoda.webp" alt="">
                    </a>
                    <a href="" class="title">Пусковые провода</a>
                </div>
                <div class="item">
                    <a href="">
                    <img src="images/zima/zu.webp" alt="">
                    </a>
                    <a href="" class="title">Зарядные устройства</a>
                </div>
                <div class="item">
                    <a href="">
                    <img src="images/zima/pusk_ustr.webp" alt="">
                    </a>
                    <a href="" class="title">Пусковые устройства</a>
                </div>
            </div>

            <div class="text-2">
                <p>Сверили все пункты? Считайте, что к зиме готовы! Правильно обслуженный и снаряжённый автомобиль не подведёт в снегопад и не заставит внепланово вызывать такси морозным утром. Пусть ваша зима пройдёт позитивно и безаварийно! Но если технике вдруг потребуется помощь — Гиперавто всегда рядом.</p>
            </div>
            

        </div>
    </div>
    
</body>
</html>