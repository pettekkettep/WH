<?php

session_start();

include("functions_x.php");

if($_GET){
    $id = $_GET['id'];
    $group = $_GET['group'];
}


?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <? print_profile($id, $group) ?>
    </div>


<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>