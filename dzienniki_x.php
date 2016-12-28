<?php
require_once("./dziennikifunctions_x.php");
session_start();

?>


<? include("before_content.php") ?>

    <div class="col-6 col-m-6">
        <div class="row">
            <?
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                print_dziennik_of_id($id);
            }

            elseif(isset($_GET['klasa']) && !isset($_GET['przedmiot'])){
                $klasa = $_GET['klasa'];
                print_dzienniki_of_klasa($klasa);

            }

            elseif(isset($_GET['przedmiot']) && !isset($_GET['klasa'])){
                $przedmiot = $_GET['przedmiot'];
                print_dzienniki_of_przedmiot($przedmiot);
            }

            elseif(isset($_GET['przedmiot']) && isset($_GET['klasa'])){
                $klasa = $_GET['klasa'];
                $przedmiot = $_GET['przedmiot'];
                print_dzienniki_of_przedmiot_klasa($przedmiot, $klasa);
            }

            else{
                print_dzienniki_link_table();
            }


            ?>

        </div>
    </div>

<? include("after_content.php") ?>
<script src="js/index_x.js"></script>
</body>
</html>