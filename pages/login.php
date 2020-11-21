<?php
$wrongLogin = '';
if(!empty($_POST)) {
    $db = json_decode(file_get_contents(__DIR__ . '/../data/employeesData.json'), 1);

    foreach($db as $employee) {
        if($_POST['name'] == $employee['name']) {
            if(md5($_POST['psw']) == $employee['psw']) {
                $_SESSION['login'] = 1;
                $_SESSION['name'] = $employee['name'];
                header('Location: '. $mainUrl . $additionallUrl .'?p=main');
                die;
            }
        }
    }
    $wrongLogin = 'Wrong name or password!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div class="login">
        <h1>Welcome to my bank. Please login!</h1>
        <h1>Name: Jonas Psw: 1234</h1>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name">
            <label for="psw">Password:</label>
            <input type="password" name="psw">
            <button type="submit">Login</button>
        </form>
        <p style="color: red; font-size: 18px"><?= $wrongLogin ?></p>
    </div>
</body>
</html>