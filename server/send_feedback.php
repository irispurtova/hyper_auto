<?php   
    require '../connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = htmlentities(mysqli_real_escape_string($connect, $_POST['id_prod']));
        $name_user = htmlentities(mysqli_real_escape_string($connect, $_POST['name']));
        $plus_user = htmlentities(mysqli_real_escape_string($connect, $_POST['plus']));
        $minus_user = htmlentities(mysqli_real_escape_string($connect, $_POST['minus']));
        $text_user = htmlentities(mysqli_real_escape_string($connect, $_POST['text_feedback']));

        if(isset($_POST['stars'])) {
            if ($_POST['stars'] == '1') {
                $evaluation = 1;
            } elseif ($_POST['stars'] == '2') {
                $evaluation = 2;
            } elseif ($_POST['stars'] == '3') {
                $evaluation = 3;
            } elseif ($_POST['stars'] == '4') {
                $evaluation = 4;
            } elseif ($_POST['stars'] == '5') {
                $evaluation = 5;
            }
        }
        
        $sql = "INSERT INTO feedback (name, plus, minus, text, ev, id_prod) VALUES ('$name_user', '$plus_user', '$minus_user','$text_user', '$evaluation', '$id')";

        if (mysqli_query($connect, $sql)) {
            echo '<div class="result" style="padding-top: 20px">Спасибо за отзыв!</div>';
        } else {
            echo 'Error: ' . mysqli_error($connect);
        }
    }
?>