<?php
    session_start();

    require "../connect.php";   
    
    if (isset($_GET['del_subcat'])) {
        $pr_del_subcat = $_GET['del_subcat'];

        $query = "DELETE FROM class WHERE id_subcat = $pr_del_subcat";
        mysqli_query($connect, $query) or die(mysqli_error($connect));

        $query1 = "DELETE FROM subcategories WHERE id_subcat = $pr_del_subcat";
        mysqli_query($connect, $query1) or die(mysqli_error($connect));
    }

    if (isset($_GET['del_class'])) {
        $pr_del_class = $_GET['del_class'];

        $query = "DELETE FROM class WHERE id_class = $pr_del_class";
        mysqli_query($connect, $query) or die(mysqli_error($connect));
    }
    
    if ($_SESSION['account'] == 'admin') {
        ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Изменение категорий</title>

                <link rel="stylesheet" href="css/cats.css" type="text/css">
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
                            <a href="../auth/unlogin.php">Выход</a>
                        </div>
                    </div>
                </div>

                <div class="main">
                    <div class="inner">

                        <div class="bread-crumbs"><a href="main.php">Главная</a> > Изменение категорий</div>

                        <div class="cats">
                            <?php
                            $sql = "SELECT * FROM categories";
                            $result = mysqli_query($connect, $sql);

                            if(mysqli_num_rows($result) > 0) {
                                foreach($result as $row) { 
                                    $cat_id = $row['id'];
                                    $cat_name = $row['cat_name']; ?>
<div class="cat">
                                    <br>
                                    <h2 style="color: green"><?=$cat_name;?></h2>
                                    <form action="" method="post" onsubmit="return addSubcat(this)" id="add_subcat_name">
                                        <input type="text" name="new_subcat" placeholder="Введите название новой подкатегории" style="width: 410px; font-size: 18px">
                                        <input type="hidden" name="cat_id" value="<?=$cat_id;?>">    
                                        <input type="submit" name="add_subcat" value="Добавить" style="font-size: 18px">                            
                                    </form>

                                    <table style="width: 600px; font-size: 18px">
                                        <?php
                                        $sql2 = "SELECT * FROM subcategories WHERE id_cat = $cat_id";
                                        $result2 = mysqli_query($connect, $sql2);

                                        if(mysqli_num_rows($result2) > 0) {
                                            foreach($result2 as $row2) { 
                                                $subcat_id = $row2['id_subcat'];
                                                $subcat_name = $row2['subcat_name'];?>
                                                <tr>
                                                    <th style="width: 70%; padding: 4px 0px; font-size: 20px">
                                                        <?=$subcat_name;?>
                                                    </th>
                                                    <td>
                                                        <a onclick="openModal('<?=$subcat_id?>', '<?=$subcat_name;?>')">Изменить</a> / 
                                                        <a href="?del_subcat=<?=$subcat_id?>" onclick="return confirm('Вы уверены?');">&times;</a>
                                                    </td>                                                     
                                                </tr>
                                                
                                                <td>                                            
                                                    <form action="" method="post" onsubmit="return changeCat(this)" id="add_class_name">
                                                        <input type="text" name="new_class" placeholder="Введите название нового класса" style="width: 300px; font-size: 18px">
                                                        <input type="hidden" name="subcat_id" value="<?=$subcat_id;?>">    
                                                        <input type="submit" name="add_class" value="Добавить" style="font-size: 18px">                            
                                                    </form>
                                                </td>
                                                
                                                <?php
                                                $sql3 = "SELECT * FROM class WHERE id_subcat = $subcat_id";
                                                $res3 = mysqli_query($connect, $sql3);

                                                if(mysqli_num_rows($res3) > 0) {
                                                    foreach($res3 as $row3) { 
                                                        $id_class = $row3['id_class'];
                                                        $name_class = $row3['name_class']; ?>
                                                        <tr>
                                                            <td><?=$name_class;?></td>
                                                            <td>
                                                                <a onclick="openModalClass('<?=$id_class?>', '<?=$name_class;?>')">Изменить</a> / 
                                                                <a href="?del_class=<?=$id_class?>" onclick="return confirm('Вы уверены?');">&times;</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } ?>
                                                <?php
                                            }
                                            echo '<br>';
                                        }
                                        ?>
                                    </table>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <form action="" method="post" id="editForm">
                                    <input type="text" name="edited_subcat_name" id="edited_subcat_name" placeholder="Введите новое название подкатегории" style="font-size: 18px; width: 450px">
                                    <input type="hidden" id="subcat_id" name="subcat_id" value="">
                                    <input type="submit" name="submit" value="Сохранить" style="font-size: 18px">
                                </form>
                            </div>
                        </div>

                        <div id="myModalClass" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeClassModal()">&times;</span>
                                <form action="" method="post" id="editFormClass">
                                    <input type="text" name="edited_class_name" id="edited_class_name" placeholder="Введите новое название класса" style="font-size: 18px; width: 450px">
                                    <input type="hidden" id="class_id" name="class_id" value="">
                                    <input type="submit" name="submit" value="Сохранить" style="font-size: 18px">
                                </form>
                            </div>
                        </div>

                        <script>
                            function openModal(subcatId, subcatName) {
                                var modal = document.getElementById("myModal");
                                var editedSubcatNameInput = document.getElementById("edited_subcat_name");
                                var SubcaIdInput = document.getElementById("subcat_id");
                                editedSubcatNameInput.value = subcatName;  
                                SubcaIdInput.value = subcatId;                              
                                modal.style.display = "block";
                            }

                            function openModalClass(classId, className) {
                                var modal = document.getElementById("myModalClass");
                                var editedClassNameInput = document.getElementById("edited_class_name");
                                var ClassIdInput = document.getElementById("class_id");
                                editedClassNameInput.value = className;  
                                ClassIdInput.value = classId;                              
                                modal.style.display = "block";
                            }

                            document.getElementsByClassName("close")[0].onclick = function() {
                                document.getElementById("myModal").style.display = "none";
                            }

                            function closeClassModal() {
                                document.getElementById("myModalClass").style.display = "none";
                            }

                            function changeCat(form) {
                                var new_class = form.querySelector('[name="new_class"]').value;
                                var subcat_id = form.querySelector('[name="subcat_id"]').value;

                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        window.location.reload();
                                    }
                                };
                                xhttp.open("POST", "server/add_new_class.php", true);
                                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhttp.send("new_class=" + encodeURIComponent(new_class) + "&subcat_id=" + encodeURIComponent(subcat_id));
                            }

                            function addSubcat(form) {
                                var new_subcat = form.querySelector('[name="new_subcat"]').value;
                                var cat_id = form.querySelector('[name="cat_id"]').value;

                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        window.location.reload();
                                    }
                                };
                                xhttp.open("POST", "server/add_new_subcat.php", true);
                                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhttp.send("new_subcat=" + encodeURIComponent(new_subcat) + "&cat_id=" + encodeURIComponent(cat_id));
                            }

                            document.getElementById("editForm").addEventListener("submit", function(event) {
                                event.preventDefault(); 
                                
                                var form = event.target;
                                var formData = new FormData(form);
                                
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", 'server/change_subcat_name.php', true);
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        window.location.reload();
                                    }
                                };
                                xhr.send(formData);
                            });

                            document.getElementById("editFormClass").addEventListener("submit", function(event) {
                                event.preventDefault(); 
                                
                                var form = event.target;
                                var formData = new FormData(form);
                                
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", 'server/change_class_name.php', true);
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        window.location.reload();
                                    }
                                };
                                xhr.send(formData);
                            });
                        </script>

                    </div>

                    <script>
                        if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.location.href );
                        }
                    </script>

                </div>
            </body>
            </html>

            <?php
    }
    else {    
        header('Location: ../index.php');
    }
?>

