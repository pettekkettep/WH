<?php

if(isset($_SESSION['msg'])) echo $_SESSION['msg'];

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

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <?php echo $_SESSION['msg'] ?>
    Tu w przyszłości będzie panel administracji
</body>
</html>