<?php

require_once('./functions_x.php');

session_start();

if($_POST){
    $login = trim_input($_POST['login']);
    $email = trim_input($_POST['email']);
    $password = md5(trim_input($_POST['password']));
    $password2 = md5(trim_input($_POST['password2']));
    if($password != $password2) die("Spróbuj podać takie same hasła następnym razem. Pzdr.");
    if(empty($login) || empty($email) || empty($password)) die("Zostawiłeś któreś z pól puste plebeuszu. Try again.");
    

}


?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
<div class="login-form form-sleek">
    <form action="/register.php" method="post">
        <h1>Formularz rejestracji</h1>
        <h2>Nie musisz być związany z WH, aby się zarejestrować, ale wtedy nie masz też szansy na bonusy z tego wynikające.</h2>
        <h2 class="gryff">Rejestracja nie ma NIC WSPÓLNEGO z zapisami na ucznia. Są to dwie osobne rzeczy.</h2><hr>
        Login <input type="text" name="login" value="" placeholder="Login będziesz podawał przy każdym logowaniu" required></input>
        E-mail <input type="email" name="email" value="" placeholder="Podaj prawdziwy, bo będzie beka jak zapomnisz hasło" required></input>
        Hasło <input type="password" value="" name="password" required></input>
        Powtórz hasło <input type="password" value="" name="password2" required></input>
        <input type="submit" value="JEDZIEMY!"></input>
    </form>
</div>
</body>
</html>