<?

require_once("./pokatnafunctions_x.php");
require_once("./logfunctions_x.php");

function simple_db_query($sql){
    include('db_config.php');

    $dbConnection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    mysqli_query($dbConnection, 'SET NAMES utf8');

    if (!$dbConnection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($dbConnection, $sql) or trigger_error(mysqli_error($dbConnection)." in ".$sql);
    return $result;
}

/*
 * FUNCKJE DOTYCZĄCE CZAR
 */

function zresetuj_czary($id){
    $sql = "UPDATE hpotter_bank_skrytki SET skapiec = 0, rozbojnik = 0, szczesciarz = 0, kupiec = 0, stroz = 0 WHERE numer = $id";
    db_statement($sql);
}

/*
 * FUNKCJE DOTYCZĄCE WYŚWIETLANIA KOLEKCJI FASOLEK
 */

function print_fasolka_state($user, $fasolka){
    $sql = "SELECT * FROM beans_owners WHERE fasolka = $fasolka AND skrytka = $user";
    $result = db_statement($sql);
    $sql = "SELECT smak, wartosc, obrazek FROM beans WHERE id = $fasolka";
    $outcome = db_statement($sql);
    $row = mysqli_fetch_assoc($outcome);
    $smak = $row['smak'];
    $wartosc = $row['wartosc'];
    $img = $row['obrazek'];
    if(mysqli_num_rows($result)>0){
        if($wartosc==1) $wartosc_text = "POSPOLITA";
        elseif($wartosc==2) $wartosc_text = "<span class='colored'>RZADKA</span>";
        elseif($wartosc==3) $wartosc_text = "<span class='rav'>UNIKATOWA</span>";
        elseif($wartosc==4) $wartosc_text = "<span class='huff'>LEGENDARNA</span>";
        elseif($wartosc==5) $wartosc_text = "<span class='gryff'>BEZCENNA</span>";

        echo "<p style='text-align: center;margin-top:10px;margin-bottom: 0px'>$fasolka</p><img src='$img' style='margin: 1px auto'><p class='center-align bit-bigger bold'>$wartosc_text</p><p class='bit-smaller narrow center-align'>Fasolka o smaku $smak";
        if(can_edit_name($fasolka)) echo " <a href='fasolka.php?cmd=edit&id=$fasolka'>(zmień smak)</a> ";
        echo "</p>";
    }
    else{
        if($wartosc==1) $wartosc_text = "<span style='color: #777'>POSPOLITA</span>";
        elseif($wartosc==2) $wartosc_text = "<span style='color: #777'>RZADKA</span>";
        elseif($wartosc==3) $wartosc_text = "<span style='color: #777'>UNIKATOWA</span>";
        elseif($wartosc==4) $wartosc_text = "<span style='color: #777'>LEGENDARNA</span>";
        elseif($wartosc==5) $wartosc_text = "<span style='color: #777'>BEZCENNA</span>";
        echo "<p style='text-align: center;margin-top:10px;margin-bottom: 0px'>$fasolka</p><img src='fasolki/0.png' style='margin: 1px auto'><p class='center-align bit-bigger bold'>$wartosc_text</p><p class='bit-smaller narrow center-align' style='color: #888'>Fasolka o smaku $smak</p>";
    }
}

function ile_fasolek_na_koncie($user){
    $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

/*
 * FUNKCJE DOTYCZĄCE SKUPU
 */

function print_fasolka_duplicate($fasolka, $amount)
{

    $sql = "SELECT smak, wartosc, obrazek FROM beans WHERE id = $fasolka";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $smak = $row['smak'];
    $wartosc = $row['wartosc'];
    $img = $row['obrazek'];
    if ($wartosc == 1) {
        if(happy_hours_noon()) $wartosc_text = "Sprzedaj za 2 galeony";
        else $wartosc_text = "Sprzedaj za 1 galeon";
    }
    elseif ($wartosc == 2) $wartosc_text = "<span class='colored'>Sprzedaj za 10 galeonów</span>";
    elseif ($wartosc == 3) $wartosc_text = "<span class='rav'>Sprzedaj za 100 galeonów</span>";
    elseif ($wartosc == 4) $wartosc_text = "<span class='huff'>Sprzedaj za 1 000 galeonów</span>";
    elseif ($wartosc == 5) $wartosc_text = "<span class='gryff'>Sprzedaj za 2 000 galeonów</span>";

    echo "<p style='text-align: center;margin-top:10px;margin-bottom: 0px'>$fasolka</p><img src='$img' style='margin: 1px auto'><p class='center-align bold'>$wartosc_text</p><p class='bit-smaller narrow center-align'>Fasolka o smaku $smak</p>";
}

/*
 * FUNKCJE OGÓLNE
 */

function dodaj_exp($id, $ile){
    $sql = "UPDATE hpotter_bank_skrytki SET dodexp = dodexp + $ile WHERE numer = $id";
    db_statement($sql);
    refresh_rank($id);
}

/*
 * FUNKCJE DOTYCZĄCE LOSOWANIA
 */

function change_konto($id, $ile){
    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto + $ile WHERE numer = $id";
    simple_db_query($sql);
    return true;
}

function change_freebeans($id, $ile){
    $sql = "UPDATE hpotter_bank_skrytki_q SET freebeans = freebeans + $ile WHERE id = $id";
    simple_db_query($sql);
    return true;
}

function pojedyncze_losowanie_fasolki($user, $prob_array, $cena_fasolki){
    $unik_thres = ceil($prob_array[0] * 200);
    $rzad_thres = $unik_thres + ceil($prob_array[1] * 200);
    $los = rand(1, 200);
    if($los <= $unik_thres){
        $sql = "SELECT id, smak, wartosc, obrazek FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
        $result = simple_db_query($sql);
        $row = mysqli_fetch_assoc($result);
    }
    elseif($los <= $rzad_thres){
        $sql = "SELECT id, smak, wartosc, obrazek FROM beans WHERE wartosc = 2 ORDER BY RAND() LIMIT 1";
        $result = simple_db_query($sql);
        $row = mysqli_fetch_assoc($result);
    }
    else{
        $sql = "SELECT id, smak, wartosc, obrazek FROM beans WHERE wartosc = 1 ORDER BY RAND() LIMIT 1";
        $result = simple_db_query($sql);
        $row = mysqli_fetch_assoc($result);
    }
    $fasolka = $row['id'];
    $sql = "INSERT INTO beans_owners(skrytka, fasolka) VALUES($user, $fasolka)";
    simple_db_query($sql);
    $sql = "UPDATE hpotter_bank_skrytki SET wydano = wydano + $cena_fasolki, suma = suma + 1 WHERE numer = $user";
    simple_db_query($sql);
    if (time_between()) {
        $sql = "UPDATE hpotter_bank_skrytki SET noc = noc + 1 WHERE numer = $user";
        simple_db_query($sql);
    }
    return $row;
}

function get_bonus_threshold($id){
    $sql = "SELECT szczesciarz FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $szczesciarz = $row['szczesciarz'];
    if(happy_hours_night()) $bonus = 10;
    else $bonus = 0;
    $szansa = 10 * (szczesciarz_pts($szczesciarz) + $bonus);
    return $szansa;
}

function bonusowa_fasolka($id){
    $szansa = get_bonus_threshold($id);
    $los = rand(1,1000);
    if($los <= $szansa){
        $row = pojedyncze_losowanie_fasolki($id, [0.005, 0.195], 0);
        quest_add($id, 'doubles', 1);
        return $row;
    }
    else return false;
}

function czy_sa_bileciki($id, $mode){
    $sql = "SELECT $mode FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    if($row[$mode] <= 0) return false;
    else{
        $sql = "UPDATE hpotter_bank_skrytki SET $mode = $mode - 1, ".$mode."u = ".$mode."u + 1 WHERE numer = $id";
        simple_db_query($sql);
        return true;
    }
}

function losuj_fasolki($id, $mode){
    $fasolki = array();
    $nasionka = array();
    if($mode == 'regular'){
        $konto = get_konto_of_id($id);
        if($konto < -95){
            $fasolki = [];
            $nasionka = [];
        }
        else{
            $fasolki[] = pojedyncze_losowanie_fasolki($id, [0.005, 0.195], 5);
            change_konto($id, -5);
            $bonusowa = bonusowa_fasolka($id);
            if($bonusowa) $fasolki[] = $bonusowa;
            $nasionko_pot = losuj_nasionko($id);
            if($nasionko_pot != 0) $nasionka[] = $nasionko_pot;
        }
        return array($fasolki, $nasionka);
    }
    elseif($mode == 'bonus'){
        if(czy_sa_darmowe($id) == 1){
            $fasolki[] = pojedyncze_losowanie_fasolki($id, [0.005, 0.195], 0);
            $bonusowa = bonusowa_fasolka($id);
            if($bonusowa) $fasolki[] = $bonusowa;
            $nasionko_pot = losuj_nasionko($id);
            if($nasionko_pot != 0) $nasionka[] = $nasionko_pot;
        }
        else{
            $fasolki = [];
            $nasionka = [];
        }
        return array($fasolki, $nasionka);
    }
    elseif($mode == 'bronze'){
        if(czy_sa_bileciki($id, $mode)){
            for($i = 1; $i <= 10; $i = $i + 1){
                $fasolki[] = pojedyncze_losowanie_fasolki($id, [0.02, 0.38], 0);
                $bonusowa = bonusowa_fasolka($id);
                if($bonusowa) $fasolki[] = $bonusowa;
                $nasionko_pot = losuj_nasionko($id);
                if($nasionko_pot != 0) $nasionka[] = $nasionko_pot;
            }
        }
        else{
            $fasolki = [];
            $nasionka = [];
        }
        return array($fasolki, $nasionka);
    }
    elseif($mode == 'silver'){
        if(czy_sa_bileciki($id, $mode)){
            for($i = 1; $i <= 20; $i = $i + 1){
                $fasolki[] = pojedyncze_losowanie_fasolki($id, [0.08, 0.42], 0);
                $bonusowa = bonusowa_fasolka($id);
                if($bonusowa) $fasolki[] = $bonusowa;
                $nasionko_pot = losuj_nasionko($id);
                if($nasionko_pot != 0) $nasionka[] = $nasionko_pot;
            }
        }
        else{
            $fasolki = [];
            $nasionka = [];
        }
        return array($fasolki, $nasionka);
    }
    elseif($mode == 'golden'){
        if(czy_sa_bileciki($id, $mode)){
            for($i = 1; $i <= 30; $i = $i + 1){
                $fasolki[] = pojedyncze_losowanie_fasolki($id, [0.08, 0.82], 0);
                $bonusowa = bonusowa_fasolka($id);
                if($bonusowa) $fasolki[] = $bonusowa;
                $nasionko_pot = losuj_nasionko($id);
                if($nasionko_pot != 0) $nasionka[] = $nasionko_pot;
            }
        }
        else{
            $fasolki = [];
            $nasionka = [];
        }
        return array($fasolki, $nasionka);
    }
    else{
        return false;
    }
}

function losuj_fasolke($id, $bonus = 0){

    $konto = get_konto_of_id($id);
    if(($konto < -95) && ($bonus == 0)) return 0;

    $rand = rand(1, 200);
    if($rand < 161){
        echo "<h1>Wylosowałas/eś <span class='colored'>pospolitą</span> fasolkę</h1>";
        $sql = "SELECT id, smak FROM beans WHERE wartosc = 1 ORDER BY RAND() LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
    }
    elseif($rand < 200){
        echo "<h1>Wylosowałas/eś <span class='colored'>rzadką</span> fasolkę</h1>";
        $sql = "SELECT id, smak FROM beans WHERE wartosc = 2 ORDER BY RAND() LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
    }
    else{
        echo "<h1>Wylosowałas/eś <span class='colored'>unikatową</span> fasolkę</h1>";
        $sql = "SELECT id, smak FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
    }
    return $id;
}

function losuj_dodatkowa_fasolke($id){

    $sql = "SELECT szczesciarz FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $szczesciarz = $row['szczesciarz'];
    if(happy_hours_night()) $bonus = 10;
    else $bonus = 0;
    $szansa = 10 * (szczesciarz_pts($szczesciarz) + $bonus);
    $los = rand(1,1000);
    if($los <= $szansa){
        $rand = rand(1, 200);
        if($rand < 161){
            echo "<h1>Wylosowałas/eś <span class='colored'>pospolitą</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 1 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        elseif($rand < 200){
            echo "<h1>Wylosowałas/eś <span class='colored'>rzadką</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 2 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        else{
            echo "<h1>Wylosowałas/eś <span class='colored'>unikatową</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        return $id;
    }
    else{
        return 0;
    }
}

function dodaj_fasolke_do_kolekcji($user, $fasolka, $bonus = 0){
    if($bonus == 0) {
        $cena_fasolki = 5;
    }
    else $cena_fasolki = 0;

    $sql = "INSERT INTO beans_owners(skrytka, fasolka) VALUES($user, $fasolka)";
    db_statement($sql);
    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto - $cena_fasolki, wydano = wydano + $cena_fasolki, suma = suma + 1 WHERE numer = $user";
    db_statement($sql);
    if (time_between()) {
        $sql = "UPDATE hpotter_bank_skrytki SET noc = noc + 1 WHERE numer = $user";
        db_statement($sql);
    }
}

function ile_wydal($user){
    $sql = "SELECT wydano FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['wydano'];
}

function ile_wszystkich_fasolek(){
    $sql = "SELECT id FROM beans";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_nocnych_wszystkich_fasolek($user){
    return return_one_row('noc', 'hpotter_bank_skrytki', 'numer', $user);
}

function ile_znalezionych_fasolek($user){
    $sql = "SELECT suma FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['suma'];
}

function za_ile_sprzedano($user){
    $sql = "SELECT skup FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['skup'];
}

function ile_uzytych_brazowych($user){
    $sql = "SELECT bronzeu FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['bronzeu'];
}

function ile_uzytych_srebrnych($user){
//    $sql = "SELECT silveru FROM hpotter_bank_skrytki WHERE numer = $user";
//    $result = db_statement($sql);
//    $row = mysqli_fetch_assoc($result);
//    return $row['silveru'];
    return return_one_row('silveru', 'hpotter_bank_skrytki', 'numer', $user);
}

function ile_uzytych_zlotych($user){
    $sql = "SELECT goldenu FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['goldenu'];
}

function ile_brazowych($user){
    $sql = "SELECT bronze FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['bronze'];
}

function ile_srebrnych($user){
    $sql = "SELECT silver FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['silver'];
}

function ile_zlotych($user){
    $sql = "SELECT golden FROM hpotter_bank_skrytki WHERE numer = $user";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['golden'];
}

function ile_pospolitych_fasolek($user = 0){
    if($user == 0) $sql = "SELECT id FROM beans WHERE wartosc = 1";
    else $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user AND fasolka IN (SELECT id FROM beans WHERE wartosc = 1)";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_rzadkich_fasolek($user = 0){
    if($user == 0) $sql = "SELECT id FROM beans WHERE wartosc = 2";
    else $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user AND fasolka IN (SELECT id FROM beans WHERE wartosc = 2)";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_unikatowych_fasolek($user = 0){
    if($user == 0) $sql = "SELECT id FROM beans WHERE wartosc = 3";
    else $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user AND fasolka IN (SELECT id FROM beans WHERE wartosc = 3)";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_legendarnych_fasolek($user = 0){
    if($user == 0) $sql = "SELECT id FROM beans WHERE wartosc = 4";
    else $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user AND fasolka IN (SELECT id FROM beans WHERE wartosc = 4)";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_bezcennych_fasolek($user = 0){
    if($user == 0) $sql = "SELECT id FROM beans WHERE wartosc = 5";
    else $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user AND fasolka IN (SELECT id FROM beans WHERE wartosc = 5)";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_z_grupy($grupa, $user = 0){
    if($user == 0) $sql = "SELECT fasolka FROM beans_groups WHERE grupa = '$grupa'";
    else $sql = "SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $user AND fasolka IN (SELECT fasolka FROM beans_groups WHERE grupa = '$grupa')";
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function ile_w_ciagu($kiedy, $user){
    if($kiedy == 'godzina'){
        $sql = "SELECT id FROM beans_owners WHERE skrytka = $user AND data >= NOW() - INTERVAL 60 MINUTE";
    }
    else {
        $sql = "SELECT id FROM beans_owners WHERE skrytka = $user AND data >= NOW() - INTERVAL 30 MINUTE";
    }
    $result = db_statement($sql);
    return mysqli_num_rows($result);
}

function czy_nowa_fasolka($user, $fasolka){
    $sql = "SELECT id FROM beans_owners WHERE fasolka = $fasolka AND skrytka = $user";
    $result = db_statement($sql);
    return (mysqli_num_rows($result)==1);
}

function add_to_rank($user, $fasolka){
    $sql = "SELECT wartosc FROM beans WHERE id = $fasolka";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $wartosc = $row['wartosc'];
    if($wartosc==1){$pkt = 1;}
    elseif($wartosc==2){$pkt = 10;}
    elseif($wartosc==3){$pkt = 1000;}
    elseif($wartosc==4){$pkt = 2000;}
    elseif($wartosc==5){$pkt = 5000;}
    $sql = "UPDATE hpotter_bank_skrytki SET rank = rank + $pkt WHERE numer = $user";
    db_statement($sql);
}

function return_ranking($user){
    $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE rank > 0 AND numer <> 8 ORDER BY rank DESC";
    $i = 1;
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $numer = $row['numer'];
        if($numer == $user) return $i;
        $i = $i + 1;
    }
    return "niesklasyfikowano";
}

function time_between(){
    $current_time = strtotime(date('H:i'));
    $begin = strtotime("23:00");
    $end = strtotime("5:00");
    if ($current_time >= $begin || $current_time <= $end)
    {
        return true;
    }
    return false;
}

function happy_hours_night(){
    $current_time = strtotime(date('H:i'));
    $begin = strtotime("22:00");
    $end = strtotime("3:59");
    if ($current_time >= $begin || $current_time <= $end)
    {
        return true;
    }
    return false;
}

function happy_hours_morning(){
    $current_time = strtotime(date('H:i'));
    $begin = strtotime("4:00");
    $end = strtotime("9:59");
    if ($current_time >= $begin && $current_time <= $end)
    {
        return true;
    }
    return false;
}

function happy_hours_noon(){
    $current_time = strtotime(date('H:i'));
    $begin = strtotime("10:00");
    $end = strtotime("15:59");
    if ($current_time >= $begin && $current_time <= $end)
    {
        return true;
    }
    return false;
}


function realizuj_bilecik($rodzaj, $id){

    $rand = rand(1, 200);
    if($rodzaj == 'bronze'){
        $sql = "SELECT bronze FROM hpotter_bank_skrytki WHERE numer = $id";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $numer = $row['bronze'];
        if($numer <= 0) return 0;

        if($rand < 200){
            echo "<h1>Wylosowałas/eś <span class='colored'>rzadką</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 2 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        else{
            echo "<h1>Wylosowałas/eś <span class='colored'>unikatową</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
    }

    elseif($rodzaj == 'silver'){
        $sql = "SELECT silver FROM hpotter_bank_skrytki WHERE numer = $id";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $numer = $row['silver'];
        if($numer <= 0) return 0;

        if($rand < 101){
            echo "<h1>Wylosowałas/eś <span class='colored'>rzadką</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 2 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        else{
            echo "<h1>Wylosowałas/eś <span class='colored'>unikatową</span> fasolkę</h1>";
            $sql = "SELECT id, smak FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
    }

    else{
        $sql = "SELECT golden FROM hpotter_bank_skrytki WHERE numer = $id";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $numer = $row['golden'];
        if($numer <= 0) return 0;

        echo "<h1>Wylosowałas/eś <span class='colored'>unikatową</span> fasolkę</h1>";
        $sql = "SELECT id, smak FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
    }

    return $id;
}

function give_bilecik($id, $how_many, $type){
    $sql = "UPDATE hpotter_bank_skrytki SET $type = $type + $how_many WHERE numer = $id";
    simple_db_query($sql);
}

function is_quest_complete($user, $quest){
    $sql = "SELECT * FROM beans_quests WHERE skrytka = $user AND quest = $quest";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) return true;
    else return false;
}

function print_fasolka_recent(){
    $sql = "SELECT DISTINCT(skrytka) FROM beans_owners WHERE data >= NOW() - INTERVAL 1 DAY";
    $result = db_statement($sql);
    $ile_graczy = mysqli_num_rows($result);
    $sql = "SELECT id FROM beans_owners WHERE data >= NOW() - INTERVAL 1 DAY";
    $result = db_statement($sql);
    $ile_fasolek = mysqli_num_rows($result);
    $sql = "SELECT id FROM beans_owners WHERE data >= NOW() - INTERVAL 1 DAY AND fasolka IN (SELECT id FROM beans WHERE wartosc = 3)";
    $result = db_statement($sql);
    $ile_unikatowych = mysqli_num_rows($result);
    echo "<span class='colored bit-bigger bold'>".$ile_graczy."</span> graczy wylosowało <span class='colored bit-bigger bold'>".$ile_fasolek."</span> fasolek, w tym <span class='colored bit-bigger bold'>".$ile_unikatowych."</span> unikatowych";
}

function print_fasolka_top_5(){

    $sql = "SELECT wlasciciel, rank FROM hpotter_bank_skrytki WHERE rank > 0 ORDER BY rank DESC LIMIT 5";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $wlasciciel = $row['wlasciciel'];
        $rank = $row['rank'];
        echo "<p class='narrow'>".$wlasciciel." <span class='colored bit-bigger bold'>".$rank."</span>   pkt</p>";
    }
}

function print_last_unikat(){

    $sql = "SELECT fasolka, skrytka, data FROM beans_owners WHERE fasolka IN (SELECT id FROM beans WHERE wartosc = 3) ORDER BY data DESC LIMIT 1";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $fasolka = $row['fasolka'];
    $skrytka = $row['skrytka'];
    $data = $row['data'];

    $sql = "SELECT smak FROM beans WHERE id = $fasolka";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $smak = $row['smak'];

    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $skrytka";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $wlasciciel = $row['wlasciciel'];

    echo "<p>
                <span class=\"colored bit-bigger bold\">".time_description($data)."</span> znaleziono unikatową fasolkę o smaku <span class=\"colored bit-bigger bold\">$smak</span>! Gratulacje dla <span class=\"colored bit-bigger bold\">$wlasciciel</span>
            </p>";
}

function print_last_kradziez(){
    $sql = "SELECT tresc, data FROM beans_log ORDER BY data DESC LIMIT 1";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $tresc = $row['tresc'];
    $data = $row['data'];
    echo "<p><span class='colored bit-bigger bold'>".time_description($data)."</span> $tresc";
}

function theft_prob($id){
    $sql = "SELECT kradziez FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $kradziez = $row['kradziez'];

    $now = time(); // or your date as well
    $your_date = strtotime($kradziez);
    $datediff = $now - $your_date;
    $ile_godzin = $datediff/(60*60);

    if($ile_godzin > 1) $ile_godzin = 1;
    return round((10 * $ile_godzin), 2);
}

function theft_bonus($id){
    $sql = "SELECT kradziez FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $kradziez = $row['kradziez'];

    $now = time(); // or your date as well
    $your_date = strtotime($kradziez);
    $datediff = $now - $your_date;
    $ile_kwadransow = $datediff/(30*60);
    $ile_kwadransow = (0.9*$ile_kwadransow + 0.1);
    if($ile_kwadransow > 1) $ile_kwadransow = 1;

    $sql = "SELECT rozbojnik FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $rozbojnik = $row['rozbojnik'];
    if($rozbojnik < 7) return round($ile_kwadransow*3*$rozbojnik,2);
    elseif($rozbojnik == 7) return round($ile_kwadransow*25,2);
    elseif($rozbojnik == 8) return round($ile_kwadransow*40,2);
    elseif($rozbojnik == 9) return round($ile_kwadransow*60,2);
    else return round($ile_kwadransow*80,2);
}

function theft_def_bonus($id){
    $sql = "SELECT stroz FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $rozbojnik = $row['stroz'];

    if($rozbojnik < 7) return 3 * $rozbojnik;
    elseif($rozbojnik == 7) return 25;
    elseif($rozbojnik == 8) return 40;
    elseif($rozbojnik == 9) return 60;
    else return 80;
}

function losuj_kradziez($id, $atak){
    $base = theft_prob($id);
    $bonus = theft_bonus($id);
    $def = theft_def_bonus($atak);
    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $atak";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $od_wlasciciel = $row['wlasciciel'];

    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $do_wlasciciel = $row['wlasciciel'];

    $total = $base + $bonus - $def;
    if($total < 0) $total = 0;

    $threshold = floor($total * 10);
    $los = rand(1, 1000);

    if($los < $threshold){
        $sql = "SELECT id, fasolka FROM beans_owners WHERE skrytka = $atak ORDER BY RAND() LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $target = $row['id'];
        $fasolka = $row['fasolka'];

        $sql = "SELECT wartosc, smak FROM beans WHERE id = $fasolka";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $wartosc = $row['wartosc'];
        $smak = $row['smak'];
        if($wartosc == 1){
            $los_2 = rand(1,100);
            if(($los_2 <= 90) || (get_konto_of_id($id) < 5)){
                $sql = "UPDATE beans_owners SET skrytka = $id WHERE id = $target";
                db_statement($sql);
                $tekst = "ktoś skradł $od_wlasciciel pospolitą fasolkę o smaku $smak";
                quest_add($id, 'stolenbeans', 1);
                quest_add($atak, 'theftvictim', 1);
            }
            else{
                $tekst = przekaz_hajs($id, $atak, 5);
                $target = 0;
            }
        }
        elseif($wartosc == 2){
            $los_2 = rand(1,100);
            if(($los_2 <= 40) || (get_konto_of_id($id)<10)){
                $sql = "UPDATE beans_owners SET skrytka = $id WHERE id = $target";
                db_statement($sql);
                $tekst = "ktoś skradł $od_wlasciciel rzadką fasolkę o smaku $smak";
                quest_add($id, 'stolenbeans', 1);
                quest_add($atak, 'theftvictim', 1);
            }
            else{
                $tekst = przekaz_hajs($id, $atak, 10);
                $target = 0;
            }
        }
        elseif($wartosc == 3){
            $los_2 = rand(1,100);
            if(($los_2 <= 1) || (get_konto_of_id($id) < 20)){
                $sql = "UPDATE beans_owners SET skrytka = $id WHERE id = $target";
                db_statement($sql);
                $tekst = "ktoś skradł $od_wlasciciel unikatową fasolkę o smaku $smak";
                quest_add($id, 'stolenbeans', 1);
                quest_add($atak, 'theftvictim', 1);
            }
            else{
                $tekst = przekaz_hajs($id, $atak, 20);
                $target = 0;
            }
        }
        else{
            if(get_konto_of_id($id) >= 30){
                $tekst = przekaz_hajs($id, $atak, 30);
                $target = 0;
            }
            else{
                $tekst = "$od_wlasciciel był(a) celem złodzieja, ale na szczęście nic nie zniknęło";
                quest_add($id, 'failedthefts', 1);
            }
        }
        $sql = "INSERT INTO beans_log(tresc, ofiara, zlodziej, target) VALUES('$tekst', $atak, $id, $target)";
        db_statement($sql);
    }
    else {
        $tekst = "Nieudana";
        quest_add($id, 'failedthefts', 1);
    }
    return $tekst;
}

function przekaz_hajs($do, $od, $limit = 0, $ile = 0){
    if($ile == 0){
        $ile = rand(1, $limit);
    }

    $sql = "SELECT konto FROM hpotter_bank_skrytki WHERE numer = $od";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $konto = $row['konto'];

    if($ile > $konto) $ile = 1;
    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto - $ile WHERE numer = $od";
    db_statement($sql);

    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto + $ile WHERE numer = $do";
    db_statement($sql);

    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $od";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $od_wlasciciel = $row['wlasciciel'];

    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $do";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    quest_add($do, 'stolenmoney', $ile);
    quest_add($od, 'theftvictim', 1);

    return "ktoś skradł $od_wlasciciel $ile galeonów";
}

function refresh_rank($id){
    $sql = "SELECT wartosc FROM beans WHERE id IN (SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $id)";
    $result = db_statement($sql);
    $rank = 0;
    while($row = mysqli_fetch_assoc($result)){
        $wartosc = $row['wartosc'];
        if($wartosc==1){$pkt = 1;}
        elseif($wartosc==2){$pkt = 10;}
        elseif($wartosc==3){$pkt = 1000;}
        elseif($wartosc==4){$pkt = 2000;}
        elseif($wartosc==5){$pkt = 4000;}
        $rank = $rank + $pkt;
    }
    $sql = "SELECT suma, dodexp FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $suma = $row['suma'];
    $dodexp = $row['dodexp'];
    $rank = $rank + $suma + $dodexp;
    $sql = "UPDATE hpotter_bank_skrytki SET rank = $rank WHERE numer = $id";
    db_statement($sql);
}

function something_new_feed($id){
    $sql = "SELECT tresc FROM beans_log WHERE ofiara = $id AND showed = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) return true;
    else return false;
}

function feed_kradziez($id){
    $sql = "SELECT tresc FROM beans_log WHERE ofiara = $id AND showed = 0";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $tresc = $row['tresc'];
        echo "<p>$tresc</p>";
    }
}

function update_feed($id){
    $sql = "UPDATE beans_log SET showed = 1 WHERE ofiara = $id";
    db_statement($sql);
}

function skapiec_pts($lvl){
    if($lvl == 0) return 0;
    elseif($lvl == 1) return 1;
    elseif($lvl == 2) return 2;
    elseif($lvl == 3) return 3;
    elseif($lvl == 4) return 4;
    elseif($lvl == 5) return 5;
    elseif($lvl == 6) return 6;
    elseif($lvl == 7) return 7;
    elseif($lvl == 8) return 8;
    elseif($lvl == 9) return 10;
    else return 15;
}

function szczesciarz_pts($lvl){
    if($lvl <= 3) return $lvl;
    elseif($lvl == 4) return 5;
    elseif($lvl == 5) return 7;
    elseif($lvl == 6) return 10;
    elseif($lvl == 7) return 12;
    elseif($lvl == 8) return 15;
    elseif($lvl == 9) return 20;
    else return 30;
}

function stroz_pts($lvl){
    if($lvl <= 6) return 3 * $lvl;
    elseif($lvl == 7) return 25;
    elseif($lvl == 8) return 40;
    elseif($lvl == 9) return 65;
    else return 80;
}

function kupiec_pts($lvl){
    if($lvl == 0) return 0;
    elseif($lvl <= 6) return $lvl;
    elseif($lvl == 7) return 7;
    elseif($lvl == 8) return 10;
    elseif($lvl == 9) return 20;
    elseif($lvl == 10) return 30;
}

function rozbojnik_pts($lvl){
    if($lvl <= 6) return 3*$lvl;
    elseif($lvl == 7) return 25;
    elseif($lvl == 8) return 40;
    elseif($lvl == 9) return 60;
    else return 80;
}

function next_lvl_cost($sum){
    $cost = 100;
    while($sum > 0){
        $cost = 1.15 * $cost;
        $cost = floor($cost);
        $sum = $sum - 1;
    }
    return $cost;
}

function cost_to_this_lvl($sum){
    $cost = 100;
    $total_cost = 0;
    while($sum > 0){
        $total_cost = $total_cost + $cost;
        $cost = 1.15 * $cost;
        $cost = floor($cost);
        $sum = $sum - 1;
    }
    return $total_cost;
}

function level_up($co, $kto, $za_ile){
    $sql = "UPDATE hpotter_bank_skrytki SET ".$co." = ".$co." + 1, konto = konto - $za_ile WHERE numer = $kto";
    db_statement($sql);
}

function skup_bonus($suma, $kto){
    $sql = "SELECT kupiec FROM hpotter_bank_skrytki WHERE numer = $kto";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $kupiec = $row['kupiec'];
    $procent = (kupiec_pts($kupiec)) / 100;
    $bonus = ceil($procent * $suma);
    return $bonus;
}

function hajs_z_czary($kto){
    $sql = "SELECT konto, skapiec, skapiecdata FROM hpotter_bank_skrytki WHERE numer = $kto";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $skapiec = $row['skapiec'];
    $konto = $row['konto'];
    $skapiecdata = $row['skapiecdata'];
    $bonus = ceil(((skapiec_pts($skapiec)) / 100) * $konto);
    if($bonus > 500) $bonus = 500;
    if($bonus < 0) $bonus = 1;
    $today = date('Y-m-d'); // or your date as well
    $your_date = strtotime($skapiecdata);
    $your_date = date('Y-m-d', $your_date);
    if($today != $your_date){
        $sql = "UPDATE hpotter_bank_skrytki SET konto = konto + $bonus, skapiecdata = CURRENT_TIMESTAMP WHERE numer = $kto";
        db_statement($sql);
        quest_add($kto, 'fromskapiec', $bonus);
        return "Wyciągnęłaś/ąłeś $bonus galeonów z czary!";

    }
    else{
        return "Za wcześnie na nagrodę z czary!";
    }


}

function quest_add($id, $kolumna, $ilosc){
    $sql = "UPDATE hpotter_bank_skrytki_q SET ".$kolumna." = ".$kolumna." + $ilosc WHERE id = $id";
    db_statement($sql);
}

function from_quest_db($id, $what){
    $sql = "SELECT ".$what." FROM hpotter_bank_skrytki_q WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_row($result);
    return $row[0];
}

function level_exp($id){
    $sql = "SELECT rank FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $exp = $row['rank'];

    if($exp < 100){
        $lvl = 1;
        $remaining = 100 - ($exp);
        $progress = 100 - round(100* ($remaining / 100), 1);
    }
    elseif($exp < 300){
        $lvl = 2;
        $remaining = 200 - ($exp - 100);
        $progress = 100 - round(100* ($remaining / 200), 1);
    }
    elseif($exp < 600){
        $lvl = 3;
        $remaining = 300 - ($exp - 300);
        $progress = 100 - round(100* ($remaining / 300), 1);
    }
    elseif($exp < 1000){
        $lvl = 4;
        $remaining = 400 - ($exp - 600);
        $progress = 100 - round(100* ($remaining / 400), 1);
    }
    elseif($exp < 1500){
        $lvl = 5;
        $remaining = 500 - ($exp - 1000);
        $progress = 100 - round(100* ($remaining / 500), 1);
    }
    elseif($exp < 2100){
        $lvl = 6;
        $remaining = 600 - ($exp - 1500);
        $progress = 100 - round(100* ($remaining / 600), 1);
    }
    elseif($exp < 2800){
        $lvl = 7;
        $remaining = 700 - ($exp - 2100);
        $progress = 100 - round(100* ($remaining / 700), 1);
    }
    elseif($exp < 3600){
        $lvl = 8;
        $remaining = 800 - ($exp - 2800);
        $progress = 100 - round(100* ($remaining / 800), 1);
    }
    elseif($exp < 4600){
        $lvl = 9;
        $remaining = 1000 - ($exp - 3600);
        $progress = 100 - round(100* ($remaining / 1000), 1);
    }
    elseif($exp < 5800){
        $lvl = 10;
        $remaining = 1200 - ($exp - 4600);
        $progress = 100 - round(100* ($remaining / 1200), 1);
    }
    elseif($exp < 7200){
        $lvl = 11;
        $remaining = 1400 - ($exp - 5800);
        $progress = 100 - round(100* ($remaining / 1400), 1);
    }
    elseif($exp < 8900){
        $lvl = 12;
        $remaining = 1700 - ($exp - 7200);
        $progress = 100 - round(100* ($remaining / 1700), 1);
    }
    elseif($exp < 10900){
        $lvl = 13;
        $remaining = 2000 - ($exp - 8900);
        $progress = 100 - round(100* ($remaining / 2000), 1);
    }
    elseif($exp < 13300){
        $lvl = 14;
        $remaining = 2400 - ($exp - 10900);
        $progress = 100 - round(100* ($remaining / 2400), 1);
    }
    elseif($exp < 16200){
        $lvl = 15;
        $remaining = 2900 - ($exp - 13300);
        $progress = 100 - round(100* ($remaining / 2900), 1);
    }
    elseif($exp < 19700){
        $lvl = 16;
        $remaining = 3500 - ($exp - 16200);
        $progress = 100 - round(100* ($remaining / 3500), 1);
    }
    elseif($exp < 23900){
        $lvl = 17;
        $remaining = 4200 - ($exp - 19700);
        $progress = 100 - round(100* ($remaining / 4200), 1);
    }
    elseif($exp < 28900){
        $lvl = 18;
        $remaining = 5000 - ($exp - 23900);
        $progress = 100 - round(100* ($remaining / 5000), 1);
    }
    elseif($exp < 34900){
        $lvl = 19;
        $remaining = 6000 - ($exp - 28900);
        $progress = 100 - round(100* ($remaining / 6000), 1);
    }
    elseif($exp < 42100){
        $lvl = 20;
        $remaining = 7200 - ($exp - 34900);
        $progress = 100 - round(100* ($remaining / 7200), 1);
    }
    elseif($exp < 50700){
        $lvl = 21;
        $remaining = 8600 - ($exp - 42100);
        $progress = 100 - round(100* ($remaining / 8600), 1);
    }
    elseif($exp < 61000){
        $lvl = 22;
        $remaining = 10300 - ($exp - 50700);
        $progress = 100 - round(100* ($remaining / 10300), 1);
    }
    elseif($exp < 73400){
        $lvl = 23;
        $remaining = 12400 - ($exp - 61000);
        $progress = 100 - round(100* ($remaining / 12400), 1);
    }
    elseif($exp < 88300){
        $lvl = 24;
        $remaining = 14900 - ($exp - 73400);
        $progress = 100 - round(100* ($remaining / 14900), 1);
    }
    elseif($exp < 106200){
        $lvl = 25;
        $remaining = 17900 - ($exp - 88300);
        $progress = 100 - round(100* ($remaining / 17900), 1);
    }
    elseif($exp < 127600){
        $lvl = 26;
        $remaining = 21400 - ($exp - 106200);
        $progress = 100 - round(100* ($remaining / 21400), 1);
    }
    elseif($exp < 153300){
        $lvl = 27;
        $remaining = 25700 - ($exp - 127600);
        $progress = 100 - round(100* ($remaining / 25700), 1);
    }
    elseif($exp < 184200){
        $lvl = 28;
        $remaining = 30900 - ($exp - 153300);
        $progress = 100 - round(100* ($remaining / 30900), 1);
    }
    elseif($exp < 221200){
        $lvl = 29;
        $remaining = 37000 - ($exp - 184200);
        $progress = 100 - round(100* ($remaining / 37000), 1);
    }
    elseif($exp < 265600){
        $lvl = 30;
        $remaining = 44400 - ($exp - 221200);
        $progress = 100 - round(100* ($remaining / 44400), 1);
    }
    elseif($exp < 318900){
        $lvl = 31;
        $remaining = 53300 - ($exp - 265600);
        $progress = 100 - round(100* ($remaining / 53300), 1);
    }
    elseif($exp < 382900){
        $lvl = 32;
        $remaining = 64000 - ($exp - 318900);
        $progress = 100 - round(100* ($remaining / 64000), 1);
    }
    elseif($exp < 459700){
        $lvl = 33;
        $remaining = 76800 - ($exp - 382900);
        $progress = 100 - round(100* ($remaining / 76800), 1);
    }
    elseif($exp < 551900){
        $lvl = 34;
        $remaining = 92200 - ($exp - 459700);
        $progress = 100 - round(100* ($remaining / 92200), 1);
    }
    elseif($exp < 662500){
        $lvl = 35;
        $remaining = 110600 - ($exp - 551900);
        $progress = 100 - round(100* ($remaining / 110600), 1);
    }
    elseif($exp < 795200){
        $lvl = 36;
        $remaining = 132700 - ($exp - 662500);
        $progress = 100 - round(100* ($remaining / 132700), 1);
    }
    elseif($exp < 954500){
        $lvl = 37;
        $remaining = 159300 - ($exp - 795200);
        $progress = 100 - round(100* ($remaining / 159300), 1);
    }
    elseif($exp < 1145600){
        $lvl = 38;
        $remaining = 191100 - ($exp - 954500);
        $progress = 100 - round(100* ($remaining / 191100), 1);
    }
    elseif($exp < 1374900){
        $lvl = 39;
        $remaining = 229300 - ($exp - 1145600);
        $progress = 100 - round(100* ($remaining / 229300), 1);
    }
    else{
        $lvl = 0;
        $remaining = 0;
        $progress = 0.0;
    }
    $progress = round($progress, 1);
    return array($lvl, $remaining, $progress);
}

function czy_mozna_pomoc($od, $do){
    if($od == $do) return false;
    list($lvl, $remaining, $progress) = level_exp($od);
    if($lvl < 15) return false;
    $freebeans = from_quest_db($do, 'freebeans');
    if($freebeans > 500) return false;
    $sql = "SELECT id FROM beans_help WHERE od = $od AND do = $do AND DATE(data) = DATE(NOW())";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) return false;
    return true;
}

function darmowe_fasolki($od, $do){

    $sql = "UPDATE hpotter_bank_skrytki_q SET freebeans = freebeans + 5 WHERE id = $do";
    db_statement($sql);
    if(happy_hours_morning()) $darmowe_helper = 2;
    else $darmowe_helper = 1;

    $sql = "UPDATE hpotter_bank_skrytki_q SET freebeans = freebeans + $darmowe_helper, helped = helped + 1 WHERE id = $od";
    db_statement($sql);
    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $od";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $od_wlasciciel = $row['wlasciciel'];
    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $do";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $do_wlasciciel = $row['wlasciciel'];
    $tekst = "$od_wlasciciel pomogła/pomógł $do_wlasciciel!";
    $sql = "INSERT INTO beans_log(tresc, ofiara, zlodziej, target) VALUES('$tekst', $do, $od, 0)";
    db_statement($sql);
    $sql = "INSERT INTO beans_help(od, do) VALUES($od, $do)";
    db_statement($sql);

}

function czy_sa_darmowe($id){
    $freebeans = from_quest_db($id, 'freebeans');
    if($freebeans > 0){
        $sql = "UPDATE hpotter_bank_skrytki_q SET freebeans = freebeans - 1 WHERE id = $id";
        db_statement($sql);
        return 1;
    }
    else{
        return 0;
    }
}

function pokatna_log($id){
    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['wlasciciel'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO pokatna_log(imie, ip) VALUES('$name', '$ip')";
    db_statement($sql);
}

function get_wlasciciel_of_id($id){
    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['wlasciciel'];
    return $name;
}

function print_wylosowana_fasolka($id, $id_fasolki, $smak, $wartosc, $img, $ile){
    if($wartosc==1) $wartosc = "Pospolita fasolka";
    elseif($wartosc==2) $wartosc = "Rzadka fasolka";
    elseif($wartosc==3) $wartosc = "<span class='huff'>UNIKATOWA</span> fasolka";
    elseif($wartosc==4) $wartosc = "LEGENDARNA fasolka";
    elseif($wartosc==5) $wartosc = "BEZCENNA fasolka";
    if($ile >= 4) echo "<div class='col-3'>";
    echo "<img src='$img'><h3>$wartosc o smaku $smak.</h3>";
    if(czy_nowa_fasolka($id, $id_fasolki)){
        echo "<h4 style='text-align:center;color:gold'>NOWA FASOLKA DO KOLEKCJI!</h4>";
    }
    else{
        echo "<h4 style='text-align:center'>Już masz taką fasolkę w kolekcji!</h4>";
    }
    if($ile >= 4) echo "</div>";

}

function losuj_nasionko($id){
    $los = rand(1, 70);
    if($los == 69){
        $potential = rand(100, 200);
        $sql = "INSERT INTO beans_seeds(user_id, potential) VALUES($id, $potential)";
        db_statement($sql);
        return $potential;
    }
    else return 0;
}

function print_nasionko($potential){
    $przymiot = nasionko_adj($potential);
    echo "<h2 style='text-align: center'>Znalazłaś/eś  $przymiot nasionko. ";
    if($potential > 160) echo "Nie zmarnuj tego!</h2>";
    else echo "Możesz spróbować wyhodować coś z tego...</h2>";

}

function nasionko_adj($potential){
    if($potential <= 120) return "marne";
    elseif($potential <= 140) return "przeciętne";
    elseif($potential <= 160) return "dobre";
    elseif($potential <= 180) return "<span class='gryff'>wyjątkowe</span>";
    else return "<span class='gryff'>doskonałe</span>";
}

function print_unused_seeds($id){
    $sql = "SELECT id, potential FROM beans_seeds WHERE user_id = $id AND pot_id = 0 ORDER BY potential DESC";
    $result = db_statement($sql);
    $how_many = mysqli_num_rows($result);
    $i = 0;
    echo "<h4 style='text-align: center'>Masz <span class='colored bit-bigger'>$how_many</span> nasion</h4>";
    if($how_many > 0) echo "<table class='full-width center-align basic-table'><tr><th></th><th>Potencjał</th><th></th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        $i++;
        if($i > 10) break;
        echo "<tr><td></td><td>".nasionko_adj($row['potential'])."</td><td><a href='fasolka_hodowla.php?cmd=plant&seed=".$row['id']."'><div class='button-fitted'>ZASADŹ</div></a><a href='fasolka_hodowla.php?cmd=discard&seed=".$row['id']."'><div class='button-fitted'>WYRZUĆ</div></a></td></tr>";
    }
    if($how_many > 0) echo "</table>";
}

function print_unused_pots($id){
    print_buy_pots($id);
    $sql = "SELECT * FROM beans_pots WHERE user_id = $id AND seed_id = 0";
    $result = db_statement($sql);
    echo "<table>";
    while($row = mysqli_fetch_assoc($result)){
        print_pot($row);
    }
    echo "</table>";
}

function print_pot($pot){
    $type = $pot['type'];
    $uses = $pot['used'];

    echo "<tr><td>";
    switch($type){
        case 1:
            echo "<img src='fasolki/doniczki/doniczkapustaniebieska.png' style='width: 40%; max-width: 100%'>";
            break;
        case 2:
            echo "<img src='fasolki/doniczki/doniczkapustazielona.png' style='width: 40%; max-width: 100%'>";
            break;
        default:
        case 3:
            echo "<img src='fasolki/doniczki/doniczkapustazolta.png' style='width: 40%; max-width: 100%'>";
            break;
    }

    echo "</td><td><p style='text-align: center'>Pozostało $uses użyć</p></td></tr>";
}

function print_buy_pots($id){
    echo "<h4 style='text-align: center'>Kup nową <span class='bit-bigger colored'>doniczkę</span></h4>";
    echo "<a href='fasolka_hodowla.php?cmd=buypot&type=1'><div class='button-or-not' style='padding: 7px'>Kup zwykłą (50 gal.)</div></a>";
    echo "<a href='fasolka_hodowla.php?cmd=buypot&type=2'><div class='button-or-not' style='padding: 7px'>Kup porządną (250 gal.)</div></a>";
    echo "<a href='fasolka_hodowla.php?cmd=buypot&type=3'><div class='button-or-not' style='padding: 7px'>Kup wybitną (2000 gal.)</div></a>";
}

function print_hodowla($id){
    $sql = "SELECT * FROM beans_seeds WHERE user_id = $id AND pot_id <> 0 ORDER BY last_watered";
    $result = db_statement($sql);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        if(($i % 3) == 0 AND $i != 0) echo "</div>";
        if(($i % 3) == 0) echo "<div class='row'>";
        print_potted_seed($row);
        $i++;
    }
    if($i != 0) echo"</div>";
    else  echo "<h4>Coś tu pustawo... Chwytaj grabki i coś tu posadź, bo trochę wstyd i sąsiedzi gadają...</h4>";
    echo "</div>";
}

function print_potted_seed($seed){
    $last_watered = $seed['last_watered'];
    $watered = $seed['watered'];
    $fertilized = $seed['fertilized'];
    $id = $seed['id'];
    $potential = $seed['potential'];
    switch($watered){
        case 0:
        case 1:
        case 2:
            $koncowka = "s1.png";
            break;
        case 3:
        case 4:
            $koncowka = "s2.png";
            break;
        case 5:
        case 6:
            $koncowka = "s3.png";
            break;
        case 7:
        case 8:
            $koncowka = "s4.png";
            break;
        default:
        case 9:
        case 10:
            $koncowka = "s5.png";
            break;
    }
    $pot_id = $seed['pot_id'];
    $sql = "SELECT type FROM beans_pots WHERE id = $pot_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $type = $row['type'];
    echo "<div class='col-4' style='text-align: center'>";
    switch($type){
        case 1:
            echo "<img src='fasolki/doniczki/niebieska$koncowka' style='width: 80%; max-width: 100%'>";
            break;
        case 2:
            echo "<img src='fasolki/doniczki/zielona$koncowka' style='width: 80%; max-width: 100%'>";
            break;
        default:
        case 3:
            echo "<img src='fasolki/doniczki/zolta$koncowka' style='width: 80%; max-width: 100%'>";
            break;
    }
    echo "<p class='narrow'>Potencjał: <span class='colored bold'>$potential</span></p>";
    echo "<p class='narrow'>Nawiozło <span class='colored bold'>$fertilized</span>/10 osób</p>";
    echo "<p class='narrow'>Podlano <span class='colored bold'>$watered</span>/10 razy</p>";
    czy_mozna_podlac_link($id, $last_watered, $watered);
    echo "</div>";

}

function czy_mozna_podlac($id, $id_nasionka){
    $sql = "SELECT last_watered, user_id FROM beans_seeds WHERE id = $id_nasionka";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==0) return false;
    $row = mysqli_fetch_assoc($result);
    $last_watered = $row['last_watered'];
    $user_id = $row['user_id'];
    if($user_id != $id){
        return false;
    }
    $now = time(); // or your date as well
    $your_date = strtotime($last_watered);
    $datediff = $now - $your_date;

    $ile_godzin = $datediff/(60*60);
    if($ile_godzin < 1){
        return false;
    }
    return $ile_godzin;
}

