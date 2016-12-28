<!--DOSTĘP DO TEJ STRONY: ROOTS-->

<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./logfunctions_x.php');

session_start();
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php?location=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if(!users_is_root($_SESSION['username'], $_SESSION['password'])){
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
    $id = trim_input($id);
    $sql = "SELECT title, text, textnarrow FROM infos WHERE id = $id";

    $result = db_statement($sql);
    if($result == false) die;
    if(mysqli_num_rows($result)!=1) echo "<h1>Brak infopage'a o takim id.</h1>";
    else {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $text = $row['text'];
        $textnarrow = $row['textnarrow'];
    }
}

if(isset($_POST['title']) && isset($_POST['text']) && users_is_root($_SESSION['username'], $_SESSION['password'])){
    if(isset($_SESSION['id'])){
        $title = $_POST['title'];
        $text = $_POST['text'];
        $textnarrow = $_POST['textnarrow'];
        $id = $_SESSION['id'];

        $sql = "UPDATE infos SET title = '$title', text = '$text', textnarrow = '$textnarrow' WHERE id = $id";
        $result = db_statement($sql);

        $_SESSION['msg'] = "Infopage $id zedytowany!";
        add_event("zedytował(a) infosa nr $id", "info_ed");
        header("Location: panel.php");
        unset($_SESSION['id']);
        exit();
    }
    else {
        $title = $_POST['title'];
        $text = $_POST['text'];
        $textnarrow = $_POST['textnarrow'];

        $sql = "INSERT INTO infos(title, text, textnarrow) VALUES('$title', '$text', '$textnarrow')";
        $result = db_statement($sql);

        $_SESSION['msg'] = "Infopage dodany!";
        add_event("dodał(a) infosa o tytule $title", "info_dod");
        header("Location: panel.php");
        exit();
    }
}
print_admin_toolbox()
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Kreator infopage'a</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>
<body>
<h4>Pamiętaj, że jeśli edytujesz infopage, który zawiera dużo tekstu to z powodu (prawdopodobnie) sposobu alokacji pamięci w bazie, treść infopage'a może zostać bez ostrzeżenia ucięta. ZATEM zachowaj oryginalną treść infopage'a. Jeśli problem będzie się powtarzał jedyną możliwością jest usunięcie rekordu w bazie danych i stworzenie nowego o takim samym numerze ID. Tworzenie nowego rekordu bowiem alokuje odpowiednią ilość pamięci w strukturze bazy. (Ironicznie) Powodzenia.</h4>
<?php

echo "<div class='dzienniki-form form-sleek row'>";
echo "<form action='/add_infopage.php' method='post'>
        <h2>Dodaj/edytuj infopage'a</h2>
        Tytuł infopage'a <input type='text' name='title' value='$title' required>
        <p>Treść infopejdża na horyzontalne ekrany</p>
        <textarea rows='25' name='text'>$text</textarea>
        <p>Treść infopejdża na małe wertykalne ekrany (tj. smartfona trzymanego pionowo)</p>
        <p>Jeśli pole jest puste oznacza, że treść infopage'a jest jednakowa dla obu sposobów wyświetlania</p>
        <textarea rows='25' name='textnarrow'>$textnarrow</textarea>
        <input type='submit' value='Gotowe!'>
        </form></div>";
?>

</body>
</html>
