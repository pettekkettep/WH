<?php

include('functions_x.php');

function print_oceny_of_id($id){
    $sql = "SELECT imie, nazwisko, dom, klasa FROM zapisy_u WHERE id=$id";
    $outcome = db_statement($sql);
    if($outcome == false){
        echo "<h1>Coś nie pykło</h1>";
        return;
    }
    $ocena = mysqli_fetch_assoc($outcome);
    $imie = $ocena['imie'];
    $nazwisko = $ocena['nazwisko'];
    $klasa = $ocena['klasa'];
    switch($ocena['dom']) {
        case '#ff0000':
            $dom = 'gryff';
            break;
        case '#ffcc00':
            $dom = 'huff';
            break;
        case '0066ff':
            $dom = 'rav';
            break;
        case '00cc00':
            $dom = 'slyth';
            break;
    }

    echo "<h1 class='dom'>Oceny $imie $nazwisko</h1>";
    echo "<table class='generic-table-no-borders'><tr><th>Ocena</th><th>Przedmiot</th><th>Za co?</th><th>Kiedy?</th></tr>";

    $sql = "SELECT * FROM oceny WHERE uczen_id=$id";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $przedmiot = $row['przedmiot'];
        $ocena = $row['ocena'];
        $iddz = $row['dziennik_id'];
        switch($row['rodzaj']) {
            case '#ff66ff':
                $rodzaj = 'odpowiedź';
                break;
            case '#ff6600':
                $rodzaj = 'kartkówkę';
                break;
            case 'red':
                $rodzaj = 'egzamin';
                break;
            case '#9900CC':
                $rodzaj = 'sprawdzian';
                break;
            case '#33cc00':
                $rodzaj = 'zadanie domowe';
                break;
            case 'yellow':
                $rodzaj = 'zadanie dodatkowe';
                break;
            case '#0099ff':
                $rodzaj = 'aktywność';
                break;
            case '999999':
                $rodzaj = 'praktykę';
                break;
        }
        echo "<tr class='img-logo'><td>$ocena</td><td>$przedmiot</td><td>za $rodzaj</td>";
        echo "<td class='no-wrap-fit only-big'>";
        if($iddz != 0) echo "<a href='dzienniki_x.php?id=$iddz'><div class='button-fitted'>POKAŻ</div></a>";
        echo "</td>";
        echo "<td class='no-wrap-fit only-small'>";
        if($iddz != 0) echo "<a href='dzienniki_x.php?id=$iddz'><div class='button-fitted'>></div></a>";
        echo "</td>";
        echo "</tr>";

    }

    echo "</table>";
}

function print_oceny_of_dom($dom){
    switch($dom){
        case "gryff":
            $kolor = "#ff0000";
            break;
        case "huff":
            $kolor = "#ffcc00";
            break;
        case "rav":
            $kolor = "0066ff";
            break;
        case "slyth":
            $kolor = "00cc00";
            break;
    }
    echo "<table class='generic-table-no-borders'><tr><th>Kto</th><th>Ocena</th><th>Przedmiot</th><th>Za co?</th><th>Klasa</th><th>Kiedy przyznano?</th></tr>";
    $sql = "SELECT id, imie, nazwisko, klasa FROM zapisy_u WHERE dom='$kolor'";
    $outcome = db_statement($sql);
    while($uczen = mysqli_fetch_assoc($outcome)) {
        $id = $uczen['id'];
        $imie = $uczen['imie'];
        $nazwisko = $uczen['nazwisko'];
        $klasa = $uczen['klasa'];
        switch ($uczen['dom']) {
            case '#ff0000':
                $dom = 'gryff';
                break;
            case '#ffcc00':
                $dom = 'huff';
                break;
            case '0066ff':
                $dom = 'rav';
                break;
            case '00cc00':
                $dom = 'slyth';
                break;
        }

        $sql = "SELECT * FROM oceny WHERE uczen_id=$id";
        $result = db_statement($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $przedmiot = $row['przedmiot'];
                $ocena = $row['ocena'];
                $iddz = $row['dziennik_id'];
                switch ($row['rodzaj']) {
                    case '#ff66ff':
                        $rodzaj = 'odpowiedź';
                        break;
                    case '#ff6600':
                        $rodzaj = 'kartkówkę';
                        break;
                    case 'red':
                        $rodzaj = 'egzamin';
                        break;
                    case '#9900CC':
                        $rodzaj = 'sprawdzian';
                        break;
                    case '#33cc00':
                        $rodzaj = 'zadanie domowe';
                        break;
                    case 'yellow':
                        $rodzaj = 'zadanie dodatkowe';
                        break;
                    case '#0099ff':
                        $rodzaj = 'aktywność';
                        break;
                    case '999999':
                        $rodzaj = 'praktykę';
                        break;
                }
                echo "<tr class='$dom img-logo'><td>$imie $nazwisko</td><td>$ocena</td><td>$przedmiot</td><td>za $rodzaj</td><td>$klasa</td><td class='no-wrap-fit'><a href='dzienniki_x.php?id=$iddz'>[POKAŻ DZIENNIK]</td></tr>";

            }
        }
    }

    echo "</table>";
}

