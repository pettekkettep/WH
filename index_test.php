<?php

session_start();

require_once("./logfunctions_x.php");
require_once("./pokatnafunctions_x.php");


if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

if(isset($_POST['user']) && isset($_POST['comment']) && isset($_POST['newsid'])){
    add_comment_to_news($_POST['user'], $_POST['comment'], $_POST['newsid']);
    $newsid = $_POST['newsid'];
    $user = $_POST['user'];
    add_event("dodał(a) komentarz pod newsem o nr. $newsid","dod_kom",$user);
    header("Location: " . $_SERVER['REQUEST_URI']);
    $_SESSION['msg'] = "Dodano komentarz!";
    exit();
}

if($_GET['logout'] == 1){
    setcookie('username', "", 1);
    setcookie('password', "", 1);
    session_destroy();
    session_start();
    header("Location: index_x.php");
    exit();
}

elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
    $username = trim_input($_COOKIE['username']);
    $password = trim_input($_COOKIE['password']);
    if(users_is_admin($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
}

if(!isset($_GET['p'])){
    $_GET['p'] = 1;
}

if(isset($_GET['comment_delete_id']) && users_is_root($_SESSION['username'], $_SESSION['password'])){
    delete_comment_id($_GET['comment_delete_id']);
    $id = trim_input($_GET['comment_delete_id']);
    add_event("usunął/ęła komentarz o nr. $id","us_kom");
    header("Location: index_x.php");
    $_SESSION['msg'] = "Usunięto komentarz.";
    exit();
}


?>

<!doctype HTML>
<html>
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Wirtualny Hogwart im. Syriusza Croucha to szkoła z ogromnymi tradycjami i doświadczeniem w nauczaniu młodych adeptów magii! Zapraszamy na XXXII rok szkolny!">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Headland+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

</head>
<!--<body onLoad="window.scrollBy(0,330)">-->
<body onload = "startTimer()">
<div class="punkty">
    <div class="row extra-margin">
        <div class="col-const-3 pts-details"><?  echo "<a class='wocolor' href='/punkty.php?show=gryffindor'>".print_g_points()."</a>"; ?><div class="gryff-tlo"><? print_top_5('g'); ?></div></div>
        <div class="col-const-3 pts-details"><?  echo "<a class='wocolor' href='/punkty.php?show=hufflepuff'>".print_h_points()."</a>"; ?><div class="huff-tlo"><? print_top_5('h'); ?></div></div>
        <div class="col-const-3 pts-details"><?  echo "<a class='wocolor' href='/punkty.php?show=ravenclaw'>".print_r_points()."</a>"; ?><div class="rav-tlo"><? print_top_5('r'); ?></div></div>
        <div class="col-const-3 pts-details"><?  echo "<a class='wocolor' href='/punkty.php?show=slytherin'>".print_s_points()."</a>"; ?><div class="slyth-tlo"><? print_top_5('s'); ?></div></div>
    </div>
</div>
<div class="row">
    <a href="http://wh.boo.pl/index_x.php"><div class="logo" id="logo-mobile"><img src = "hogwarts-tiny.jpg"></div></a>
</div>
<div class="row">
    <a href="index_x.php"><div class="logo" id="napis-wh"><img src = "napis.png"></div></a>
</div>
<div class="row row-style-light center-align">
    <div class="col-4">
        <? print_last_news(5); ?>
    </div>

    <div class="col-4 img-logo" style="padding: 7px">

        <img id="logo-wh" src="logo.jpg">
        <? $days = days_since();
        echo "<p>Nasza szkoła istnieje od <span class='score'> $days </span>dni.</p>" ?>

    </div>

    <div class="col-4 col-m-0 center-align only-screen">
        <div class="row">
            <img class="full-width-but" src="blok/zapisyimg/zapisy1.png" style="margin: 10px 0 20px 0;">
        </div>
        <div class="row">
            <div class="col-2">
                <img class="full-width-but" src="blok/zapisyimg/przyp2.png" id="przyp_u"  style="margin: 5px 0 0 0;">
            </div>
            <div class="col-10">
                <a href="zapisy_u.php"><img class="full-width-but" src="blok/zapisyimg/zapisy3.png"  style="margin: 0" onmouseover="onHoverU();" onmouseout="offHoverU();""></a>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <img class="full-width-but" src="blok/zapisyimg/przyp2.png"  style="margin: 5px 0 0 0;" id="przyp_n">
            </div>
            <div class="col-10">
                <a href="zapisy_n.php"><img class="full-width-but" src="blok/zapisyimg/zapisy2.png"  style="margin: 0;" onmouseover="onHoverN();" onmouseout="offHoverN();"></a>
            </div>
        </div>
    </div>
</div>
<div class="row row-style center-align">
    <div class="col-2">
        <?php
        $sql = "SELECT SUM(wydano) AS wydano, SUM(suma) AS suma FROM hpotter_bank_skrytki";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $wydano = $row['wydano'];
        $suma = $row['suma'];
        $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE rank > 0";
        $result = db_statement($sql);
        $ilu = mysqli_num_rows($result);
        echo "<h4>Do tej pory</h4> <p><span class='colored bit-bigger bold'>$ilu</span> osób wylosowało <span class='colored bit-bigger bold'>$suma</span> fasolek za <span class='colored bit-bigger bold'>$wydano</span> galeonów!</p>";
        ?>
    </div>
    <div class="col-3">
        <h4>Ostatni unikat:</h4>
        <?php
        print_last_unikat();
        ?>
    </div>
    <div class="col-2">
        <a href="fasolka_panel.php"><div class="button-or-not" style="margin-top: 10%"><h4>Wejdź do gry!</h4></div></a>
    </div>
    <div class="col-2">
        <?php
        $sql = "SELECT wlasciciel, rank FROM hpotter_bank_skrytki ORDER BY rank DESC LIMIT 3";
        echo "<h4>Top 3 graczy:</h4>";
        $result = db_statement($sql);
        while($row = mysqli_fetch_assoc($result)){
            $wlasciciel = $row['wlasciciel'];
            $rank = $row['rank'];
            echo "<p class='narrow'>$wlasciciel <span class='bold colored bit-bigger'>$rank</span> xp</p>";
        }
        ?>
    </div>
    <div class="col-3">
        <h4>Ostatnia kradzież:</h4>
        <?php
        print_last_kradziez();
        ?>
    </div>
    </div>

<div class="row row-style">

    <div class="col-low-res center-align">
        <? print_mobile_top(); ?>
    </div>

    <div class="col-1 col-m-0"></div>
    <div class="col-0 col-2 col-m-3">
        <? print_left_blocks(); ?>
    </div>

<div class="col-6 col-m-6">
    <div class="row" id="row-center">
        <h1>Tablica ogłoszeń</h1>
        <? print_feed($_GET['p']); ?>
    </div>
</div>

<? include ("after_content.php"); ?>

<div class="dementor hide" id="demi">
    <img src="dem1.png" alt="Dementi" id="demi-img">
    <div class="zapisy-tekst">
        <p class="on-img-1"><a class="wocolor" href="zapisy_u.php" id="on-img-1">ZAPISY SĄ</a></p>
        <p class="on-img-2"><a class="wocolor" href="zapisy_u.php" id="on-img-2">OTWARTE!</a></p>
    </div>
</div>
<script src="js/index_x.js"></script>
</body>
</html>