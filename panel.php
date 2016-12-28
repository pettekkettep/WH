<?php

require_once('./logfunctions_x.php');

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
    $username = trim_input($_COOKIE['username']);
    $password = trim_input($_COOKIE['password']);
    if(users_is_admin($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])){
    header("Location: panel_enter.php");
    exit();
}

if($_POST){
    $msg = trim_input($_POST['msg']);
    $msg = "napisał(a): ".$msg;
    add_event($msg, "msg");
    header("Location: panel.php");
    exit();
}

print_admin_toolbox();
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
    <div class="row">
        <div class="col-2">
            <ul class="no-indent">
                <li class="menu">
                    <a href="/dodaj_dziennik.php">
                        Dodaj dziennik
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_dziennik.php">
                        Edytuj dziennik
                    </a>
                </li>
                <li class="menu">
                    <a href="/dodaj_news.php">
                        Dodaj news
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_news.php">
                        Edytuj news
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_add_date.php">
                        Dodaj ważną datę
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_punkty.php">
                        Dodaj punkty
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_oceny.php">
                        Dodaj oceny
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_news.php">
                        Zarządzaj newsami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_dziennik.php">
                        Zarządzaj dziennikami
                    </a>
                </li>
                <li class="menu">
                    <a href="/tabelki_kurs.php">
                        HOW TO: Tabelki
                    </a>
                </li>
                <li class="menu">
                    <a href="/punkty_wykres.php">
                        Walka o PD
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-7 only-big">
            <div class="row row-center" style="height: 10%">
                <p class="narrow">
                    Zrobione:
                </p>
                <p class="narrow">
                    <span class="glyphicon glyphicon-ok"></span> Logowanie
                    <span class="glyphicon glyphicon-ok"></span> Dzienniki
                    <span class="glyphicon glyphicon-ok"></span> Miniczat
                    <span class="glyphicon glyphicon-ok"></span> Daty
                    <span class="glyphicon glyphicon-ok"></span> Newsy
                    <span class="glyphicon glyphicon-ok"></span> Komentarze pod newsami<br>
                    <span class="glyphicon glyphicon-ok"></span> Zapisy
                    <span class="glyphicon glyphicon-ok"></span> Napisy na głównej
                    <span class="glyphicon glyphicon-ok"></span> Admini
                    <span class="glyphicon glyphicon-ok"></span> Galeony
                    <span class="glyphicon glyphicon-ok"></span> Plan lekcji
                </p>
            </div>
            <h4>Ostatnie 24h <a href="panel_old_logs.php">(zobacz archiwum logów)</a></h4>
            <div class="row row-center" style="height: 75%; overflow-y: scroll">
                <? print_log_feed(); ?>
            </div>
            <div style="margin-top: 15px; height: 25px>
                <form method="post" action="panel.php">
            <?php
            if(msg_enable($_SESSION['username'])) {
                echo "<form method=\"post\" action=\"panel.php\"><div class=\"col-10\"><input class=\"full-width\" type=\"text\" name=\"msg\" placeholder='Można wysłać 3 wiadomości w ciągu 24 godzin'></input></div>
                    <div class=\"col-2\"><input class=\"full-width\" style=\"color: white; font-family: Ubuntu; background-color: #764134; border: 2px white solid; border-radius: 5px;\" type=\"submit\" value=\"Wyślij\"></input></div>
                </form>";
            }
            else {
                echo "Można wysłać 3 wiadomości w ciągu 24 godzin!";
            }
            ?>

            </div>
        </div>
        <div class="col-3">
            <ul class="no-indent">
                <li class="menu">
                    <a href="/panel_manage_news.php">
                        Zarządzaj newsami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_dziennik.php">
                        Zarządzaj dziennikami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_dates.php">
                        Zarządzaj ważnymi datami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_zapisy.php">
                        Zarządzaj zapisami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_site_vars.php">
                        Zarządzaj napisami na stronie głównej
                    </a>
                </li>
                <li class="menu">
                    <a href="/add_infopage.php">
                        Dodaj infopage'a
                    </a>
                </li>
                <li class="menu">
                    <a href="/manage_infopages.php">
                        Zarządzaj infopage'ami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_admin.php">
                        Zarządzaj adminami
                    </a>
                </li>
                <li class="menu">
                    <a href="/bank_x.php">
                        Dodaj galeony
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_plan_dodaj.php">
                        Dodaj lekcję do planu
                    </a>
                </li>
                <li class="menu">
                    <a href="/plan_lekcji.php?klasa=1&dzien=all">Edytuj plan [klasy 1]</a>
                    <a href="/plan_lekcji.php?klasa=2&dzien=all">Edytuj plan [klasy 2]</a>
                    <a href="/plan_lekcji.php?klasa=3&dzien=all">Edytuj plan [klasy 3]</a>
                </li>
                <li class="menu">
                    <a href="/panel_dzienniki_check.php">
                        Punkty/oceny vs usunięte dzienniki
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_manage_blocks.php">
                        Zarządzaj blokami
                    </a>
                </li>
                <li class="menu">
                    <a href="/panel_komnata.php">
                        Komnata Tajemnic
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>