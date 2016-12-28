<?php

require_once('./dziennikifunctions_x.php');
require_once('./logfunctions_x.php');

session_start();
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])) {
    header("Location: panel_enter.php");
    exit();
}

if($_POST){
    $id = $_SESSION['id'];
    unset($_SESSION['id']);
    $title = $_POST['subject'];
    $text = $_POST['content'];
    $textcd = $_POST['additional_content'];
    $icon = $_POST['header_image_url'];
    $date = $_POST['date'];

    $sql = "UPDATE news SET title = '$title', text = '$text', textcd = '$textcd', icon = '$icon', date = '$date' WHERE id = $id";
    db_statement($sql);
    add_event("zedytował(a) news >>$title<<", "ed_news");
    $_SESSION['msg'] = "Zedytowano news.";
    header("Location: panel.php");
    die;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE id=$id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) die("Nie ma takiego newsa!");
    $row = mysqli_fetch_assoc($result);

    $title = $row['title'];
    $text = $row['text'];
    $textcd = $row['textcd'];
    $icon = $row['icon'];
    $date = $row['date'];
    $_SESSION['id'] = $id;
}
else {
    die("Nie ma takiego newsa!");
}


?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Napisz newsa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <script src="//cdn.ckeditor.com/4.5.10/full/ckeditor.js"></script>
</head>
<body>
<div class="basic-form form-sleek">
    <form action="/edytuj_news.php" method="post">
        <h2>Edytuj newsa</h2>
        <h3>Zwróć uwagę, by wymiary każdego obrazka (KTÓRY WSTAWISZ RĘCZNIE) były wyrażone w <i>procentach</i> szerokości, NIE W PIKSELACH (kod możesz podejrzeć wciskając "Źródło dokumentu")</h3>
        <p>Temat</p> <input type="text" name="subject" value="<? echo $title ?>"required></input>
        <p>Treść</p><textarea class="ckeditor" name="content" required><? echo $text ?></textarea>
        <p>Treść dodatkowa</p><textarea class="ckeditor" name="additional_content"><? echo $textcd ?></textarea>
        <p>Link do obrazka</p> <input type="text" name="header_image_url" value="<? echo $icon ?>"></input>
        <p>Data newsa</p> <input type="text" name="date" value="<? echo $date ?>"></input>
        <input type="submit" value="Sprawdziłem poprawność i chcę opublikować!"></input>
    </form>
</div>
</body>
</html>