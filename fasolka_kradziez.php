<?php

session_start();
require_once('./fasolkifunctions_x.php');

$id = account_access($_SESSION['username'], $_SESSION['password']);
if($id != false){
    print_my_account($id);
}
else {
    header("Location: pokatna_x.php?location=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if(isset($_SESSION['outcome'])){
    print_overfooter($_SESSION['outcome']);
    unset($_SESSION['outcome']);
}

$base = theft_prob($id);
$bonus = theft_bonus($id);
$total = $base + $bonus;

if(isset($_GET['atak'])){

    $atak = trim_input($_GET['atak']);
    $_SESSION['kradziez'] = losuj_kradziez($id, $atak);
    $sql = "UPDATE hpotter_bank_skrytki SET kradziez = CURRENT_TIMESTAMP WHERE numer = $id";
    $result = db_statement($sql);
    refresh_rank($id);
    refresh_rank($atak);
    header("Location: fasolka_kradziez.php");
    exit();
}
?>

<!-- POCZĄTEK -->
<!doctype HTML>
<html>
<head>
    <title>FASOLKI | kradzież</title>
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
    <!--    <img src="belkapkt8.png" alt="Punkty">-->
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
<div class="row row-style-light center-align fasolka-hide">
    <div class="col-4">
        <? print_last_news(5); ?>
    </div>

    <div class="col-4 img-logo" style="padding: 7px">

        <img id="logo-wh" src="logo.jpg">
        <? $days = days_since();
        echo "<p>Nasza szkoła istnieje od <span class='score'> $days </span>dni.</p>" ?>
        <!--        <script src="//eradia.net/script/player.php?id=100781"></script>-->
        <!--        <br><a href="#" onclick="window.open('http://the_gosix.eradia.net/utwor.html','','toolbar=no, menubar=no,location=no, personalbar=no, scrollbars=no, directories=no, status=no, resizable=no, width=380, height=260')"><div class="button-fitted" style="font-size: 150%">ZAMÓW PIOSENKĘ</div></a>-->

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
<!--<div class="row row-style">-->
<!--    <h1 style="text-align: center">Trwa rozpoczęcie XXIII roku szkolnego w <span class="colored">Wirtualnym Hogwarcie</span>! <a class="wocolor" href="http://applet.chatsm.pl/?room=pub_czarownica"><div class="button-fitted">WEJDŹ</div></a></h1>-->
<!--</div>-->
<!--<div class="row row-style center-align" style="padding: 10px">-->
<!--        <script src="//eradia.net/script/stats.php?id=209715"></script><br><a href="#" onclick="window.open('http://the_gosix.eradia.net/utwor.html','','toolbar=no, menubar=no,location=no, personalbar=no, scrollbars=no, directories=no, status=no, resizable=no, width=380, height=260')"><h1>ZAMÓW PIOSENKĘ</h1></a>-->
<!--</div>-->
<div class="row row-style">

    <div class="col-low-res fasolka-hide center-align">
        <? print_mobile_top(); ?>
        <!--        <div class="row row-block-right">-->
        <!--            --><?// print_important_dates() ?>
        <!--        </div>-->
        <!--        <div class="row row-block-right">-->
        <!--            --><?// print_time_table_mobile() ?>
        <!--        </div>-->
    </div>

    <div class="col-1 col-m-0"></div>
    <div class="col-0 col-2 col-m-3 fasolka-hide">
        <!--        <div class="row row-block-left">-->
        <!--            --><?// print_left_first() ?>
        <!--        </div>-->
        <!--        <div class="row row-block-left">-->
        <!--            --><?// print_left_second() ?>
        <!--        </div>-->
        <!--        <div class="row row-block-left">-->
        <!--            --><?//
        //            print_enroll_menu();
        //            print_pupil_search();
        //            ?>
        <!--        </div>-->
        <!--        <div class="row row-block-left">-->
        <!--            --><?// print_time_table() ?>
        <!--        </div>-->
        <!--        <div class="row row-block-left">-->
        <!--            --><?// print_sale() ?>
        <!--        </div>-->
        <!--        <div class="row row-block-left">-->
        <!--            --><?// print_pokatna() ?>
        <!--        </div>-->
        <? print_left_blocks(); ?>
    </div>
    <!-- KONIEC -->
    <div class="col-6 col-m-6">

        <div class="row">
            <div class="col-12">
                <a href="fasolka_panel.php">
                    <div class="button-or-not">
                        <span class="glyphicon glyphicon-step-backward"></span> Powrót do PANELU
                    </div>
                </a></div>
            <div class="col-3">
                <a href="losuj_fasolke.php">
                    <div class="button-or-not">
                        <span class="glyphicon glyphicon-shopping-cart"></span><br> LOSUJ FASOLKĘ
                    </div>
                </a></div>
            <div class="col-3"><a href="fasolka.php">
                    <div class="button-or-not">
                        <span class="glyphicon glyphicon-book"></span><br> Moja KOLEKCJA
                    </div>
                </a></div>
            <div class="col-3"><a href="fasolka_quest.php">
                    <div class="button-or-not">
                        <span class="glyphicon glyphicon-ok-circle"></span><br> Lista QUESTÓW
                    </div>
                </a></div>
            <div class="col-3"><a href="fasolka_rank.php">
                    <div class="button-or-not">
                        <span class="glyphicon glyphicon-star-empty"></span><br> RANKING Graczy
                    </div>
                </a></div>
            <!--        <div class="col-3"><a href="fasolka_skup.php">-->
            <!--                <div class="button-or-not">-->
            <!--                    <span class="glyphicon glyphicon-shopping-cart"></span><br> SKUP Fasolek-->
            <!--                </div>-->
            <!--            </a></div>-->
        </div>

        <?
        if(isset($_SESSION['kradziez'])){
            if($_SESSION['kradziez'] == "Nieudana"){
                echo "<h1>Próba kradzieży zakończona niepowodzeniem</h1>";
            }
            else{
                echo "<h1>Kradzież udana!</h1>";
                echo "<h2>".$_SESSION['kradziez']."</h2>";
            }
            unset($_SESSION['kradziez']);
        }
        else {
            echo "<h1>Kogo by tu okraść...</h1>";
            echo "<h2>Szanse na udaną kradzież (jeśli przeciwnik nie ma obrony) wynoszą $base% + $bonus% = $total%</h2>";

            echo "<table class='basic-table full-width center-align'>";
            echo "<tr><th>Gracz</th><th>Ranking</th><th></th></tr>";
            $sql = "SELECT numer, wlasciciel, rank FROM hpotter_bank_skrytki WHERE rank > 0 ORDER BY rank DESC";
            $result = db_statement($sql);
            while($row = mysqli_fetch_assoc($result)){
                $numer = $row['numer'];
                echo "<tr><td>".$row['wlasciciel']."</td><td>".$row['rank']."</td><td>";
                if($numer != $id) echo "<a href='fasolka_kradziez.php?atak=$numer'><div class='button-fitted'>OKRADNIJ</div></a>";
                echo "</td></tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

    <!-- POCZĄTEK ------------->

    <div class="col-low-res fasolka-hide">
        <? print_mobile_bottom() ?>
    </div>


    <div class="col-0 col-2 col-m-3 fasolka-hide">
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_important_dates() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_pub_czaro() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_castle() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_dorm() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_houses_details() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_kleks() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_kp_block() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_quidd_block() ?>
        <!--    </div>-->
        <!--    <div class="row row-block-right">-->
        <!--        --><?// print_izba_pamieci() ?>
        <!--    </div>-->
        <? print_right_blocks(); ?>
    </div>
    <div class="col-1 col-m-0"></div>

    <!--    mała zmiana-->
    <div class="col-12 col-m-12">
        <div class="row" id="row-center">
            <p class="narrow">&copy; 2005-2016 <span class="bold colored-footer">Dyrekcja i Zarząd WH</span>. Wszelkie prawa zastrzeżone</p>
            <p class="narrow bottom-buffer">
                Designed&Developed: <span class="bold colored-footer">Xeme</span>
                Graphics: <span class="bold colored-footer">Sloan</span>
                Content: <span class="bold colored-footer">Społeczność WH</span>
            </p>
            <p class="narrow"><span class="glyphicon glyphicon-alert"></span> &nbsp;Nasza strona korzysta z <span class="bold">ciasteczek</span>, chyba że Isabell wszystkie zjadła.</p>

        </div>
    </div>
    <? print_admin_toolbox() ?>
    <!--    koniec-->

    <!-- KONIEC ------------->


</body>
</html>