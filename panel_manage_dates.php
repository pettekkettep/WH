<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./logfunctions_x.php');

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
    add_event("pokazał(a) datę nr $id","pok_data");
    $_SESSION['msg'] = "Pokazano datę o id: $id";
    header("Location: panel_manage_dates.php");
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'hide') && isset($_GET['id'])){
    $id = $_GET['id'];
    date_hide($id);
    add_event("ukrył(a) datę nr $id","ukr_data");
    $_SESSION['msg'] = "Ukryto datę o id: $id";
    header("Location: panel_manage_dates.php");
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'delete') && isset($_GET['id'])){
    $id = $_GET['id'];
    date_delete($id);
    add_event("usunął/ęła datę nr $id","us_data");
    $_SESSION['msg'] = "Usunięto datę o id: $id";
    header("Location: panel_manage_dates.php");
}
print_admin_toolbox()
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE WAŻNYMI DATAMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1>Lista dat</h1>
<h2>W kolejności od ostatnio dodanych</h2>

    <? print_dates_to_manage(); ?>

</body>
</html>
