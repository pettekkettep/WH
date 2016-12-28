<?php

session_start();

require_once("./functions_x.php");

if(isset($_GET['id']) || isset($_GET['show'])){
    $id = trim_input($_GET['id']);
    $show = trim_input($_GET['show']);
}
else {
    header("Location: index_x.php");
    exit;
}

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

if($_GET['action'] == 'delete' && users_is_root($_SESSION['username'], $_SESSION['password'])){
    $id = trim_input($_GET['id']);
    $sql = "DELETE FROM punkty_opis WHERE id = $id";
    $result = db_statement($sql);
    $_SESSION['msg'] = "Usunięto punkty!";
    header("Location: punkty.php");
    exit;
}

?>
<? include("before_content.php"); ?>

    <div class="col-6 col-m-6 ">
        <div class="row" id="row-center">
            <?php
            if(isset($_GET['id'])){
                print_punkty_of_id($id);
            }
            if(isset($_GET['show'])){
                print_punkty_of_dom($show);
            }
            ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>