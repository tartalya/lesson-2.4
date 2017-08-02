<?php

require_once 'functions.php';

$uploads_dir = 'uploads';


if (isset($_POST['send'])) {

    $my_result = 0;
    $test = get_test($_POST['testid']);

    for ($i = 0; $i < count($test); $i++) {

        //echo '<b>' . $test[$i]['right'] . '<br><br>';

        if ($test[$i]['right'] == $_POST[$i]) {

            $my_result = $my_result + 5;
        } else {

            $my_result = $my_result + 2;
        }
    }


    $finish_result = round($my_result / count($test));

    //echo 'Здравствуйте ' . $_POST['username'];
    //echo '<br>';
    //echo 'Ваша оценка за прохождение теста ' . $finish_result;

    $sert_string = 'Выдано ' . $_POST['username']
            . ' c оценкой ' . $finish_result;



    echo '<img src="sert.php?string=' . $sert_string . '">';
    die();
}




if (!isset($_GET['id'])) {

    http_response_code(404);
    echo '404 страница не найдена';
    die();
}

if (!get_test($_GET['id'])) {

    http_response_code(404);
    echo '404 нет такого теста';
    die();
}


$test = get_test($_GET['id']);


include'template.php';
?>





