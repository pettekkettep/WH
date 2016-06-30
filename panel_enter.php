<?php

require_once('./functions_x.php');

session_start();
$style = 'display:none';

if(users_is_admin($_SESSION['username'], $_SESSION['password'])){
    header("Location: index_x.php");
    exit();
}

if(isset($_POST['login']) && isset($_POST['password'])){
    $_POST['password'] = md5($_POST['password']);
    if(users_is_admin($_POST['login'], $_POST['password'])){
        $_SESSION['username'] = $_POST['login'];
        $_SESSION['password'] = $_POST['password'];
        header("Location: index_x.php");
        exit();
    }
    else {
        $style = 'display:block';
    }
}





?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
    <div class="login-form form-sleek">
        <form action="/panel_enter.php" method="post">
            <h1>Strefa nauczycieli.</h1><h1> Aby przejść dalej, wpisz hasło.</h1><hr>
            <h3>"Z wielką mocą wiąże się wielka odpowiedzialność"</h3>
            <div class="error" style="<? echo $style ?>">
                Zaszła jakaś pomyłeczka. Spróbuj ponownie!
            </div>
            Login <input type="text" name="login" placeholder="Najlepiej swój"></input>
            Hasło <input type="password" name="password" placeholder="Najlepiej poprawne"></input>
            <input type="submit" value="Chcę wejść!"></input>
        </form>
    </div>
</body>
</html>