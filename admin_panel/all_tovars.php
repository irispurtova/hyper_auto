<? require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Все товары</title>

    <link rel="stylesheet" href="css/all_tovars.css" type="text/css">
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
                <a href="">Выход</a>
            </div>
        </div>
    </div>

    <?php
        if (isset($_GET['del'])) {
            $pr_del = $_GET['del'];

            $query = "DELETE FROM products WHERE id = $pr_del";
            mysqli_query($connect, $query) or die(mysqli_error($connect));
        }
    ?>

    <div class="main">
        <div class="container">
            <div class="bread-crumbs"><a href="main.php">Главная</a> > Все товары</div>
            <div class="left">
                <div class="categories">
                    <h1>Категории</h1>
                    <h1 class="all"><a href="all_tovars.php" style="color: #404040; font-size: 26px">Показать все товары</a></h1>
                    <h2><a href="?season_tovar='yes'">Сезонные товары</a></h2>

                    <?php
                        $sql = "SELECT * FROM categories";
                        $result = mysqli_query($connect, $sql);

                        if(mysqli_num_rows($result) > 0) {
                            foreach($result as $row) { 
                                $id_cat = $row['id'];
                                $cat_name = $row['cat_name']; ?>

                                <h2><a href="?id_cat='<?=$id_cat;?>'" name="id_cat"><?=$cat_name;?></a></h2> 
                                <div class="mini_cat">                                
                                    <?php
                                        $sql_subcat = "SELECT * FROM subcategories WHERE id_cat = $id_cat";
                                        $result_subcat = mysqli_query($connect, $sql_subcat);
                                        if(mysqli_num_rows($result_subcat) > 0) {
                                            foreach($result_subcat as $row_1) { 
                                                $id_sub = $row_1['id_subcat'];
                                                $sub = $row_1['subcat_name']; ?>
                                                <h3><a href="?id_subcat='<?=$id_sub;?>'" name="id_subcat"><?=$sub;?></a></h3>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                            <?php                            
                            } 
                        }
                    ?>                  

                    <a href="add-tovar.php"><div class="add-button">Добавить товар</div></a>
                </div>
                <div class="list">
                    <?php
                        if (isset($_GET['id_cat'])) {
                            $id_c = $_GET['id_cat'];
                            $products = "SELECT * FROM products WHERE category_id = $id_c";
                        } else if (isset($_GET['id_subcat'])) {
                            $id_s = $_GET['id_subcat'];
                            $products = "SELECT * FROM products WHERE subcategory_id = $id_s";
                        } else {
                            $products = "SELECT * FROM products";
                        }

                        if (isset($_GET['season_tovar'])) {
                            $season_tovar = $_GET['season_tovar'];
                            $products = "SELECT * FROM products WHERE season = $season_tovar";
                        }
                        
                        $result_products = mysqli_query($connect, $products);

                        if(mysqli_num_rows($result_products) > 0) {
                            foreach($result_products as $row) { 
                                $id = $row['id'];
                                $title = $row['title'];
                                $category = $row['category_id'];
                                $subcategory = $row['subcategory_id'];
                                $article = $row['article'];
                                $code = $row['code'];
                                $brand = $row['brand'];
                                $price = $row['price'];
                                $season = $row['season']; ?>
                                
                                <div class="card">
                                    <div class="img">
                                        <?php
                                            $img_src_sql = "SELECT source FROM images WHERE id_product = $id LIMIT 1";
                                            $res_sql_img = mysqli_query($connect, $img_src_sql);
                                            if(mysqli_num_rows($res_sql_img) > 0) {
                                                foreach($res_sql_img as $row_img) { 
                                                    $img_src = $row_img['source'];
                                                }
                                            }
                                        ?>
                                        <img src="<?=$img_src;?>" alt="">
                                    </div>
                                    <div class="text">
                                        <p><?=$title;?></p>
                                    </div>
                                    <div class="action">
                                        <div class="upd"><a href="upd-tovar.php?id=<?=$id;?>">Изменить</a></div>
                                        <div class="del"><a href="?del=<?=$id?>" onclick="return confirm('Вы уверены?');">Удалить</a></div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p style="font-size: 18px">Товаров нет</p>';
                        }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
    
</body>
</html>