function czy_mozna_zerwac($id, $id_nasionka){
    $sql = "SELECT watered, user_id FROM beans_seeds WHERE id = $id_nasionka";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==0) return false;
    $row = mysqli_fetch_assoc($result);
    $watered = $row['watered'];
    $user_id = $row['user_id'];
    if($user_id != $id){
        return false;
    }
    if($watered < 10){
        return false;
    }
    return true;
}

function czy_mozna_podlac_link($id, $last_watered, $watered){
    if($watered >= 10){
        echo "<a href='/fasolka_hodowla.php?harvest=$id'><div class='button-fitted' style='color: orange'>ZBIERZ</div></a>";
        return;
        //echo "Chwilowo nie można zrywać";
    }
    $now = time(); // or your date as well
    $your_date = strtotime($last_watered);
    $datediff = $now - $your_date;

    $ile_godzin = $datediff/(60*60);

    if($ile_godzin > 4) echo "<a href='/fasolka_hodowla.php?water=$id'><div class='button-fitted'>PODLEJ TERAZ</div></a>";
    print_podlewanie_hint($ile_godzin);

    return;
}

function print_podlewanie_hint($ile_godzin){
    $ile_minut = floor(60*(8 - $ile_godzin));
    $ile_godzin = 0;
    while($ile_minut > 59){
        $ile_godzin++;
        $ile_minut = $ile_minut - 60;
    }
    if($ile_godzin == 0){
        echo "<p class='narrow'>Wróć podlać za $ile_minut minut.</p>";
    }
    elseif($ile_minut == 0){
        echo "<p class='narrow'>Wróć podlać za $ile_godzin godzin.</p>";
    }
    else{
        echo "<p class='narrow'>Wróć podlać za $ile_godzin godzin i $ile_minut minut</p>";
    }

}

