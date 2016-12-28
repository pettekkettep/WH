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

$sql = "SELECT skapiec, szczesciarz, stroz, kupiec, rozbojnik FROM hpotter_bank_skrytki WHERE numer = $id";
$result = db_statement($sql);
$row = mysqli_fetch_assoc($result);

$skapiec = $row['skapiec'];
$szczesciarz = $row['szczesciarz'];
$stroz = $row['stroz'];
$kupiec = $row['kupiec'];
$rozbojnik = $row['rozbojnik'];

$suma = $skapiec + $szczesciarz + $stroz + $kupiec + $rozbojnik;
$cost = next_lvl_cost($suma);
$total_cost_so_far = cost_to_this_lvl($suma);

if(isset($_GET['ulepsz'])){
    $co = trim_input($_GET['ulepsz']);
    if($co == "skapiec"){
        if($skapiec < 10){
            $konto = get_konto_of_id($id);
            if($konto < $cost) $tekst = "Nie ma wystarczających funduszy!";
            else{
                level_up('skapiec', $id, $cost);
                $tekst = "Ulepszono czarę skąpca na " .($skapiec+1). " poziom!";
            }
        }
        else{
            $tekst = "Czara skąpca jest już na 10. poziomie. Obecnie nie można uzyskać wyższego";
        }
    }
    elseif($co == "szczesciarz"){
        if($szczesciarz < 10){
            $konto = get_konto_of_id($id);
            if($konto < $cost) $tekst = "Nie ma wystarczających funduszy!";
            else{
                level_up('szczesciarz', $id, $cost);
                $tekst = "Ulepszono czarę szczęściarza na " .($szczesciarz+1). " poziom!";
            }
        }
        else{
            $tekst = "Czara szczęściarza jest już na 10. poziomie. Obecnie nie można uzyskać wyższego";
        }
    }
    elseif($co == "stroz"){
        if($stroz < 10){
            $konto = get_konto_of_id($id);
            if($konto < $cost) $tekst = "Nie ma wystarczających funduszy!";
            else{
                level_up('stroz', $id, $cost);
                $tekst = "Ulepszono czarę stróża na " .($stroz+1). " poziom!";
            }
        }
        else{
            $tekst = "Czara stróża jest już na 10. poziomie. Obecnie nie można uzyskać wyższego";
        }
    }
    elseif($co == "kupiec"){
        if($kupiec < 10){
            $konto = get_konto_of_id($id);
            if($konto < $cost) $tekst = "Nie ma wystarczających funduszy!";
            else{
                level_up('kupiec', $id, $cost);
                $tekst = "Ulepszono czarę kupca na " .($kupiec+1). " poziom!";
            }
        }
        else{
            $tekst = "Czara kupca jest już na 10. poziomie. Obecnie nie można uzyskać wyższego";
        }
    }
    elseif($co == "rozbojnik"){
        if($rozbojnik < 10){
            $konto = get_konto_of_id($id);
            if($konto < $cost) $tekst = "Nie ma wystarczających funduszy!";
            else{
                level_up('rozbojnik', $id, $cost);
                $tekst = "Ulepszono czarę rozbójnika na " .($rozbojnik+1). " poziom!";
            }
        }
        else{
            $tekst = "Czara rozbójnika jest już na 10. poziomie. Obecnie nie można uzyskać wyższego";
        }
    }
    else{
        zresetuj_czary($id);
        $kwota = floor(0.95*$total_cost_so_far);
        dodaj_galeony($id, $kwota);
        $tekst = "Zresetowano umiejętności i przelano $kwota galeonów";
    }
    $_SESSION['tekst'] = $tekst;
    header("Location: fasolka_profil.php");
    exit();
}

if($_GET['czara']=="wez"){
    $tekst = hajs_z_czary($id);
    $_SESSION['tekst'] = $tekst;
    header("Location: fasolka_profil.php");
    exit();
}

if($_GET['akcja']=="usun"){
    $majatek = get_majatek_of($id);
    $majatek = floor($majatek/2);
    $sql = "DELETE FROM hpotter_bank_przedmioty WHERE id_wlasciciela = $id";
    db_statement($sql);
    dodaj_galeony($id, $majatek);
    $_SESSION['tekst'] = "Właśnie sprzedałeś swój majątek za pół ceny! Gratulacje!";
    header("Location: fasolka_profil.php");
    exit();
}

?>

