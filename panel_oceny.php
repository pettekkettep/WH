<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./logfunctions_x.php');

if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])){
    header("Location: panel_enter.php");
    exit();
}

if($_POST){
    $stan = 'not';
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $id = $_POST['id'];
    $iddz = 0;
    $dom = $_POST['dom'];
    $kolor = $dom;
    if($kolor == "00cc00") $kolor = "#00cc00";
    if($kolor == "0066ff") $kolor = "#0066ff";
    $klasa = $_POST['klasa'];
    $ocena = $_POST['ocena'];
    $przedmiot = $_POST['przedmiot'];
    $rodzaj = $_POST['rodzaj'];

    $sql = "INSERT INTO oceny(stan, imie, nazwisko, uczen_id, dziennik_id, dom, kolor, klasa, ocena, przedmiot, rodzaj) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    $result = db_statement($sql, "sssiississs", array(&$stan, &$imie, &$nazwisko, &$id, &$iddz, &$dom, &$kolor, &$klasa, &$ocena, &$przedmiot, &$rodzaj));
    $_SESSION['msg'] = "Dodano ocenę!";
    add_event("dodał(a) ocenę ($ocena) poza dziennikiem uczniowi z nr. $id","pkt_dod");
    header("Location: panel_oceny.php");
    exit;
}

print_admin_toolbox();
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<?php
if(!isset($_GET['id'])){
    echo "<h2>Dodaj oceny</h2>";
    echo "<table class='generic-table dimmed-center-table'>";
    echo "<th class='sixty-size'>Imię i nazwisko (mail, nick)</th><th>Klasa</th><th>Zdobyte oceny</th><th class='no-wrap-fit'>Dodaj</th>";

    $sql = "SELECT zapisy_u.id, zapisy_u.imie, zapisy_u.nazwisko, zapisy_u.klasa, zapisy_u.dom, zapisy_u.mail, zapisy_u.nick, count(oceny.id) AS suma FROM zapisy_u LEFT JOIN oceny ON zapisy_u.id = oceny.uczen_id GROUP BY zapisy_u.id ORDER BY suma DESC";

    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];
        $klasa = $row['klasa'];
        $dom = convert_color_to_house($row['dom']);
        $mail = $row['mail'];
        $nick = $row['nick'];
        $suma = $row['suma'];
        echo "<tr>";
        echo "<td class='$dom'>$imie $nazwisko ($mail, $nick)</td>";
        echo "<td>$klasa</td>";
        echo "<td>$suma</td>";
        echo "<td><a href='panel_oceny.php?id=$id'><div class='button-fitted'>DODAJ</div></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
else {
    $id = trim_input($_GET['id']);
    $sql = "SELECT id, imie, nazwisko, dom, klasa FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) die;
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $imie = $row['imie'];
    $nazwisko = $row['nazwisko'];
    $dom = $row['dom'];
    $kto = $_SESSION['username'];
    $klasa = $row['klasa'];
    echo "<div class='basic-form form-sleek'><form action='/panel_oceny.php' method='post'>";
    echo "ID <input type='text' name='id' value='$id' required readonly></input>";
    echo "Imię <input type='text' name='imie' value='$imie' required readonly></input>";
    echo "Nazwisko <input type='text' name='nazwisko' value='$nazwisko' required readonly></input>";
    echo "Dom <input type='text' name='dom' value='$dom' required readonly></input>";
    echo "Klasa <input type='text' name='klasa' value='$klasa' required readonly></input>";
    echo "Przedmiot <select name='przedmiot'>";
    echo "<option value='' disabled selected>(Wybierz)</option>";

                $sql = "SELECT * FROM przedmioty";
                $result = db_statement($sql);
                while($row = mysqli_fetch_assoc($result)){
                    echo "<option value='". $row['przedmiot'] ."'> ". $row['przedmiot'] ." </option>";
                }

    echo "</select>";
    echo "Ocenoprzyznawacz <input type='text' name='kto' value='$kto' required readonly></input>";
    echo "Ocena <select name='ocena'>
            <option value='' selected>(Wybierz)</option>
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
                <option value='T'>T</option></select>";
    echo "Za co? <select name='rodzaj'>
            <option value='' selected>(Wybierz)</option>
                <option value='#ff66ff'>odpowiedź</option>
                <option value='#ff6600'>kartkówkę</option>
                <option value='red'>egzamin</option>
                <option value='#9900CC'>sprawdzian</option>
                <option value='#33cc00'>zadanie domowe</option>
                <option value='yellow'>zadanie dodatkowe</option>
                <option value='#0099ff'>aktywność</option>
                <option value='999999'>praktykę</option>";
    echo "</select>";
    echo "<input type='submit' value='Dodaj ocenę' required></input></form></div>";
}
?>
</body>
</html>