function seed_potential($id){
    $sql = "SELECT potential FROM beans_seeds WHERE id = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['potential'];
}

function calc_water_effect($potential, $ile_godzin){
    $diff = 0.25 * abs(8 - $ile_godzin);
    if($diff < 0.25) $diff = -1 + (4*$diff);
    elseif($diff > 6) $diff = 6;
    $diff = 0.3 - (0.1 * $diff);
    return ($diff * $potential);
}

function calc_harvest_reward($potential, $seed_id, $user_id){
    $sql = "SELECT choice FROM beans_pending_seeds WHERE seed_id = $seed_id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=0) return;

    $rewards = [];
    for($i=1;$i<=3;$i++){
        $pospolita = 100;
        $rzadka = 0.4 * $potential;
        if($rzadka > 500) $rzadka = 500;
        $unikatowa = $potential - 2500;
        if($unikatowa < 0) $unikatowa = 0;
        $bezcenna = $potential - 4100;
        if($bezcenna < 0) $bezcenna = 0;
        $sum = $pospolita + $rzadka + $unikatowa + $bezcenna;
        $bezcenna = floor(100 * ($bezcenna / $sum));
        $unikatowa = $bezcenna + floor(100 * ($unikatowa / $sum));
        $rzadka = $unikatowa + floor(100 * ($rzadka / $sum));

        $rand = rand(1, 100);
        if($rand <= $bezcenna){
            $sql = "SELECT id FROM beans WHERE wartosc = 5 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        elseif($rand <= $unikatowa){
            $sql = "SELECT id FROM beans WHERE wartosc = 3 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        elseif($rand <= $rzadka){
            $sql = "SELECT id FROM beans WHERE wartosc = 2 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }
        else{
            $sql = "SELECT id FROM beans WHERE wartosc = 1 ORDER BY RAND() LIMIT 1";
            $result = db_statement($sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
        }

        $rewards[] = $id;
        $sql = "DELETE FROM beans_seeds WHERE id = $seed_id";
        db_statement($sql);
        $sql = "INSERT INTO beans_pending_seeds(seed_id, user_id, choice) VALUES($seed_id, $user_id, $id)";
        db_statement($sql);
    }
    return $rewards;
}

function get_array_from_bean_id($bean_id){
    $array = array();
    $sql = "SELECT id, smak, wartosc, obrazek FROM beans WHERE id = $bean_id";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $array[] = $row;
    return $array;
}

function print_reward_options($id, $seed_id){
    $sql = "SELECT choice FROM beans_pending_seeds WHERE seed_id = $seed_id AND user_id = $id";
    $outcome = db_statement($sql);
    $rewards = [];
    while($choice = mysqli_fetch_assoc($outcome)){
        $rewards[] = $choice['choice'];
    }
    foreach($rewards as $reward){
        $sql = "SELECT wartosc, smak FROM beans WHERE id = $reward";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $wartosc = $row['wartosc'];
        $smak = $row['smak'];
        if($wartosc==1) $wartosc_text = "POSPOLITA";
        elseif($wartosc==2) $wartosc_text = "<span class='colored'>RZADKA</span>";
        elseif($wartosc==3) $wartosc_text = "<span class='rav'>UNIKATOWA</span>";
        elseif($wartosc==4) $wartosc_text = "<span class='huff'>LEGENDARNA</span>";
        else $wartosc_text = "<span class='gryff'>BEZCENNA</span>";
        if($wartosc_text != 5) {
            echo "<a href='fasolka_hodowla.php?cmd=collect&reward=$reward&seed=$seed_id'><div class='button-or-not'>$wartosc_text fasolka o smaku $smak</div></a>";
        }
        else {
            echo "<a href='fasolka_hodowla.php?cmd=collect&reward=$reward&seed=$seed_id'><div class='button-or-not rav bold'>ODKRYJ NOWY SMAK FASOLKI!</div></a>";
        }
    }
}

function decisions_pending($id){
    $sql = "SELECT DISTINCT seed_id FROM beans_pending_seeds WHERE user_id = $id";
    $result = db_statement($sql);
    $ile = mysqli_num_rows($result);
    if($ile == 0) return false;
    else return $ile;
}

function print_pending_decisions($id){
    $sql = "SELECT DISTINCT seed_id FROM beans_pending_seeds WHERE user_id = $id";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $seed_id = $row['seed_id'];
        print_reward_options($id, $seed_id);
        echo "<br><hr><br>";
    }
}

function czy_nieodkryta_fasolka($reward){
    $sql = "SELECT smak FROM beans WHERE id = $reward";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    if($row['smak']=='nieznanym') return true;
    else return false;
}

function print_collect_status($id, $reward, $seed_id){
    $reward = trim_input($reward);
    $seed_id = trim_input($seed_id);

    $sql = "SELECT * FROM beans_pending_seeds WHERE user_id = $id AND seed_id = $seed_id AND choice = $reward";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=0){
        $sql = "DELETE FROM beans_pending_seeds WHERE seed_id = $seed_id AND user_id = $id";
        db_statement($sql);
        $sql = "UPDATE beans_pots SET seed_id = 0 WHERE seed_id = $seed_id";
        db_statement($sql);
        dodaj_fasolke_do_kolekcji($id, $reward, 1);
        $_SESSION['fasolki'] = get_array_from_bean_id($reward);
        if(czy_nieodkryta_fasolka($reward)) return 1;
        else return 2;
    }
    else{
        echo "Coś poszło nie tak. Próbowałaś/eś oszukać? :/";
        return false;
    }
}

