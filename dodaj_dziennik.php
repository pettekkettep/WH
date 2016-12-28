<!--DOSTĘP DO TEJ STRONY: ADMINS-->

<?php

require_once('./dziennikifunctions_x.php');

session_start();

if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php?location=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])) {
    header("Location: panel_enter.php");
    exit();
}

print_admin_toolbox();
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Kreator dziennika</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">

    <script src="/ckeditor/ckeditor.js"></script></head>
<body>


        <?php


        if($_POST){
            if(isset($_POST['klasa'])){
                create_dziennik();
                unset($_SESSION['przedmiot']);
                unset($_SESSION['data']);
                $_SESSION['przedmiot'] = $_POST['przedmiot'];
                $_SESSION['data'] = $_POST['data'];
                $id = last_insert_dzienniki($_POST['nauczyciel']);
                unset($_SESSION['iddz']);
                $_SESSION['iddz'] = $id;
                print_wybierz_uczniow($id);
            }
            elseif(isset($_POST['lista'])){
                unset($_SESSION['uczniowie']);
                $_SESSION['uczniowie'] = $_POST['uczniowie'];
                unset($_SESSION['oceny']);
                $_SESSION['oceny'] = $_POST['oceny'];
                unset($_SESSION['punkty']);
                $_SESSION['punkty'] = $_POST['punkty'];
                if(isset($_POST['uczniowie'])) print_wpisz_oceny_punkty($_SESSION['uczniowie'], $_SESSION['punkty'], $_SESSION['oceny']);
                else print_dzienniki_details();
            }
            elseif(isset($_POST['oceny'])){
                foreach ($_SESSION['uczniowie'] as $id){
                    foreach ($_POST[$id] as $key => $ocena){
                        if($ocena != NULL){
                            $przedmiot = $_SESSION['przedmiot'];
                            $profesor = $_SESSION['username'];
                            $data = $_SESSION['data'];
                            $iddz = $_SESSION['iddz'];
                            switch($key){
                                case "ob":
                                    $za = "Obecność";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "odp":
                                    $za = "Odpowiedź";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "kart":
                                    $za = "Kartkówka";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "egz":
                                    $za = "Egzamin";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "spr":
                                    $za = "Sprawdzian";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "lista":
                                    $za = "Lista";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "zaddom":
                                    $za = "Zadanie domowe";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "zaddod":
                                    $za = "Zadanie dodatkowe";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "akt":
                                    $za = "Aktywność";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "prakt":
                                    $za = "Praktyka";

                                    dodaj_punkty($ocena, $id, $iddz, $data, $za, $przedmiot, $profesor);
                                    break;
                                case "oodp":
                                    $rodzaj = "#ff66ff";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "okart":
                                    $rodzaj = "#ff6600";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "oegz":
                                    $rodzaj = "red";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "ospr":
                                    $rodzaj = "#9900CC";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "ozaddom":
                                    $rodzaj = "#33cc00";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "ozaddod":
                                    $rodzaj = "yellow";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "oakt":
                                    $rodzaj = "#0099ff";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                                case "oprakt":
                                    $rodzaj = "999999";
                                    dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor);
                                    break;
                            }
                        }
                    }
                }
                print_dzienniki_details();
            }
            elseif(isset($_POST['details'])){
                $iddz = $_SESSION['iddz'];
                $numer = $_POST['numer'];
                $temat = $_POST['temat'];
                $opis = $_POST['opis'];
                $domowa = $_POST['domowa'];
                $pracatermin = $_POST['pracatermin'];
                add_dziennik_details($iddz, $numer, $temat, $opis, $domowa, $pracatermin);
                $_SESSION['msg'] = "Dziennik dodany! Czeka na akceptację!";
                if($_SESSION['martin']=="yas"){
                    unset($_SESSION['martin']);
                    header("Location: http://youtu.be/Xn599R0ZBwg");
                } else {
                header("Location: panel.php");
                }
            }
        } else {
            print_dzienniki_begin();
        }

        ?>

</body>
</html>