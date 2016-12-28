<!--ADMINS-->

<?php

require_once('./dziennikifunctions_x.php');
require_once('./logfunctions_x.php');

session_start();
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php?location=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])) {
    header("Location: panel_enter.php");
    exit();
}

if($_POST){
    $title = $_POST['subject'];
    $text = $_POST['content'];
    $textcd = $_POST['additional_content'];
    if($_POST['header_image'] != "") $icon = $_POST['header_image'];
    else $icon = $_POST['header_image_url'];
    $date = date("Y-m-d H:i:s");
    $author = $_SESSION['username'];
    $stat = 1;

    $sql = "INSERT INTO news(title, text, textcd, icon, stat, date, author) VALUES (?,?,?,?,?,?,?)";
    db_statement($sql, "ssssiss", array(&$title, &$text, &$textcd, &$icon, &$stat, &$date, &$author));
    add_event("dodał(a) news >>$title<<", "dod_news");
    $_SESSION['msg'] = "Dodano news.";
    header("Location: panel.php");
    die;
}

print_admin_toolbox();
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Napisz newsa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<body>
<div class="basic-form form-sleek">
    <form action="/dodaj_news.php" method="post">
        <h2>Dodaj newsa</h2>
        <h3>Zwróć uwagę, by wymiary każdego obrazka (KTÓRY WSTAWISZ RĘCZNIE) były wyrażone w <i>procentach</i> szerokości, NIE W PIKSELACH (kod możesz podejrzeć wciskając "Źródło dokumentu")</h3>
        <p>Temat</p> <input type="text" name="subject" required></input>
        <p>Treść</p><textarea class="ckeditor" id = "ck1" name="content" required></textarea>
        <p>Treść dodatkowa</p><textarea class="ckeditor" id = "ck2" name="additional_content"></textarea>
        <p>Obrazek do nagłówka</p>
        <select name='header_image'>
            <option value='' disabled selected>(Wybierz)</option>
            <option value='/news/astronomia.png'>Astronomia</option>
            <option value='/news/cm.png'>Czarna Magia</option>
            <option value='/news/doprofesorow.png'>Do profesorów</option>
            <option value='/news/egzaminy.png'>Egzaminy</option>
            <option value='/news/eliksiry.png'>Eliksiry</option>
            <option value='/news/gryffindor.png'>Gryffindor</option>
            <option value='/news/hm.png'>Historia Magii</option>
            <option value='/news/hufflepuff.png'>Hufflepuff</option>
            <option value='/news/jezykoznawstwo.png'>Językoznawstwo</option>
            <option value='/news/kleks.png'>Kleks</option>
            <option value='/news/kp.png'>Klub Pojedynków</option>
            <option value='/news/konkurs.png'>Konkurs</option>
            <option value='/news/latanie.png'>Latanie</option>
            <option value='/news/mecz.png'>Mecz</option>
            <option value='/news/numerologia.png'>Numerologia</option>
            <option value='/news/oddyrekcji.png'>Od dyrekcji</option>
            <option value='/news/olimpiada.png'>Olimpiada</option>
            <option value='/news/onms.png'>OnMS</option>
            <option value='/news/opcm.png'>OpCM</option>
            <option value='/news/pozahogwartem.png'>Poza Hogwartem</option>
            <option value='/news/ravenclaw.png'>Ravenclaw</option>
            <option value='/news/rozrywka.png'>Rozrywka</option>
            <option value='/news/slytherin.png'>Slytherin</option>
            <option value='/news/runy.png'>Starożytne Runy</option>
            <option value='/news/transmutacja.png'>Transmutacja</option>
            <option value='/news/uwaga.png'>Uwaga</option>
            <option value='/news/wohp.png'>WoHP</option>
            <option value='/news/wommir.png'>WoMMiR</option>
            <option value='/news/wrozbiarstwo.png'>Wróżbiarstwo</option>
            <option value='/news/zaklecia.png'>Zaklęcia</option>
            <option value='/news/zielarstwo.png'>Zielarstwo</option>
        </select>
        <p>Jeśli nie wybrałeś z listy to podaj link do obrazka</p> <input type="text" name="header_image_url"></input>
        <input type="submit" value="Sprawdziłem poprawność i chcę opublikować!"></input>
        
    </form>
</div>
</body>
</html>