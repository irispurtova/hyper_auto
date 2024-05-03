<?php
require '../../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edited_subcat_name = mysqli_real_escape_string($connect, $_POST['edited_subcat_name']);
    $subcat_id = intval($_POST['subcat_id']);
    
    $query = "UPDATE subcategories SET subcat_name = '$edited_subcat_name' WHERE id_subcat = $subcat_id";

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