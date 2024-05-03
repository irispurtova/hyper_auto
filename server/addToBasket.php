<?php
    session_start();
    
    require '../connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_prod = $_POST["id_prod"];
        $quantity = $_POST['quantity'];

        $sql1 = "SELECT * FROM orders WHERE id_prod = $id_prod AND id_user = $id_user AND id_order IS NULL";
        $res1 = mysqli_query($connect, $sql1);
        if (mysqli_num_rows($res1) > 0) {
            foreach ($res1 as $row1) {
                $sql = "UPDATE orders SET count_prod = '$quantity' WHERE id_prod = $id_prod AND id_user = $id_user AND id_order IS NULL";
                $result = $connect->query($sql);
            }
        } else {
            $sql = "INSERT INTO orders (id_user, id_prod, count_prod) VALUES ('$id_user', '$id_prod', '$quantity')";
            $result = $connect->query($sql);
        }

        if ($result) {
            echo 'данные в бд обновлены';
        } else {
            echo 'ошибка в обновлении данных в бд';
        }
    }
?>