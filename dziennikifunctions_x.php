<?php

include('logfunctions_x.php');

function last_insert_dzienniki($prof){
    include('db_config.php');

    $dbConnection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    $sql = "SELECT max(id) as max FROM dzienniki WHERE prof='$prof'";
    $result = mysqli_query($dbConnection, $sql);
    if(mysqli_num_rows($result)!=1) die("Błąd");
    else{
        $row = mysqli_fetch_assoc($result);
        return $row['max'];
    }

}

function print_dzienniki_begin(){
    echo "<div class='dzienniki-form form-sleek row'>";
    echo "<form action='/dodaj_dziennik.php' method='post'>
        <h2>Zrób to raz - a dobrze!</h2>
        <h3>Samego wpisu nie można edytować, ale można zedytować oceny, punkty, czy samą treść wpisu. MIMO WSZYSTKO, nie pomyl się.</h3>
        Nauczyciel <input type='text' name='nauczyciel' value='" . $_SESSION['username'] ."' required readonly>
        Przedmiot <select name='przedmiot' required>
        <option value='' disabled selected>(Wybierz)</option>";
            
                $sql = "SELECT * FROM przedmioty";
                $result = db_statement($sql);
                while($row = mysqli_fetch_assoc($result)){
                    echo "<option value='". $row['przedmiot'] ."'> ". $row['przedmiot'] ." </option>";
                }
            
        echo "</select>
        Klasa <select name='klasa' required>
            <option value='' disabled selected>(Wybierz)</option>
            <option value='1'>I</option>
            <option value='2'>II</option>
            <option value='3'>III</option>
            <option value='0'>wszystkie</option>
        </select>
        Data lekcji<input type='date' name='data' required>
        Godzina lekcji <input type='time' name='godzina' required>
        
        <input type='submit' value='Idź do: Obecność'>
        </form></div>";
}

function create_dziennik(){

    $day = $_POST['data'];
    $time = $_POST['godzina'];
    $datetime = date('Y-m-d H:i:s', strtotime("$day $time"));
    $przedmiot = $_POST['przedmiot'];
    $klasa = $_POST['klasa'];
    $prof = $_POST['nauczyciel'];
    $stan = "not";

    $sql = "INSERT INTO dzienniki (przedmiot, klasa, prof, datetime, stan) VALUES(?,?,?,?,?)";
    db_statement($sql, "sssss", array(&$przedmiot, &$klasa, &$prof, &$datetime, &$stan));
    
}

function print_wybierz_uczniow($id){

    $sql = "SELECT klasa FROM dzienniki WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $klasa = $row['klasa'];
    if($klasa==0) $_SESSION['martin']="yas";


    echo "<div class='dzienniki-form form-sleek row'><form action='/dodaj_dziennik.php' method='post'>
        <h2>Wybierz uczniów, którzy pojawili się na lekcji</h2>";
        if($klasa == 0){
            $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND dom='#ff0000' ORDER BY nazwisko";
        }
        else $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND klasa = $klasa AND dom='#ff0000' ORDER BY nazwisko";
        $result = db_statement($sql);
        echo "<div class='col-3 gryff'>";
        echo "<h3>Gryffindor</h3><br>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $imienazwisko = $row['imie']. " " .$row['nazwisko'];
            $desc = "Mail: ".$row['mail'].", nick: ".$row['nick'];
            echo "<label><input type='checkbox' name='uczniowie[]' value='$id'><span title='$desc'>$imienazwisko</span><br></label>";
        }
        echo "</div>";
        if($klasa == 0) $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND dom='#ffcc00' ORDER BY nazwisko";
        else $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND klasa = $klasa AND dom='#ffcc00' ORDER BY nazwisko";
        $result = db_statement($sql);
        echo "<div class='col-3 huff'>";
        echo "<h3>Hufflepuff</h3><br>";
        while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
                $imienazwisko = $row['imie']. " " .$row['nazwisko'];
                $desc = "Mail: ".$row['mail'].", nick: ".$row['nick'];
                echo "<label><input type='checkbox' name='uczniowie[]' value='$id'><span title='$desc'>$imienazwisko</span><br></label>";
            }
        echo "</div>";

        if($klasa == 0) $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND dom='0066ff' ORDER BY nazwisko";
        else $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND klasa = $klasa AND dom='0066ff' ORDER BY nazwisko";
        $result = db_statement($sql);
        echo "<div class='col-3 rav'>";
        echo "<h3>Ravenclaw</h3><br>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $imienazwisko = $row['imie']. " " .$row['nazwisko'];
            $desc = "Mail: ".$row['mail'].", nick: ".$row['nick'];
            echo "<label><input type='checkbox' name='uczniowie[]' value='$id'><span title='$desc'>$imienazwisko</span><br></label>";
        }
        echo "</div>";

        if($klasa == 0)$sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND dom='00cc00' ORDER BY nazwisko";
        else $sql = "SELECT id, imie, nazwisko, mail, nick FROM zapisy_u WHERE acc = 1 AND klasa = $klasa AND dom='00cc00' ORDER BY nazwisko";
        $result = db_statement($sql);
        echo "<div class='col-3 slyth'>";
        echo "<h3>Slytherin</h3><br>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $imienazwisko = $row['imie']. " " .$row['nazwisko'];
            $desc = "Mail: ".$row['mail'].", nick: ".$row['nick'];
            echo "<label><input type='checkbox' name='uczniowie[]' value='$id'><span title='$desc'>$imienazwisko</span><br></label>";
        }
        echo "</div>";
        echo "<div class='row col-12'><br><h3>Chcę dodać punkty za:</h3><br>";
        echo "<label><input type='checkbox' name='punkty[]' value='spr'>Sprawdzian<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='egz'>Egzamin<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='kart'>Kartkówkę<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='odp'>Odpowiedź<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='prakt'>Praktykę<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='akt'>Aktywność<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='lista'>Listę<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='zaddom'>Zadanie domowe<br></label>";
        echo "<label><input type='checkbox' name='punkty[]' value='zaddod'>Zadanie dodatkowe<br></label>";


        echo "<br><h3>Chcę dodać oceny za:</h3><br>";
        echo "<label><input type='checkbox' name='oceny[]' value='spr'>Sprawdzian<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='egz'>Egzamin<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='kart'>Kartkówkę<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='odp'>Odpowiedź<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='prakt'>Praktykę<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='akt'>Aktywność<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='zaddom'>Zadanie domowe<br></label>";
        echo "<label><input type='checkbox' name='oceny[]' value='zaddod'>Zadanie dodatkowe<br></label>";
        echo"</div>";

        echo "<div class='row col-12'><br><h3>Więcej uczniów nie pamiętam, za wszystkich serdecznie żałuję</h3><br>";
        echo "<input type='hidden' name='lista' value='YAAAAAAAAAS'>";
        echo "<input type='submit' value='Idź do: Punkty i oceny'>
        </div></form></div>";

}

