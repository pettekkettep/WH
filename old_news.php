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

if(!isset($_GET['p'])){
    $_GET['p'] = 1;
}

if(isset($_GET['comment_delete_id']) && users_is_root($_SESSION['username'], $_SESSION['password'])){
    delete_comment_id($_GET['comment_delete_id']);
    header("Location: index_x.php");
    $_SESSION['msg'] = "Usunięto komentarz.";
    exit();
}

?>
<? include("before_content.php"); ?>

    <div class="col-6 col-m-6 ">
        <div class="row" id="row-center">
            <h1>Tablica ogłoszeń</h1>
            <? print_feed_old($_GET['p']); ?>
        </div>
    </div>

<? include("after_content.php"); ?>
</body>
</html>