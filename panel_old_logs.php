<?php

require_once('./logfunctions_x.php');

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}
if(!isset($_SESSION['username'])){
    header("Location: panel_enter.php");
    exit();
}

if(!users_is_admin($_SESSION['username'], $_SESSION['password'])){
    header("Location: panel_enter.php");
    exit();
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
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
<div class="row">
    <div class="col-8" style="margin-left: 20%">
        <?php
        if(!isset($_GET['p'])) $page = 1;
        else $page = trim_input($_GET['p']);
        $sql = "SELECT * FROM log ORDER BY data DESC";
        $sql_pag = paginate($sql, "panel_old_logs.php", 100, $page);
        $result = db_statement($sql_pag);
        if(mysqli_num_rows($result) > 0){
            echo "<table class='simplest'><th>Data</th><th>IP</th><th>Zdarzenie</th>";
            while($row = mysqli_fetch_assoc($result)){
                $data = $row['data'];
                $ip = $row['ip'];
                $tresc = $row['tresc'];
                $kto = $row['kto'];
                $data_str = str_replace(" ","&nbsp;",$data);
                $data_str = str_replace("-","&#8209;",$data_str);
                echo "<tr><td>$data_str</td><td>$ip</td>";
                $komunikat = $kto ." ". time_description($data) ." ". $tresc;
                echo "<td>$komunikat</td></tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</div>
</body>
</html>