function print_wpisz_oceny_punkty($lista, $punkty, $oceny){

    echo "<div class='dzienniki-form form-sleek row'>";
    echo "<form action='dodaj_dziennik.php' method='post'>";

    echo "<h1>Punkty</h1>";
    echo "<div class='row img-logo'>";
    echo "<table class=set-width'>";
    echo "<tr><th>Imię i nazwisko</th>";
    echo "<th>Obecność</th>";
    if(!empty($punkty)) {
        if (in_array("spr", $punkty)) echo "<th>Sprawdzian</th>";
        if (in_array("egz", $punkty)) echo "<th>Egzamin</th>";
        if (in_array("kart", $punkty)) echo "<th>Kartkówka</th>";
        if (in_array("odp", $punkty)) echo "<th>Odpowiedź</th>";
        if (in_array("prakt", $punkty)) echo "<th>Praktyka</th>";
        if (in_array("akt", $punkty)) echo "<th>Aktywność</th>";
        if (in_array("lista", $punkty)) echo "<th>Lista</th>";
        if (in_array("zaddom", $punkty)) echo "<th>Zad. domowe</th>";
        if (in_array("zaddod", $punkty)) echo "<th>Z. dodatkowe</th>";
        echo "</tr>";
    }

    foreach($lista as $uczen) {
        $sql = "SELECT imie, nazwisko FROM zapisy_u WHERE id=$uczen";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];

        echo "<tr>";
        echo "<td>$imie $nazwisko</td>";
        echo "<td><input type='text' name='$uczen" . "[ob]" . "'></td>";
        if (!empty($punkty)) {
            if (in_array("spr", $punkty)) echo "<td><input type='text' name='$uczen" . "[spr]" . "'></td>";
            if (in_array("egz", $punkty)) echo "<td><input type='text' name='$uczen" . "[egz]" . "'></td>";
            if (in_array("kart", $punkty)) echo "<td><input type='text' name='$uczen" . "[kart]" . "'></td>";
            if (in_array("odp", $punkty)) echo "<td><input type='text' name='$uczen" . "[odp]" . "'></td>";
            if (in_array("prakt", $punkty)) echo "<td><input type='text' name='$uczen" . "[prakt]" . "'></td>";
            if (in_array("akt", $punkty)) echo "<td><input type='text' name='$uczen" . "[akt]" . "'></td>";
            if (in_array("lista", $punkty)) echo "<td><input type='text' name='$uczen" . "[lista]" . "'></td>";
            if (in_array("zaddom", $punkty)) echo "<td><input type='text' name='$uczen" . "[zaddom]" . "'></td>";
            if (in_array("zaddod", $punkty)) echo "<td><input type='text' name='$uczen" . "[zaddod]" . "'></td>";

            echo "</tr>";
        }
    }

    echo "</table>";
    echo "</div><br><br>";
    echo "<h1>Oceny</h1>";
    echo "<div class='row img-logo'>";
    echo "<table class='set-width'>";

    if(!empty($oceny)) {
        echo "<tr><th>Imię i nazwisko</th>";
        if (in_array("spr", $oceny)) echo "<th>Sprawdzian</th>";
        if (in_array("egz", $oceny)) echo "<th>Egzamin</th>";
        if (in_array("kart", $oceny)) echo "<th>Kartkówka</th>";
        if (in_array("odp", $oceny)) echo "<th>Odpowiedź</th>";
        if (in_array("prakt", $oceny)) echo "<th>Praktyka</th>";
        if (in_array("akt", $oceny)) echo "<th>Aktywność</th>";
        if (in_array("zaddom", $oceny)) echo "<th>Zad. domowe</th>";
        if (in_array("zaddod", $oceny)) echo "<th>Z. dodatkowe</th>";
        echo "</tr>";
    } else {
        echo "<h2>Brak ocen do dodania! Zazdro</h2>";
    }
    if(!empty($oceny)) {
        foreach($lista as $uczen){
            echo "<tr>";
            $sql = "SELECT imie, nazwisko FROM zapisy_u WHERE id=$uczen";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $imie = $row['imie'];
            $nazwisko = $row['nazwisko'];

            echo "<tr>";
            echo "<td>$imie $nazwisko</td>";
            if (in_array("spr", $oceny)) echo "<td><select name='$uczen" . "[ospr]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("egz", $oceny)) echo "<td><select name='$uczen" . "[oegz]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("kart", $oceny)) echo "<td><select name='$uczen" . "[okart]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("odp", $oceny)) echo "<td><select name='$uczen" . "[oodp]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("prakt", $oceny)) echo "<td><select name='$uczen" . "[oprakt]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("akt", $oceny)) echo "<td><select name='$uczen" . "[oakt]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("zaddom", $oceny)) echo "<td><select name='$uczen" . "[ozaddom]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            if (in_array("zaddod", $oceny)) echo "<td><select name='$uczen" . "[ozaddod]" . "'>
            <option value='' selected> </option>
                <option value='W'>W</option>
                <option value='P+'>P+</option>
                <option value='P'>P</option>
                <option value='P-'>P-</option>
                <option value='Z+'>Z+</option>
                <option value='Z'>Z</option>
                <option value='Z-'>Z-</option>
                <option value='N+'>N+</option>
                <option value='N'>N</option>
                <option value='N-'>N-</option>
                <option value='O+'>O+</option>
                <option value='O'>O</option>
                <option value='O-'>O-</option>
                <option value='T+'>T+</option>
                <option value='T'>T</option></select></td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "</div>";
    echo "<div class='row img-logo'>";
    echo "<input type='hidden' name='oceny' value='YAAAAAAAAAS'>";
    echo "<input type='submit' value='Idź do: Szczegóły lekcji'>";
    echo "</div>";
    echo "</form></div>";

}
//gsrh
function dodaj_punkty($punkty, $id, $iddz, $data, $za, $przedmiot, $profesor){
    $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $imie = $row['imie'];
    $nazwisko = $row['nazwisko'];
    $dom = $row['dom'];
    $uzasadnienie = "Przedmiot: $przedmiot, Profesor: $profesor, Data: $data, Za: $za Dla: $imie $nazwisko";
    $punkty = intval($punkty);
    $zmiana = "Dodał";


    switch($dom){
        case "#ff0000":
            $dom = 1;
            break;
        case "00cc00":
            $dom = 2;
            break;
        case "0066ff":
            $dom = 3;
            break;
        case "#ffcc00":
            $dom = 4;
            break;
    }

    $sql = "INSERT INTO punkty_opis(id_dom, uczen_id, dziennik_id, kto, ile, zmiana, uzasadnienie) VALUES(?,?,?,?,?,?,?)";
    $result = db_statement($sql, "iiisiss", array(&$dom, &$id, &$iddz, &$profesor, &$punkty, &$zmiana, &$uzasadnienie));
}

