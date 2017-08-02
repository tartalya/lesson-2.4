<?php

$uploads_dir = 'uploads';

require_once 'functions.php';

if (isset($_FILES['testfile'])) {

    //var_dump($_FILES);
    $extension = explode('.', $_FILES['testfile']['name']);
    if ($extension[1] != 'json') {

        echo 'Для загрузки принимаются только файлы с раширением json';
        echo '<br><br>';
        echo 'Попробуйте еще раз';
        //var_dump($extension);
        echo '<br><br>';
        draw_admin_form();
    } else {

        $filename = $extension[0] . rand(0, 1000000) . '.' . $extension[1]; //можно было бы и принудительно приписывать .json
        //$_FILES['testfile']['name'] = $filename;

        if (move_uploaded_file($_FILES['testfile']['tmp_name'], $uploads_dir . '/' . $filename)) {

            echo 'Файл успешно загружен<br>';
            echo 'Вы будете перенаправлены на страницу со списком тестов через 3 секунды';
            echo '<meta http-equiv="refresh" content="3;URL=list.php" />'; // именно так, так как такой вариант работает 
            
            

            $res = json_decode(file_get_contents('list.db'), true);


            $res[] = array('path' => "$uploads_dir/$filename", 'name' => $_POST['testname']);




            file_put_contents('list.db', json_encode($res));
        } else {

            echo 'Что то пошло не так и файл не был загружен';
        }
    }
} else {


    draw_admin_form();
}
?>