function print_available_pots($id){
    $sql = "SELECT * FROM beans_pots WHERE user_id = $id AND seed_id = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=0) echo "Doniczka<select name='pot'>";
    else echo "<p class='gryff'>Nie masz wolnej doniczki!</p>";
    while($row = mysqli_fetch_assoc($result)){
        $pot_id = $row['id'];
        $type = $row['type'];
        $uses = $row['used'];

        switch($type){
            case 1:
                $typ = "Zwykła";
                break;
            case 2:
                $typ = "Porządna";
                break;
            default:
            case 3:
                $typ = "Wybitna";
                break;
        }

        echo "<option value='$pot_id'>$typ, użyć: $uses</option>";
    }
    if(mysqli_num_rows($result)!=0) echo "</select>";
}

function print_plant_form($id, $seed_id){
    $seed_id = trim_input($seed_id);
    $sugerowana = get_suggested_reward();
    echo "<form method='post' class='form-sleek'>";
    echo "<input type='hidden' name='seed' value='$seed_id'>";
    print_available_pots($id);
    echo "Nagroda dla innych za nawożenie (jeśli chcesz, żeby inny gracz otrzymywał 5 galeonów bonusu to wpisz tutaj 15, koszt nawozu to bowiem 10 galeonów). <span class='huff'>Obecna sugerowana nagroda to $sugerowana galeonów.</span><input type='number' name='fertreward' min='5' required>";
    echo "<input type='submit' value='Zasadź'>";
    echo "</form>";
}