function dodaj_ocene($ocena, $id, $iddz, $przedmiot, $rodzaj, $profesor){
    $sql = "SELECT imie, nazwisko, dom, klasa FROM zapisy_u WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $imie = $row['imie'];
    $nazwisko = $row['nazwisko'];
    $kolor = $row['dom'];
    $klasa = $row['klasa'];
    $dom = "";
    $stan = 'not';
    if($kolor == "00cc00") $kolor = "#00cc00";
    if($kolor == "0066ff") $kolor = "#0066ff";
    switch($kolor){
        case "#ff0000":
            $dom = "Gryffindor";
            break;
        case "#ffcc00":
            $dom = "Hufflepuff";
            break;
        case "#0066ff":
            $dom = "Ravenclaw";
            break;
        case "#00cc00":
            $dom = "Slytherin";
            break;
    }

    $sql = "INSERT INTO oceny(stan, imie, nazwisko, uczen_id, dziennik_id, dom, kolor, klasa, ocena, przedmiot, rodzaj) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    $result = db_statement($sql, "sssiississs", array(&$stan, &$imie, &$nazwisko, &$id, &$iddz, &$dom, &$kolor, &$klasa, &$ocena, &$przedmiot, &$rodzaj));


}

function print_dzienniki_details(){
    echo "<div class='dzienniki-form form-sleek row'>";
    echo "<form action='/dodaj_dziennik.php' method='post'>
        <h2>Ostatni krok!</h2>
        Numer lekcji wg programu nauczania <input type='text' name='numer' required >
        Temat <input type='text' name='temat' required >
        <p>Opis lekcji</p>
        <textarea rows='12' name='opis' class='ckeditor' ></textarea>
        <p>Praca domowa</p>
        <textarea rows='5' name='domowa' class='ckeditor' ></textarea>
        <p>Termin pracy domowej</p> <input type='date' name='pracatermin'>
        <input type='hidden' name='details' value='YAAAAAAAAAS' required >
        <input type='submit' value='Dokończ!'>
        </form></div>";
}

