<?php
    session_start();
    
    require '../connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }

    $id_prod = $_POST["id_prod"];

    $sql_count = "SELECT SUM(count_prod) AS total_count_prod FROM orders WHERE id_user = $id_user AND id_order IS NULL";
    $result_count = $connect->query($sql_count);

    if ($result_count->num_rows > 0) {
        $row_count = $result_count->fetch_assoc();
        $totalCountProd = $row_count["total_count_prod"]; ?>
        
        <?php
    }

    echo $totalCountProd;
?>