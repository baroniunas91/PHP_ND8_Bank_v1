<?php
defined('FRONT') || die;
if(!isset($_POST['add']) && !isset($_POST['qty']) && !isset($_SESSION['addIndex'])) {
    header('Location: '. $mainUrl . $additionallUrl .'?p=main');
    die;
}

if(isset($_POST['add']) && isset($_SESSION['addIndex'])) {
    unset($_SESSION['addIndex']);
}

if (isset($_SESSION['addIndex'])) {
    $idAdd = $_SESSION['addIndex'];
} else {
    $idAdd = $_POST['add'];
}

$db = json_decode(file_get_contents(__DIR__ . '/../data/accountsData.json'), 1);
foreach($db as $key => $value) {
    if($value['id'] == $idAdd) {
        $index = $key;
        $name = $db[$key]['name'];
        $surname = $db[$key]['surname'];
        $balance = $db[$key]['balance'];
        $_SESSION['addIndex'] = $db[$key]['id'];
        break;
    }
}

if(isset($_POST['index'])) {
    $addQty = $_POST['qty'];
    $index = $_POST['index'];
    // jei vietoj '.' įvedė ',' pakeičiu.
    if(!is_numeric($addQty)) {
        $searchForValue = ',';
        $stringValue = $addQty;
        if(strpos($stringValue, $searchForValue) !== false ) {
            $addQty = str_replace(',', '.', $addQty);
        }
    }
    if(!is_numeric($addQty)) {
        $_SESSION['addNotNumeric'] = true;
        header('Location: '. $mainUrl . $additionallUrl .'?p=add');
        die;
    } else if ($addQty >= 0) {
        $addQty = round($addQty, 2);
        $db[$index]['balance'] += $addQty;
        $_SESSION['addMoneySuccess'] = true;;
        $_SESSION['addMoneySuccessAccount'] = $db[$index]['bankAccount'];
        $_SESSION['addMoneySuccessQty'] = $addQty;
        file_put_contents(__DIR__ . '/../data/accountsData.json', json_encode($db));
        unset($_SESSION['addIndex']);
        header('Location: '. $mainUrl . $additionallUrl .'?p=main');
        die;
    } else {
        $_SESSION['addNegative'] = true;
        $_SESSION['addIndex'] = $db[$index]['id'];
        header('Location: '. $mainUrl . $additionallUrl .'?p=add');
        die;
    }
}

require __DIR__ . '/header.php';
?>
    <div class="content">
        <h1>Add money</h1>
        <h2 class="infoAboutAccount"><?= $name . ' ' . $surname?></h2>
        <h2 class="infoAboutAccount">Account balance: <?= $balance?>Eur</h2>
        <form class="moneyForm" action="" method="post">
            <label>Add money:</label>
            <input type="text" name="qty" placeholder="Enter money">
            <button type="submit" name="index" value="<?= $index?>">Add</button>
        </form>
        <?php if(isset($_SESSION['addNotNumeric'])) : ?>
            <p class="addWrong">Please enter a number!</p>
        <?php 
        unset($_SESSION['addNotNumeric']);
        endif; ?>
        <?php if(isset($_SESSION['addNegative'])) : ?>
            <p class="addWrong">You can't add negative number!</p>
        <?php 
        unset($_SESSION['addNegative']);
        endif; ?>
        <form action="" method="get">
            <button class="create-button" type="submit" name="createAccountBack" value="1">Back to accounts list</button>
        </form>
    </div>
</body>
</html>