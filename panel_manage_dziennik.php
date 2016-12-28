<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./dziennikifunctions_x.php');

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
    if($_GET['akcja'] == "accept") {
        $id = $_GET['id'];
        $sql = "UPDATE dzienniki SET stan='yes' WHERE id=?";
        add_event("zaakceptował(a) dziennik nr $id","dz_acc");
        db_statement($sql, 'i', array(&$id));
        $_SESSION['msg'] = "Zaakceptowano dziennik";
        header("Location: panel_manage_dziennik.php");
        exit();
    }
    elseif($_GET['akcja'] == "delete"){
        $id = $_GET['id'];
        $sql = "DELETE FROM dzienniki WHERE id=?";
        add_event("usunął/ęła dziennik nr $id","dz_us");
        db_statement($sql, 'i', array(&$id));
        $_SESSION['msg'] = "Usunięto dziennik";
        header("Location: panel_manage_dziennik.php");
        exit();
    }
}
print_admin_toolbox();

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE DZIENNIKAMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1 id="header">Zarządzanie dziennikami</h1>
<h3>Dzienniki są ważne. ~Bridget Jones</h3>
<?



if(users_is_root($_SESSION['username'], $_SESSION['password'])){
    echo "<h2>Dzienniki do akceptacji</h2>";
    print_waiting_dziennik_list();
    echo "<a class='back-hlink' href='#header'>&uarr; Wróć do góry &uarr;</a>";
    echo "<h2>Dzienniki zaakceptowane</h2>";
    print_dziennik_list();
    echo "<a class='back-hlink' href='#header'>&uarr; Wróć do góry &uarr;</a>";
}
else if(users_is_admin($_SESSION['username'], $_SESSION['password'])){
    echo "<h2>Moje dzienniki, których szczegóły mogę edytować</h2>";
    print_my_dziennik($_SESSION['username']);
}



?>
</body>
</html>

