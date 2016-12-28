<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./logfunctions_x.php');

if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_root($_SESSION['username'], $_SESSION['password'])) {
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

if($_GET){
    if(($_GET['akcja'] == "deletep") && users_is_root($_SESSION['username'], $_SESSION['password'])) {
        $id = trim_input($_GET['id']);
        $sql = "DELETE FROM punkty_opis WHERE dziennik_id = $id";
        $result = db_statement($sql);
        $_SESSION['msg'] = "Usunięto punkty nieistniejącego dziennika!";
        add_event("usunął/ęła punkty z usuniętego wcześniej dziennika o id $id","dzp_us");
        header("Location: panel_dzienniki_check.php");
        exit();
    }

    if(($_GET['akcja'] == "deleteo") && users_is_root($_SESSION['username'], $_SESSION['password'])) {
        $id = trim_input($_GET['id']);
        $sql = "DELETE FROM oceny WHERE dziennik_id = $id";
        $result = db_statement($sql);
        $_SESSION['msg'] = "Usunięto oceny nieistniejącego dziennika!";
        add_event("usunął/ęła oceny z usuniętego wcześniej dziennika o id $id","dzo_us");
        header("Location: panel_dzienniki_check.php");
        exit();
    }

    if(($_GET['akcja'] == "deletepall") && users_is_root($_SESSION['username'], $_SESSION['password'])) {
        $sql = "DELETE FROM punkty_opis WHERE 1 = 1";
        $result = db_statement($sql);
        $_SESSION['msg'] = "Usunięto wszystkie punkty!!!";
        add_event("usunął/ęła wszystkie punkty z bazy","dzpall_us");
        header("Location: panel_dzienniki_check.php");
        exit();
    }

    if(($_GET['akcja'] == "deleteoall") && users_is_root($_SESSION['username'], $_SESSION['password'])) {
        $sql = "DELETE FROM oceny WHERE 1 = 1";
        $result = db_statement($sql);
        $_SESSION['msg'] = "Usunięto wszystkie oceny!!!";
        add_event("usunął/ęła wszystkie oceny z bazy","dzoall_us");
        header("Location: panel_dzienniki_check.php");
        exit();
    }

}

print_admin_toolbox()
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE PUNKTAMI i OCENAMI (z dzienników)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1>Punktacja a dzienniki</h1>
<h3>Punkty w podziale na dzienniki oraz informacja czy dane dzienniki istnieją w bazie</h3>

<?
if(users_is_root($_SESSION['username'], $_SESSION['password'])) {
    echo "<table class='generic-table dimmed-center-table'>";
    echo "<tr><th>ID Dziennika</th><th>Ile wpisów punktowych</th><th>Czy dziennik w bazie?</th><th><a href='panel_dzienniki_check.php?akcja=deletepall' onclick='return confirm(\"Tak. Chcę usunąć wszystkie punkty!\")'><div class='button-fitted'>USUŃ WSZYSTKIE PUNKTY</div></a></th></tr>";

    $sql = "SELECT dziennik_id, count(*) as ile FROM punkty_opis WHERE dziennik_id <> 0 GROUP BY dziennik_id";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $dziennik_id = $row['dziennik_id'];
        $ile = $row['ile'];
        $sql = "SELECT id FROM dzienniki WHERE id = $dziennik_id";
        $outcome = db_statement($sql);
        echo "<tr>";
        echo "<td>$dziennik_id</td>";
        echo "<td>$ile</td>";
        if(mysqli_num_rows($outcome)==1) {
            echo "<td class='slyth bold'>TAK</td>";
            echo "<td></td>";
        }
        else {
            echo "<td class='gryff bold'>NIE</td>";
            echo "<td><a href='panel_dzienniki_check.php?akcja=deletep&id=$dziennik_id'><div class='button-fitted'>USUŃ</div></a></td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}
?>
<h1>Oceny a dzienniki</h1>
<h3>Oceny w podziale na dzienniki oraz informacja czy dane dzienniki istnieją w bazie</h3>

<?

if(users_is_root($_SESSION['username'], $_SESSION['password'])) {
    echo "<table class='generic-table dimmed-center-table'>";
    echo "<tr><th>ID Dziennika</th><th>Ile ocen</th><th>Czy dziennik w bazie?</th><th><a href='panel_dzienniki_check.php?akcja=deleteoall' onclick='return confirm(\"Tak. Chcę usunąć wszystkie oceny!\")'><div class='button-fitted'>USUŃ WSZYSTKIE OCENY</div></a></th></tr>";

    $sql = "SELECT dziennik_id, count(*) as ile FROM oceny WHERE dziennik_id <> 0 GROUP BY dziennik_id";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $dziennik_id = $row['dziennik_id'];
        $ile = $row['ile'];
        $sql = "SELECT id FROM dzienniki WHERE id = $dziennik_id";
        $outcome = db_statement($sql);
        echo "<tr>";
        echo "<td>$dziennik_id</td>";
        echo "<td>$ile</td>";
        if(mysqli_num_rows($outcome)==1) {
            echo "<td class='slyth bold'>TAK</td>";
            echo "<td></td>";
        }
        else {
            echo "<td class='gryff bold'>NIE</td>";
            echo "<td><a href='panel_dzienniki_check.php?akcja=deleteo&id=$dziennik_id'><div class='button-fitted'>USUŃ</div></a></td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}


?>
</body>
</html>
