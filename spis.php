<?php

require_once("./functions_x.php");

if(isset($_GET['show'])){
    $show = trim_input($_GET['show']);
}

print_admin_toolbox();

?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row">
            <?
                if(isset($_GET['show'])){
                    print_table_of($show);
                }
                if(isset($_GET['name'])) {
                    $name = trim_input($_GET['name']);
                    print_search_of($name);
                }
            ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>