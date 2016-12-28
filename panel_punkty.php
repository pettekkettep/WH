<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./logfunctions_x.php');
require_once('./mailer_x.php');

if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])){
    header("Location: panel_enter.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['id']) $id = $_POST['id'];
    else $id = 0;
    $dom = $_POST['dom'];
    $kto = $_POST['kto'];
    $ile = trim_input($_POST['ile']);
    $why = trim_input($_POST['why']);

    switch($dom){
        case "gryff":
            $dom_id = 1;
            $to_log = "Gryffindorowi";
            break;
        case "slyth":
            $dom_id = 2;
            $to_log = "Slytherinowi";
            break;
        case "rav":
            $dom_id = 3;
            $to_log = "Ravenclawowi";
            break;
        case "huff":
            $dom_id = 4;
            $to_log = "Hufflepuffowi";
            break;
    }

    $sql = "INSERT INTO punkty_opis(id_dom, uczen_id, kto, ile, uzasadnienie, zmiana) VALUES ($dom_id, $id, '$kto', $ile, '$why', 'Dodał')";
    if($id!=0) add_event("dodał(a) punkty ($ile) poza dziennikiem uczniowi z nr. $id","pkt_dod");
    else add_event("dodał(a) punkty ($ile) całemu $to_log","pkt_dod");
    $result = db_statement($sql);
    $_SESSION['msg'] = "Dodano punkty!";
    header("Location: panel_punkty.php");
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
    echo "<h2>Dodaj punkty domowi (w przypadku, gdy punkty nie są przyznawane indywidualnie, np. Chrzest Kotów)</h2>";
    echo "<div class='basic-form form-sleek'><form action='/panel_punkty.php' method='post'>";
    echo "Dom <select name='dom'>
            <option value='' disabled selected>(Wybierz)</option>
            <option value='gryff'>Gryffindor</option>
            <option value='huff'>Hufflepuff</option>
            <option value='rav'>Ravenclaw</option>
            <option value='slyth'>Slytherin</option>
            </select>";
    $kto = $_SESSION['username'];
    echo "Wielkoduszny punktodawacz <input type='text' name='kto' value='$kto' required readonly></input>";
    echo "Ilość punktów <input type='text' name='ile' required></input>";
    echo "Uzasadnienie <input type='text' name='why' required></input>";
    echo "<input type='submit' value='Dodaj punkty domowi' required></input></form></div>";
    echo "<h2>Dodaj punkty</h2>";
    echo "<table class='generic-table dimmed-center-table'>";
    echo "<th class='sixty-size'>Imię i nazwisko (mail, nick)</th><th>Klasa</th><th>Zdobyte punkty</th><th class='no-wrap-fit'>Dodaj</th>";

    $sql = "SELECT zapisy_u.id, zapisy_u.imie, zapisy_u.nazwisko, zapisy_u.klasa, zapisy_u.dom, zapisy_u.mail, zapisy_u.nick, sum(punkty_opis.ile) AS suma FROM zapisy_u LEFT JOIN punkty_opis ON zapisy_u.id = punkty_opis.uczen_id GROUP BY zapisy_u.id ORDER BY suma DESC";

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
        echo "<td><a href='panel_punkty.php?id=$id'><div class='button-fitted'>DODAJ</div></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

else{
    $id = trim_input($_GET['id']);
    $sql = "SELECT id, imie, nazwisko, dom FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) die;
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $imie = $row['imie'];
    $nazwisko = $row['nazwisko'];
    $dom = convert_color_to_house($row['dom']);
    $kto = $_SESSION['username'];
    echo "<div class='basic-form form-sleek'><form action='/panel_punkty.php' method='post'>";
    echo "ID <input type='text' name='id' value='$id' required readonly></input>";
    echo "Imię <input type='text' name='imie' value='$imie' required readonly></input>";
    echo "Nazwisko <input type='text' name='nazwisko' value='$nazwisko' required readonly></input>";
    echo "Dom <input type='text' name='dom' value='$dom' required readonly></input>";
    echo "Wielkoduszny punktodawacz <input type='text' name='kto' value='$kto' required readonly></input>";
    echo "Ilość punktów <input type='text' name='ile' required></input>";
    echo "Uzasadnienie <input type='text' name='why' required></input>";
    echo "<input type='submit' value='Dodaj punkty' required></input></form></div>";

    
    
}
?>
        </body>
</html>