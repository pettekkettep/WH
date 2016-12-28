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

if(!users_is_root($_SESSION['username'], $_SESSION['password'])){
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

$sql = "SELECT * FROM main_page_vars ORDER BY id";
$result = db_statement($sql);
if(mysqli_num_rows($result) != 29) {
    die("W bazie nie ma tego, co trzeba. Pech. Napisz do Xema");
}

if($_POST){
    $sql = "UPDATE main_page_vars SET content = '". $_POST['ann1'] . "' WHERE id = 'ann1';" .
        "UPDATE main_page_vars SET content = '". $_POST['ann2'] . "' WHERE id = 'ann2';" .
        "UPDATE main_page_vars SET content = '". $_POST['ann3'] . "' WHERE id = 'ann3';" .
        "UPDATE main_page_vars SET content = '". $_POST['ghead'] . "' WHERE id = 'ghead';" .
        "UPDATE main_page_vars SET content = '". $_POST['hhead'] . "' WHERE id = 'hhead';" .
        "UPDATE main_page_vars SET content = '". $_POST['rhead'] . "' WHERE id = 'rhead';" .
        "UPDATE main_page_vars SET content = '". $_POST['shead'] . "' WHERE id = 'shead';" .
        "UPDATE main_page_vars SET content = '". $_POST['gp1'] . "' WHERE id = 'gp1';" .
        "UPDATE main_page_vars SET content = '". $_POST['gp2'] . "' WHERE id = 'gp2';" .
        "UPDATE main_page_vars SET content = '". $_POST['hp1'] . "' WHERE id = 'hp1';" .
        "UPDATE main_page_vars SET content = '". $_POST['hp2'] . "' WHERE id = 'hp2';" .
        "UPDATE main_page_vars SET content = '". $_POST['rp1'] . "' WHERE id = 'rp1';" .
        "UPDATE main_page_vars SET content = '". $_POST['rp2'] . "' WHERE id = 'rp2';" .
        "UPDATE main_page_vars SET content = '". $_POST['sp1'] . "' WHERE id = 'sp1';" .
        "UPDATE main_page_vars SET content = '". $_POST['sp2'] . "' WHERE id = 'sp2';" .
        "UPDATE main_page_vars SET content = '". $_POST['gk'] . "' WHERE id = 'gk';" .
        "UPDATE main_page_vars SET content = '". $_POST['gs'] . "' WHERE id = 'gs';" .
        "UPDATE main_page_vars SET content = '". $_POST['hk'] . "' WHERE id = 'hk';" .
        "UPDATE main_page_vars SET content = '". $_POST['hs'] . "' WHERE id = 'hs';" .
        "UPDATE main_page_vars SET content = '". $_POST['rk'] . "' WHERE id = 'rk';" .
        "UPDATE main_page_vars SET content = '". $_POST['rs'] . "' WHERE id = 'rs';" .
        "UPDATE main_page_vars SET content = '". $_POST['sk'] . "' WHERE id = 'sk';" .
        "UPDATE main_page_vars SET content = '". $_POST['ss'] . "' WHERE id = 'ss';" .
        "UPDATE main_page_vars SET content = '". $_POST['p1'] . "' WHERE id = 'p1';" .
        "UPDATE main_page_vars SET content = '". $_POST['p2'] . "' WHERE id = 'p2';" .
        "UPDATE main_page_vars SET content = '". $_POST['kdate'] . "' WHERE id = 'kdate';" .
        "UPDATE main_page_vars SET content = '". $_POST['knab'] . "' WHERE id = 'knab';" .
        "UPDATE main_page_vars SET content = '". $_POST['knacz'] . "' WHERE id = 'knacz';" .
        "UPDATE main_page_vars SET content = '". $_POST['ksowa'] . "' WHERE id = 'ksowa';";

    db_multi_statement($sql);
    add_event("zedytował(a) napisy na głównej stronie","ed_vars");
    $_SESSION['msg'] = "Zmodyfikowano teksty na stronie domowej! Gratki!";
    header("Location: panel_manage_site_vars.php");
}
print_admin_toolbox();
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE NAPISAMI NA STRONIE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1>Lista zmiennych</h1>
    <?php edit_page_variables($result) ?>
</body>
</html>
