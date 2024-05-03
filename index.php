<?php
    session_start();    

    require 'connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'admin') {
        header("location: admin_panel/main.php");
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
    <link rel="stylesheet" href="css/index.css" type="text/css">
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
    
    <div class="banner">
        <div class="container">
            <div class="slider">
                <img src="images/banner/1.jpg" alt="Slide 1">
                <img src="images/banner/2.jpeg" alt="Slide 2">
                <img src="images/banner/3.jpg" alt="Slide 3">
                <img src="images/banner/4.jpg" alt="Slide 4">
                <img src="images/banner/5.jpg" alt="Slide 5">
                <img src="images/banner/6.jpg" alt="Slide 6">

                <button class="prev">&#10094;</button>
                <button class="next">&#10095;</button>
            </div>            
        </div>
    </div>

    <div class="inner">
        <div class="container">
            <h2 style="margin-left: 0px">Сезонное предложение</h2>
            
            <div class="tovars">
                <button class="prev" onclick="showPrevItem()">&#10094;</button>

                <div class="carousel">
                    <?php
                        $sql = "SELECT * FROM products  WHERE season = 'yes' order by RAND() ";
                        $res = mysqli_query($connect, $sql);
                        $count = 0;
                        if (mysqli_num_rows($res) > 0) {
                            foreach($res as $row) { 
                                $count++;
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];

                                $sql_img = "SELECT * FROM images WHERE id_product = $id";
                                $img_res = mysqli_query($connect, $sql_img);
                                if (mysqli_num_rows($img_res) > 0) {
                                    foreach ($img_res as $img_row) {
                                        $img_source = $img_row['source']; 
                                        
                                        if ($count <=6 ) { ?>
                                        
                                        <div class="tovar">
                                            <img src="admin_panel/<?=$img_source;?>" alt="">
                                            <p class="title-class"><strong><a href="tovar.php?id=<?=$id;?>" style="color: black"><?=$title;?></a></strong></p>
                                            <p class="price-class"><?=$price;?>,00 ₽</p>
                                        </div>

                                        <?php
                                        } else { ?>
                                            <div class="tovar hidden">
                                                <img src="admin_panel/<?=$img_source;?>" alt="">
                                                <p class="title-class"><strong><a href="tovar.php?id=<?=$id;?>" style="color: black"><?=$title;?></a></strong></p>
                                                <p class="price-class"><?=$price;?>,00 ₽</p>
                                            </div>
                                        <?php
                                        }
                                    }
                                }
                                ?>

                                <?php
                            }
                        }
                    ?>
                </div>

                <button class="next" onclick="showNextItem()">&#10095;</button>
            </div>


            <script>
                let currentIndex = 0;
                const items = document.querySelectorAll('.tovar');
                const itemsHidden = document.querySelectorAll(".hidden");
                let itemsHiddenLenght;
                itemsHiddenLenght = itemsHidden.length;

                function showNextItem() {
                    if (currentIndex < itemsHiddenLenght) {
                        items[currentIndex].classList.add('hidden');
                        currentIndex = (currentIndex + 1) % items.length;
                        items[currentIndex + 5].classList.remove('hidden');
                    }                 
                }

                function showPrevItem() {
                    if (currentIndex == 0) {
                        
                    } else if (currentIndex <= itemsHiddenLenght) {
                        items[currentIndex + 5].classList.add('hidden');
                        currentIndex = (currentIndex - 1 + items.length) % items.length;
                        items[currentIndex].classList.remove('hidden');
                    }
                }
            </script>            

            <h2 style="margin-left: 0px; padding-top: 30px">Техпомощь в дороге</h2>

            <div class="tovars">
                <button class="prev1" onclick="showPrevItem1()">&#10094;</button>

                <div class="carousel1">
                <?php
                    $sql = "SELECT * FROM products WHERE subcategory_id = 2 order by RAND()";
                    $res = mysqli_query($connect, $sql);
                    $count = 0;
                    if (mysqli_num_rows($res) > 0) {
                        foreach($res as $row) { 
                            $count++;
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];

                            $sql_img = "SELECT * FROM images WHERE id_product = $id";
                            $img_res = mysqli_query($connect, $sql_img);
                            if (mysqli_num_rows($img_res) > 0) {
                                foreach ($img_res as $img_row) {
                                    $img_source = $img_row['source']; 

                                    if ($count <=6 ) { ?>                                        
                                        <div class="tovar1">
                                            <img src="admin_panel/<?=$img_source;?>" alt="">
                                            <p class="title-class"><strong><a href="tovar.php?id=<?=$id;?>" style="color: black"><?=$title;?></a></strong></p>
                                            <p class="price-class"><?=$price;?>,00 ₽</p>
                                        </div>

                                        <?php
                                        } else { ?>
                                            <div class="tovar1 hidden1">
                                                <img src="admin_panel/<?=$img_source;?>" alt="">
                                                <p class="title-class"><strong><a href="tovar.php?id=<?=$id;?>" style="color: black"><?=$title;?></a></strong></p>
                                                <p class="price-class"><?=$price;?>,00 ₽</p>
                                            </div>
                                        <?php
                                        }
                                }
                            }
                            ?>

                            <?php
                        }
                    }
                ?>
                </div>

                <button class="next1" onclick="showNextItem1()">&#10095;</button>                
            </div>

            <script>
                let currentIndex1 = 0;
                const items1 = document.querySelectorAll('.tovar1');
                const itemsHidden1 = document.querySelectorAll(".hidden1");
                let itemsHiddenLenght1;
                itemsHiddenLenght1 = itemsHidden1.length;

                function showNextItem1() {
                    if (currentIndex1 < itemsHiddenLenght1) {
                        items1[currentIndex1].classList.add('hidden1');
                        currentIndex1 = (currentIndex1 + 1) % items1.length;
                        items1[currentIndex1 + 5].classList.remove('hidden1');
                    }                 
                }

                function showPrevItem1() {
                    if (currentIndex1 == 0) {
                        
                    } else if (currentIndex1 <= itemsHiddenLenght1) {
                        items1[currentIndex1 + 5].classList.add('hidden1');
                        currentIndex1 = (currentIndex1 - 1 + items1.length) % items1.length;
                        items1[currentIndex1].classList.remove('hidden1');
                    }
                }
            </script>   
            
        </div>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function() {
            var index = 0;
            var slides = document.querySelectorAll('.slider img');
            var totalSlides = slides.length;
            var prevButton = document.querySelector('.prev');
            var nextButton = document.querySelector('.next');
            
            function showSlide(n) {
                for (var i = 0; i < totalSlides; i++) {
                    slides[i].classList.remove('active');
                }
                slides[n].classList.add('active');
            }
            
            function nextSlide() {
                index = (index + 1) % totalSlides;
                showSlide(index);
            }
            
            function prevSlide() {
                index = (index - 1 + totalSlides) % totalSlides;
                showSlide(index);
            }
            
            nextSlide(); // Вызываем функцию nextSlide() один раз при загрузке страницы
            
            var slideInterval = setInterval(nextSlide, 3000);
            
            prevButton.addEventListener('click', function() {
                clearInterval(slideInterval);
                prevSlide();
            });
            
            nextButton.addEventListener('click', function() {
                clearInterval(slideInterval);
                nextSlide();
            });
        });

    </script>

    
</body>
</html>