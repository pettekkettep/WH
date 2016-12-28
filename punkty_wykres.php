<?php

session_start();

require_once("./functions_x.php");

?>

<!doctype HTML>
<html>
<head>
    <title>RD | stat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Wirtualny Hogwart im. Syriusza Croucha to szkoła z ogromnymi tradycjami i doświadczeniem w nauczaniu młodych adeptów magii! Zapraszamy na XXXII rok szkolny!">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Headland+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Dzień', 'Gryffindor', 'Hufflepuff', 'Ravenclaw', 'Slytherin'],
                <?
                $now = time(); // or your date as well
                $your_date = strtotime("2016-09-05");
                $datediff = $now - $your_date;
                $i_limit = floor($datediff/(60*60*24));
                for($i = 1; $i <= $i_limit; $i++){
                    echo "[$i,";
                    $sql = "SELECT sum(ile) AS punkty FROM punkty_opis WHERE id_dom = 1 AND created <= '2016-09-05' + INTERVAL $i DAY";
                    $result = db_statement($sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['punkty'].",";
                    $sql = "SELECT sum(ile) AS punkty FROM punkty_opis WHERE id_dom = 4 AND created <= '2016-09-05' + INTERVAL $i DAY";
                    $result = db_statement($sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['punkty'].",";
                    $sql = "SELECT sum(ile) AS punkty FROM punkty_opis WHERE id_dom = 3 AND created <= '2016-09-05' + INTERVAL $i DAY";
                    $result = db_statement($sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['punkty'].",";
                    $sql = "SELECT sum(ile) AS punkty FROM punkty_opis WHERE id_dom = 2 AND created <= '2016-09-05' + INTERVAL $i DAY";
                    $result = db_statement($sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['punkty']."],";
                }
                ?>
            ]);

            var options = {
                title: 'Walka o Puchar Domów',
                curveType: 'function',
                legend: { position: 'bottom' },
                backgroundColor: { fill:'transparent' },
                fontName: 'Ubuntu',
                legendTextStyle: { color: '#FFF' },
                titleTextStyle: { color: '#FFF' },
                hAxis: {
                    title: 'Dni od rozpoczęcia roku',
                    color: '#FFF',
                    gridlines: {
                        color: "#CCCCCC"
                    },
                    baselineColor: '#CCCCCC',
                    textStyle:{color: '#FFF'},
                    titleTextStyle:{color: '#FFF'},
                },
                vAxis: {
                    textStyle:{color: '#FFF'},
                    titleTextStyle:{color: '#FFF'},
                    title: 'Liczba punktów'
                },
                series: {
                    0: {color: '#ff0000', lineWidth: 3},
                    1: {color: '#ffcc00', lineWidth: 3},
                    2: {color: '#0066ff', lineWidth: 3},
                    3: {color: '#00cc00', lineWidth: 3},
                }

            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body onLoad="window.scrollBy(0,600)">
<!--<body onload = "startTimer()">-->
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
<div class="row row-style-light center-align">
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

    <div class="col-low-res center-align">
        <? print_mobile_top(); ?>
        <!--        <div class="row row-block-right">-->
        <!--            --><?// print_important_dates() ?>
        <!--        </div>-->
        <!--        <div class="row row-block-right">-->
        <!--            --><?// print_time_table_mobile() ?>
        <!--        </div>-->
    </div>



<div class="col-12 col-m-12 ">
    <div id="curve_chart" style="width: 90%; height: 400px; margin: 30px auto"></div>

</div>

    <div class="col-low-res">
        <? print_mobile_bottom() ?>
    </div>




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

<script src="js/index_x.js"></script>
</body>
</html>