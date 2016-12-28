<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./newsfunctions_x.php');
require_once('./logfunctions_x.php');

if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])) {
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

if($_GET){
    if(($_GET['akcja'] == "archive") && users_is_root($_SESSION['username'], $_SESSION['password'])) {
        $id = $_GET['id'];
        $sql = "UPDATE news SET stat=2 WHERE id=?";
        db_statement($sql, 'i', array(&$id));
        add_event("zarchiwizował(a) news o nr. $id", "arch_news");
        $_SESSION['msg'] = "Zarchiwizowano newsa";
        header("Location: panel_manage_news.php");
        exit();
    }
    elseif(($_GET['akcja'] == "unarchive") && users_is_root($_SESSION['username'], $_SESSION['password'])) {
        $id = $_GET['id'];
        $sql = "UPDATE news SET stat=1 WHERE id=?";
        db_statement($sql, 'i', array(&$id));
        add_event("przywrócił(a) news o nr. $id", "przywr_news");
        $_SESSION['msg'] = "Przywrócono newsa";
        header("Location: panel_manage_news.php");
        exit();
    }
    elseif(($_GET['akcja'] == "delete") && users_is_root($_SESSION['username'], $_SESSION['password'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM news WHERE id=?";
        db_statement($sql, 'i', array(&$id));
        add_event("usunął/ęła news o nr. $id", "us_news");
        $_SESSION['msg'] = "Usunięto newsa";
        header("Location: panel_manage_news.php");
        exit();
    }
    elseif(($_GET['akcja'] == "archiveall") && users_is_root($_SESSION['username'], $_SESSION['password'])){
        $sql = "UPDATE news SET stat=2 WHERE stat=1";
        db_statement($sql);
        add_event("zarchiwizował(a) wszystkie widoczne newsy", "usall_news");
        $_SESSION['msg'] = "Wszystko do archiwuuuuuum!";
        header("Location: panel_manage_news.php");
        exit();
    }
}

print_admin_toolbox();
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE NEWSAMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
<h1 id="header">Zarządzanie newsami</h1>
<h3>"Jeśli nie zamierzasz umieścić w newsie tabelki, to zastanów się, czy ten news jest potrzebny" ~A. Martell 2016</h3>

<?
if(users_is_root($_SESSION['username'], $_SESSION['password'])){
    echo "<h2>Newsy obecnie widoczne</h2>";
    print_current_news();
    echo "<a class='back-hlink' href='#header'>&uarr; Wróć do góry &uarr;</a>";
    echo "<h2>Newsy zarchiwizowane</h2>";
    print_archived_news();
    echo "<a class='back-hlink' href='#header'>&uarr; Wróć do góry &uarr;</a>";
}
else if(users_is_admin($_SESSION['username'], $_SESSION['password'])){
    echo "<h2>Moje newsy, które mogę edytować (W RAZIE TAKIEJ KONIECZNOŚCI - nadgorliwość nie jest wskazana - będziesz chciał(a) dodać brakujący przecinek, ale sobie skasujesz całość? GOOD LUCK, HAVE FUN - w bazie nie ma kopii zapasowej</h2>";
    print_my_news($_SESSION['username']);
    echo "<h2>Newsy obecnie widoczne</h2>";
    print_current_news();
}



?>
</body>
</html>

