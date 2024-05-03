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
                        <div class="bread-crumbs"><a href="main.php">Главная</a> > Оформление заказов</div>   
                        
                        <div class="table">
                            <table>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Заказчик</th>
                                    <th>Сумма заказа</th>
                                    <th>Состояние</th>
                                    <th></th>
                                </tr>

                                <?php
                                    $sql = "SELECT * FROM all_orders";
                                    $res = mysqli_query($connect, $sql);
                                    if (mysqli_num_rows($res) > 0) {
                                        foreach ($res as $row) {
                                            $id_order = $row['id_order'];
                                            $user_name = $row['user_name'];
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
                                                <td><?=$id_order;?></td>
                                                <td><?=$user_name;?></td>
                                                <td><?=$total;?> рублей</td>
                                                <td><?=$status;?></td>
                                                <td><a href="order-admin.php?id=<?=$id_order;?>">Подробнее</a></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                                
                                
                            </table>
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