function add_dziennik_details($iddz, $numer, $temat, $opis, $domowa, $pracatermin){
    $obecnosc = create_obecnosc($iddz);
    add_event("dodał(a) dziennik nr $iddz", "add_dz");
    $sql = "UPDATE dzienniki SET temat = ?, nr = ?, notatka = ?, praca = ?, obecnosc = ?, pracatermin = ? WHERE id=?";
    db_statement($sql, "ssssssi", array(&$temat, &$numer, &$opis, &$domowa, &$obecnosc, &$pracatermin, &$iddz));
}

function print_waiting_dziennik_list(){
    echo "<table class='generic-table dimmed-center-table'><tr><th>Nauczyciel</th><th>Przedmiot</th><th>Klasa</th><th>Data i godzina lekcji</th><th>Czy terminowo?</th><th>Punktacja</th><th>Akcje</th></tr>";
    $sql = "SELECT * FROM dzienniki WHERE stan = 'not' ORDER BY created";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $spoznienie = calc_delay($row['datetime'], $row['created']);
        echo "<tr>";
        echo "<td>".$row['prof']."</td>";
        echo "<td>".$row['przedmiot']."</td>";
        echo "<td>".$row['klasa']."</td>";
        echo "<td>".$row['datetime']."</td>";
        echo "<td>".$spoznienie."</td>";
        echo "<td>".$row['obecnosc']."</td>";
        echo "<td><a class='subtle' href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a>&nbsp;<a class='subtle' href='panel_manage_dziennik.php?akcja=accept&id=$id'><div class='button-fitted'>AKCEPTUJ</div></a>&nbsp;<a class='subtle' href='edytuj_dziennik.php?id=$id'><div class='button-fitted'>EDYTUJ</div></a>&nbsp;<a class='subtle' href='panel_manage_dziennik.php?akcja=delete&id=$id'><div class='button-fitted'>USUŃ</div></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function print_dziennik_list(){
    echo "<table class='generic-table dimmed-center-table'><tr><th>Nauczyciel</th><th>Przedmiot</th><th>Klasa</th><th>Data i godzina lekcji</th><th>Czy terminowo?</th><th>Punktacja</th><th>Akcje</th></tr>";
    $sql = "SELECT * FROM dzienniki WHERE stan = 'yes' ORDER BY created";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $spoznienie = calc_delay($row['datetime'], $row['created']);
        echo "<tr>";
        echo "<td>".$row['prof']."</td>";
        echo "<td>".$row['przedmiot']."</td>";
        echo "<td>".$row['klasa']."</td>";
        echo "<td>".$row['datetime']."</td>";
        echo "<td>".$spoznienie."</td>";
        echo "<td>".$row['obecnosc']."</td>";
        echo "<td><a class='subtle' href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a><a class='subtle' href='edytuj_dziennik.php?id=$id'><div class='button-fitted'>EDYTUJ</div></a><a class='subtle' href='panel_manage_dziennik.php?akcja=delete&id=$id'><div class='button-fitted'>USUŃ</div></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function print_my_dziennik($user){
    echo "<table class='generic-table dimmed-center-table'><tr><th>Nauczyciel</th><th>Przedmiot</th><th>Klasa</th><th>Data i godzina lekcji</th><th>Punktacja</th><th>Akcje</th></tr>";
    $sql = "SELECT * FROM dzienniki WHERE prof = '$user' ORDER BY created";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        echo "<tr>";
        echo "<td>".$row['prof']."</td>";
        echo "<td>".$row['przedmiot']."</td>";
        echo "<td>".$row['klasa']."</td>";
        echo "<td>".$row['datetime']."</td>";
        echo "<td>".$row['obecnosc']."</td>";
        echo "<td class='no-wrap-fit'><a class='subtle' href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a> <a class='subtle' href='edytuj_dziennik.php?id=$id'><div class='button-fitted'>EDYTUJ</div></a>";
        echo "</tr>";
    }
    echo "</table>";
}