function print_oceny_of_przedmiot($przedmiot)
{


    $sql = "SELECT * FROM oceny WHERE przedmiot='$przedmiot'";
    $result = db_statement($sql);
    if($result == false){
        echo "<h1>Coś nie pykło</h1>";
        return;
    }
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='generic-table-no-borders top-buffer-margin'><tr><th>Kto</th><th>Ocena</th><th>Za co?</th><th>Klasa</th><th>Kiedy?</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['uczen_id'];
            $ocena = $row['ocena'];
            $iddz = $row['dziennik_id'];
            switch ($row['rodzaj']) {
                case '#ff66ff':
                    $rodzaj = 'odpowiedź';
                    break;
                case '#ff6600':
                    $rodzaj = 'kartkówkę';
                    break;
                case 'red':
                    $rodzaj = 'egzamin';
                    break;
                case '#9900CC':
                    $rodzaj = 'sprawdzian';
                    break;
                case '#33cc00':
                    $rodzaj = 'zadanie domowe';
                    break;
                case 'yellow':
                    $rodzaj = 'zadanie dodatkowe';
                    break;
                case '#0099ff':
                    $rodzaj = 'aktywność';
                    break;
                case '999999':
                    $rodzaj = 'praktykę';
                    break;
            }
            $sql = "SELECT imie, nazwisko, klasa, dom FROM zapisy_u WHERE id=$id";
            $outcome = db_statement($sql);
            if (mysqli_num_rows($outcome) > 0) {
                $uczen = mysqli_fetch_assoc($outcome);
                $imie = $uczen['imie'];
                $nazwisko = $uczen['nazwisko'];
                $klasa = $uczen['klasa'];
                switch ($uczen['dom']) {
                    case '#ff0000':
                        $dom = 'gryff';
                        break;
                    case '#ffcc00':
                        $dom = 'huff';
                        break;
                    case '0066ff':
                        $dom = 'rav';
                        break;
                    case '00cc00':
                        $dom = 'slyth';
                        break;
                }
                echo "<tr class='$dom img-logo'><td>$imie $nazwisko</td><td>$ocena</td><td>za $rodzaj</td><td>$klasa</td>";
                echo "<td class='only-big'><a href='dzienniki_x.php?id=$iddz'><div class='button-fitted'>POKAŻ</div></td>";
                echo "<td class='only-small'><a href='dzienniki_x.php?id=$iddz'><div class='button-fitted'>></div></td>";
                echo "</tr>";
            }
        } echo "</table>";
        }else {
        echo "<h1>Brak ocen z tego przedmiotu w bazie</h1>";
    }

}

