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

        $count_products = 0;

        foreach ($res as $row) {
            $id_prod = $row['id_prod'];
            $count = $row['count_prod'];

            $count_products += $count;
        }

    } else if (mysqli_num_rows($res) == 0) {
        $count_products = 0;
    }

    echo $count_products;
?>