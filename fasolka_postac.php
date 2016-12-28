<?php

session_start();
require_once('./fasolkipostac_functions_x.php');

if(isset($_SESSION['outcome'])){
    print_overfooter($_SESSION['outcome']);
    unset($_SESSION['outcome']);
}
$id = account_access($_SESSION['username'], $_SESSION['password']);
if($id != false){
    print_my_account($id);
}
if(isset($_GET['id'])){
    $postac_id = trim_input($_GET['id']);
}
else{
    if($id == false) {
        header("Location: pokatna_x.php?location=" . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
    $postac_id = $id;
}

$kto = get_wlasciciel_of_id($postac_id);
list($lvl, $remaining, $progress) = level_exp($postac_id);

?>

<!-- POCZĄTEK -->
<!doctype HTML>
<html>
<head>
    <title>FASOLKI | <? echo strtoupper($kto) ?></title>
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
    </div>

    <div class="col-1 col-m-0"></div>
    <div class="col-0 col-2 col-m-3 fasolka-hide">
        <? print_left_blocks(); ?>
    </div>
    <!-- KONIEC -->
    <div class="col-6 col-m-6">

        <?php
        $sql = "SELECT rank FROM hpotter_bank_skrytki WHERE numer = $postac_id";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        if($row['rank']==0 OR $row['rank']==NULL){
            echo "<h1>Nie tędy droga...</h1>";
        }
        else{
            print_fasolki_navbar();
            echo "<h1 style='text-align: center; font-size: 350%'>".$kto."</h1>";
            echo "<h1 style='text-align: center; font-size: 250%' class='colored'>".$lvl." poziom</h1>";
            print_best_three_beans($postac_id);
            echo "<h3>Posiadane ordery</h3>";
            echo "<div class='row'>";
            $hmo = 0; //how many orders
            $hmo = print_order($hmo, rank_from_table($postac_id, 'stolenbeans', 'hpotter_bank_skrytki_q'), 'Zuchwały złodziej fasolek');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'stolenmoney', 'hpotter_bank_skrytki_q'), 'Bezczelny złodziej galeonów');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'failedthefts', 'hpotter_bank_skrytki_q'), 'Mistrz nieudanych kradzieży');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'skupbonus', 'hpotter_bank_skrytki_q'), 'Kolekcjoner bonusów ze skupu');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'fromskapiec', 'hpotter_bank_skrytki_q'), 'Zbieracz galeonów z czary');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'doubles', 'hpotter_bank_skrytki_q'), 'Zbieracz dodatkowych fasolek');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'theftvictim', 'hpotter_bank_skrytki_q'), 'Ulubiona ofiara złodziei');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'helped', 'hpotter_bank_skrytki_q'), 'Uprzejmy pomagacz');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'planted', 'hpotter_bank_skrytki_q'), 'Zręczny nasionkozasiewicz');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'konto', 'hpotter_bank_skrytki'), 'Skąpy galeonozbieracz');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'dodexp', 'hpotter_bank_skrytki'), 'Zdolny ogrodnik');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'suma', 'hpotter_bank_skrytki'), 'Wydajny fasolkolekcjoner');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'wydano', 'hpotter_bank_skrytki'), 'Najlepszy losokupca');
            $hmo = print_order($hmo, rank_from_table($postac_id, 'noc', 'hpotter_bank_skrytki'), 'Nocny marek');
            $hmo = print_order($hmo, rank_from_table_diff($postac_id, '(bronzeu+silveru+goldenu) AS sum', 'sum', 'hpotter_bank_skrytki'), 'Bilecikomaniak');
            $hmo = print_order($hmo, rank_from_table_diff($postac_id, '(rozbojnik+skapiec+kupiec+stroz+szczesciarz) AS sum', 'sum', 'hpotter_bank_skrytki'), 'Czaroulepszacz');
            if($hmo == 0) echo "<h4 class='center-align'>No nie... żadnego orderu?</h4>";
            echo "</div>";

        }
        ?>



    </div>

    <!-- POCZĄTEK ------------->

    <div class="col-low-res fasolka-hide">
        <? print_mobile_bottom() ?>
    </div>


    <div class="col-0 col-2 col-m-3 fasolka-hide">
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