<?php require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>

    <link rel="stylesheet" href="css/add_tovars.css" type="text/css">
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

    <div class="main">
        <div class="container">
            <div class="bread-crumbs"><a href="main.php">Главная</a> > <a href="all_tovars.php">Все товары</a> > Добавить товар</div>

            <div class="block-values">
                <form id="add" method="post" enctype="multipart/form-data">
                    <select name="category_id" id="main_select" onchange="show_select()">
                        <option value="Не выбрано">Выберите категорию</option>
                        <?php
                            $sql = "SELECT * FROM categories";
                            $res = mysqli_query($connect, $sql);
                            if(mysqli_num_rows($res) > 0) {
                                foreach($res as $row) { 
                                    $id = $row['id'];
                                    $cat_title = $row['cat_name']; ?>
                                        <option value="<?=$cat_title?>"><?=$cat_title?></option>
                                    <?php
                                }
                            } 
                        ?>
                    </select>

                    <?php
                        $sql_dist = "SELECT DISTINCT id_cat FROM subcategories";
                        $res_dist = mysqli_query($connect, $sql_dist);
                        if(mysqli_num_rows($res_dist) > 0) {
                            foreach($res_dist as $row) { 
                                $cat = $row['id_cat']; ?>
                                <select name="subcategory_id_<?=$cat;?>" id="<?=$cat;?>" style="display: none" onchange="updateSubcatId(this)">
                                    <option value="Не выбрано">Выберите подкатегорию</option>
                                    <?php
                                    $sql_dist_sub = "SELECT * FROM subcategories WHERE id_cat = $cat";
                                    $res_dist_sub = mysqli_query($connect, $sql_dist_sub);
                                    if(mysqli_num_rows($res_dist_sub) > 0) {
                                        foreach($res_dist_sub as $row_sub) { 
                                            $subcat_id = $row_sub['id_subcat'];
                                            $subcat_name = $row_sub['subcat_name']; ?>
                                            <option value="<?=$subcat_id;?>"><?=$subcat_name;?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                            }
                        }
                    ?>

                    <div id="class_selects" style="width: 100% "></div>

                    <script>
                        var id_subcat = '';

                        function updateSubcatId(selectElement) {
                            var id_subcat = selectElement.value;
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("class_selects").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("POST", "server/add_class_select.php?id_subcat=" + id_subcat, true);
                            xhttp.send();
                        }

                    </script>                    

                    <input type="text" placeholder="Название товара" name="title">
                    <input type="text" placeholder="Артикул товара" name="article">
                    <input type="text" placeholder="Код товара" name="code">
                    <input type="text" placeholder="Бренд" name="brand">
                    <input type="number" placeholder="Цена товара" name="price">

                    <div class="block-season-tovar">                        
                        <input type="checkbox" id="season" name="season" value="yes">
                        <label for="season" style="font-size: 18px">Сезонный товар</label>
                    </div>
                    
                    <div class="photo">Фото товара:</div>
                    <div>
                        <input type="file" id="images" name="images[]" accept="image/*" required style="font-size: 16px">                        
                    </div>                                      

                    <input type="submit" value="Добавить товар">
                </form>

                <div id="imageContainer"></div>
                
            </div>

            <script>                
                function show_select() {
                    var main_select = document.getElementById('main_select');
                    var autotovars = document.getElementById('1');
                    var autozapchasti = document.getElementById('2');
                    var shini = document.getElementById('3');
                    var masla = document.getElementById('4');
                    var accum = document.getElementById('5');

                    var desired_box = main_select.options[main_select.selectedIndex].value;

                    if (desired_box == 'Автотовары') {
                        autotovars.style.display = '';                        
                        autozapchasti.style.display = 'none';
                        shini.style.display = 'none';
                        masla.style.display = 'none';
                        accum.style.display = 'none';
                    } else if (desired_box == 'Автозапчасти') {
                        autotovars.style.display = 'none';
                        autozapchasti.style.display = '';
                        shini.style.display = 'none';
                        masla.style.display = 'none';
                        accum.style.display = 'none';
                    } else if (desired_box == 'Шины') {
                        autotovars.style.display = 'none';
                        autozapchasti.style.display = 'none';
                        shini.style.display = '';
                        masla.style.display = 'none';
                        accum.style.display = 'none';
                    } else if (desired_box == 'Масла и смазки') {
                        autotovars.style.display = 'none';
                        autozapchasti.style.display = 'none';
                        shini.style.display = 'none';
                        masla.style.display = '';
                        accum.style.display = 'none';
                    } else if (desired_box == 'Аккумуляторы') {
                        autotovars.style.display = 'none';
                        autozapchasti.style.display = 'none';
                        shini.style.display = 'none';
                        masla.style.display = 'none';
                        accum.style.display = '';
                    } else if (desired_box == 'Не выбрано') {
                        autotovars.style.display = 'none';
                        autozapchasti.style.display = 'none';
                        shini.style.display = 'none';
                        masla.style.display = 'none';
                        accum.style.display = 'none';
                    }
                }

                document.getElementById('images').addEventListener('change', handleImageSelect);

                function handleImageSelect(event) {
                    var files = event.target.files;

                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        displayImage(file);
                    }
                }

                function displayImage(file) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var imageSrc = e.target.result;

                        var imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('imageWrapper');

                        var deleteButton = document.createElement('button');
                        deleteButton.classList.add('deleteButton');
                        deleteButton.innerHTML = '✖';

                        deleteButton.addEventListener('click', function () {
                            imageWrapper.remove();
                        });

                        var imageElement = document.createElement('img');
                        imageElement.src = imageSrc;

                        imageWrapper.appendChild(deleteButton);
                        imageWrapper.appendChild(imageElement);
                        document.getElementById('imageContainer').appendChild(imageWrapper);
                    };

                    reader.readAsDataURL(file);
                }
            </script>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $title = $_POST['title'];

                if (isset($_POST['subcategory_id_1'])&&($_POST['subcategory_id_1'] != 'Не выбрано')) {
                    $subcategory_id = $_POST['subcategory_id_1'];
                } else if (isset($_POST['subcategory_id_2'])&&($_POST['subcategory_id_2'] != 'Не выбрано')) {
                    $subcategory_id = $_POST['subcategory_id_2'];
                } else if (isset($_POST['subcategory_id_3'])&&($_POST['subcategory_id_3'] != 'Не выбрано')) {
                    $subcategory_id = $_POST['subcategory_id_3'];
                } else if (isset($_POST['subcategory_id_4'])&&($_POST['subcategory_id_4'] != 'Не выбрано')) {
                    $subcategory_id = $_POST['subcategory_id_4'];
                } else if (isset($_POST['subcategory_id_5'])&&($_POST['subcategory_id_5'] != 'Не выбрано')) {
                    $subcategory_id = $_POST['subcategory_id_5'];
                }    
                
                for ($i = 1; $i < 10000; $i++) {
                    if (isset($_POST['class_sub_id_'.$i])&&($_POST['class_sub_id_'.$i] != 'Не выбрано')) {
                        $class_id = $_POST['class_sub_id_'.$i];
                    }
                }                

                $sql_post = "SELECT * FROM subcategories WHERE id_subcat = '$subcategory_id'";
                $res_post = mysqli_query($connect, $sql_post);
                if(mysqli_num_rows($res_post) > 0) {
                    foreach($res_post as $row) { 
                        $category_id = $row['id_cat']; 
                    }
                }
                
                $article = $_POST['article'];
                $code = $_POST['code'];
                $brand = $_POST['brand'];
                $price = $_POST['price'];

                if (isset($_POST['season'])) {
                    $season = $_POST['season'];
                } else {
                    $season = 'no';
                }

                $connect->begin_transaction();

                try {
                    $sqlTest = "INSERT INTO products (title, category_id, subcategory_id, id_class, article, code, brand, price, season) 
                                VALUES ('$title', '$category_id', '$subcategory_id', '$class_id', '$article', '$code', '$brand', '$price', '$season')";
                                
                    if ($connect->query($sqlTest) !== TRUE) {
                        throw new Exception("Ошибка при добавлении данных в таблицу 'products': " . $connect->error);
                    }
                
                    $lastInsertedId = $connect->insert_id;

                    $targetDirectory = "images/";
                    
                    $uploadedImages = [];
                
                    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
                        $fileName = basename($_FILES["images"]["name"][$key]);
                        $targetFilePath = $targetDirectory . $fileName;
                
                        if (move_uploaded_file($tmp_name, $targetFilePath)) {
                            $uploadedImages[] = $targetFilePath;
                            $sqlImages = "INSERT INTO images (id_product, source) VALUES ('$lastInsertedId', '$targetFilePath')";
                            if ($connect->query($sqlImages) !== TRUE) {
                                throw new Exception("Ошибка при добавлении изображения в таблицу 'images': " . $connect->error);
                            }                                
                        } else {
                            throw new Exception("Ошибка при загрузке изображения $fileName.");
                        }
                    }
                
                    $connect->commit();
                    echo "<br> Товар успешно добавлен!";
                } catch (Exception $e) {
                    $connect->rollback();
                    echo "Ошибка: " . $e->getMessage();
                }
                
                
            }?>
            
        </div>
    </div>
    
</body>
</html>