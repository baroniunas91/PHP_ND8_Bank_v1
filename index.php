<?php
session_start();

// $mainUrl = 'http://localhost';
// $additionallUrl = '/BIT/ND8_Bankas_v1/';
$mainUrl = 'https://erbars.000webhostapp.com';
$additionallUrl = '/';

$_SESSION['mainUrl'] = $mainUrl;
$_SESSION['additionallUrl'] = $additionallUrl;
define('FRONT', true);
if(!($_SESSION['login'] ?? 0)) {
    require __DIR__.'/pages/login.php';
} else {
    if(isset($_GET['p'])) {
        if('add' == $_GET['p']) {
            require __DIR__.'/pages/add.php';
        }
        if('create' == $_GET['p']) {
            require __DIR__.'/pages/create.php';
        }
        if('remove' == $_GET['p']) {
            require __DIR__.'/pages/remove.php';
        }
        if('take' == $_GET['p']) {
            require __DIR__.'/pages/take.php';
        }
        if('main' == $_GET['p']) {
            require __DIR__.'/pages/main.php';
        }
    } else {
        if(!isset($_GET['p']) && !isset($_GET['logout']) && !isset($_GET['createAccount']) && !isset($_GET['createAccountBack'])) {
            header('Location: '. $mainUrl . $additionallUrl .'?p=main');
            die;
        }
    }
}

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: '. $mainUrl . $additionallUrl .'?p=main');
    die;
}
if(isset($_GET['createAccount'])) {
    header('Location: '. $mainUrl . $additionallUrl .'?p=create');
    die;
}
if(isset($_GET['createAccountBack'])) {
    if(isset($_SESSION['temp'])) {
        unset($_SESSION['temp']);
    }
    if(isset($_SESSION['addIndex'])) {
        unset($_SESSION['addIndex']);
    }
    header('Location: '. $mainUrl . $additionallUrl .'?p=main');
    die;
}
