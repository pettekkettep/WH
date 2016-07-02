<?php

if(isset($_SESSION['msg'])) echo $_SESSION['msg'];

require_once('./functions_x.php');

session_start();
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_root($_SESSION['username'], $_SESSION['password'])){
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'show') && isset($_GET['id'])){
    $id = $_GET['id'];
    date_show($id);
    $_SESSION['msg'] = "Pokazano datę o id: $id";
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'hide') && isset($_GET['id'])){
    $id = $_GET['id'];
    date_hide($id);
    $_SESSION['msg'] = "Ukryto datę o id: $id";
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'delete') && isset($_GET['id'])){
    $id = $_GET['id'];
    date_delete($id);
    $_SESSION['msg'] = "Usunięto datę o id: $id";
}

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE WAŻNYMI DATAMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<h1>Lista dat</h1>
<h2>W kolejności od ostatnio dodanych</h2>

<? print_dates_to_manage(); ?>

</body>
</html>