function zasadz_nasionko($id, $seed_id, $fertreward, $pot_id){
    $id = trim_input($id);
    $seed_id = trim_input($seed_id);
    $fertreward = trim_input($fertreward);
    $pot_id = trim_input($pot_id);

    $sql = "SELECT * FROM beans_pots WHERE id = $pot_id AND seed_id = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) return "Sadzenie nieudane.";

    $sql = "SELECT * FROM beans_seeds WHERE id = $seed_id AND pot_id = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)!=1) return "Sadzenie nieudane.";

    $sql = "UPDATE beans_seeds SET pot_id = $pot_id, planted = CURRENT_TIMESTAMP, last_watered = CURRENT_TIMESTAMP WHERE id = $seed_id";
    db_statement($sql);

    $sql = "UPDATE beans_pots SET seed_id = $seed_id, fertreward = $fertreward, used = used - 1 WHERE id = $pot_id";
    db_statement($sql);

    $tekst = get_wlasciciel_of_id($id) . " zasadził(a) nowe nasionko!";
    $sql = "INSERT INTO beans_log(tresc) VALUES('$tekst')";
    db_statement($sql);

    $sql = "UPDATE hpotter_bank_skrytki_q SET planted = planted + 1 WHERE id = $id";
    db_statement($sql);

    dodaj_exp($id, 10);

    return "Zasadzono ziarenko pomyślnie!";

}

