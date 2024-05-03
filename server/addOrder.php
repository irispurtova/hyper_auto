<?php
    session_start();
    
    require '../connect.php';

    if (isset($_SESSION["account"]) && $_SESSION["account"] == 'user') {
        $id_user = 1;
    } else {
        $id_user = 0;
    }

    $name_user = $_POST['name_user'];
    $tel_user = $_POST['tel_user'];
    $email_user = $_POST['email_user'];
    $addr_user = $_POST['addr_user'];
    $totalPrice = $_POST['totalPrice'];

    if ($totalPrice != 0) {
        $sql = "INSERT INTO all_orders (id_user, user_name, user_tel, user_email, user_address, total, status) VALUES ('$id_user', '$name_user', '$tel_user', '$email_user', '$addr_user', '$totalPrice', 1)";
        $res = mysqli_query($connect, $sql);

        if ($res) {
            $id_order = mysqli_insert_id($connect); // Получаем автоматически сгенерированный ID
            $sql1 = "UPDATE orders SET id_order = '$id_order' WHERE id_user = '$id_user' AND id_order IS NULL";
    
            $res1 = mysqli_query($connect, $sql1);
            
            if ($res1) {
                echo 'Спасибо за заказ! С Вами свяжутся для уточнения данных.';
            } else {
                echo '// Ошибка при вставке во вторую таблицу'. mysqli_error($connect);;
            }
        } else {
            echo '// Ошибка при вставке в первую таблицу'. mysqli_error($connect);;
        }
    } else {
        echo 'Выберите товары для заказа!';
    }    
    
?>