<!-- POCZĄTEK -->
<!doctype HTML>
<html>
<head>
    <title>FASOLKI | profil</title>
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
        <?php
        if(isset($_SESSION['tekst'])){
            echo "<div class='row'><h1>".$_SESSION['tekst']."</h1></div>";
            unset($_SESSION['tekst']);
        }

        ?>

        <div class="row">
            <h3>Pieniądze wydane na ulepszenia: <span class="colored bold"><?php echo $total_cost_so_far ?></span> galeonów</h3>
            <h4>Zresetowanie czar spowoduje przelanie z powrotem na konto 95% wydanych na nie galeonów.</h4>

            <a href="fasolka_profil.php?ulepsz=cancel">
                <div class="button-or-not">RESETUJ CZARY</div>
            </a>
            <div class="col-6">
                <a href="fasolka_profil.php?czara=wez"><img src="fasolki/czary/czara1.png"></a>
                </div>
            <div class="col-6">
                <h1 class="center-align" style="color: #aaddaa; padding-top: 4%">Czara skąpca</h1>
                <h4 class="center-align">Obecny poziom: <span style="color: #aaddaa"><? echo $skapiec ?></span></h4>
                <h4 class="center-align">Obecny bonus: <span style="color: #aaddaa"><? echo "+".skapiec_pts($skapiec)."%" ?></span></h4>
                <p style="margin: 5% 0%; text-align: justify">Raz dziennie daje możliwość odebrania (klikając na czarę) nagrodę w wysokości części posiadanego budżetu (maksymalnie 500 galeonów). Ulepszenie czary na 10. poziom umożliwia otrzymywanie 15% liczby posiadanych galeonów codziennie.</p>

                <a href="fasolka_profil.php?ulepsz=skapiec">
                    <div class="button-or-not">ULEPSZ</div>
                </a>
                <p class="italic center-align bit-smaller narrow">Koszt: <? echo $cost ?> galeonów</p>

            </div>
            </div>

        <div class="row">
            <div class="col-6">
                <img src="fasolki/czary/czara3.png">

            </div>
            <div class="col-6">
                <h1 class="center-align" style="color: #ffbbee; padding-top: 4%">Czara szczęściarza</h1>
                <h4 class="center-align">Obecny poziom: <span style="color: #ffbbee"><? echo $szczesciarz ?></span></h4>
                <h4 class="center-align">Obecny bonus: <span style="color: #ffbbee"><? echo "+".szczesciarz_pts($szczesciarz)."%" ?></span></h4>
                <p style="margin: 5% 0%; text-align: justify;">Umożliwia uzyskanie dwóch fasolek z jednego losu. Ulepszenie czary na 10. poziom daje 30% szansę na wylosowanie dodatkowej fasolki.</p>

                <a href="fasolka_profil.php?ulepsz=szczesciarz">
                    <div class="button-or-not">ULEPSZ</div>
                </a>
                <p class="italic center-align bit-smaller narrow">Koszt: <? echo $cost ?> galeonów</p>

            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <img src="fasolki/czary/czara5.png">

            </div>
            <div class="col-6">
                <h1 class="center-align" style="color: #3355ee; padding-top: 4%">Czara stróża</h1>
                <h4 class="center-align">Obecny poziom: <span style="color: #3355ee"><? echo $stroz ?></span></h4>
                <h4 class="center-align">Obecny bonus: <span style="color: #3355ee"><? echo "+".stroz_pts($stroz)."%" ?></span></h4>
                <p style="margin: 5% 0%; text-align: justify;">Zmniejsza szansę na udaną kradzież z kolekcji fasolek. Ulepszenie czary na 10. poziom zmniejsza tę szansę o 80 punktów procentowych.</p>

                <a href="fasolka_profil.php?ulepsz=stroz">
                    <div class="button-or-not">ULEPSZ</div>
                </a>
                <p class="italic center-align bit-smaller narrow">Koszt: <? echo $cost ?> galeonów</p>

            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <img src="fasolki/czary/czara6.png">

            </div>
            <div class="col-6">
                <h1 class="center-align" style="color: #aa33bb; padding-top: 4%">Czara kupca</h1>
                <h4 class="center-align">Obecny poziom: <span style="color: #aa33bb"><? echo $kupiec ?></span></h4>
                <h4 class="center-align">Obecny bonus: <span style="color: #aa33bb"><? echo "+".kupiec_pts($kupiec)."%" ?></span></h4>
                <p style="margin: 5% 0%; text-align: justify">Daje specjalne względy u kupca fasolek. Każda sprzedaż wiąże się z bonusową ilością otrzymanych galeonów. Ulepszenie czary na 10. poziom daje 30% bonusu.</p>

                <a href="fasolka_profil.php?ulepsz=kupiec">
                    <div class="button-or-not">ULEPSZ</div>
                </a>
                <p class="italic center-align bit-smaller narrow">Koszt: <? echo $cost ?> galeonów</p>

            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <img src="fasolki/czary/czara7.png">

            </div>
            <div class="col-6">
                <h1 class="center-align" style="color: #aadddd; padding-top: 4%">Czara rozbójnika</h1>
                <h4 class="center-align">Obecny poziom: <span style="color: #aadddd"><? echo $rozbojnik ?></span></h4>
                <h4 class="center-align">Obecny bonus: <span style="color: #aadddd"><? echo "+".rozbojnik_pts($rozbojnik)."%" ?></span></h4>
                <p style="margin: 5% 0%; text-align: justify">Zwiększa szanse na udaną kradzież z kolekcji rywala. Ulepszenie czary na 10. poziom zwiększa maksymalny bonus do 80 punktów procentowych. Maksymalny bonus ładuje się co 15 minut.</p>

                <a href="fasolka_profil.php?ulepsz=rozbojnik">
                    <div class="button-or-not">ULEPSZ</div>
                </a>
                <p class="italic center-align bit-smaller narrow">Koszt: <? echo $cost ?> galeonów</p>

            </div>
        </div>
        <h4 class="center-align" style="color: red"><a href="fasolka_profil.php?akcja=usun">Sprzedaj swój majątek z Pokątnej za pół ceny.</a></h4>


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