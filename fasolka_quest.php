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

if(isset($_GET['nagroda'])){
    $nagroda = trim_input($_GET['nagroda']);
    $sql = "SELECT FROM beans_quest WHERE skrytka = $id AND quest = $nagroda";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0){
        header("Location: fasolka_quest.php");
        exit;
    }
    else {
        $sql = "INSERT INTO beans_quests(skrytka, quest) VALUES($id, $nagroda)";
        db_statement($sql);
        $nr_fasolki = 85 + intval($nagroda);
        dodaj_fasolke_do_kolekcji($id, $nr_fasolki);
        $_SESSION['fasolki'] = get_array_from_bean_id($nr_fasolki);
        header("Location: losuj_fasolke.php");
        exit;
    }

}
?>

<!-- POCZĄTEK -->
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

    <?php
    print_fasolki_navbar()
    ?>
    <div class="row">
        <div class="col-6"><h3><span class="huff">(nowy!) </span>Pomóc innym graczom 100 razy</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 32)){
                echo "<div class=\"button-or-not\">
                <h2>ZAKOŃCZONO</h2>
            </div>";
            }
            elseif(from_quest_db($id, 'helped') >= 100){
                echo "<a href='fasolka_quest.php?nagroda=32'><div class=\"button-or-not\">
                <h2 style='color: hotpink'>NAGRODA!</h2>
            </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".from_quest_db($id, 'helped')."\" max=\"100\"></progress>
                <h4>Udzielono pomocy <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'helped')."</span> z <span class=\"bit-bigger colored bold\">100</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3><span class="huff">(nowy!) </span>Pomóc innym graczom 1000 razy</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 33)){
                echo "<div class=\"button-or-not\">
                <h2>ZAKOŃCZONO</h2>
            </div>";
            }
            elseif(from_quest_db($id, 'helped') >= 1000){
                echo "<a href='fasolka_quest.php?nagroda=33'><div class=\"button-or-not\">
                <h2 style='color: hotpink'>NAGRODA!</h2>
            </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".from_quest_db($id, 'helped')."\" max=\"1000\"></progress>
                <h4>Udzielono pomocy <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'helped')."</span> z <span class=\"bit-bigger colored bold\">1000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3><span class="huff">(nowy!) </span>Pomóc innym graczom 5000 razy</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 34)){
                echo "<div class=\"button-or-not\">
                <h2>ZAKOŃCZONO</h2>
            </div>";
            }
            elseif(from_quest_db($id, 'helped') >= 5000){
                echo "<a href='fasolka_quest.php?nagroda=34'><div class=\"button-or-not\">
                <h2 style='color: hotpink'>NAGRODA!</h2>
            </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".from_quest_db($id, 'helped')."\" max=\"5000\"></progress>
                <h4>Udzielono pomocy <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'helped')."</span> z <span class=\"bit-bigger colored bold\">5000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3><span class="huff">(nowy!) </span>Ukraść 100 fasolek</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 22)){
                echo "<div class=\"button-or-not\">
                <h2>ZAKOŃCZONO</h2>
            </div>";
            }
            elseif(from_quest_db($id, 'stolenbeans') >= 100){
                echo "<a href='fasolka_quest.php?nagroda=22'><div class=\"button-or-not\">
                <h2 style='color: hotpink'>NAGRODA!</h2>
            </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".from_quest_db($id, 'stolenbeans')."\" max=\"100\"></progress>
                <h4>Ukradziono <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'stolenbeans')."</span> z <span class=\"bit-bigger colored bold\">100</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Paść ofiarą kradzieży 100 razy</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 23)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'theftvictim') >= 100){
                    echo "<a href='fasolka_quest.php?nagroda=23'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'theftvictim')."\" max=\"100\"></progress>
                    <h4>Byłaś/eś okradziona/y <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'theftvictim')."</span> z <span class=\"bit-bigger colored bold\">100</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Ukraść 1000 galeonów</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 24)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'stolenmoney') >= 1000){
                    echo "<a href='fasolka_quest.php?nagroda=24'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'stolenmoney')."\" max=\"1000\"></progress>
                    <h4>Ukradziono <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'stolenmoney')."</span> z <span class=\"bit-bigger colored bold\">1000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Przeprowadzić 1000 nieudanych prób kradzieży</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 25)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'failedthefts') >= 1000){
                    echo "<a href='fasolka_quest.php?nagroda=25'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'failedthefts')."\" max=\"1000\"></progress>
                    <h4>Przeprowadzono <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'failedthefts')."</span> z <span class=\"bit-bigger colored bold\">1000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Zbierz 1000 galeonów z bonusów w skupie</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 26)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'skupbonus') >= 1000){
                    echo "<a href='fasolka_quest.php?nagroda=26'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'skupbonus')."\" max=\"1000\"></progress>
                    <h4>Zebrano <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'skupbonus')."</span> z <span class=\"bit-bigger colored bold\">1000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Zbierz 10 000 galeonów z bonusów w skupie</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 27)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'skupbonus') >= 10000){
                    echo "<a href='fasolka_quest.php?nagroda=27'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'skupbonus')."\" max=\"10000\"></progress>
                    <h4>Zebrano <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'skupbonus')."</span> z <span class=\"bit-bigger colored bold\">10000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Wyciągnąć (w sumie) 5000 galeonów z czary skąpca</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 28)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'fromskapiec') >= 5000){
                    echo "<a href='fasolka_quest.php?nagroda=28'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'fromskapiec')."\" max=\"5000\"></progress>
                    <h4>Wyciągnięto <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'fromskapiec')."</span> z <span class=\"bit-bigger colored bold\">5000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Wyciągnąć (w sumie) 20 000 galeonów z czary skąpca</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 29)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'fromskapiec') >= 20000){
                    echo "<a href='fasolka_quest.php?nagroda=29'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'fromskapiec')."\" max=\"20000\"></progress>
                    <h4>Wyciągnięto <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'fromskapiec')."</span> z <span class=\"bit-bigger colored bold\">20000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Wylosować 1000 razy dodatkową fasolkę z losu</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 30)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'doubles') >= 1000){
                    echo "<a href='fasolka_quest.php?nagroda=30'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'doubles')."\" max=\"1000\"></progress>
                    <h4>Wylosowano <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'doubles')."</span> z <span class=\"bit-bigger colored bold\">1000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-6"><h3><span class="huff">(nowy!) </span>Wylosować 5000 razy dodatkową fasolkę z losu</h3></div>
            <div class="col-6">
                <?php
                if(is_quest_complete($id, 31)){
                    echo "<div class=\"button-or-not\">
                    <h2>ZAKOŃCZONO</h2>
                </div>";
                }
                elseif(from_quest_db($id, 'doubles') >= 5000){
                    echo "<a href='fasolka_quest.php?nagroda=31'><div class=\"button-or-not\">
                    <h2 style='color: hotpink'>NAGRODA!</h2>
                </div></a>";
                }
                else{
                    echo "<div class=\"button-or-not-no-hover\">
                    <progress value=\"".from_quest_db($id, 'doubles')."\" max=\"5000\"></progress>
                    <h4>Wylosowano <span class=\"bit-bigger colored bold\">".from_quest_db($id, 'doubles')."</span> z <span class=\"bit-bigger colored bold\">5000</span></h4>
                </div>";
                }
                ?>

            </div>
        </div>

    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie pospolite fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 1)){
                echo "<div class=\"button-or-not\">
                <h2>ZAKOŃCZONO</h2>
            </div>";
            }
            elseif(ile_pospolitych_fasolek($id) >= ile_pospolitych_fasolek()){
                echo "<a href='fasolka_quest.php?nagroda=1'><div class=\"button-or-not\">
                <h2 style='color: hotpink'>NAGRODA!</h2>
            </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_pospolitych_fasolek($id)."\" max=\"".ile_pospolitych_fasolek()."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_pospolitych_fasolek($id)."</span> z <span class=\"bit-bigger colored bold\">".ile_pospolitych_fasolek()."</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie rzadkie fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 2)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_rzadkich_fasolek($id) >= ile_rzadkich_fasolek()){
                echo "<a href='fasolka_quest.php?nagroda=2'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_rzadkich_fasolek($id)."\" max=\"".ile_rzadkich_fasolek()."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_rzadkich_fasolek($id)."</span> z <span class=\"bit-bigger colored bold\">".ile_rzadkich_fasolek()."</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie unikatowe fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 3)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_unikatowych_fasolek($id) >= ile_unikatowych_fasolek()){
                echo "<a href='fasolka_quest.php?nagroda=3'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_unikatowych_fasolek($id)."\" max=\"".ile_unikatowych_fasolek()."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_unikatowych_fasolek($id)."</span> z <span class=\"bit-bigger colored bold\">".ile_unikatowych_fasolek()."</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz 50 fasolek w ciągu ostatnich 30 minut</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 4)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_w_ciagu('pol', $id) >= 50){
                echo "<a href='fasolka_quest.php?nagroda=4'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_w_ciagu('pol', $id)."\" max=\"50\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">";echo ile_w_ciagu('pol', $id); echo"</span> z <span class=\"bit-bigger colored bold\">50</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz 200 fasolek w ciągu ostatniej godziny</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 5)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_w_ciagu('godzina', $id) >= 200){
                echo "<a href='fasolka_quest.php?nagroda=5'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_w_ciagu('godzina', $id)."\" max=\"200\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_w_ciagu('godzina', $id)."</span> z <span class=\"bit-bigger colored bold\">200</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Wydaj 100 galeonów na fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 6)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_wydal($id) >= 100){
                echo "<a href='fasolka_quest.php?nagroda=6'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_wydal($id)."\" max=\"100\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_wydal($id)."</span> z <span class=\"bit-bigger colored bold\">100</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Wydaj 1 000 galeonów na fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 7)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_wydal($id) >= 1000){
                echo "<a href='fasolka_quest.php?nagroda=7'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_wydal($id)."\" max=\"1000\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_wydal($id)."</span> z <span class=\"bit-bigger colored bold\">1000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Wydaj 10 000 galeonów na fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 8)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_wydal($id) >= 10000){
                echo "<a href='fasolka_quest.php?nagroda=8'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_wydal($id)."\" max=\"10000\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_wydal($id)."</span> z <span class=\"bit-bigger colored bold\">10000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie owocowe fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 9)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_z_grupy('owoc',$id) >= ile_z_grupy('owoc')){
                echo "<a href='fasolka_quest.php?nagroda=9'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_z_grupy('owoc',$id)."\" max=\"".ile_z_grupy('owoc')."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_z_grupy('owoc',$id)."</span> z <span class=\"bit-bigger colored bold\">".ile_z_grupy('owoc')."</h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie warzywne fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 10)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_z_grupy('warzywo',$id) >= ile_z_grupy('warzywo')){
                echo "<a href='fasolka_quest.php?nagroda=10'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_z_grupy('warzywo',$id)."\" max=\"".ile_z_grupy('warzywo')."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_z_grupy('warzywo',$id)."</span> z <span class=\"bit-bigger colored bold\">".ile_z_grupy('warzywo')."</h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie egzotyczne fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 11)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_z_grupy('egz',$id) >= ile_z_grupy('egz')){
                echo "<a href='fasolka_quest.php?nagroda=11'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_z_grupy('egz',$id)."\" max=\"".ile_z_grupy('egz')."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_z_grupy('egz',$id)."</span> z <span class=\"bit-bigger colored bold\">".ile_z_grupy('egz')."</h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie obrzydliwe fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 12)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_z_grupy('egz',$id) >= ile_z_grupy('egz')){
                echo "<a href='fasolka_quest.php?nagroda=12'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_z_grupy('egz',$id)."\" max=\"".ile_z_grupy('egz')."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_z_grupy('egz',$id)."</span> z <span class=\"bit-bigger colored bold\">".ile_z_grupy('egz')."</h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie słodkie fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 13)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_z_grupy('sweet',$id) >= ile_z_grupy('sweet')){
                echo "<a href='fasolka_quest.php?nagroda=13'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_z_grupy('sweet',$id)."\" max=\"".ile_z_grupy('sweet')."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_z_grupy('sweet',$id)."</span> z <span class=\"bit-bigger colored bold\">".ile_z_grupy('sweet')."</h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz wszystkie wegańskie fasolki</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 14)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_z_grupy('wege',$id) >= ile_z_grupy('wege')){
                echo "<a href='fasolka_quest.php?nagroda=14'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_z_grupy('wege',$id)."\" max=\"".ile_z_grupy('wege')."\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_z_grupy('wege',$id)."</span> z <span class=\"bit-bigger colored bold\">".ile_z_grupy('wege')."</h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz (w sumie) 1 000 fasolek w nocy (23:00 - 5:00)</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 15)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_nocnych_wszystkich_fasolek($id) >= 1000){
                echo "<a href='fasolka_quest.php?nagroda=15'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_nocnych_wszystkich_fasolek($id)."\" max=\"1000\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_nocnych_wszystkich_fasolek($id)."</span> z <span class=\"bit-bigger colored bold\">1 000</span></h4>
            </div>";
            }
            ?>

        </div>

    </div>
    <div class="row">
        <div class="col-6"><h3>Zbierz (w sumie) 5 000 fasolek</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 16)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_znalezionych_fasolek($id) >= 5000){
                echo "<a href='fasolka_quest.php?nagroda=16'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_znalezionych_fasolek($id)."\" max=\"5000\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_znalezionych_fasolek($id)."</span> z <span class=\"bit-bigger colored bold\">5 000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Sprzedaj fasolki o wartości (w sumie) 1 000 galeonów</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 17)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(za_ile_sprzedano($id) >= 1000){
                echo "<a href='fasolka_quest.php?nagroda=17'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".za_ile_sprzedano($id)."\" max=\"1000\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".za_ile_sprzedano($id)."</span> z <span class=\"bit-bigger colored bold\">1 000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Sprzedaj fasolki o wartości (w sumie) 10 000 galeonów</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 18)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(za_ile_sprzedano($id) >= 10000){
                echo "<a href='fasolka_quest.php?nagroda=18'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".za_ile_sprzedano($id)."\" max=\"10000\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".za_ile_sprzedano($id)."</span> z <span class=\"bit-bigger colored bold\">10 000</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Użyj 10 brązowych bilecików</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 19)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_uzytych_brazowych($id) >= 10){
                echo "<a href='fasolka_quest.php?nagroda=19'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_uzytych_brazowych($id)."\" max=\"10\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_uzytych_brazowych($id)."</span> z <span class=\"bit-bigger colored bold\">10</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Użyj 10 srebrnych bilecików</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id,20)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_uzytych_srebrnych($id) >= 10){
                echo "<a href='fasolka_quest.php?nagroda=20'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_uzytych_srebrnych($id)."\" max=\"10\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_uzytych_srebrnych($id)."</span> z <span class=\"bit-bigger colored bold\">10</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-6"><h3>Użyj 10</span> złotych bilecików</h3></div>
        <div class="col-6">
            <?php
            if(is_quest_complete($id, 21)){
                echo "<div class=\"button-or-not\">
            <h2>ZAKOŃCZONO</h2>
        </div>";
            }
            elseif(ile_uzytych_zlotych($id) >= 10){
                echo "<a href='fasolka_quest.php?nagroda=21'><div class=\"button-or-not\">
            <h2 style='color: hotpink'>NAGRODA!</h2>
        </div></a>";
            }
            else{
                echo "<div class=\"button-or-not-no-hover\">
                <progress value=\"".ile_uzytych_zlotych($id)."\" max=\"10\"></progress>
                <h4>Zebrano <span class=\"bit-bigger colored bold\">".ile_uzytych_zlotych($id)."</span> z <span class=\"bit-bigger colored bold\">10</span></h4>
            </div>";
            }
            ?>

        </div>
    </div>
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