function create_obecnosc($id){
    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 1 AND zmiana = 'Dodał' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['ile'];
    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 1 AND zmiana = 'Odjął' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['ile'];
    $gryff = $plus - $minus;

    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 2 AND zmiana = 'Dodał' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['ile'];
    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 2 AND zmiana = 'Odjął' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['ile'];
    $slyth = $plus - $minus;

    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 3 AND zmiana = 'Dodał' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['ile'];
    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 3 AND zmiana = 'Odjął' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['ile'];
    $rav = $plus - $minus;

    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 4 AND zmiana = 'Dodał' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['ile'];
    $sql = "SELECT sum(ile) as ile FROM punkty_opis WHERE id_dom = 4 AND zmiana = 'Odjął' AND dziennik_id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['ile'];
    $huff = $plus - $minus;

    $text1 = "<p class='gryff'>Gryffindor $gryff</p>";
    $text2 = "<p class='huff'>Hufflepuff $huff</p>";
    $text3 = "<p class='rav'>Ravenclaw $rav</p>";
    $text4 = "<p class='slyth'>Slytherin $slyth</p>";

    return $text1 . $text2 . $text3 . $text4;

}

function print_dziennik_of_id($id){
    //Print dziennik details
    $sql = "SELECT * FROM dzienniki WHERE id = $id";
    $result = db_statement($sql);
    if($result == false) {
        die("<h1>Ups. Jakiś błąd</h1>");
    }
    if(mysqli_num_rows($result)!=1) die("Błąd. Nie ma takiego dziennika.");
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $nr = $row['nr'];
    $prof = $row['prof'];
    $przedmiot = $row['przedmiot'];
    $klasa = $row['klasa'];
    $notatka = $row['notatka'];
    $praca = $row['praca'];
    $obecnosc = $row['obecnosc'];
    $timestamp = $row['datetime'];
    $data = date("d/m/Y", strtotime($timestamp));
    $godz = date("H:i", strtotime($timestamp));

    echo "<h1>Dziennik</h1>";
    echo "<table class='generic-table dimmed-table' style='width: 100%'>";
    echo "<tr><td style='width: 40%'>Numer identyfikacyjny dziennika</td><td>$id</td>";
    echo "<tr><td>Nauczyciel</td><td>$prof</td>";
    echo "<tr><td>Przedmiot</td><td>$przedmiot</td>";
    echo "<tr><td>Numer lekcji (wg programu)</td><td>$nr</td>";
    echo "<tr><td>Klasa</td><td>$klasa</td>";
    echo "<tr><td>Dzień i godzina lekcji</td><td>$data, godz: $godz</td>";
    echo "<tr><td>Notatka z lekcji</td><td>$notatka</td>";
    echo "<tr><td>Praca domowa</td><td>$praca</td>";
    echo "<tr><td>Punkty przyznane domom</td><td>$obecnosc</td>";
    echo "<tr><td>Punkty przyznane uczniom</td><td>";
    print_punkty_of_dziennik_id($id);
    echo "</td>";
    echo "<tr><td>Oceny przyznane uczniom</td><td>";
    print_oceny_of_dziennik_id($id);
    echo "</td></table>";

}

function print_punkty_of_dziennik_id($id){
    $sql = "SELECT DISTINCT uczen_id FROM punkty_opis WHERE dziennik_id=$id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) < 1) {
        echo "<p>Nie przyznano żadnych punktów.</p>";
        return;
    }
    else {
        while($row = mysqli_fetch_assoc($result)) {
            $uczen_id = $row['uczen_id'];
            $sql = "SELECT sum(ile) as sum FROM punkty_opis WHERE dziennik_id=$id AND uczen_id=$uczen_id AND zmiana='Dodał'";
            $outcome = db_statement($sql);
            $outcome = mysqli_fetch_assoc($outcome);
            $plus = $outcome['sum'];
            if($plus == NULL) $plus = 0;
            $sql = "SELECT sum(ile) as sum FROM punkty_opis WHERE dziennik_id=$id AND uczen_id=$uczen_id AND zmiana='Odjął'";
            $outcome = db_statement($sql);
            $outcome = mysqli_fetch_assoc($outcome);
            $minus = $outcome['sum'];
            if($minus == NULL) $minus = 0;
            $wynik = $plus - $minus;
            $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id=$uczen_id";
            $outcome = db_statement($sql);
            $outcome = mysqli_fetch_assoc($outcome);
            $imie = $outcome['imie'];
            $nazwisko = $outcome['nazwisko'];
            switch($outcome['dom']) {
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
            echo "<p class='$dom narrow-dziennik'>$imie $nazwisko $wynik pkt</p>";
        }

    }
}

