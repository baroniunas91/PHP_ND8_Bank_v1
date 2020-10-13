<?php
defined('FRONT') || die;
if(!isset($_SESSION['takeFalse'])) {
    if(!isset($_POST['take']) && !isset($_POST['toTake']) && !isset($_SESSION['temp'])) {
        header('Location: '. $mainUrl . $additionallUrl .'?p=main');
        die;
    }
}
if(isset($_POST['take']) && isset($_SESSION['temp'])) {
    unset($_SESSION['temp']);
}
if (isset($_SESSION['temp'])) {
    $idTake = $_SESSION['temp'];
} else {
    $idTake = $_POST['take'];
}

$db = json_decode(file_get_contents(__DIR__ . '/../data/accountsData.json'), 1);
foreach($db as $key => $value) {
    if($value['id'] == $idTake) {
        $index = $key;
        $name = $db[$key]['name'];
        $surname = $db[$key]['surname'];
        $balance = $db[$key]['balance'];
        $_SESSION['temp'] = $db[$key]['id'];
        break;
    }
}

if(isset($_POST['take2'])) {
    $index = $_POST['take2'];
    $userBalance = $db[$index]['balance'];
    $wantToTake = $_POST['toTake'];
    // jei vietoj '.' įvedė ',' pakeičiu.
    if(!is_numeric($wantToTake)) {
        $searchForValue = ',';
        $stringValue = $wantToTake;
        if(strpos($stringValue, $searchForValue) !== false ) {
            $wantToTake = str_replace(',', '.', $wantToTake);
        }
    }
    if (!is_numeric($wantToTake)) {
        $_SESSION['takeNotNumeric'] = true;
        header('Location: '. $mainUrl . $additionallUrl .'?p=take');
        die;
    } else if($userBalance - $wantToTake >= 0) {
        $wantToTake = round($wantToTake, 2);
        $db[$index]['balance'] -= $wantToTake;
        $_SESSION['takeSuccess'] = true;
        $_SESSION['takeSuccessQty'] = $wantToTake;
        $_SESSION['takeSuccessAccount'] = $db[$index]['bankAccount'];
        file_put_contents(__DIR__ . '/../data/accountsData.json', json_encode($db));
        unset($_SESSION['temp']);
        header('Location: '. $mainUrl . $additionallUrl .'?p=main');
        die;
    } else {
        $_SESSION['takeFalse'] = true;
        $_SESSION['temp'] = $db[$index]['id'];
        header('Location: '. $mainUrl . $additionallUrl .'?p=take');
        die;
    }
}

require __DIR__ . '/header.php';
?>
    <div class="content">
        <h1>Take money</h1>
        <h2 class="infoAboutAccount"><?= $name . ' ' . $surname?></h2>
        <h2 class="infoAboutAccount">Account balance: <?= $balance?> Eur</h2>
        <form class="moneyForm" action="" method="post">
            <label>Take money</label>
            <input type="text" name="toTake" placeholder="Enter money">
            <button type="submit" name="take2" value="<?= $index?>">Take</button>
        </form>
        <?php if(isset($_SESSION['takeFalse'])) : ?>
            <p class="addWrong">Account balance can't be negative!</p>
        <?php 
        unset($_SESSION['takeFalse']);
        endif; ?>
        <?php if(isset($_SESSION['takeNotNumeric'])) : ?>
            <p class="addWrong">Please enter a number!</p>
        <?php 
        unset($_SESSION['takeNotNumeric']);
        endif; ?>
        <form action="" method="get">
            <button class="create-button" type="submit" name="createAccountBack" value="1">Back to accounts list</button>
        </form>
    </div>
</body>
</html>