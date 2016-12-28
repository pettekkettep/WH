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

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'down') && isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT kolej FROM bloki WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $kolej = $row['kolej'];
    $kolej = $kolej + 1;
    $sql = "UPDATE bloki SET kolej = $kolej WHERE id = $id";
    $result = db_statement($sql);
    $_SESSION['msg'] = "Get low, low, low...";
    add_event("zmienił(a) pozycję bloku $id na stronie","blok_zm");
    header("Location: panel_manage_blocks.php");
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'up') && isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT kolej FROM bloki WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $kolej = $row['kolej'];
    $kolej = $kolej - 1;
    $sql = "UPDATE bloki SET kolej = $kolej WHERE id = $id";
    $result = db_statement($sql);
    $_SESSION['msg'] = "Hop do góry";
    add_event("zmienił(a) pozycję bloku $id na stronie","blok_zm");
    header("Location: panel_manage_blocks.php");
}

if(users_is_root($_SESSION['username'], $_SESSION['password']) && ($_GET['action'] == 'delete') && isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM bloki WHERE id = $id";
    $result = db_statement($sql);
    $_SESSION['msg'] = "Usunięto blok";
    add_event("usunął/ęła blok $id ze strony","blok_us");
    header("Location: panel_manage_blocks.php");
}

if($_POST){
    $nazwa = $_POST['nazwa'];
    $strona = $_POST['strona'];
    $kolej = $_POST['kolej'];
    $tresc = addslashes($_POST['tresc']);
    if(isset($_SESSION['edit'])){
        $id = $_SESSION['edit'];
        unset($_SESSION['edit']);
        $sql = "UPDATE bloki SET nazwa = '$nazwa', strona = '$strona', kolej = $kolej, tresc = '$tresc' WHERE id = $id";
        $result = db_statement($sql);
        $_SESSION['msg'] = "Zedytowano blok";
        add_event("zedytował(a) blok $id na stronie","blok_ed");
        header("Location: panel_manage_blocks.php");
    }
    else {
        $sql = "INSERT INTO bloki (nazwa, strona, kolej, tresc) VALUES ('$nazwa', '$strona', $kolej, '$tresc')";
        $result = db_statement($sql);
        $_SESSION['msg'] = "Dodano blok";
        add_event("stworzył(a) nowy blok na stronie","blok_dod");

        header("Location: panel_manage_blocks.php");
    }
}


print_admin_toolbox()
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE BLOKAMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1>Blokowisko</h1>
<h2>Jeśli dwa bloki będą miały tę samą pozycję (tudzież miejsce) to wyświetlą się w przypadkowej kolejności. ZAWSZE bloki wyświetlają się w kolejności rosnącej pozycji, ale numery nie muszą iść po kolei. Więc jeśli jesteś pewna/pewien, że jakiś blok ma być zawsze forever and ever na dole to możesz dać mu miejsce milion milionów wtedy zawsze będzie na dnie (tak jak <a href="https://www.youtube.com/watch?v=S06eUO2eiGM">Patrycja Markowska</a>)</h2>
<? print_blocks_to_manage(); ?>

</body>
</html>
