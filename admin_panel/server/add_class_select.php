<?php
    require '../../connect.php';

    $id_subcat = $_GET['id_subcat']; ?>

    <select name="class_sub_id_<?=$id_subcat;?>" id="subcat_<?=$id_subcat;?>" style="width: 100%">
        <option value="Не выбрано">Выберите класс</option>
        <?php
        $sql_class_dist = "SELECT * FROM class WHERE id_subcat = $id_subcat";
        $res_class_dist = mysqli_query($connect, $sql_class_dist);
        if(mysqli_num_rows($res_class_dist) > 0) {
            foreach($res_class_dist as $row_class_dist) { 
                $class_id = $row_class_dist['id_class'];
                $name_class = $row_class_dist['name_class']; ?>
                <option value="<?=$class_id;?>"><?=$name_class;?></option>
                <?php
            }
        } ?>
    </select>