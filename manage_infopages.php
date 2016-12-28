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

if($_GET['action'] == 'delete' && users_is_root($_SESSION['username'], $_SESSION['password'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM infos WHERE id = $id";
    db_statement($sql);

    $_SESSION['msg'] = 'Usunięto infopage!';
    add_event("usunął/ęła infosa o nr. $id","info_us");
    header("Location: panel.php");
    exit();
}
print_admin_toolbox()
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE INFOPAGE'AMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1 id="header">Zarządzanie infopage'ami</h1>
<h3>Infopage satanas!</h3>

<? print_infopages_list(); ?>

</body>
</html>


