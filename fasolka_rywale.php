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



if(isset($_POST['atak']) AND !isset($_SESSION['cheatproof'])){

    $_SESSION['cheatproof'] = true;
    $atak = trim_input($_POST['cel']);
    $_SESSION['kradziez'] = losuj_kradziez($id, $atak);
    $sql = "UPDATE hpotter_bank_skrytki SET kradziez = CURRENT_TIMESTAMP WHERE numer = $id";
    $result = db_statement($sql);
    refresh_rank($id);
    refresh_rank($atak);
    header("Location: fasolka_rywale.php");
    exit();
}

if(isset($_POST['editprofit'])){

    $fertreward = trim_input($_POST['fertreward']);
    $seed_id = $_POST['seed'];
    if($fertreward < 11) $fertreward = 11;
    $sql = "UPDATE beans_pots SET fertreward = $fertreward WHERE seed_id = $seed_id";
    $result = db_statement($sql);
    header("Location: fasolka_rywale.php");
    exit();
}

if(isset($_POST['nawoz'])){

    $seed_id = trim_input($_POST['cel']);
    if(czy_mozna_nawiezc($id, $seed_id)){
        nawiez_nasionko($id, $seed_id);
    }
    header("Location: fasolka_rywale.php");
    exit();
}

if(isset($_POST['pomoc'])){

    $pomoc = trim_input($_POST['cel']);
    if(czy_mozna_pomoc($id, $pomoc)){
        darmowe_fasolki($id, $pomoc);
        if(happy_hours_morning()) $_SESSION['kradziez'] = "Twój przyjaciel zyskał 5 darmowych fasolek, a Ty dwie!";
        else $_SESSION['kradziez'] = "Twój przyjaciel zyskał 5 darmowych fasolek, a Ty jedną!";
    }
    else{
        $_SESSION['kradziez'] = "Nie oszukuj!";
    }
    header("Location: fasolka_rywale.php");
    exit();
}

if(isset($_GET['bilecik'])){
    $kolor = trim_input($_GET['bilecik']);
    $komu = trim_input($_GET['gracz']);
    if($kolor == 'b'){
        $sql = "UPDATE hpotter_bank_skrytki SET bronze = bronze + 1 WHERE numer = $komu";
        db_statement($sql);
        header("Location: fasolka_rywale.php");
        exit;
    }
    elseif($kolor == 's'){
        $sql = "UPDATE hpotter_bank_skrytki SET silver = silver + 1 WHERE numer = $komu";
        db_statement($sql);
        header("Location: fasolka_rywale.php");
        exit;
    }
    else{
        $sql = "UPDATE hpotter_bank_skrytki SET golden = golden + 1 WHERE numer = $komu";
        db_statement($sql);
        header("Location: fasolka_rywale.php");
        exit;
    }
}
?>

<!-- POCZĄTEK -->
<!doctype HTML>
<html>
<head>
    <title>FASOLKI | rywale</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Wirtualny Hogwart im. Syriusza Croucha to szkoła z ogromnymi tradycjami i doświadczeniem w nauczaniu młodych adeptów magii! Zapraszamy na XXXII rok szkolny!">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Headland+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script>
    function action() {
        this.style.visibility = 'hidden';
    }
