<html>
    <head>
        <title><?= get_test_name($_GET['id']) ?></title>
        <meta charset="utf-8">



    </head>

    <body>

    <center><h1><?= get_test_name($_GET['id']) ?></h1></center>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

        <?php
        for ($i = 0; $i < count($test); $i++) {

            echo '<b>' . $test[$i]['questions'] . '<br><br>';

            foreach ($test[$i]['variants'] as $valu) {


                echo '<input type="radio" value="' . $valu . '" name="' . $i . '">' . $valu . '<br><br>';
            }
        }
        ?>
        <br>
        <input type="text" name="username" placeholder="Пожалуйста представьтесь">
        <input type="hidden" name="testid" value="<?= $_GET['id'] ?>">
        <input type="submit" name="send" value="отправить">
    </form>

</body>
</html>