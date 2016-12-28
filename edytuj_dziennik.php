<?php

require_once ("dziennikifunctions_x.php");
require_once ("logfunctions_x.php");
session_start();

if($_GET['id'] != NULL){
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
    $sql = "SELECT * FROM dzienniki WHERE id=$id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) die("Błąd");
    $row = mysqli_fetch_assoc($result);

    $datetime = $row['datetime'];
    $date = date('Y-m-d', strtotime($datetime));
    $time = date('H:i', strtotime($datetime));
    
    $nr = $row['nr'];
    $temat = $row['temat'];
    $notatka = $row['notatka'];
    $klasa = $row['klasa'];
    $praca = $row['praca'];
    if(!users_is_root($_SESSION['username'], $_SESSION['password'])){
        if($row['prof'] != $_SESSION['username']){
            header("Location: panel.php");
            die;
        }
    }
}

else if($_POST){
    $id = $_SESSION['id'];
    unset($_SESSION['id']);
    $day = $_POST['data'];
    $time = $_POST['godzina'];
    $datetime = date('Y-m-d H:i:s', strtotime("$day $time"));

    $nr = $_POST['nr'];
    $temat = $_POST['temat'];
    $notatka = $_POST['notatka'];
    $klasa = $_POST['klasa'];
    $praca = $_POST['praca'];
    add_event("zedytował(a) dziennik nr $id", "ed_dz");
    $sql = "UPDATE dzienniki SET nr = ?, temat = ?, notatka = ?, klasa = ?, praca = ?, datetime = ? WHERE id = ?";
    db_statement($sql, "ssssssi", array(&$nr, &$temat, &$notatka, &$klasa, &$praca, &$datetime, &$id));
    $_SESSION['msg'] = "Zedytowano dziennik!";
    header("Location: panel.php");
}

else {
    die("Błąd");
}

?>


<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Edytor dziennika</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <script src="//cdn.ckeditor.com/4.5.10/full/ckeditor.js"></script></head>
<body>
    <div class="basic-form form-sleek row">
        <form action="/edytuj_dziennik.php" method="post">
            <h2>Zrób to raz - a dobrze!</h2>
            Numer lekcji wg programu nauczania <input type="text" name="nr" value="<? echo $nr ?>" required>
            Temat <input type="text" name="temat" value="<? echo $temat ?>" required>
            Notatka <textarea name="notatka" class="ckeditor" required><? echo $notatka ?></textarea>
            Klasa <input type="text" name="klasa" value="<? echo $klasa ?>" required>
            Praca domowa <textarea name="praca" class="ckeditor" required><? echo $praca ?></textarea>
            Data <input type="date" name="data" value="<? echo $date ?>" required>
            Godzina <input type="time" name="godzina" value="<? echo $time ?>" required>

            <input type="submit" value="Edytuj">

        </form>
    </div>
</body>
</html>
    


