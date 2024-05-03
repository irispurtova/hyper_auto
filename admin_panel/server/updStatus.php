<?php
require '../../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedValue = $_POST['selectedValue'];
    $id = $_POST['id'];
    
    $query = "UPDATE all_orders SET status = '$selectedValue' WHERE id_order = $id";

    $result = mysqli_query($connect, $query);

    if ($result) {
        echo 'успех';
    } else {
        echo "Ошибка";
    }
} else {
    echo 'неудача';
} 

?>