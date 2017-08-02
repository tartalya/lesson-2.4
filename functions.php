<?php
if (isset($_COOKIE['blc'])) {

    if (intval($_COOKIE['blc']) > 10) {


        echo 'you banned';
        die;
    }
}

function draw_admin_form() {
    ?>

    <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">


        Загрузить файл с тестом в формате JSON, расширение файла должно быть обязательно .JSON !!!
        <br>
        <input name="testfile" type="file" />
        <br>
        <input type="text" name="testname" placeholder="Введите название теста">
        <br>
        <input type="submit" value="Отправить">
    </form>

    <?php
}

function get_test($id) {

    $id = intval($id);

    $test_path = json_decode(file_get_contents('list.db'), true);


    if (!isset($test_path[$id]['path'])) {

        return false;
    }


    $file = $test_path[$id]['path'];

    $test = json_decode(file_get_contents($file), true);


    return $test;
}

function get_test_name($id) {

    $test_path = json_decode(file_get_contents('list.db'), true);
    $test_name = $test_path[$id]['name'];

    return $test_name;
}

function get_users() {


    $users = json_decode(file_get_contents('login.json'), true);

    if ($users) {

        return $users;
    }

    return false;
}

function have_user($login) {

    $users = json_decode(file_get_contents('login.json'), true);


    if ($users) {

        foreach ($users as $value) {

            if ($login == $value['login']) {

                return true;
            }
        }
    }
    return false;
}

class user {

    function __construct() {

        if ($users = json_decode(file_get_contents('login.json'), true)) {
            $this->users = $users;
        } else {
            $this->users = array();
        }
    }

    private $users;
    private $passkey;

    function start_auth($login, $password, $expire = 0) {



        foreach ($this->users as $value) {


            if ($login == $value['login'] && md5($password) == $value['password']) {

                $this->passkey = $this->generate_passkey();

                $this->users[$value['id']]['passkey'] = $this->passkey;



                setcookie('login', $value['login'], $expire);
                setcookie('passkey', $this->passkey, $expire);
                setcookie('user_id', $value['id'], $expire);
                setcookie('name', $value['name'], $expire);



                file_put_contents('login.json', json_encode($this->users));



                return TRUE;
            }

            return FALSE;
        }
    }

    function is_admin() {



        foreach ($this->users as $value) {

            if (isset($_COOKIE['passkey']) == $value['passkey'] && $value['role'] == 'admin') {

                return true;
            }
        }
        return false;
    }

    function generate_passkey($length = 25) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }
        return $random_string;
    }

    function exist($login) {

        foreach ($this->users as $value) {

            if ($login == $value['login']) {

                return true;
            }
        }

        return false;
    }

    function is_auth($login, $passkey) {

        foreach ($this->users as $value) {

            if ($login == $value['login'] && $passkey == $value['passkey']) {

                return true;
            }
        }

        return false;
    }

}
?>