function calc_fert_bonus($seed_id){
    $sql = "SELECT potential, planted FROM beans_seeds WHERE id = $seed_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $potential = $row['potential'];
    $planted = $row['planted'];

    $now = time(); // or your date as well
    $your_date = strtotime($planted);
    $datediff = $now - $your_date;

    $ile_godzin = $datediff/(60*60);
    if($ile_godzin > 10){
        $ile_godzin = 10;
    }

    $mnoznik = 0.1 - (0.01 * $ile_godzin);
    return floor($mnoznik * $potential);
}

function czy_mozna_nawiezc($user_id, $seed_id){
    $sql = "SELECT user_id FROM beans_seeds WHERE id = $seed_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $user_id_from_db = $row['user_id'];
    if(get_konto_of_id($user_id_from_db)<-100) return false;
    if($user_id_from_db == $user_id) return false;
    $sql = "SELECT * FROM beans_fert WHERE user_id = $user_id AND seed_id = $seed_id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==0) return true;
    else return false;
}

function nawiez_nasionko($user_id, $seed_id){
    $sql = "SELECT fertreward, user_id FROM beans_pots WHERE seed_id = $seed_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $fertreward = $row['fertreward'];
    $id_recip = $row['user_id'];

    $bonus = calc_fert_bonus($seed_id);
    $sql = "UPDATE beans_seeds SET potential = potential + $bonus, fertilized = fertilized + 1 WHERE id = $seed_id";
    db_statement($sql);
    $sql = "INSERT INTO beans_fert(user_id, seed_id) VALUES($user_id, $seed_id)";
    db_statement($sql);
    $fert = $fertreward - 10;
    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto + $fert WHERE numer = $user_id";
    db_statement($sql);
    $sql = "UPDATE hpotter_bank_skrytki SET konto = konto - $fertreward WHERE numer = $id_recip";
    db_statement($sql);
    $tekst = get_wlasciciel_of_id($user_id) . " nawiozła/nawiózł nasionko ". get_wlasciciel_of_id($id_recip);
    $sql = "INSERT INTO beans_log(tresc, ofiara) VALUES('$tekst', $id_recip)";
    db_statement($sql);
    return true;


}

