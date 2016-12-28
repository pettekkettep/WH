<?

require_once("./functions_x.php");

function account_access($login, $password){
    $login = trim_input($login);
    $password = trim_input($password);

    $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE numer = '$login' AND haslo = '$password'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $id = $row['numer'];
        return $id;
    }
    else {
        $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE wlasciciel = '$login' AND haslo = '$password'";
        $result = db_statement($sql);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $id = $row['numer'];
            return $id;
        }
        else {
            $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE mail = '$login' AND haslo = '$password'";
            $result = db_statement($sql);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $id = $row['numer'];
                return $id;
            }
            else {
                return false;
            }
        }
    }
}

function print_bank_login($style){
    echo "
    <div class='login-form form-sleek'>";

    echo " <h1>Wejdź do swojego konta w Banku Gringotta</h1>
        <h1> Aby przejść dalej, wpisz hasło.</h1>
        <a href='/pokatna_x.php?cmd=create'><div class='button-acc'>NIE MAM KONTA!</div></a>
        <hr><br><br>
        ";
    echo "
    <form action='/pokatna_x.php' method='post'>";
    echo "
        <div class='error' style='$style'>";
    echo " Zaszła jakaś pomyłeczka. Spróbuj ponownie!";
    echo "
        </div>
        ";
    echo " Login <input type='text' name='login' placeholder='Numer/Nick/E-Mail'></input>";
    echo " Hasło <input type='password' name='password'</input>";
    echo " <input type='submit' value='Chcę wejść!'></input>";
    echo "
    </form>
    ";
    echo "
</div>";
}

function print_bank_register($style, $text){
    echo "
    <div class='login-form form-sleek'>";

    echo " <h1>Formularz rejestracji</h1>
        <hr><br><br>
        ";
    echo "
    <form action='/pokatna_x.php?cmd=create' method='post'>";
    echo "
        <div class='error' style='$style'>";
    echo $text."</div>";
    echo " Imię i nazwisko <input type='text' name='login' required></input>";
    echo " E-mail <input type='email' name='email' required></input>";
    echo " Hasło <input type='password' name='password' required></input>";
    echo " Powtórz hasło <input type='password' name='password_conf' required></input>";
    echo " Dom/funkcja <select name='dom'>
            <option value='' selected></option>
            <option value='Gryffindor'>Gryffindor</option>
            <option value='Hufflepuff'>Hufflepuff</option>
            <option value='Ravenclaw'>Ravenclaw</option>
            <option value='Slytherin'>Slytherin</option>
            <option value='Nauczyciel'>Nauczyciel</option>
            <option value='Inny'>Inny</option>
            </select>";
    echo " <input type='submit' value='Zarejestruj mnie!'></input>";
    echo "
    </form>
    ";
    echo "
</div>";

}

function print_sklep($sklep){
    $sklep = trim_input($sklep);
    $sql = "SELECT * FROM hpotter_bank_sklepy WHERE kategoria = $sklep";
    $result = db_statement($sql);

    if(mysqli_num_rows($result)>0){
        echo "<table class='full-width basic-table center-align'>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $nazwa = $row['nazwa'];
            $opis = $row['opis'];
            $zdjecie = $row['zdjecie'];
            $cena = $row['cena'];
            echo "<tr><td><img class='ramkens' src='$zdjecie'></td><td><p class='colored narrow bit-bigger'>$nazwa</p><p class='narrow bit-smaller'>$opis</p></td><td class='img-logo'><p class='narrow'>Cena: $cena galeonów</p>";
            $ile = item_possession($id, account_access($_SESSION['username'], $_SESSION['password']));
            if($ile > 0){
                echo "<p class='narrow emphasize'>Posiadasz: $ile</p>";
            }
            if(can_afford(account_access($_SESSION['username'], $_SESSION['password']), $cena)){
                echo "<a href='/pokatna_x.php?item=$id'><div class='button'>KUP</div></a>";
            }
            else{
                echo "<div class='button hasTooltip'>KUP<span>Za mało pieniędzy</span></div></a>";
            }

            echo "</tr>";
        }
        echo "</table>";
    }
}

function item_possession($item_id, $user_id){
    $sql = "SELECT COUNT(*) AS ile FROM hpotter_bank_przedmioty WHERE id_wlasciciela = $user_id AND id_przedmiotu = $item_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['ile'];
}

function can_afford($id, $cena){
    $konto = get_konto_of_id($id);
    $afford = ($konto >= $cena);
    return $afford;
}

function print_przedmioty_of($id){
    $id = trim_input($id);
    $sql = "SELECT id_przedmiotu FROM hpotter_bank_przedmioty WHERE id_wlasciciela = $id";
    $result = db_statement($sql);

    if(mysqli_num_rows($result)>0){
        echo "<table class='full-width basic-table center-align'>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id_przedmiotu'];
            $sql = "SELECT nazwa, zdjecie, cena FROM hpotter_bank_sklepy WHERE id=$id";
            $result_outcome = db_statement($sql);
            $outcome = mysqli_fetch_assoc($result_outcome);
            $nazwa = $outcome['nazwa'];
            $zdjecie = $outcome['zdjecie'];
            $cena = $outcome['cena'];
            echo "<tr><td><img class='ramkens adj-img' src='$zdjecie'></td><td><p class='colored narrow bit-bigger'>$nazwa</p><td class='img-logo'><p class='narrow'>Wartość: $cena galeonów</p></tr>";
        }
        echo "</table>";
    }
}

