<?php
session_start();
require_once("./logfunctions_x.php");
if(!isset($_GET['klasa']) || !isset($_GET['dzien'])){
    header("Location: index_x.php");
}
if($_GET['action']=="delete"){
    $id = trim_input($_GET['id']);
    $sql = "DELETE FROM plan WHERE id=$id";
    $result = db_statement($sql);
    $_SESSION['msg'] = "Usunięto lekcję";
    add_event("usunął/ęła lekcję o id $id","plan_us");
    header("Location: plan_lekcji.php");
    exit();
}

?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6 ">
        <div class="row" id="row-center">
            <?
            $klasa = $_GET['klasa'];
            $klasa = trim_input($klasa);
            $dzien = $_GET['dzien'];
            $dzien = trim_input($dzien);
            if($dzien == 'all') print_plan_all($klasa);
            else print_plan($klasa, $dzien);
            ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>