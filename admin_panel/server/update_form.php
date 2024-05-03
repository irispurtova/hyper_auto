<?php
require '../../connect.php';

$id = mysqli_real_escape_string($connect, $_POST["id"]);
$title = mysqli_real_escape_string($connect, $_POST["title"]); 
$article = mysqli_real_escape_string($connect, $_POST["article"]);
$code = mysqli_real_escape_string($connect, $_POST["code"]);
$brand = mysqli_real_escape_string($connect, $_POST["brand"]);
$price = mysqli_real_escape_string($connect, $_POST["price"]);  
$season_on = mysqli_real_escape_string($connect, $_POST["season"]);          

$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0) {
    foreach($result as $row) { 
        $season = $row['season'];
    }
}

if ($season_on == 'on') {
    if ($season == 'no') {
        $season = 'yes';
    }
} else {
    if ($season == 'yes') {
        $season = 'no';
    }
}

$sql = "UPDATE products SET
        title = '$title',
        article = '$article', 
        code = '$code', 
        brand = '$brand', 
        price = '$price', 
        season = '$season'
        WHERE id = $id";

if (mysqli_query($connect, $sql)) {
    echo "Данные успешно обновлены";
} else {
    echo "Ошибка при обновлении данных: " . mysqli_error($connect);
}

mysqli_close($connect);
?>