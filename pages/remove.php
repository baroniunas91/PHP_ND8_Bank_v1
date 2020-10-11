<?php
defined('FRONT') || die;
// jei bando removint nepaspaudes mygtuko
if(!isset($_POST['remove'])) {
    header('Location: '. $mainUrl . $additionallUrl .'?p=main');
    die;
}

$idDelete = $_POST['remove'];
// nuskaitau duomenų bazę
$db = json_decode(file_get_contents(__DIR__ . '/../data/accountsData.json'), 1);
$possibleDelete = true;
$deleteName;
$deleteSurname;

foreach($db as $key => $value) {
    if($value['id'] == $idDelete) {
        if($value['balance'] != 0) {
            $possibleDelete = false;
        } else {
            $deleteName = $db[$key]['name'];
            $deleteSurname = $db[$key]['surname'];
            unset($db[$key]);
        }
        break;
    }
}
if($possibleDelete) {
    $_SESSION['deleteSuccess'] = true;
    $_SESSION['deleteName'] = $deleteName;
    $_SESSION['deleteSurname'] = $deleteSurname;
    file_put_contents(__DIR__ . '/../data/accountsData.json', json_encode($db));
} else {
    $_SESSION['deleteNot'] = !$possibleDelete;
}
header('Location: '. $mainUrl . $additionallUrl .'?p=main');
die;