</script>

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



        <?
        print_fasolki_navbar();

        if(isset($_SESSION['kradziez'])){
            if($_SESSION['kradziez'] == "Nieudana"){
                echo "<h1>Próba kradzieży zakończona niepowodzeniem</h1>";
            }
            else{
                echo "<h1 class='gryff' style='font-size: 250%'>".$_SESSION['kradziez']."</h1>";
            }
        }

        if($_GET['cmd'] =='profitedit' AND can_edit_profit($id, $_GET['id'])){
            print_profit_edit_form($_GET['id']);
        }



            echo "<h1>Pomoc w hodowli</h1><h2>Koszt nawozu to 10 galeonów, kolumna \"zysk dla Ciebie\" już to uwzględnia i zawiera ile galeonów zyskasz/stracisz, gdy pomożesz w uprawie danemu graczowi.</h2><h3>10 najlepszych ofert</h3><table class='basic-table full-width center-align'><tr><th>Gracz</th><th>Zysk dla Ciebie (postęp nawożenia)</th><th></th></tr>";
            $sql = "SELECT beans_seeds.id AS id, beans_seeds.user_id AS user_id, beans_pots.fertreward AS fertreward, beans_seeds.fertilized AS fertilized FROM beans_seeds INNER JOIN beans_pots ON beans_seeds.id = beans_pots.seed_id WHERE beans_seeds.pot_id <> 0 AND fertilized < 10 ORDER BY beans_pots.fertreward DESC";
            $result = db_statement($sql);
            $i = 0;
            if(mysqli_num_rows($result)==0){
                echo "<h4>Brak sadzonek do nawożenia</h4>";
            }
            else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;
                    $wlasciciel = get_wlasciciel_of_id($row['user_id']);
                    $user_id = $row['user_id'];
                    $seed_id = $row['id'];
                    $fertilized = $row['fertilized'];
                    $zysk = $row['fertreward'] - 10;
                    echo "<tr><td><a href='fasolka_postac.php?id=$user_id' class='wocolor'>$wlasciciel</a></td><td>$zysk ";
                    if ($id == $user_id) echo "<a href='fasolka_rywale.php?cmd=profitedit&id=$seed_id'>(zmień)</a> ";
                    echo "(<span class='colored bold'>$fertilized</span>/10)</td><td><form method='post' class='form-fasolki'><input type='hidden' name='cel' value='$seed_id'>";
                    if (czy_mozna_nawiezc($id, $seed_id)) echo "<input type='submit' name='nawoz' value='NAWIEŹ'>";
                    echo "</form></td></tr>";
                    if ($i >= 10) break;
                }

                echo "</table>";
            }

        $sql = "SELECT beans_seeds.id AS id, beans_seeds.user_id AS user_id, beans_pots.fertreward AS fertreward, beans_seeds.fertilized AS fertilized FROM beans_seeds INNER JOIN beans_pots ON beans_seeds.id = beans_pots.seed_id WHERE beans_seeds.user_id = $id AND fertilized < 10 ORDER BY beans_pots.fertreward DESC";
        $result = db_statement($sql);
        $i = 0;
        echo "<h3>Twoje oferty</h3>";
        if(mysqli_num_rows($result)==0){
            echo "<h4>Brak</h4>";
        }
        else {
           echo "<table class='basic-table full-width center-align'><tr><th>Gracz</th><th>Zysk dla Ciebie (postęp nawożenia)</th></tr>";
            while($row = mysqli_fetch_assoc($result)){
                $i++;
                $wlasciciel = get_wlasciciel_of_id($row['user_id']);
                $user_id = $row['user_id'];
                $seed_id = $row['id'];
                $fertilized = $row['fertilized'];
                $zysk = $row['fertreward'] - 10;
                echo "<tr><td>$wlasciciel</td><td>$zysk ";
                if($id == $user_id) echo "<a href='fasolka_rywale.php?cmd=profitedit&id=$seed_id'>(zmień)</a> ";
                echo "(<span class='colored bold'>$fertilized</span>/10)</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        if(happy_hours_morning()) echo "<h1 class='huff'>Happy hours! (4:00-9:59) Za pomoc otrzymasz DWA darmowe losy zamiast jednego!";

        echo "<h1 style='border-top: 1px white solid; margin-top: 30px; padding-top: 20px'>Możesz kogoś okraść albo komuś pomóc!</h1>";
        echo "<h2>Szanse na udaną kradzież (jeśli przeciwnik nie ma obrony) wynoszą $base% + $bonus% = $total%</h2>";
        echo "<h2>Szanse na udaną pomoc zawsze wynoszą 100%! Twój rywal otrzyma 5 darmowych losowań, a Ty jedno! Aby pomóc musisz mieć przynajmniej 15. poziom. Pomóc można raz dziennie każdemu graczowi!</h2>";
        echo "<h2><span class='colored bold'>Nie można</span> pomagać graczom, którzy posiadają ponad 500 darmowych losów</h2>";
            echo "<table class='basic-table full-width center-align'>";
            echo "<tr><th>Gracz</th><th>Ranking</th><th></th></tr>";
            $sql = "SELECT numer, wlasciciel, rank FROM hpotter_bank_skrytki WHERE rank > 0 ORDER BY rank DESC";
            $result = db_statement($sql);
            while($row = mysqli_fetch_assoc($result)){
                $numer = $row['numer'];
                echo "<tr><td><a href='fasolka_postac.php?id=$numer' class='wocolor'>" . $row['wlasciciel'];
                if($id == 8) echo "<a class='wocolor' href='fasolka_rywale.php?bilecik=b&gracz=$numer'><span style='color: brown'> B</span></a><a class='wocolor' href='fasolka_rywale.php?bilecik=s&gracz=$numer'><span style='color: grey'> S</span></a><a class='wocolor' href='fasolka_rywale.php?bilecik=g&gracz=$numer'><span style='color: gold'> G</span></a>";
                echo "</a></td><td>".$row['rank']."</td><td><form method='post' class='form-fasolki'><input type='hidden' name='cel' value='$numer'>";
                if($numer != $id) echo "<input type='submit' name='atak' value='OKRADNIJ'>";
                if(czy_mozna_pomoc($id, $numer)) echo "<input type='submit' name='pomoc' value='POMÓŻ'>";
                echo "</form></td></tr>";
            }
            echo "</table>";

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
<?
    if(!isset($_POST['atak'])){
        unset($_SESSION['cheatproof']);
        unset($_SESSION['kradziez']);
    }
?>