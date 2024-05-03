<?php
require 'connect.php';

$id = mysqli_real_escape_string($connect, $_POST["id"]);
//$image = mysqli_real_escape_string($connect, $_POST["image"]);

if ($_FILES['image']) {
    $uploadDir = 'images/';
    $fileName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $stmt = $connect->prepare("INSERT INTO images (id_product, source) VALUES (?, ?)");
        $stmt->bind_param("ss", $id, $targetFile);

        if ($stmt->execute()) {
            echo "Изображение успешно загружено в базу данных";
        } else {
            echo "Ошибка при загрузке в базу данных: " . $connect->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка при загрузке файла на сервер";
    }
} else {
    echo 'тут ошибка';
}
?>