function print_name_bean_form($bean_id, $user_id){
    $sql = "SELECT obrazek, smak FROM beans WHERE id = $bean_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $img = $row['obrazek'];
    $smak = $row['smak'];
    echo "<p style='text-align: center'><img src='$img'></p>";
    echo "<form class='form-sleek' method='post' action='fasolka_hodowla.php'>";
    echo "Podaj nowy smak fasolki! (Jedyna taka możliwość, podejmij szybko decyzję zanim ktoś inny odkryje ten smak!";
    echo "<input type='hidden' name='bean_id' value='$bean_id'>";
    echo "<input type='hidden' name='namer_id' value='$user_id'>";
    echo "<input type='text' name='smak' maxlength='50' value='$smak'>";
    echo "<input type='submit' name='name' value='Nazwij smak'>";
    echo "</form>";
}

function dodaj_nowy_smak($smak, $seed_id, $user_id){
    $smak = trim_input($smak);
    $sql = "UPDATE beans SET smak = '$smak', namer_id = $user_id WHERE id = $seed_id";
    db_statement($sql);
    return true;
}

function discard_seed($seed_id){
    $sql = "DELETE FROM beans_seeds WHERE id = $seed_id";
    db_statement($sql);
}

function buy_pot($pot_type, $id){
    if($pot_type == 1) $price = 50;
    elseif($pot_type == 2) $price = 250;
    else $price = 2000;

    $stan_konta = get_konto_of_id($id);
    if(($stan_konta - $price) < -100){
        return "Zbyt mało funduszy!";
    }
    else{
        $sql = "UPDATE hpotter_bank_skrytki SET konto = konto - $price WHERE numer = $id";
        db_statement($sql);
        if($pot_type == 1) $uses = 3;
        elseif($pot_type == 2) $uses = 20;
        else $uses = 200;
        $sql = "INSERT INTO beans_pots(user_id, type, used) VALUES($id, $pot_type, $uses)";
        db_statement($sql);
        return "Kupiono doniczkę!";
    }
}

