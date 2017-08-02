<?php

require_once 'functions.php';

$user = new user();


if (!$user->is_admin()) {
    
    http_response_code(403);
    die();
    
}

if (!isset($_GET['id'])) {
    
    
    http_response_code(403);
    die();
    
}


$remove_id = $_GET['id'];


if ($tests = json_decode(file_get_contents('list.db'), true)) {
    
    
    
    unlink($tests[$remove_id]['path']);
    unset($tests[$remove_id]);
    
    file_put_contents('list.db', json_encode($tests));
    
    
    header('Location: list.php');
    
}





?>
