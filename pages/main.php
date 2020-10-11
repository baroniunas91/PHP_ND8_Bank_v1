<?php
defined('FRONT') || die;
if(file_exists(__DIR__ . '/../data/accountsData.json')) {
    $accountsDb = json_decode(file_get_contents(__DIR__ . '/../data/accountsData.json'), 1);
} else {
    $accountsDb = file_put_contents(__DIR__ . '/../data/accountsData.json', json_encode([]));
}
require __DIR__ . '/header.php';
?>
    <div class="content">
        <h1>Bank accounts list</h1>
        <form action="" method="get">
            <button class="create-button" type="submit" name="createAccount" value="1">Create new account</button>
        </form>
        <!-- pridėda sąskaita sekmingai pranešimas -->
        <?php
        if(isset($_SESSION['addSuccess'])) : ?>
        <h3 class="addSuccess"><?= $_SESSION['addSuccess'] ?></h3>
        <?php 
        unset($_SESSION['addSuccess']);
        endif; ?>
        <!-- ištrinta sąskaita sėkmingai -->
        <?php
        if(isset($_SESSION['deleteSuccess'])) : ?>
        <h3 class="addSuccess">You successfully delete <?= $_SESSION['deleteName'] . ' ' . $_SESSION['deleteSurname']?> bank account</h3>
        <?php 
        unset($_SESSION['deleteSuccess']);
        unset($_SESSION['deleteName']);
        unset($_SESSION['deleteSurname']);
        endif; ?>
        <!-- ištrinti sąskaitos nepavyko pranešimas -->
        <?php
        if(isset($_SESSION['deleteNot'])) : ?>
        <h3 class="addWrong">You can delete accounts only with 0Eur account balance!</h3>
        <?php 
        unset($_SESSION['deleteNot']);
        endif; ?>
        <!-- pranešimas, kad paimti pinigus iš sąskaitos pavyko -->
        <?php
        if(isset($_SESSION['takeSuccess'])) : ?>
        <h3 class="addSuccess">You are successfully take <?= $_SESSION['takeSuccessQty']?>Eur from <?= $_SESSION['takeSuccessAccount']?> bank account!</h3>
        <?php 
        unset($_SESSION['takeSuccess']);
        unset($_SESSION['takeSuccessAccount']);
        unset($_SESSION['takeSuccessQty']);
        endif; ?>
        <!-- pranešimas, kad įdėti pinigus į sąskaitą pavyko -->
        <?php
        if(isset($_SESSION['addMoneySuccess'])) : ?>
        <h3 class="addSuccess">You are successfully add <?= $_SESSION['addMoneySuccessQty']?>Eur into <?= $_SESSION['addMoneySuccessAccount']?> bank account!</h3>
        <?php 
        unset($_SESSION['addMoneySuccess']);
        unset($_SESSION['addMoneySuccessAccount']);
        unset($_SESSION['addMoneySuccessQty']);
        endif; ?>
        <?php foreach($accountsDb as $value): ?>
        <div class=account>
            <div class="account-info">
                <p class="name"><?= $value['name'] ?></p>
                <p class="surname"><?= $value['surname'] ?></p>
                <p class="id"><?= $value['personId'] ?></p>
                <p class="bank-account"><?= $value['bankAccount'] ?></p>
                <p class="balance"><?= $value['balance']?>Eur</p>
            </div>
            <div class="account-actions">
                <form action="<?= $mainUrl . $additionallUrl .'?p=remove' ?>" method="post">
                    <button type="submit" name="remove" value="<?= $value['id'] ?>" class="delete">Delete</button>
                </form>
                <form action="<?= $mainUrl . $additionallUrl .'?p=add' ?>" method="post">
                    <button type="submit" name="add" value="<?= $value['id'] ?>" class="add">Add</button>
                </form>
                <form action="<?= $mainUrl . $additionallUrl .'?p=take' ?>" method="post">
                    <button type="submit" name="take" value="<?= $value['id'] ?>" class="take">Take</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>