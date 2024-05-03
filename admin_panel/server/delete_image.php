<?php

require '../../connect.php';

$id = mysqli_real_escape_string($connect, $_POST["userId"]);
$imgSrc = mysqli_real_escape_string($connect, $_POST["imgSrc"]);

$sql = "DELETE FROM images WHERE id_product = $id AND source = '$imgSrc'";

if ($connect->query($sql) === TRUE) {
    echo "Image deleted successfully";
} else {
    echo "Error deleting image: " . $connect->error;
}

// Закрытие соединения с базой данных
$connect->close();
?>
