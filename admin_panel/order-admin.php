<?php
    session_start();

    require "../connect.php";    
    
    if ($_SESSION['account'] == 'admin') {
        ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Административная панель</title>

                <link rel="stylesheet" href="css/orders.css" type="text/css">
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
                        <?php
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                            }
                        ?>
                        <div class="bread-crumbs"><a href="main.php">Главная</a> > <a href="orders.php">Оформление заказов</a> > Заказ №<?=$id;?></div>   
                        
                        <div class="table">
                            <table>
                                <tr>
                                    <th>Имя</th>
                                    <th>Телефон</th>
                                    <th>E-mail</th>
                                    <th>Адрес</th>
                                    <th>Сумма заказа</th>
                                    <th>Статус</th>                                    
                                </tr>

                                <?php
                                    $sql = "SELECT * FROM all_orders WHERE id_order = $id";
                                    $res = mysqli_query($connect, $sql);
                                    if (mysqli_num_rows($res) > 0) {
                                        foreach ($res as $row) {
                                            $name = $row['user_name'];
                                            $tel = $row['user_tel'];
                                            $email = $row['user_email'];
                                            $addr = $row['user_address'];
                                            $total = $row['total'];
                                            $id_status = $row['status'];
                            
                                            $sql_status = "SELECT * FROM order_status WHERE id = $id_status";
                                            $res_status = mysqli_query($connect, $sql_status);
                                            if (mysqli_num_rows($res_status)>0) {
                                                foreach ($res_status as $row_status) {
                                                    $status = $row_status['status'];
                                                }
                                            } ?>
                                            <tr>
                                                <td><?=$name;?></td>
                                                <td><?=$tel;?></td>
                                                <td><?=$email;?></td>
                                                <td><?=$addr;?></td>
                                                <td><?=$total?></td>
                                                <td>
                                                    <select name="status" id="status" onchange="sendRequest(event, <?=$id;?>)">
                                                        <?php
                                                            $sqls = "SELECT * FROM order_status";
                                                            $ress = mysqli_query($connect, $sqls);
                                                            if (mysqli_num_rows($ress)>0) {
                                                                foreach ($ress as $rows) {
                                                                    $status_value = $rows['id']; 
                                                                    $status_text = $rows['status'];
                                                                    
                                                                    if ($id_status == $status_value) {
                                                                        ?><option value="<?=$status_value;?>" selected><?=$status_text;?></option><?php
                                                                    } else {
                                                                        ?><option value="<?=$status_value;?>"><?=$status_text;?></option><?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                                
                                
                            </table>

                            <script>
                                function sendRequest(event, id) {
                                    event.preventDefault();

                                    var selectedValue = document.getElementById("status").value;
                                    console.log(selectedValue);

                                    var xhttp = new XMLHttpRequest();

                                    xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            console.log(xhttp.responseText);
                                        }
                                    };
                                    xhttp.open("POST", "server/updStatus.php", true);
                                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    xhttp.send("id=" + encodeURIComponent(id) + "&selectedValue=" + encodeURIComponent(selectedValue));
                                }
                            </script>
                        </div>

                        <div class="tovars">
                        <?php
                            $sql1 = "SELECT * FROM orders WHERE id_order = $id";
                            $res1 = mysqli_query($connect, $sql1);
                            if (mysqli_num_rows($res1)>0) {
                                foreach ($res1 as $row1) {
                                    $id_prod = $row1['id_prod'];
                                    $count_prod = $row1['count_prod'];

                                    $sql2 = "SELECT * FROM products WHERE id = $id_prod";
                                    $res2 = mysqli_query($connect, $sql2);
                                    if (mysqli_num_rows($res2)>0) {
                                        foreach ($res2 as $row2) {
                                            $title = $row2['title'];
                                            $price = $row2['price'];

                                            $sql3 = "SELECT * FROM images WHERE id_product = $id_prod LIMIT 1";
                                            $res3 = mysqli_query($connect, $sql3);
                                            if (mysqli_num_rows($res3)>0) {
                                                foreach ($res3 as $row3) {
                                                    $img_source = $row3['source'];?>

                                                    <div class="order-item">
                                                        <div class="left" style="width: 100px; margin: 0px">
                                                            <img src="../admin_panel/<?=$img_source;?>" alt="" width="100px">
                                                        </div>
                                                        
                                                        <div class="right">
                                                            <p><?=$title;?></p>
                                                            <p><?=$count_prod;?> штук</p>
                                                            <p>Цена: <?=$price;?> рублей</p>
                                                        </div>
                                                        
                                                    </div>

                                                    
                                                        

                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            } ?>
                        </div>
                    </div>
                </div>
                
            </body>
            </html>

            <?php
    }
    else {    
        header('Location: ../index.php');
    }
?>