function get_suggested_reward(){
    $sql = "SELECT beans_pots.fertreward AS fertreward FROM beans_seeds INNER JOIN beans_pots ON beans_seeds.id = beans_pots.seed_id WHERE beans_seeds.pot_id <> 0 AND beans_seeds.fertilized < 10 ORDER BY beans_pots.fertreward DESC LIMIT 1 OFFSET 9";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    if($row['fertreward']<10) return 11;
    return ($row['fertreward']+1);
}

function can_edit_name($bean_id){
    $user_id = account_access($_SESSION['username'], $_SESSION['password']);
    $sql = "SELECT id FROM beans WHERE id = $bean_id AND namer_id = $user_id";
    $result = db_statement($sql);
    return (mysqli_num_rows($result)>0);
}

function sprawdz_doniczke($seed_id){
    $sql = "SELECT id, used FROM beans_pots WHERE seed_id = $seed_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $used = $row['used'];
    $pot_id = $row['id'];
    if($used < 1){
        $sql = "DELETE FROM beans_pots WHERE id = $pot_id";
        db_statement($sql);
    }
}

function can_edit_profit($user_id, $seed_id){
    $seed_id = trim_input($seed_id);
    $sql = "SELECT id FROM beans_seeds WHERE id = $seed_id AND user_id = $user_id";
    $result = db_statement($sql);
    return (mysqli_num_rows($result)==1);
}

function print_profit_edit_form($seed_id){
    $seed_id = trim_input($seed_id);
    $sugerowana = get_suggested_reward();
    $sql = "SELECT fertreward FROM beans_pots WHERE seed_id = $seed_id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $obecna = $row['fertreward'];
    echo "<form method='post' class='form-sleek'>";
    echo "<input type='hidden' name='seed' value='$seed_id'>";
    echo "Nagroda dla innych za nawożenie (jeśli chcesz, żeby inny gracz otrzymywał 5 galeonów bonusu to wpisz tutaj 15, koszt nawozu to bowiem 10 galeonów). <span class='huff'>Obecna sugerowana nagroda to $sugerowana galeonów.</span><input type='number' name='fertreward' min='5' value='$obecna' required>";
    echo "<input type='submit' name='editprofit' value='Zmień nagrodę'>";
    echo "</form>";
}

function print_fasolki_navbar(){
    echo "<div class='row'>
            <div style='width: 11.1%; padding: 0; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_panel.php'>
                    <div class='button-or-not' style='padding: 10px 0; color: cyan'>
                        <span class='glyphicon glyphicon-step-backward'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='losuj_fasolke.php'>
                    <div class='button-or-not' style='padding: 10px 0; color: hotpink'>
                        <span class='glyphicon glyphicon-shopping-cart'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka.php'>
                    <div class='button-or-not' style='padding: 10px 0'>
                        <span class='glyphicon glyphicon-book'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_hodowla.php'>
                    <div class='button-or-not' style='padding: 10px 0; color: lime'>
                        <span class='glyphicon glyphicon-grain'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_profil.php'>
                    <div class='button-or-not' style='padding: 10px 0'>
                        <span class='glyphicon glyphicon-user'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_quest.php'>
                    <div class='button-or-not' style='padding: 10px 0'>
                        <span class='glyphicon glyphicon-ok-circle'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_rank.php'>
                    <div class='button-or-not' style='padding: 10px 0'>
                        <span class='glyphicon glyphicon-star-empty'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_skup.php'>
                    <div class='button-or-not' style='padding: 10px 0'>
                        <span class='glyphicon glyphicon-eur'></span>
                    </div>
                </a>
            </div>
            <div style='width: 11.1%; padding: 0; float: left; font-size: 125%;'>
                <a href='fasolka_rywale.php'>
                    <div class='button-or-not' style='padding: 10px 0; color: yellow'>
                        <span class='glyphicon glyphicon-screenshot'></span>
                    </div>
                </a>
            </div>
        </div>";
}

function calc_harvest_prob($potential){

    $pospolita = 100;
    $rzadka = 0.4 * $potential;
    if($rzadka > 500) $rzadka = 500;
    $unikatowa = $potential - 2500;
    if($unikatowa < 0) $unikatowa = 0;
    $bezcenna = $potential - 4100;
    if($bezcenna < 0) $bezcenna = 0;
    $sum = $pospolita + $rzadka + $unikatowa + $bezcenna;
    $bezcenna = floor(100 * ($bezcenna / $sum));
    $unikatowa = floor(100 * ($unikatowa / $sum));
    $szansa_na_bezcenna = (1000000 - ((100 - $bezcenna) * (100 - $bezcenna) * (100 - $bezcenna)))/10000;
    $szansa_na_unikatowa = (1000000 - ((100 - $unikatowa) * (100 - $unikatowa) * (100 - $unikatowa)))/10000;
    return "Szansa na wylosowanie unikatowej fasolki wynosi $szansa_na_unikatowa%, natomiast na bezcenną $szansa_na_bezcenna%.";
}

?>