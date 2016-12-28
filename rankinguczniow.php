<?php
require_once("./functions_x.php");
?>
<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row">
            <? 
            
            $klasa = trim_input($_GET['klasa']);
            $kiedy = trim_input($_GET['kiedy']);
            print_best_list($klasa, $kiedy);
            
            ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>