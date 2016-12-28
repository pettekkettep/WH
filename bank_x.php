<?php

session_start();

require_once("./pokatnafunctions_x.php");
require_once ("./logfunctions_x.php");

$id = account_access($_SESSION['username'], $_SESSION['password']);
if($id != false){
    print_my_account($id);
}
else {
    header("Location: pokatna_x.php");
}

if($_POST){
    if(isset($_POST['id'])){
        $id = trim_input($_POST['id']);
        $galeony = trim_input($_POST['galeony']);
        add_event("dodał(a) $galeony gal. osobie o numerze skrytki $id","gring_dod");
        dodaj_galeony($id, $galeony);
        $_SESSION['msg'] = "Dodano galce! :)";
        header("Location: bank_x.php");
        exit;
    }
    else{
        $lista = $_POST['dodajgal'];
        $ile = $_POST['ile'];
        foreach($lista as $id){
            $id = trim_input($id);
            add_event("dodał(a) $ile gal. osobie o numerze skrytki $id","gring_dod");
            dodaj_galeony($id, $ile);
        }
        $_SESSION['msg'] = "Dodano galce! :)";
        header("Location: bank_x.php");
        exit;
    }
}


?>
<? include("before_content.php"); ?>

    <div class="col-6 col-m-6 ">
        <div class="row" id="row-center">
            <?php
            if(isset($_GET['id']) && users_is_root($_SESSION['username'], $_SESSION['password'])){
                $id = trim_input($_GET['id']);
                print_dodaj_galeony($id);
            }
            else{print_majatek();}

            if(isset($_SESSION['msg'])){
                echo "<h2>".$_SESSION['msg']."</h2>";
                unset($_SESSION['msg']);
            }




            ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>