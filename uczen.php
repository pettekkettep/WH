<?php
require_once("./functions_x.php");

print_admin_toolbox();
?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row" id="row-center">
            <div class="col-12">
            <?
                if(isset($_POST['name'])) {
                    print_pupil_search_result($_POST['name']);
                }
            ?>
            </div>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>