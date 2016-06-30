<?php

require_once('./functions_x.php');

session_start();
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])){
    header("Location: panel_enter.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $author = $_SESSION['username'];
    $content_1 = $_POST['date'];
    $content_2 = $_POST['content'];
    $day = $_POST['expiry_day'];
    $time = $_POST['expiry_hour'];
    $expiry = date('Y-m-d H:i:s', strtotime("$day $time"));
    $priority = $_POST['priority'];
    $hyperlink = $_POST['hyperlink'];
    $processed = dates_add_date($author, $content_1, $content_2, $expiry, $priority, $hyperlink);
    if($processed) {
        $_SESSION['msg'] = 'Et voila! Wysłano datę do dyrekcji!';
        header("Location: panel.php");
        exit();
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
<div class="basic-form form-sleek">
    <form action="/panel_add_date.php" method="post">
        <h2>Dodaj ważną datę</h2>
        <h3>Krótki wstęp: </h3><h4>Data - kiedy dane wydarzenie ma miejsce (może być to zakres dat),</h4><h4>Treść - opis wydarzenia
                </h4><h4>Data/godzina utraty ważności - kiedy wydarzenie zostanie automatycznie usunięte, </h4><h4>Priorytet - "ważne" posiadają dodatkowe, żółtawe tło,
            </h4><h4>Link - pole opcjonalne, jeśli chcesz, by kliknięcie
            na ważną datę powodowało przekierowanie, np. do newsa </h4>
        Data <input type="text" name="date" placeholder="np. 13.06, do 20.06, 14.01 - 20.01" required></input>
        Treść <input type="text" name="content" placeholder="Krótko, zwięźle, na temat" required></input>
        Dzień utraty ważności <input type="date" name="expiry_day" required></input>
        Godzina utraty ważności <input type="time" name="expiry_hour"></input>
        Priorytet <select name="priority">
            <option value="0" selected>Zwykły</option>
            <option value="1">Wysoki</option>
        </select>
        Link <input type="text" name="hyperlink" placeholder="Poprawny format linku to http://......."></input>
        <input type="submit" value="Sprawdziłem poprawność i chcę wysłać!"></input>
    </form>
</div>
</body>
</html>