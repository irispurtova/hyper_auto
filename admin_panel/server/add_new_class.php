<?php
require '../../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_class = mysqli_real_escape_string($connect, $_POST['new_class']);
    $subcat_id = intval($_POST['subcat_id']);
    
    $query = "INSERT INTO class (id_subcat, name_class) VALUES ($subcat_id, '$new_class')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "Новый класс успешно добавлен";
    } else {
        echo "Ошибка при добавлении нового класса";
    }
} else {
    echo 'неудача';
}

?>