function print_oceny_of_dziennik_id($id){
    $sql = "SELECT DISTINCT uczen_id FROM punkty_opis WHERE dziennik_id=$id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) < 1) {
        echo "<p>Nie przyznano żadnych ocen.</p>";
        return;
    }
    else {
        while($row = mysqli_fetch_assoc($result)) {
            $uczen_id = $row['uczen_id'];
            $sql = "SELECT * FROM oceny WHERE uczen_id=$uczen_id AND dziennik_id=$id";
            $outcome = db_statement($sql);
            while ($ocena = mysqli_fetch_assoc($outcome)){
                switch($ocena['kolor']) {
                    case '#ff0000':
                        $dom = 'gryff';
                        break;
                    case '#ffcc00':
                        $dom = 'huff';
                        break;
                    case '#0066ff':
                        $dom = 'rav';
                        break;
                    case '#00cc00':
                        $dom = 'slyth';
                        break;
                }

                switch($ocena['rodzaj']) {
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
                $imie = $ocena['imie'];
                $nazwisko = $ocena['nazwisko'];
                $nota = $ocena['ocena'];
                echo "<p class='$dom narrow-dziennik'>$imie $nazwisko - ocena: $nota za $rodzaj</p>";
            }
        }

    }
}

function print_dzienniki_of_klasa($klasa){

    if($klasa == 'all'){
        $sql = "SELECT * FROM dzienniki ORDER BY datetime DESC";
        $result = db_statement($sql);
        if($result == false) {
            die("<h1>Ups. Jakiś błąd</h1>");
        }

        if(mysqli_num_rows($result)==0) echo "<h1>Brak dzienników!</h1>";
        else{
            echo "<h1>Wszystkie dzienniki</h1>";
            echo "<h2>Od najnowszych</h2>";
            echo "<table class='generic-table dimmed-center-table' style='width: 100%'>";
            echo "<tr><th>Data</th><th>Przedmiot</th><th>Klasa</th><th>Temat</th><th class='only-big'>Prof.</th><th></th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
                $data = $row['datetime'];
                $przedmiot = $row['przedmiot'];
                $temat = $row['temat'];
                $podpis = $row['prof'];
                $nr = $row['nr'];
                $id = $row['id'];
                $klasa = $row['klasa'];
                echo "<tr>";
                echo "<td class='no-wrap'>$data</td>";
                echo "<td class='no-wrap'>$przedmiot</td>";
                echo "<td>$klasa</td>";
                echo "<td>($nr.) $temat</td>";
                echo "<td>$podpis</td>";
                echo "<td class='no-wrap-fit only-big'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a></td>";
                echo "<td class='no-wrap-fit only-small'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>></div></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    else {
        $sql = "SELECT * FROM dzienniki WHERE (klasa=$klasa OR klasa=0)ORDER BY datetime DESC";
        $result = db_statement($sql);

        if(mysqli_num_rows($result)==0) echo "<h1>Brak dzienników dla danej klasy.</h1>";
        else{
            echo "<h1>Wszystkie dzienniki klasy $klasa</h1>";
            echo "<h2>Od najnowszych</h2>";
            echo "<table class='generic-table dimmed-center-table' style='width: 100%'>";
            echo "<tr><th>Data</th><th>Przedmiot</th><th>Temat</th><th class='only-big'>Prof.</th><th></th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
                $data = $row['datetime'];
                $przedmiot = $row['przedmiot'];
                $temat = $row['temat'];
                $podpis = $row['prof'];
                $nr = $row['nr'];
                $id = $row['id'];
                echo "<tr>";
                echo "<td class='no-wrap'>$data</td>";
                echo "<td class='no-wrap'>$przedmiot</td>";
                echo "<td>($nr.) $temat</td>";
                echo "<td class='only-big'>$podpis</td>";
                echo "<td class='no-wrap-fit only-big'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a></td>";
                echo "<td class='no-wrap-fit only-small'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>></div></a></td>";

                echo "</tr>";
            }
            echo "</table>";
        }
    }

    $result = db_statement($sql);


    
}

