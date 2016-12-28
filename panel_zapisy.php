<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./zapisyfunctions_x.php');
require_once('./logfunctions_x.php');
print_admin_toolbox();


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
    switch($_GET['akcja']){
        case "przyjmijg":
            dodaj_ucznia_do_gryff($_GET['id']);
            $id = $_GET['id'];
            add_event("przyjął/ęła ucznia o id $id do Gryffindoru!","ucz_g");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przyjmijh":
            dodaj_ucznia_do_huff($_GET['id']);
            $id = $_GET['id'];
            add_event("przyjął/ęła ucznia o id $id do Hufflepuffu!","ucz_h");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przyjmijr":
            dodaj_ucznia_do_rav($_GET['id']);
            $id = $_GET['id'];
            add_event("przyjął/ęła ucznia o id $id do Ravenclaw!","ucz_r");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przyjmijs":
            dodaj_ucznia_do_slyth($_GET['id']);
            $id = $_GET['id'];
            add_event("przyjął/ęła ucznia o id $id do Slytherinu!","ucz_s");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przyjmijn":
            przyjmij_nauczyciela($_GET['id']);
            $id = $_GET['id'];
            add_event("przyjął/ęła nauczyciela! Witaj w naszych szeregach!","nau_przyj");
            header("Location: panel_zapisy.php");
            exit();
           
        case "odrzucn":
            odrzuc_nauczyciela($_GET['id']);
            $id = $_GET['id'];
            add_event("odrzucił(a) zgłoszenie nauczyciela","nau_odrz");
            header("Location: panel_zapisy.php");
            exit();
           
        case "wyrzucn":
            wyrzuc_nauczyciela($_GET['id']);
            die("hej");
            $id = $_GET['id'];
            add_event("wyrzucił(a) nauczyciela!","nau_wyrz");
            header("Location: panel_zapisy.php");
            exit();
           
        case "wyrzucu":
            wyrzuc_ucznia($_GET['id']);
            $id = $_GET['id'];
            add_event("wyrzucił(a) ucznia!","ucz_wyrz");
            header("Location: panel_zapisy.php");
            exit();
           
        case "odrzucu":
            odrzuc_ucznia($_GET['id']);
            $id = $_GET['id'];
            add_event("odrzucił(a) zgłoszenie ucznia","ucz_odrz");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przenies1":
            przenies_ucznia_do_klasy_1($_GET['id']);
            $id = $_GET['id'];
            add_event("przeniósł/osła ucznia o nr. $id do klasy 1","ucz_1");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przenies2":
            przenies_ucznia_do_klasy_2($_GET['id']);
            $id = $_GET['id'];
            add_event("przeniósł/osła ucznia o nr. $id do klasy 2","ucz_2");
            header("Location: panel_zapisy.php");
            exit();
           
        case "przenies3":
            przenies_ucznia_do_klasy_3($_GET['id']);
            $id = $_GET['id'];
            add_event("przeniósł/osła ucznia o nr. $id do klasy 3","ucz_3");
            header("Location: panel_zapisy.php");
            exit();
           
        case "absolwent":
            absolwentuj_ucznia($_GET['id']);
            $id = $_GET['id'];
            add_event("przeniósł/osła ucznia o nr. $id w poczet absolwentów!","ucz_abs");
            header("Location: panel_zapisy.php");
            exit();
           
        default:
            die("Błąd! Nie przewidziano takiego przypadku. Nie majstruj nic przy get'cie. Byli tacy, co kombinowali...");

    }
}
if($_POST){
    $result = send_to_all_uczen($_POST['temat'], $_POST['text']);
    $_SESSION['mailresult'] = $result;
    header("Location: panel_zapisy.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE ZASOBAMI LUDZKIMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<?
if(isset($_SESSION['mailresult'])){
    echo $_SESSION['mailresult'];
    unset($_SESSION['mailresult']);
}
?>

<h1 id="header">Zarządzanie nauczycielami i uczniami</h1>
<h3>Drogi dyrektorze! Przed Tobą setki przycisków i zapadek, które powodują nieodwracalne skutki. Niewskazana jest ich obsługa w stanie wzburzenia emocjonalnego</h3>
<ul>
    <li><a href="#pupils1">Przejdź do nierozpatrzonych zgłoszeń uczniów</a></li>
    <li><a href="#teachers1">Przejdź do nierozpatrzonych zgłoszeń nauczycieli</a></li>
    <li><a href="#pupils2">Przejdź do przyjętych uczniów</a></li>
    <li><a href="#teachers2">Przejdź do przyjętych nauczycieli</a></li>
</ul>

<h2 id="pupils1">Nierozpatrzone zgłoszenia uczniów</h2>
<? print_future_pupils_list(); ?>
<a class="back-hlink" href="#header">&uarr; Wróć do góry &uarr;</a>
<h2 id="teachers1">Nierozpatrzone zgłoszenia nauczycieli</h2>
<? print_future_teachers_list(); ?>
<a class="back-hlink" href="#header">&uarr;Wróć do góry &uarr;</a>
<h2 id="pupils2">Przyjęci uczniowie</h2>
<? print_pupils_list(); ?>
<a class="back-hlink" href="#header">&uarr; Wróć do góry &uarr;</a>
<h2 id="teachers2">Przyjęci nauczyciele</h2>
<? print_teachers_list(); ?>
<a class="back-hlink" href="#header">&uarr; Wróć do góry &uarr;</a>
<div class="row">
    <div class="col-6" style="margin-left: 25%">
        <form class="form-sleek" action="panel_zapisy.php" method="post">
            Temat<input type="text" name="temat" value="Wiadomość do wszystkich uczniów">
            Treść (nagłówki i stopki zostaną dodane automatycznie)<textarea rows="5" name="text"></textarea>
            <input type="submit" value="Wyślij wszystkim uczniom">
        </form>
    </div>
</div>
</body>
</html>

