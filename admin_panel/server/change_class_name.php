<?php
require '../../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edited_class_name = mysqli_real_escape_string($connect, $_POST['edited_class_name']);
    $class_id = intval($_POST['class_id']);
    
    $query = "UPDATE class SET name_class = '$edited_class_name' WHERE id_class = $class_id";

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