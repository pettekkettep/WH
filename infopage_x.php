<?php
session_start();
require_once("./functions_x.php");
if(!isset($_GET['id'])){
    header("Location: index_x.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $id = trim_input($id);
    $sql = "UPDATE infos SET opened = opened + 1 WHERE id = $id";
    $result = db_statement($sql);
    if($result == false){
        header("Location: index_x.php");
        exit();
    }
//    RADZENIE SOBIE Z DLUGIMI TEKSTAMI OBECNIE NIE CHCE MI SIE MYSLEC NAD MADRZEJSZYM ROZWIAZANIEM
    if($id == 2){
        $next_id = 95;
        $sql = "SELECT title, text FROM infos WHERE id = $id";
        $result = db_statement($sql);
        if($result == false){
            header("Location: index_x.php");
            exit();
        }
        if(mysqli_num_rows($result)!=1){
            header("Location: index_x.php");
            exit();
        }
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $text = $row['text'];
        $to_title = " - ".$title;
        $sql = "SELECT text FROM infos WHERE id = $next_id";
        $result = db_statement($sql);
        if($result == false){
            header("Location: index_x.php");
            exit();
        }
        if(mysqli_num_rows($result)!=1){
            header("Location: index_x.php");
            exit();
        }
        $row = mysqli_fetch_assoc($result);
        $text2 = $row['text'];
        $text = $text . $text2;

    }
    //
    else {
        $id = trim_input($id);
        $sql = "SELECT title, text, textnarrow FROM infos WHERE id = $id";
        $result = db_statement($sql);
        if($result == false){
            header("Location: index_x.php");
            exit();
        }
        if(sizeof($result) != 1){
            header("Location: index_x.php");
            exit();
        }
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $text = $row['text'];
        $textnarrow = $row['textnarrow'];
        if($textnarrow == "") $textnarrow = $text;
        $to_title = " - ".$title;
    }
}
print_admin_toolbox();
?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row" id="wide-ver">
            <? echo $text ?>
        </div>
        <div class="row" id="narrow-ver">
            <? echo $textnarrow ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>