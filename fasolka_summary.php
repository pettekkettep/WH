<?php

session_start();

require_once('./fasolkifunctions_x.php');

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>FASOLKI | dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<div class="row row-style" style="padding: 15px; display: table">
    <table class="basic-table center-align" style="margin: 15px;">
        <tr>
            <th>Numery fasolek >>> </th>
            <?php
            for ($i = 1; $i <= 106; $i++) {
                $sql = "SELECT smak FROM beans WHERE id = $i";
                $result = db_statement($sql);
                $row = mysqli_fetch_assoc($result);
                $smak = "o smaku ".$row['smak'];
                echo "<th style='font-size: 70%; width: 4px;' class='hasTooltip'>$i<span>$smak</span></th>";
            }
            ?>
        </tr>
        <tr>
            <th style="white-space: nowrap">Ile osób ma tę fasolkę</th>
            <?php
            for ($i = 1; $i <= 106; $i++) {
                $sql = "SELECT DISTINCT skrytka FROM beans_owners WHERE fasolka = $i";
                $result = db_statement($sql);
                $ile = mysqli_num_rows($result);
                if($ile == 0) echo "<th style='font-size: 90%;color: yellow'>$ile</th>";
                else echo "<th style='font-size: 80%'>$ile</th>";
            }
            ?>
        </tr>

            <?php
            $sql = "SELECT DISTINCT skrytka FROM beans_owners ORDER BY skrytka";
            $result = db_statement($sql);
            while($row = mysqli_fetch_assoc($result)){
                $skrytka = $row['skrytka'];
                $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $skrytka";
                $outcome = db_statement($sql);
                $wynik = mysqli_fetch_assoc($outcome);
                $wlasciciel = $wynik['wlasciciel'];
                echo "<tr><td style='white-space: nowrap'>$wlasciciel</td>";
                $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $skrytka ORDER BY fasolka";
                $outcome = db_statement($sql);
                $fasolki = array();
                while($wynik = mysqli_fetch_assoc($outcome)){
                    array_push($fasolki, $wynik['fasolka']);
                }
                for ($i = 1; $i <= 106; $i++) {
                    echo "<td";
                    if(in_array($i, $fasolki)) echo " style='background-color: green'";
                    else echo " style='background-color: grey'";
                    echo ">&nbsp;</td>";
                }
                echo "</tr>";
            }


            ?>

    </table>
</div>
</body>
</html>