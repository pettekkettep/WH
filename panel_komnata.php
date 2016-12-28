<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./zapisyfunctions_x.php');
require_once('./logfunctions_x.php');
print_admin_toolbox();


if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_root($_SESSION['username'], $_SESSION['password'])) {
    $_SESSION['msg'] = 'Brak odpowiednich uprawnień';
    header("Location: panel.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - KOMNATA TAJEMNIC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<h1>
    <form class="form-sleek" action="panel_komnata.php" method="post">
        Podaj IP(v4)<input type="text" name="ip">
        <input type="submit" value="Szpieguj!">
    </form>
    <?php
    if($_POST){
        $ip = trim_input($_POST['ip']);
        print_personal($ip);
        $sql = "SELECT DISTINCT ip FROM bigbrother WHERE token IN(SELECT token FROM bigbrother WHERE ip = '$ip')";
        $result = db_statement($sql);
        while($row = mysqli_fetch_assoc($result)){
            $ip = $row['ip'];
            echo "<h1 class='huff center-align'>$ip</h1>";
            print_personal($ip);
        }

    }
    ?>
</h1>

</body>
</html>
