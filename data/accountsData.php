<?php
session_start();
$mainUrl = $_SESSION['mainUrl'];
$additionallUrl = $_SESSION['additionallUrl'];

if(!file_exists('accountsData.json')) {
    $accounts = [];
}
$accounts = json_decode(file_get_contents('accountsData.json'), 1);

if(isset($_POST['create'])) {
    // suskaiciuojam id
    if(count($accounts) == 0) {
        $id = 1;
    } else {
        $maxId = 0;
        foreach($accounts as $val) {
            if($val['id'] > $maxId) {
                $maxId = $val['id'];
            }
        }
        $id = $maxId + 1;
    }
    // patikrinu asmens koda ar validus
    $personId = $_POST['personId'];
    $personIdValid = true;
    if(strlen($personId) != 11 || !is_numeric($personId)) {
        $personIdValid = false;
    }
    //patikrinu ar pirmas skaicius geras nuo 1 iki 6
    $firstNr = false;
    if(strlen($personId) == 11) {
        for($i=1; $i<=6; $i++) {
            if((int)$personId[0] == $i) {
                $firstNr = true;
            }
        }
    }
    if(!$firstNr) {
        $personIdValid = false;
    }
    foreach($accounts as $value) {
        if($personId == $value['personId']) {
            $personIdValid = false;
        }
    }
    //generuoju banko saskaita
    $bankAccount = 'LT';
    for($i=1; $i<=18; $i++) {
        if($i==3) {
            $bankAccount .= '7';
        } else if($i==4) {
            $bankAccount .= '3';
        } else if($i>=5 && $i <=7) {
            $bankAccount .= '0';
        } else {
            $bankAccount .= rand(0, 9);
        }
    }
    // tikrinu ar name nėra skaičiaus, jei yra nepraleidžiu
    $enteredName = $_POST['name'];
    $validName = true;
    if(strlen($enteredName) <= 3) {
        $validName = false;
    }
    for($i=0; $i<strlen($enteredName); $i++) {
        if(is_numeric($enteredName[$i])) {
            $validName = false;
        }
    }
    // tikrinu ar surname nėra skaičiaus, jei yra nepraleidžiu
    $enteredSurname = $_POST['surname'];
    $validSurname = true;
    if(strlen($enteredSurname) <= 3) {
        $validSurname = false;
    }
    for($i=0; $i<strlen($enteredSurname); $i++) {
        if(is_numeric($enteredSurname[$i])) {
            $validSurname = false;
        }
    }
    // jei kazkur buvo nevalidu redirectins vel vesti is naujo
    if(!$validName || !$validSurname || !$personIdValid) {
        if(!$validName) {
            $_SESSION['addWrongName'] = 'Name should be more than 3 symbols and symbols should be not a numbers!';
        }
        if(!$validSurname) {
            $_SESSION['addWrongSurname'] = 'Surname should be more than 3 symbols and symbols should be not a numbers!';
        }
        if(!$personIdValid) {
            $_SESSION['addWrongPersonId'] = 'Person ID is not valid!';
        }
        header('Location: '. $mainUrl . $additionallUrl .'?p=create');
        die;
    }
    
    
    $newAccount = ['id'=>$id,'name' => $_POST['name'], 'surname' => $_POST['surname'], 'personId' => $personId, 'bankAccount' => $bankAccount, 'balance' => 0];
    array_push($accounts, $newAccount);
    usort($accounts, function($a, $b) {
        return $a['surname'] > $b['surname'];
    });
    file_put_contents('accountsData.json', json_encode($accounts));
    $_SESSION['addSuccess'] = 'You are successfully added new account! Owner: ' . $newAccount['name'] .' '. $newAccount['surname'];
    header('Location: '. $mainUrl . $additionallUrl .'?p=main');
    die;
}