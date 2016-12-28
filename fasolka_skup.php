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


//
//if($id != 8){
//    header("Location: fasolka_panel.php");
//    exit();
//}

if(isset($_SESSION['outcome'])){
    print_overfooter($_SESSION['outcome']);
    unset($_SESSION['outcome']);
}

if($_POST) {
    $freebeans = from_quest_db($id, 'freebeans');
    if(isset($_POST['bilecik'])) {
        if($_POST['bilecik']=='bronze'){
            if($freebeans >= 25){
                give_bilecik($id, 1, 'bronze');
                change_freebeans($id, -25);
                $_SESSION['sprzedano'] = "<h1>Kupiłeś brązowy bilecik!</h1>";
            }
            header("Location: fasolka_skup.php");
            exit();
        }
        elseif($_POST['bilecik']=='silver'){
            if($freebeans >= 100){
                give_bilecik($id, 1, 'silver');
                change_freebeans($id, -100);
                $_SESSION['sprzedano'] = "<h1>Kupiłeś srebrny bilecik!</h1>";
            }
            header("Location: fasolka_skup.php");
            exit();
        }
        else{
            if($freebeans >= 400){
                give_bilecik($id, 1, 'golden');
                change_freebeans($id, -400);
                $_SESSION['sprzedano'] = "<h1>Kupiłeś złoty bilecik!</h1>";
            }
            header("Location: fasolka_skup.php");
            exit();
        }
    }
    else {
        $sql = "SELECT fasolka, count(*) AS ilosc FROM beans_owners WHERE skrytka = $id GROUP BY fasolka HAVING count(*) > 1";
        $result = db_statement($sql);
        if (mysqli_num_rows($result) == 0) {
            $_SESSION['sprzedano'] = "<h3>Nic nie sprzedano... bo nie ma czego.</h3>";
        } else {
            $bonus = $_SESSION['bonus'];
            $ile = $_SESSION['ile'];
            $ids_to_delete = $_SESSION['ids_to_delete'];
            $suma = $_SESSION['suma'];
            unset($_SESSION['bonus'], $_SESSION['ile'], $_SESSION['suma'], $_SESSION['ids_to_delete']);
            foreach ($ids_to_delete as $idf) {
                $sql = "DELETE FROM beans_owners WHERE id = $idf";
                db_statement($sql);
            }

            quest_add($id, 'skupbonus', $bonus);
            $sql = "UPDATE hpotter_bank_skrytki SET konto = konto + $suma, skup = skup + $suma WHERE numer = $id";
            db_statement($sql);
            $_SESSION['sprzedano'] = "<h3>Sprzedano $ile fasolek za $suma galeonów (w tym $bonus to bonus)!</h3>";
            header("Location: fasolka_skup.php");
            exit();
        }
    }


}
else{

    //    $sql = "SELECT id, fasolka FROM beans_owners WHERE skrytka = $id AND fasolka IN (SELECT fasolka FROM beans_owners WHERE skrytka = $id GROUP BY fasolka HAVING count(*) > 1) LIMIT 50";

    $sql = "SELECT fasolka, count(*) AS ilosc FROM beans_owners WHERE skrytka = $id GROUP BY fasolka HAVING count(*) > 1";
    $result = db_statement($sql);
    $suma = 0;
    $ile = 0;
    $ids_to_delete = [];
    while($row = mysqli_fetch_assoc($result)){
        $fasolka = $row['fasolka'];
        $ilosc = $row['ilosc'];
        $ilosc = $ilosc - 1;
        $sql = "SELECT wartosc FROM beans WHERE id = $fasolka";
        $outcome = db_statement($sql);
        $wynik = mysqli_fetch_assoc($outcome);
        $wartosc = $wynik['wartosc'];
        if(happy_hours_noon()) $pospolita_wart = 2;
        else $pospolita_wart = 1;
        if ($wartosc == 1) $suma = $suma + ($ilosc*$pospolita_wart);
        elseif ($wartosc == 2) $suma = $suma + ($ilosc*10);
        elseif ($wartosc == 3) $suma = $suma + ($ilosc*100);
        elseif ($wartosc == 4) $suma = $suma + ($ilosc*1000);
        elseif ($wartosc == 5) $suma = $suma + ($ilosc*2000);
        $ile = $ile + $ilosc;
        $sql = "SELECT id FROM beans_owners WHERE skrytka = $id AND fasolka = $fasolka LIMIT $ilosc";
        $outcome = db_statement($sql);

        while($wynik = mysqli_fetch_assoc($outcome)){
            $idf = $wynik['id'];
            array_push($ids_to_delete, $idf);
        }

    }
    $_SESSION['ids_to_delete'] = $ids_to_delete;
    $bonus = skup_bonus($suma, $id);
    $suma = $suma + $bonus;
    $_SESSION['ile'] = $ile;
    $_SESSION['suma'] = $suma;
    $_SESSION['bonus'] = $bonus;


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

    <?
    if(happy_hours_noon()) echo "<h1 class='huff'>Happy hours! (10:00-15:59) Za sprzedaż pospolitej fasolki otrzymasz 2 galeony zamiast 1!";

    if(!isset($_SESSION['sprzedano'])){
        $freebeans = from_quest_db($id, 'freebeans');
        echo "<h2>Darmowe losy możesz wymienić na bileciki! <span class='colored'>25 losów kosztuje brązowy bilecik, 100 srebrny, natomiast złoty 400</span>.</h2><h2>Brązowy bilecik losuje 10, srebrny 20, a złoty 30 nowych fasolek ze zwiększonym prawdopodobieństwem na fasolki rzadkie i unikatowe!</h2>";

            if($freebeans >= 400){echo"<form class=\"form-sleek\" action=\"fasolka_skup.php\" method=\"post\" style=\"margin-top: 0px;padding: 0px 20px\">
        <input style='display: block' type=\"submit\" value=\"Kup złoty bilecik\">
        <p class=\"robotic\" id=\"pot\"><label>Jeśli widzisz to pole, to zostaw je puste</label>
            <input name=\"bilecik\" type=\"hidden\" id=\"robotest\" value=\"golden\">
            </p></form>";}
            if($freebeans >= 100){echo"<form class=\"form-sleek\" action=\"fasolka_skup.php\" method=\"post\" style=\"margin-top: 0px; padding: 0px 20px\">
        <input style='display: block' type=\"submit\" value=\"Kup srebrny bilecik\">
        <p class=\"robotic\" id=\"pot\"><label>Jeśli widzisz to pole, to zostaw je puste</label>
            <input name=\"bilecik\" type=\"hidden\" id=\"robotest\" value=\"silver\">
            </p></form>";}
            if($freebeans >= 25){echo"<form class=\"form-sleek\" action=\"fasolka_skup.php\" method=\"post\" style=\"margin-top: 0px; padding: 0px 20px\">
        <input style='display: block' type=\"submit\" value=\"Kup brązowy bilecik\">
        <p class=\"robotic\" id=\"pot\"><label>Jeśli widzisz to pole, to zostaw je puste</label>
            <input name=\"bilecik\" type=\"hidden\" id=\"robotest\" value=\"bronze\">
            </p></form>";}


        echo"<h3 style=\"font-size:250%; margin: 4% 2% 2% 2%\">Lista powtarzających się fasolek</h3>
    <form class=\"form-sleek\" action=\"fasolka_skup.php\" method=\"post\" style=\"margin-top: 0px;\">
        <input style='display: block' type=\"submit\" value=\"SPRZEDAJ ZBĘDNE FASOLKI!\" style=\"width: 100%; padding: 15px; margin-top: 0px; font-size: 200%; font-family: Ubuntu\">
        <p class=\"robotic\" id=\"pot\"><label>Jeśli widzisz to pole, to zostaw je puste</label>
            <input name=\"robotest\" type=\"text\" id=\"robotest\" class=\"robotest\">
            </p></form>";

        $sql = "SELECT id, fasolka, count(*) AS ilosc FROM beans_owners WHERE skrytka = $id GROUP BY fasolka HAVING count(*) > 1";
        $result = db_statement($sql);
        $i = 0;
        if(mysqli_num_rows($result) == 0){
            echo "<h3>Brak fasolek do sprzedania</h3>";
        }
        else {while($row = mysqli_fetch_assoc($result)){
            $i = $i + 1;
            if(($i % 3) == 1) echo "<div class='row'>";
            $fasolka = $row['fasolka'];
            $ilosc = $row['ilosc'] - 1;
            echo "<div class='col-4'>";
            print_fasolka_duplicate($fasolka, $ilosc);
            echo "</div>";
            if(($i % 3) == 0) echo "</div>";

        }}
        if(($i % 3) != 0) echo "</div>";
    }
    else {
        echo $_SESSION['sprzedano'];
        unset($_SESSION['sprzedano']);
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