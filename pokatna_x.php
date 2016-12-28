<?php

require_once('./fasolkifunctions_x.php');

session_start();

if(isset($_GET['location'])){
    $_SESSION['location'] = $_GET['location'];
}

$id = account_access($_SESSION['username'], $_SESSION['password']);
if($id != false){
    print_my_account($id);

}

if(isset($_SESSION['outcome'])){
    print_overfooter($_SESSION['outcome']);
    unset($_SESSION['outcome']);

}

$style = 'display:none';
$style_register = 'display:none';
$text_register = "";
$id = account_access($_SESSION['username'], $_SESSION['password']);

if(isset($_POST['login']) && isset($_POST['password'])){
    $password = md5(trim_input($_POST['password']));
    $id = account_access($_POST['login'], $password);
    if($id != false){
        $login = get_wlasciciel_of_id($id);

        $_SESSION['username'] = $login;
        $_SESSION['password'] = $password;
        setcookie('username', $login, time() + 60*60*24*60);
        setcookie('password', $password, time() + 60*60*24*60);
        pokatna_log($id);
        if($_SESSION['location'] != '') {
            $redirect = $_SESSION['location'];
            unset($_SESSION['location']);
            header("Location: ". $redirect);
            exit();
        }
        if(isset($_SESSION['sklep'])){
            header("Location: pokatna_x.php?sklep=".$_SESSION['sklep']);
            unset($_SESSION['sklep']);
        }
        else header("Location: bank_x.php");
        exit();
    }
    else {
        $style = 'display:block';
    }
}

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_conf']) && isset($_POST['login'])){

    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_conf = $_POST['password_conf'];
    $dom = $_POST['dom'];

    if(check_if_mail_exists($email)){
        $style_register = "display:block";
        $text_register = "Podany mail znajduje się w bazie!";
    }
    elseif(check_if_user_exists($email)){
        $style_register = "display:block";
        $text_register = "Podany nick znajduje się w bazie!";
    }
    elseif($password != $password_conf){
        $style_register = "display:block";
        $text_register = "Hasło i jego potwierdzenie są różne";
    }
    elseif(strlen($password)<6){
        $style_register = "display:block";
        $text_register = "Ale hasełko to z 6 liter minimum";
    }
    else{
        $password = md5($password);
        $id = add_account($login, $password, $email, $dom);
        $_SESSION['id_created'] = $id;
    }
}

if(isset($_GET['item'])){
    $id_item = $_GET['item'];
    $id_user = account_access($_SESSION['username'], $_SESSION['password']);
    $cena = get_cena_of_id($id_item);
    $konto = get_konto_of_id($id_user);
    
    if($konto >= $cena){
        buy_item($id_item, $id_user, $cena, $konto);
        $nazwa = get_nazwa_of_id($id_item);
        $konto = $konto - $cena;
        $_SESSION['outcome'] = "Kupiłeś $nazwa za $cena galeonów. Galeony do wydania: $konto.";
        header("Location: pokatna_x.php");
        exit;
    }
    else {
        $_SESSION['outcome'] = "Nie oszukuj :*";
        header("Location: pokatna_x.php");
        exit;
    }
}


?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6 ">
        <div class="row" id="row-center">
            <?
                if($id == false){
                    if($_GET['cmd'] == "create"){
                        if(isset($_SESSION['id_created'])){
                            print_welcome_message($_SESSION['id_created']);
                            unset($_SESSION['id_created']);
                        }else{
                            print_bank_register($style_register, $text_register);
                            if(isset($_GET['sklep'])){
                                $_SESSION['sklep'] = $_GET['sklep'];
                            }
                    }
                }
                else{
                    print_bank_login($style);
                    $_SESSION['sklep'] = $_GET['sklep'];

                }
            }
            elseif(isset($_GET['sklep'])){
                $sklep = $_GET['sklep'];
                print_sklep($sklep);
            }
            elseif(isset($_GET['showid'])){
                $id = $_GET['showid'];
                print_przedmioty_of($id);
            }


            else{
                echo "<a href='/bank_x.php'><h3>Przejdź do banku >> </h3></a>";
                echo "<a href='/index_x.php'><h3><< Wróć na stronę główną</h3></a>";
            }
?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>