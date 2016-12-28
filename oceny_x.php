<?php
require_once("./ocenyfunctions_x.php");
session_start();

?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row">
            <?
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                print_oceny_of_id($id);
            }

            elseif(isset($_GET['dom'])){
                $dom = $_GET['dom'];
                print_oceny_of_dom($dom);

            }

            elseif(isset($_GET['przedmiot'])){
                $przedmiot = $_GET['przedmiot'];
                print_oceny_of_przedmiot($przedmiot);

            }
            
            else{
                print_oceny_link_table();
            }


            ?>

        </div>
    </div>

    <? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>