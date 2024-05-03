<?php
    session_start();
    
    require '../connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }
    
    $sql = "SELECT * FROM orders WHERE id_user = $id_user AND id_order IS NULL";
    $res = mysqli_query($connect, $sql);
    
    if (mysqli_num_rows($res) > 0) {
        $totalPrice = 0;

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
    } else {
        $totalPrice = 0;
    }

    echo $totalPrice;
?>