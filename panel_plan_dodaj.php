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

if(!users_is_root($_SESSION['username'], $_SESSION['password'])){
    header("Location: panel_enter.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $przedmiot = $_POST['przedmiot'];
    $klasa = $_POST['klasa'];
    $dzien = $_POST['dzien'];
    $godzina = $_POST['godzina'];
    $miejsce = $_POST['miejsce'];

    if(!isset($_SESSION['id'])) {
        $sql = "INSERT INTO plan(przedmiot, klasa, dzien, godzina, miejsce) VALUES(?,?,?,?,?)";
        db_statement($sql, 'siiss', array(&$przedmiot, &$klasa, &$dzien, &$godzina, &$miejsce));
        add_event("dodał(a) lekcję dla klasy $klasa do planu","plan_dod");
        $_SESSION['msg'] = "Dodano lekcję.";
    }
    else {
        $id = $_SESSION['id'];
        unset($_SESSION['id']);
        $sql = "UPDATE plan SET przedmiot='$przedmiot', klasa='$klasa', dzien='$dzien', godzina='$godzina', miejsce='$miejsce'
            WHERE id=$id";
        db_statement($sql);
        add_event("zedytował(a) lekcję dla klasy $klasa w planie","plan_ed");
        $_SESSION['msg'] = "Zedytowano lekcję.";
    }

    header("Location: panel_plan_dodaj.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && users_is_root($_SESSION['username'], $_SESSION['password']) && isset($_GET['id'])){
//    czynimy założenie, że tylko edycja odbywa się przez geta (śliskie)
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
    $sql = "SELECT * FROM plan WHERE id = $id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 1){
        $result = mysqli_fetch_assoc($result);
        $przedmiot = $result['przedmiot'];
        $dzien = $result['dzien'];
        $klasa = $result['klasa'];
        $godzina = $result['godzina'];
        $miejsce = $result['miejsce'];
    } else {
        die("Nie ma takiej lekcji w bazie!");
    }
}

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
</head>
<body>
<div class="basic-form form-sleek">
    <form action="/panel_plan_dodaj.php" method="post">
        <h2>Dodaj lekcję do planu</h2>
        Przedmiot <input type="text" name="przedmiot" value="<? echo $przedmiot ?>"required></input>
        Dzień <select name="dzien">
            <option value="0" disabled <?php if(!isset($dzien)) echo "selected";?>></option>
            <option value="1" <?php if($dzien == 1) echo "selected";?>>Poniedziałek</option>
            <option value="2" <?php if($dzien == 2) echo "selected";?>>Wtorek</option>
            <option value="3" <?php if($dzien == 3) echo "selected";?>>Środa</option>
            <option value="4" <?php if($dzien == 4) echo "selected";?>>Czwartek</option>
            <option value="5" <?php if($dzien == 5) echo "selected";?>>Piątek</option>
            <option value="6" <?php if($dzien == 6) echo "selected";?>>Sobota</option>
            <option value="7" <?php if($dzien == 7) echo "selected";?>>Niedziela</option>
        </select>
        Godzina zajęć <input type="text" name="godzina" placeholder="Np. 18:00 - 18:35" value="<? echo $godzina ?>" required></input>
        Miejsce lekcji <input type="text" name="miejsce" value="<? echo $miejsce ?>" required></input>
        Klasa <select name="klasa">
            <option value="0" disabled <?php if(!isset($klasa)) echo "selected";?>></option>
            <option value="1" <?php if($klasa == 1) echo "selected";?>>I klasa</option>
            <option value="2" <?php if($klasa == 2) echo "selected";?>>II klasa</option>
            <option value="3" <?php if($klasa == 3) echo "selected";?>>III klasa</option>
        </select>
        <input type="submit" value="Dodaj lekcję!"></input>
    </form>
</div>
</body>
</html>