function print_dzienniki_of_przedmiot($przedmiot){

    $sql = "SELECT * FROM dzienniki WHERE przedmiot='$przedmiot' ORDER BY datetime DESC";
    $result = db_statement($sql);
    if($result == false) {
        die("<h1>Ups. Jakiś błąd</h1>");
    }

    if(mysqli_num_rows($result)==0) echo "<h1>Brak dzienników z danego przedmiotu.</h1>";
    else{
        echo "<h1>Wszystkie dzienniki przedmiotu $przedmiot</h1>";
        echo "<h2>Od najnowszych</h2>";
        echo "<table class='generic-table dimmed-center-table' style='width: 100%'>";
        echo "<tr><th>Data&nbsp;lekcji</th><th>Klasa</th><th style='width: 50%'>Temat</th><th class='only-big'>Prof.</th><th></th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $data = $row['datetime'];
            $klasa = $row['klasa'];
            $temat = $row['temat'];
            $podpis = $row['prof'];
            $nr = $row['nr'];
            $id = $row['id'];
            echo "<tr>";
            echo "<td class='no-wrap'>$data</td>";
            echo "<td class='no-wrap'>$klasa</td>";
            echo "<td>($nr.) $temat</td>";
            echo "<td class='only-big'>$podpis</td>";
            echo "<td class='no-wrap-fit'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function print_dzienniki_of_przedmiot_klasa($przedmiot, $klasa){

    $sql = "SELECT * FROM dzienniki WHERE przedmiot='$przedmiot' AND (klasa=$klasa OR klasa=0) ORDER BY datetime DESC";
    $result = db_statement($sql);
    if($result == false) {
        die("<h1>Ups. Jakiś błąd</h1>");
    }

    if(mysqli_num_rows($result)==0) echo "<h1>Brak dzienników dla danej klasy z tego przedmiotu.</h1>";
    else{
        echo "<h1>Wszystkie dzienniki przedmiotu $przedmiot klasy $klasa.</h1>";
        echo "<h2>Od najnowszych</h2>";
        echo "<table class='generic-table dimmed-center-table' style='width: 100%'>";
        echo "<tr><th>Data&nbsp;lekcji</th><th style='width: 60%'>Temat</th><th>Podpis</th><th></th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $data = $row['datetime'];
            $temat = $row['temat'];
            $podpis = $row['prof'];
            $nr = $row['nr'];
            $id = $row['id'];
            echo "<tr>";
            echo "<td class='no-wrap'>$data</td>";
            echo "<td>($nr.) $temat</td>";
            echo "<td>$podpis</td>";
            echo "<td class='no-wrap-fit only-big'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>POKAŻ</div></a></td>";
            echo "<td class='no-wrap-fit only-small'><a href='dzienniki_x.php?id=$id'><div class='button-fitted'>></div></a></td>";            echo "</tr>";
        }
        echo "</table>";
    }
}

function print_dzienniki_link_table(){

    echo "<h1>Witaj w królestwie dzienników</h1>";
    echo "<h2>Dzienniki są jak disco polo - albo je kochasz, albo nienawidzisz ~R. Weden 2016</h2>";
    echo "<table class='generic-table dimmed-center-table td-blocks' style='width: 100%'>";
    echo "<tr><td>Astronomia<br><img class='only-big' src='http://wh.boo.pl/przedmioty/astronomia.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Astronomia'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Astronomia'><div class='button-fitted'>KLASA II</div></a></td>
                <td><a href='dzienniki_x.php?klasa=3&przedmiot=Astronomia'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Astronomia'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Czarna Magia<br><img class='only-big' src='http://wh.boo.pl/przedmioty/cm.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Czarna+Magia'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Czarna+Magia'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Czarna+Magia'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Czarna+Magia'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Eliksiry<br><img class='only-big' src='http://wh.boo.pl/przedmioty/eliksiry.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Eliksiry'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Eliksiry'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Eliksiry'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Eliksiry'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Historia Magii<br><img class='only-big' src='http://wh.boo.pl/przedmioty/hm.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Historia+Magii'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Historia+Magii'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Historia+Magii'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Historia+Magii'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Językoznawstwo<br><img class='only-big' src='http://wh.boo.pl/przedmioty/jezykoznawstwo.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Językoznawstwo'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Językoznawstwo'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Językoznawstwo'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Językoznawstwo'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Klub Pojedynków<br><img class='only-big' src='http://wh.boo.pl/przedmioty/kp.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Klub+Pojedynków'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Klub+Pojedynków'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Klub+Pojedynków'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Klub+Pojedynków'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Latanie<br><img class='only-big' src='http://wh.boo.pl/przedmioty/latanie.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Latanie'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Latanie'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Latanie'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Latanie'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>LdZ<br><img class='only-big' src='http://wh.boo.pl/przedmioty/latanie.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Latanie+dla+Zaawansowanych'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Latanie+dla+Zaawansowanych'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Latanie+dla+Zaawansowanych'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Latanie+dla+Zaawansowanych'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Numerologia<br><img class='only-big' src='http://wh.boo.pl/przedmioty/numerologia.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Numerologia'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Numerologia'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Numerologia'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Numerologia'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>OpCM<br><img class='only-big' src='http://wh.boo.pl/przedmioty/opcm.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Obrona+przed+Czarną+Magią'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Obrona+przed+Czarną+Magią'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Obrona+przed+Czarną+Magią'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Obrona+przed+Czarną+Magią'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>OnMS<br><img class='only-big' src='http://wh.boo.pl/przedmioty/onms.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Opieka+nad+Magicznymi+Stworzeniami'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Opieka+nad+Magicznymi+Stworzeniami'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Opieka+nad+Magicznymi+Stworzeniami'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Opieka+nad+Magicznymi+Stworzeniami'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Starożytne Runy<br><img class='only-big' src='http://wh.boo.pl/przedmioty/runy.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Starożytne+Runy'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Starożytne+Runy'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Starożytne+Runy'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Starożytne+Runy'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Smokologia<br><img class='only-big' src='http://wh.boo.pl/przedmioty/runy.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Smokologia'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Smokologia'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Smokologia'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Smokologia'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Transmutacja<br><img class='only-big' src='http://wh.boo.pl/przedmioty/transmutacja.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Transmutacja'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Transmutacja'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Transmutacja'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Transmutacja'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>WoHP<br><img class='only-big' src='http://wh.boo.pl/przedmioty/wohp.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Wiedza+o+Harrym+Potterze'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Wiedza+o+Harrym+Potterze'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Wiedza+o+Harrym+Potterze'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Wiedza+o+Harrym+Potterze'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>WoMMiR<br><img class='only-big' src='http://wh.boo.pl/przedmioty/wommir.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Wiedza+o+Magicznych+Miejscach+i+Rytuałach'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Wiedza+o+Magicznych+Miejscach+i+Rytuałach'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Wiedza+o+Magicznych+Miejscach+i+Rytuałach'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Wiedza+o+Magicznych+Miejscach+i+Rytuałach'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Wróżbiarstwo<br><img class='only-big' src='http://wh.boo.pl/przedmioty/wrozbiarstwo.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Wróżbiarstwo'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Wróżbiarstwo'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Wróżbiarstwo'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Wróżbiarstwo'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Zaklęcia i Uroki<br><img class='only-big' src='http://wh.boo.pl/przedmioty/zaklecia.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Zaklęcia i Uroki'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Zaklęcia i Uroki'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Zaklęcia i Uroki'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Zaklęcia i Uroki'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>Zielarstwo<br><img class='only-big' src='http://wh.boo.pl/przedmioty/zielarstwo.png'></td>
            <td><a href='dzienniki_x.php?klasa=1&przedmiot=Zielarstwo'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2&przedmiot=Zielarstwo'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3&przedmiot=Zielarstwo'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?przedmiot=Zielarstwo'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "<tr><td>WSZYSTKIE</td>
            <td><a href='dzienniki_x.php?klasa=1'><div class='button-fitted'>KLASA I</div></a></td>
            <td><a href='dzienniki_x.php?klasa=2'><div class='button-fitted'>KLASA II</div></a></td>
            <td><a href='dzienniki_x.php?klasa=3'><div class='button-fitted'>KLASA III</div></a></td>
            <td class='only-big'><a href='dzienniki_x.php?klasa=all'><div class='button-fitted'>WSZYSTKIE</div></a></td>
            </tr>";
    echo "</table><br><br>";


}

