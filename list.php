<?php

include 'functions.php';
$user = new user();


if (empty($_COOKIE['guest_name']) && !$user->is_auth(isset($_COOKIE['login']), isset($_COOKIE['passkey']))) {


    http_response_code(403);
    die();
}



if (!json_decode(file_get_contents('list.db'), true)) {

    echo 'В базе нет ни одного теста';
    die;
}

if (is_null($result = json_decode(file_get_contents('list.db'), true))) {
    
    echo 'Файл базы поврежден или имеет не верный формат';
    die;
}


foreach ($result as $key => $value) {


    echo '<a href="test.php?id=' . $key . '">' . $value['name'] . '</a>';
    if ($user->is_admin()) {

        echo ' <a href="delete.php?id=' . $key . '">Удалить это тест</a>';
    }

    echo '<br><br>';
}



if ($user->is_admin()) {


    echo '<a href="admin.php"> Добавить тест </a>';
}
?>

