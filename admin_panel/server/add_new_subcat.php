<?php
require '../../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_subcat = mysqli_real_escape_string($connect, $_POST['new_subcat']);
    $cat_id = intval($_POST['cat_id']);
    
    $query = "INSERT INTO subcategories (id_cat, subcat_name) VALUES ($cat_id, '$new_subcat')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "Подгатегория успешно добавлена";
    } else {
        echo "Ошибка при добавлении";
    }
} else {
    echo 'неудача';
}

?>