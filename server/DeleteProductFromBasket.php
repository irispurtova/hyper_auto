<?php
    session_start();
    
    require '../connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }

    if (isset($_POST['id_prod'])) {
        $pr_del = $_POST['id_prod'];

        $sql_del = "DELETE FROM orders WHERE id_prod = $pr_del AND id_user = $id_user AND id_order IS NULL";
        $query = mysqli_query($connect, $sql_del);

        if ($query) {
            echo 'успешно';
        }
    }
?>