function print_prace_domowe(){

    echo "<h2>Aktualne prace domowe</h2>";
    $sql = "SELECT id, klasa, praca, pracatermin, przedmiot, prof FROM dzienniki WHERE pracatermin >= DATE(NOW()) ORDER BY pracatermin, klasa";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0){
        echo "Nic do wyświetlenia!";
    }
    else {
        echo "<table class='basic-table full-width center-align'>";
        echo "<tr><th></th><th class='no-wrap-fit'>Klasa</th><th>Przedmiot (profesor)</th><th>Temat pracy</th><th class='no-wrap-fit'>Termin</th></tr>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id']; $klasa = $row['klasa']; $praca = $row['praca'];
            $pracatermin = $row['pracatermin']; $przedmiot = $row['przedmiot']; $prof = $row['prof'];
            echo "<tr>";
            echo "<td class='only-big'><a href='/dzienniki_x.php?id=$id'><div class='button-fitted'>ZOBACZ</div></a></td>";
            echo "<td class='only-small'><a href='/dzienniki_x.php?id=$id'><div class='button-fitted'>></div></a></td>";
            echo "<td>$klasa</td><td>$przedmiot ($prof)</td>";
            echo "<td>$praca</td><td>$pracatermin</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    echo "<h2>Archiwum prac domowych</h2>";

    $sql = "SELECT id, klasa, praca, pracatermin, przedmiot, prof FROM dzienniki WHERE pracatermin < DATE(NOW()) AND pracatermin != 0000-00-00 ORDER BY pracatermin, klasa";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0){
        echo "Nic do wyświetlenia!";
    }
    else {
        echo "<table class='basic-table full-width center-align'>";
        echo "<tr><th></th><th class='no-wrap-fit'>Klasa</th><th>Przedmiot (profesor)</th><th>Temat pracy</th><th class='no-wrap-fit'>Termin</th></tr>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id']; $klasa = $row['klasa']; $praca = $row['praca'];
            $pracatermin = $row['pracatermin']; $przedmiot = $row['przedmiot']; $prof = $row['prof'];
            echo "<tr>";
            echo "<td class='only-big'><a href='/dzienniki_x.php?id=$id'><div class='button-fitted'>ZOBACZ</div></a></td>";
            echo "<td class='only-small'><a href='/dzienniki_x.php?id=$id'><div class='button-fitted'>></div></a></td>";
            echo "<td>$klasa</td><td>$przedmiot ($prof)</td>";
            echo "<td>$praca</td><td>$pracatermin</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}