<?php

session_start();

require_once("./functions_x.php");

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

if(isset($_POST['user']) && isset($_POST['comment']) && isset($_POST['newsid'])){
    add_comment_to_news($_POST['user'], $_POST['comment'], $_POST['newsid']);
    header("Location: " . $_SERVER['REQUEST_URI']);
    $_SESSION['msg'] = "Dodano komentarz!";
    exit();
}

if($_GET['logout'] == 1){
    unset($_SESSION['username']);
    unset($_SESSION['password']);
}

if(!isset($_GET['p'])){
    $_GET['p'] = 1;
}

if(isset($_GET['comment_delete_id']) && users_is_root($_SESSION['username'], $_SESSION['password'])){
    delete_comment_id($_GET['comment_delete_id']);
    header("Location: index_x.php");
    $_SESSION['msg'] = "Usunięto komentarz.";
    exit();
}



print_admin_toolbox();



?>
<!doctype HTML>
<html>
<head>
    <title>Wirtualny Hogwart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Headland+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">

</head>
<!--<body onLoad="window.scrollBy(0,350)">-->
<body>
<div class="row">
    <a href="http://wh.boo.pl"><div class="logo" id="logo-mobile"><img src = "hogwarts-tiny.jpg"></div></a>
</div>
<div class="row">
    <div class="logo" id="napis-wh"><img src = "theme/HogwartsFounders/gfx/wh1.png"></div>
</div>
<div class="row row-style-light">
    <div class="col-4">
        <? print_best_pupils(); ?>
    </div>
    <div class="col-4 col-m-6">
        <? print_pts_table(); ?>
    </div>
    <div class="col-4 col-m-6 img-logo">
        <img id="logo-wh" src="logo.jpg">
        <? $days = days_since();
        echo "<p>Nasza szkoła istnieje od <span class='score'> $days </span>dni.</p>" ?>
    </div>
</div>
<div class="row row-style">

    <div class="col-1 col-m-0"></div>
    <div class="col-0 col-2 col-m-3">
        <div class="row row-block-left">
            <? print_left_first() ?>
        </div>
        <div class="row row-block-left">
            <? print_left_second() ?>
        </div>
        <div class="row row-block-left">
            <?
            print_enroll_menu();
            print_pupil_search();
            ?>
        </div>
        <div class="row row-block-left">
            <? print_time_table() ?>
        </div>
        <div class="row row-block-left">
            <? print_sale() ?>
        </div>
        <div class="row row-block-left">
            <? print_pokatna() ?>
        </div>
    </div>

    <div class="col-6 col-m-6 ">
        <div class="row" id="row-center">
            <h1>Tablica ogłoszeń</h1>
            <? print_feed($_GET['p']); ?>
        </div>
    </div>

    <div class="col-low-res">
        <div class="row row-block-right">
            <? print_time_table() ?>
        </div>
        <div class="row row-block-right">
            <? print_important_dates() ?>
        </div>
        <div class="row row-block-right">
            <? print_castle() ?>
        </div>
        <div class="row row-block-right">
            <? print_enroll_menu() ?>
        </div>
        <div class="row row-block-right">
            <? print_houses_details() ?>
        </div>
        <div class="row row-block-right">
            <? print_kp_block() ?>
        </div>
        <div class="row row-block-right">
            <? print_izba_pamieci() ?>
        </div>
    </div>

    <div class="col-0 col-2 col-m-3">
        <div class="row row-block-right">
            <? print_important_dates() ?>
        </div>
        <div class="row row-block-right">
            <? print_pub_czaro() ?>
        </div>
        <div class="row row-block-right">
            <? print_castle() ?>
        </div>
        <div class="row row-block-right">
            <? print_dorm() ?>
        </div>
        <div class="row row-block-right">
            <? print_houses_details() ?>
        </div>
        <div class="row row-block-right">
            <? print_kleks() ?>
        </div>
        <div class="row row-block-right">
            <? print_kp_block() ?>
        </div>
        <div class="row row-block-right">
            <? print_quidd_block() ?>
        </div>
        <div class="row row-block-right">
            <? print_izba_pamieci() ?>
        </div>
    </div>
    <div class="col-1 col-m-0"></div>
</div>
<script src="js/index_x.js"></script>
</body>
</html>