function print_oceny_link_table(){
    echo "<h1>Strefa ocen</h1><h2>Przecież dałam Ci ocenę pozytywną, na więcej nie zasługujesz. Odejdź ode mnie. ~D.Cathville 2010</h2>";
    echo "<div class='row grades-div'>";
    echo "<h2>Szukaj ocen z przedmiotów</h2>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Astronomia'><img src='http://wh.boo.pl/przedmioty/astronomia.png'><br>Astronomia</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Czarna+Magia'><img src='http://wh.boo.pl/przedmioty/cm.png'><br>Czarna Magia</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Eliksiry'><img src='http://wh.boo.pl/przedmioty/eliksiry.png'><br>Eliksiry</a>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Historia+Magii'><img src='http://wh.boo.pl/przedmioty/hm.png'><br>Historia Magii</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Językoznawstwo'><img src='http://wh.boo.pl/przedmioty/jezykoznawstwo.png'><br>Językoznawstwo</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Klub+Pojedynków'><img src='http://wh.boo.pl/przedmioty/kp.png'><br>Klub Pojedynków</a>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Latanie'><img src='http://wh.boo.pl/przedmioty/latanie.png'><br>Latanie</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Latanie+dla+Zaawansowanych'><img src='http://wh.boo.pl/przedmioty/latanie.png'><br>Latanie dla Zaawansowanych</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Numerologia'><img src='http://wh.boo.pl/przedmioty/numerologia.png'><br>Numerologia</a>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Obrona+przed+Czarną+Magią'><img src='http://wh.boo.pl/przedmioty/opcm.png'><br>Obrona przed Czarną Magią</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Opieka+nad+Magicznymi+Stworzeniami'><img src='http://wh.boo.pl/przedmioty/onms.png'><br>OnMS</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Starożytne+Runy'><img src='http://wh.boo.pl/przedmioty/runy.png'><br>Starożytne Runy</a>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Transmutacja'><img src='http://wh.boo.pl/przedmioty/transmutacja.png'><br>Transmutacja</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Wiedza+o+Harrym+Potterze'><img src='http://wh.boo.pl/przedmioty/wohp.png'><br>Wiedza o Harrym Potterze</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Wiedza+o+Magicznych+Miejscach+i+Rytuałach'><img src='http://wh.boo.pl/przedmioty/wommir.png'><br>WoMMiR</a>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Wróżbiarstwo'><img src='http://wh.boo.pl/przedmioty/wrozbiarstwo.png'><br>Wróżbiarstwo</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Zaklęcia+i+Uroki'><img src='http://wh.boo.pl/przedmioty/zaklecia.png'><br>Zaklęcia i Uroki</a>";
    echo "</div>";
    echo "<div class='col-4'>";
    echo "<a href='oceny_x.php?przedmiot=Zielarstwo'><img src='http://wh.boo.pl/przedmioty/zielarstwo.png'><br>Zielarstwo</a>";
    echo "</div></div></div>";

    $sql = "SELECT uczen_id, COUNT(*) as freq FROM oceny GROUP BY uczen_id ORDER BY COUNT(*) DESC LIMIT 10";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==0) {
        echo "<h1>Brak ocen w bazie</h1>";
        return;
    }

    echo "</div><div class='row grades-div'><h2>Oceny poszczególnych uczniów</h2>";
    echo "<h3>10 uczniów o największej liczbie ocen</h3>";
    echo "<table class='generic-table-no-borders'><tr><th>Imię i nazwisko</th><th>Klasa</th><th>Ilość ocen</th><th></th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['uczen_id'];
        $freq = $row['freq'];
        $sql = "SELECT imie, nazwisko, dom, klasa FROM zapisy_u WHERE id=$id";
        $outcome = db_statement($sql);
        if(mysqli_num_rows($outcome)==1){
            $ocena = mysqli_fetch_assoc($outcome);
            $imie = $ocena['imie'];
            $nazwisko = $ocena['nazwisko'];
            $klasa = $ocena['klasa'];
            switch($ocena['dom']) {
                case '#ff0000':
                    $dom = 'gryff';
                    break;
                case '#ffcc00':
                    $dom = 'huff';
                    break;
                case '0066ff':
                    $dom = 'rav';
                    break;
                case '00cc00':
                    $dom = 'slyth';
                    break;
            }
            echo "<tr class='$dom img-logo'><td>$imie $nazwisko</td><td>$klasa</td><td>$freq</td><td class='no-wrap-fit'><a href='oceny_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a></td></tr>";
        }
    }

    echo "</table>";
}

?>