<?php

session_start();

require_once("./logfunctions_x.php");

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_root($_SESSION['username'], $_SESSION['password'])){
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

if(isset($_GET['action'])){
    if($_GET['action'] == "bez"){
        $id = $_GET['id'];
        $sql = "UPDATE admins SET access='n-n-n-n-n-n-n-n-n-n-n' WHERE id = $id";
        db_statement($sql);
        $_SESSION['msg'] = "Odebrano wszelkie uprawnienia!";
        add_event("odebrał(a) wszelkie uprawnienia użytkownikowi o nr. $id", "admin_odeb");
        header("Location: panel_admin.php");
        exit();
    }
    if($_GET['action'] == "admin"){
        $id = $_GET['id'];
        $sql = "UPDATE admins SET access='t-n-n-n-n-n-n-n-n-n-n' WHERE id = $id";
        db_statement($sql);
        $_SESSION['msg'] = "Nadano uprawnienia administratora";
        add_event("nadał(a) prawa admina użytkownikowi o nr. $id", "admin_nad");
        header("Location: panel_admin.php");
        exit();
    }
    if($_GET['action'] == "root"){
        $id = $_GET['id'];
        $sql = "UPDATE admins SET access='root' WHERE id = $id";
        db_statement($sql);
        $_SESSION['msg'] = "Nadano uprawnienia roota";
        add_event("nadał(a) prawa roota użytkownikowi o nr. $id", "root_nad");
        header("Location: panel_admin.php");
        exit();
    }
    if($_GET['action'] == "delete"){
        $id = $_GET['id'];
        $sql = "DELETE FROM admins WHERE id = $id";
        db_statement($sql);
        add_event("usunęł(a) admina o nr. użytkownika $id", "admin_us");
        $_SESSION['msg'] = "Usunięto admina";
        header("Location: panel_admin.php");
        exit();
    }
}

if($_POST){
    if($_POST['confirm']!="hakerzyspadac666"){
        $_SESSION['msg'] = "Złe hasło";
        header("Location: panel_admin.php");
        exit;
    }
    else{
        $nick = $_POST['name'];
        $pass = md5($_POST['pass']);
        $mail = $_POST['email'];
        $sql = "INSERT INTO admins(nick, pass, mail, added, access) VALUES('$nick', '$pass', '$mail', CURRENT_TIMESTAMP, 't-n-n-n-n-n-n-n-n-n-n')";
        db_statement($sql);
        $_SESSION['msg'] = "Dodałeś/aś admina! Hell yeah!";
        add_event("dodał(a) nowego admina! Witaj $nick","admin_dod");
        header("Location: panel_admin.php");
        exit;
    }


}


print_admin_toolbox()
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE ADMINAMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1 id="header">Zarządzanie adminami</h1>
<?// print_add_admin(); ?>
<div class="row">
    <form class="form-sleek" method="post" action="panel_admin.php">
        <div class="col-4" style="margin-left: 33%; margin-bottom: 20px;">
            Nick<input type="text" name="name">
            E-mail<input type="email" name="email">
            Hasło<input type="text" name="pass">
            Tajne hasło dostępu<input type="password" name="confirm">
            <input type="submit" value="Stwórz nowego admina">
        </div>
    </form>
</div>

<? print_admins_list(); ?>

</body>
</html>
