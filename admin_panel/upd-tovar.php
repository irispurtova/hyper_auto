<?php require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>

    <link rel="stylesheet" href="css/upd_tovar.css" type="text/css">
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
            <div class="bread-crumbs"><a href="main.php">Главная</a> > <a href="all_tovars.php">Все товары</a> > Изменить товар</div>

            <div class="block-values">
                <form id="upd" method="post" enctype="multipart/form-data">

                <?php
                    if(isset($_GET["id"])) {
                        $id = mysqli_real_escape_string($connect, $_GET["id"]);

                        $Photos = mysqli_query($connect, "SELECT * FROM `images` WHERE `id_product`='$id'");    
                        $Photos = mysqli_fetch_all($Photos, MYSQLI_ASSOC);
                    
                        $sql = "SELECT * FROM products WHERE id = '$id'";
                    
                        if($result = mysqli_query($connect, $sql)) {
                            if(mysqli_num_rows($result) > 0) {
                                foreach($result as $row) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    $category = $row['category_id'];
                                    $subcategory = $row['subcategory_id'];
                                    $article = $row['article'];
                                    $code = $row['code'];
                                    $brand = $row['brand'];
                                    $price = $row['price'];
                                    $season = $row['season']; ?>

                                    <input type="hidden" name="id" value="<?=$id;?>">

                                        <input type="text" placeholder="Название товара" name="title" value="<?=$title;?>">
                                        <input type="text" placeholder="Артикул товара" name="article" value="<?=$article;?>">
                                        <input type="text" placeholder="Код товара" name="code" value="<?=$code;?>">
                                        <input type="text" placeholder="Бренд" name="brand" value="<?=$brand;?>">
                                        <input type="number" placeholder="Цена товара" name="price" value="<?=$price;?>">

                                        <div class="block-season-tovar">
                                            <?php
                                                if ($season=='yes') { ?>
                                                    <input type="checkbox" id="season" name="season" checked>
                                                    <?php
                                                } else { ?>
                                                    <input type="checkbox" id="season" name="season">
                                                    <?php
                                                }
                                            ?> 
                                            <label for="season">Сезонный товар</label>                       
                                        </div>
                                        <div class="photo">Фото товара:</div>
                                        <div>
                                            <input type="file" id="images" name="images[]" accept="image/*" multiple style="font-size: 16px">                        
                                        </div>

                                        <input type="submit" value="Изменить товар" onclick="submitForm(event)">
                                    <?php
                                }
                            }
                        }
                    }
                ?>
                </form>

                <div id="imageContainer">
                    <?php
                        foreach($Photos as $key => $value) { ?> 
                            <div class="imageWrapper" id="photo_<?= $key + 1 ?>">
                                <div class="deleteButton" onclick="deleteImage('<?= $value['source']; ?>', '<?= $id; ?>')">✖</div>
                                <img src="<?= $value['source']; ?>">
                            </div> <?php                        
                        }
                    ?>
                </div>
                
            </div>

            <script>
                var id = <?= $id; ?>;

                function deleteImage(imgSrc, id) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'server/delete_image.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    var params = 'imgSrc=' + encodeURIComponent(imgSrc) + '&userId=' + encodeURIComponent(id);
                    xhr.send(params);

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log(xhr.responseText);
                            var element = document.querySelector('[src="' + imgSrc + '"]').closest('.imageWrapper');
                            if (element) {
                                element.parentNode.removeChild(element);
                            }
                        }
                    };
                }    

                function show_select() {
                    var main_select = document.getElementById('main_select');
                    var autotovars = document.getElementById('autotovars');
                    var autozapchasti = document.getElementById('autozapchasti');
                    var shini = document.getElementById('shini');
                    var masla = document.getElementById('masla');
                    var accum = document.getElementById('accum');

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


                    console.log(main_select);
                }

                document.getElementById('images').addEventListener('change', handleImageSelect);

                function handleImageSelect(event) {
                    var files = event.target.files;

                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        displayImage(file);
                        uploadImage(file, id);
                    }
                }

                function uploadImage(file, id) {
                    var formData = new FormData();
                    formData.append('image', file);
                    formData.append('id', id); 

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'upload_img.php', true);

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log('Изображение успешно загружено');
                        }
                    };

                    xhr.send(formData);
                }

                function displayImage(file) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var imageSrc = e.target.result;

                        var imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('imageWrapper');

                        var deleteButton = document.createElement('div');
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

            <div id="result"></div>

            <script>
                function submitForm(event) {
                    event.preventDefault();
                    var form = document.getElementById("upd");
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.response);
                            document.getElementById("result").innerHTML = 'Данные успешно обновлены!'
                        }
                    };

                    xhr.open("POST", "server/update_form.php", true);
                    xhr.send(formData);
                }
            </script>            
        </div>
    </div>
    
</body>
</html>