function print_my_account($id){
    $sql = "SELECT wlasciciel, konto FROM hpotter_bank_skrytki WHERE numer=$id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $wlasciciel = $row['wlasciciel'];
    $konto = $row['konto'];
    $majatek = get_majatek_of($id);
    echo "<footer>Zalogowano jako: <b>$wlasciciel</b> (numer konta: <b>$id</b>). Stan konta to <b>$konto</b> galeonów, a wartość przedmiotów wynosi <b>$majatek galeonów</b> (<i><a href='/pokatna_x.php?showid=$id'>zobacz kupione przedmioty</a></i>).</footer>";
}

function print_overfooter($text){
    echo "<div class='overfooter'>$text</div>";
}

function get_majatek_of($id){
    $sql = "SELECT sum(cena) AS majatek FROM hpotter_bank_przedmioty WHERE id_wlasciciela = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $majatek = $row['majatek'];
    if($majatek == "") $majatek = 0;
    return $majatek;
}

function get_konto_of_id($id){
    $sql = "SELECT konto FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $konto = $row['konto'];
    return $konto;
}

function get_nazwa_of_id($id){
    $sql = "SELECT nazwa FROM hpotter_bank_sklepy WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $nazwa = $row['nazwa'];
    return $nazwa;
}

function get_cena_of_id($id){
    $sql = "SELECT cena FROM hpotter_bank_sklepy WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $cena = $row['cena'];
    return $cena;
}

function buy_item($id_item, $id_user, $cena, $konto){
    $sql = "INSERT INTO hpotter_bank_przedmioty(id_wlasciciela, id_przedmiotu, cena) VALUES($id_user, $id_item, $cena)";
    db_statement($sql);
    $konto = $konto - $cena;
    $sql = "UPDATE hpotter_bank_skrytki SET konto = $konto WHERE numer = $id_user";
    db_statement($sql);
}

function print_majatek(){
    $sql = "SELECT numer, wlasciciel, konto, dom FROM hpotter_bank_skrytki";

    $result = db_statement($sql);
    echo "<form class='form-sleek' action='bank_x.php' method='post'> <table class='basic-table full-width center-align'>";
    echo "<tr><th>Imię i nazwisko</th>";
    if(users_is_root($_SESSION['username'], $_SESSION['password'])) echo "<th></th><th></th>";
    echo "<th>Funkcja</th><th class='no-wrap-fit'>Gotówka</th><th class='no-wrap-fit hasTooltip'>Przedmioty<span>Wartość przedmiotów</span></th><th class='hasTooltip no-wrap-fit'>Majątek<span>Całkowity majątek</span></th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['numer'];
        $wlasciciel = $row['wlasciciel'];
        $konto = $row['konto'];
        $dom = $row['dom'];
        $majatek = get_majatek_of($id);
        $calosc = $konto + $majatek;

        echo "<tr><td>$wlasciciel</td>";
        if(users_is_root($_SESSION['username'], $_SESSION['password'])) echo "<td><a href='/bank_x.php?id=$id'><div class='button-fitted'><span class='green-color bold'>Dodaj</span></div></a></td><td><input type='checkbox' name='dodajgal[]' value='$id'></td>";
        echo"<td>$dom</td><td>$konto&nbsp;gal.</td><td>$majatek&nbsp;gal.</td><td>$calosc&nbsp;gal.</td></tr>";
    }
    echo "</table>";
    if(users_is_root($_SESSION['username'], $_SESSION['password'])) echo "Ile galeonów<input type='text' name='ile'><input type='submit' value='Dodaj masowo galeony'>";
    echo "</form>";
}

function check_if_user_exists($name){
    $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE wlasciciel='$name'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) return false;
    else return true;
}

function check_if_mail_exists($mail){
    $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE mail='$mail'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) return false;
    else return true;
}

function add_account($login, $password, $email, $dom){
    $sql = "INSERT INTO hpotter_bank_skrytki(wlasciciel, haslo, mail, dom, konto, stan) VALUES('$login', '$password', '$email', '$dom', 200, 'ok')";
    db_statement($sql);
    $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE wlasciciel = '$login'";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $id = $row['numer'];
    $sql = "INSERT INTO hpotter_bank_skrytki_q(id) VALUES($id)";
    db_statement($sql);

    return $id;
}

function print_welcome_message($id){
    echo "<h2>Konto założone!</h2>
    <h3>Otrzymałaś/eś skrytkę o numerze <span class='colored bold'>$id</span>. (Nie musisz zapamiętywać tego numeru, ponieważ zalogować możesz się także przy użyciu imienia i nazwiska albo maila, które podałeś przy rejestracji</h3>
    <h2>Przelaliśmy na Twoje konto <span class='colored bold'>200</span> galeonów!</h2><br><br>
    <a href='pokatna_x.php'><h3>Przejdź do okna logowania >></h3></a>";
}

function print_dodaj_galeony($id){

    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) die;
    $wlasciciel = mysqli_fetch_assoc($result);
    $wlasciciel = $wlasciciel['wlasciciel'];

    echo "<h2>Dodaj galce!</h2>";
    echo "<div class='basic-form form-sleek'><form action='/bank_x.php' method='post'>";
    echo "Numer skrytki <input type='text' name='id' value='$id' required readonly></input>";
    echo "Właściciel <input type='text' name='wlasciciel' value='$wlasciciel' required readonly></input>";
    echo "Ilość galeonów <input type='text' name='galeony' required></input>";
    echo "<input type='submit' value='Dodaj galeony $wlasciciel' required></input></form></div>";
}

function dodaj_galeony($id, $galeony){

    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto + $galeony WHERE numer = $id";
    db_statement($sql);

}

