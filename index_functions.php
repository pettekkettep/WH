<?php

function dd($data){
    var_dump($data);
    die;
}

function days_since(){
    $now = time(); // or your date as well
    $your_date = strtotime("2006-01-15");
    $datediff = $now - $your_date;
    return floor($datediff/(60*60*24));
}

function time_description($time_ago){
    $time_ago = strtotime($time_ago);
    $mysqldate = date( 'd.m.Y H:i', $time_ago );
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );

    if($days < 3) {
        if ($seconds <= 60) {
            return "teraz";
        }
        if ($minutes <= 60) {
            if ($minutes == 1) {
                return "minutę temu";
            } elseif ($minutes < 4 || ($minutes < 25 && $minutes > 21) || ($minutes < 35 && $minutes > 31)
                || ($minutes < 45 && $minutes > 41) || ($minutes < 55 && $minutes > 51)
            ) {
                return "$minutes minuty temu";
            } else {
                return "$minutes minut temu";
            }
        }
        if ($hours <= 72) {
            if ($hours == 1) {
                return "godzinę temu";
            } elseif ($hours < 4 || ($hours < 25 && $hours > 21) || ($hours < 35 && $hours > 31)
                || ($hours < 45 && $hours > 41) || ($hours < 55 && $hours > 51) ||
                ($hours < 65 && $hours > 61) || ($hours == 72)
            ) {
                return "$hours godziny temu";
            } else {
                return "$hours godzin temu";
            }
        }
    }
    else{
        return "$days dni temu";
    }
    return "";
}

function trim_input($input){
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}

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

function users_is_admin($login, $password){
    $sql = "SELECT id, access FROM admins WHERE nick = '$login' AND pass = '$password'";
    $result = simple_db_query($sql);
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $access = $row['access'];
        if($access == "n-n-n-n-n-n-n-n-n-n-n") return false;
        return true;
    }
    else return false;
}

function users_is_root($login, $password){
    $sql = "SELECT access FROM admins WHERE nick = '$login' AND pass = '$password'";
    $result = simple_db_query($sql);
    if(mysqli_num_rows($result) == 1){
        $result = mysqli_fetch_assoc($result);
        if($result['access'] == 'root') return true;
        else return false;
    }
    else return false;
}

function add_comment_to_news($user, $comment, $newsid){
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO comments (name, text, wid, ip) VALUES('$user', '$comment', $newsid, '$ip')";
    simple_db_query($sql);
}

function add_event($string, $kind, $kto = ""){
    if($kto == "") $kto = $_SESSION['username'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $string = trim_input($string);
    $kind = trim_input($kind);
    $ip = trim_input($ip);
    $sql = "INSERT INTO log(kto, tresc, rodzaj, ip) VALUES ('$kto', '$string', '$kind', '$ip')";
    simple_db_query($sql);
}

function print_session_msg(){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

function correct_password($username, $password){
    $sql = "SELECT * FROM users WHERE login = '$username' AND password = '$password'";
    $result = simple_db_query($sql);
    if(mysqli_num_rows($result)>0) return $username;
    else return false;
}

function login_handler(){
    $login = trim_input($_POST['login']);
    $password = md5(trim_input($_POST['password']));
    $success = correct_password($login, $password);
    if($success != false){
        $_SESSION['username'] = $login;
        $_SESSION['password'] = $password;
        setcookie('username', $login, time()+60*60*24*60);
        setcookie('password', $password, time()+60*60*24*60);
        add_event("zalogował(a) się", "login");
        header("Location: index_x.php");
        exit();
    }
}
function add_comment_handler(){
    $user = trim_input($_POST['user']);
    $comment = trim_input($_POST['comment']);
    $newsid = trim_input($_POST['newsid']);
    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }
    else{
        $user = "~" . $user;
    }
    add_comment_to_news($user, $comment, $newsid);
    add_event("dodał(a) komentarz pod newsem o nr. $newsid","dod_kom",$user);
    header("Location: " . $_SERVER['REQUEST_URI']);
    $_SESSION['msg'] = "Dodano komentarz!";
    exit();
}

function logout(){
    setcookie('username', "", 1);
    setcookie('password', "", 1);
    session_destroy();
    session_start();
    header("Location: index_x.php");
    exit();
}

function cookie_login_handler(){
    $username = trim_input($_COOKIE['username']);
    $password = trim_input($_COOKIE['password']);
    if(users_is_admin($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
}

function delete_comment_id($id){
    $sql = "DELETE FROM comments WHERE id = $id";
    simple_db_query($sql);
}

function delete_comment_handler(){
    $id = trim_input($_GET['comment_delete_id']);
    delete_comment_id($id);
    add_event("usunął/ęła komentarz o nr. $id","us_kom");
    header("Location: index_x.php");
    $_SESSION['msg'] = "Usunięto komentarz.";
    exit();
}

function is_this_ip_stored(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $token = trim_input($_COOKIE['token']);
    $sql = "SELECT id FROM bigbrother WHERE ip = '$ip' AND token = '$token'";
    $result = simple_db_query($sql);
    if(mysqli_num_rows($result)==0){
        $sql = "INSERT INTO bigbrother(ip, token) VALUES('$ip', '$token')";
        simple_db_query($sql);
    }
}

function create_new_token(){
    $token = md5(rand());
    $ip = $_SERVER['REMOTE_ADDR'];
    setcookie('token', $token, time()+60*60*24*365);
    $sql = "INSERT INTO bigbrother(ip, token) VALUES('$ip', '$token')";
    simple_db_query($sql);
}

function get_houses_points(){
    $sql = "SELECT SUM( ile ) AS suma FROM punkty_opis 
                    WHERE id_dom = 1 GROUP BY id_dom";

    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $g = $row['suma'];
    if($g == NULL) $g = 0;

    $sql = "SELECT SUM( ile ) AS suma FROM punkty_opis 
                    WHERE id_dom = 2 GROUP BY id_dom";

    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $s = $row['suma'];
    if($s == NULL) $s = 0;

    $sql = "SELECT SUM( ile ) AS suma FROM punkty_opis 
                    WHERE id_dom = 3 GROUP BY id_dom";

    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $r = $row['suma'];
    if($r == NULL) $r = 0;

    $sql = "SELECT SUM( ile ) AS suma FROM punkty_opis 
                    WHERE id_dom = 4 GROUP BY id_dom";

    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $h = $row['suma'];
    if($h == NULL) $h = 0;

    return array($g, $h, $r, $s);
}

function get_houses_top5(){
    $colors = ['#ff0000', '#ffcc00', '0066ff', '00cc00'];
    foreach($colors as $color){
        $sql = "SELECT uczen_id, sum(ile) AS suma FROM punkty_opis WHERE zmiana = 'Dodał' AND uczen_id IN (SELECT id FROM zapisy_u WHERE dom = '$color') GROUP BY uczen_id ORDER BY suma DESC LIMIT 5";
        $result = simple_db_query($sql);
        $html = "<table class='full-width'>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['uczen_id'];
            $wynik = $row['suma'];
            $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
            $outcome = simple_db_query($sql);
            if($outcome == false) echo "";
            $row = mysqli_fetch_assoc($outcome);
            $imie = $row['imie'];
            $nazwisko = $row['nazwisko'];
            $dom = $row['dom'];

            $html .= "<tr><td class='bold'>".$imie." ".$nazwisko."</td><td class='no-wrap-fit'> ".$wynik."&nbsp;pkt</span></td></tr>";
        }

        $html .= "</table>";
        array_push($html_array, $html);
    }
    return $html_array;

}

function prepare_punkty_block(){
    list($g, $h, $r, $s) = get_houses_points();
    list($top5g, $top5h, $top5r, $top5s) = get_houses_top5();
    $html = "<div class='punkty'><div class='row extra-margin'><div class='col-const-3 pts-details'> <a class='wocolor' href='/punkty.php?show=gryffindor'>".$g."</a><div class='gryff-tlo'>".$top5g."</div></div>
 <div class='col-const-3 pts-details'> <a class='wocolor' href='/punkty.php?show=hufflepuff'>".$h."</a><div class='huff-tlo'>".$top5h."</div></div>
 <div class='col-const-3 pts-details'> <a class='wocolor' href='/punkty.php?show=ravenclaw'>".$r."</a><div class='rav-tlo'>".$top5r." </div></div>
 <div class='col-const-3 pts-details'> <a class='wocolor' href='/punkty.php?show=slytherin'>".$s."</a><div class='slyth-tlo'>".$top5s."</div></div>
 </div>
</div>";

    return $html;
}

function print_last_news($amount_to_show = 5){

    $sql = "SELECT id, title, author, date FROM news WHERE stat = 1 ORDER BY date DESC LIMIT $amount_to_show";
    $result = simple_db_query($sql);

    $html = "<h4>Ostatnie news<a class='wocolor' href='panel.php'>y</a></h4>";
    $html .= "<ul class='no-indent'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<li class='latest'><span class='bold colored'><a href='news_x.php?id=".$row['id']."'>" . $row['title'] . "</a></span> | " . $row['author'] . " | <i>" . time_description($row['date']) ."</i></li>";
    }
    $html .= "</ul>";
}

function fasolki_noticeboard(){
    $sql = "SELECT SUM(wydano) AS wydano, SUM(suma) AS suma FROM hpotter_bank_skrytki";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $wydano = $row['wydano'];
    $suma = $row['suma'];
    $sql = "SELECT numer FROM hpotter_bank_skrytki WHERE rank != 0";
    $result = simple_db_query($sql);
    $ilu = mysqli_num_rows($result);
    $html = "<h4>Do tej pory</h4> <p><span class='colored bit-bigger bold'>$ilu</span> osób wylosowało <span class='colored bit-bigger bold'>$suma</span> fasolek za <span class='colored bit-bigger bold'>$wydano</span> galeonów!</p>";
    return $html;
}

function last_unikat(){
    $sql = "SELECT fasolka, skrytka, data FROM beans_owners WHERE fasolka IN (SELECT id FROM beans WHERE wartosc = 3) ORDER BY data DESC LIMIT 1";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $fasolka = $row['fasolka'];
    $skrytka = $row['skrytka'];
    $data = $row['data'];

    $sql = "SELECT smak FROM beans WHERE id = $fasolka";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $smak = $row['smak'];

    $sql = "SELECT wlasciciel FROM hpotter_bank_skrytki WHERE numer = $skrytka";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $wlasciciel = $row['wlasciciel'];

    $html = "<p>
                <span class='colored bit-bigger bold'>".time_description($data)."</span> znaleziono unikatową fasolkę o smaku <span class='colored bit-bigger bold'>$smak</span>! Gratulacje dla <span class='colored bit-bigger bold'>$wlasciciel</span>
            </p>";
    
    return $html;
}

function top_3_players(){
    $sql = "SELECT numer, wlasciciel, rank FROM hpotter_bank_skrytki ORDER BY rank DESC LIMIT 3";
    $html =  "<h4>Top 3 graczy:</h4>";
    $result = simple_db_query($sql);
    while($row = mysqli_fetch_assoc($result)){
        $wlasciciel = $row['wlasciciel'];
        $rank = $row['rank'];
        $numer = $row['numer'];
        $html .= "<p class='narrow'><a href='fasolka_postac.php?id=$numer' class='wocolor'>$wlasciciel </a><span class='bold colored bit-bigger'>$rank</span> xp</p>";
    }
    return $html;
}

function last_kradziez(){
    $sql = "SELECT tresc, data FROM beans_log ORDER BY data DESC LIMIT 1";
    $result = simple_db_query($sql);
    $row = mysqli_fetch_assoc($result);
    $tresc = $row['tresc'];
    $data = $row['data'];
    return "<p><span class='colored bit-bigger bold'>".time_description($data)."</span> $tresc";
}

function prepare_headers(){
    $html = "<div class='row'>
    <a href='http://wh.boo.pl/index_x.php'><div class='logo' id='logo-mobile'><img src = 'hogwarts-tiny.jpg'></div></a>
</div>
<div class='row'>
    <a href='index_x.php'><div class='logo' id='napis-wh'><img src = 'napis.png'></div></a>
</div>
<div class='row row-style-light center-align'>
    <div class='col-4'>";
    $html .= print_last_news(5);
    $html .= "</div><div class='col-4 img-logo' style='padding: 7px'><img id='logo-wh' src='logo.jpg'><p>Nasza szkoła istnieje od <span class='score'>" . days_since() . "</span>dni.</p>";
    $html .= "</div>
<div class='col-4 col-m-0 center-align only-screen'>
    <div class='row'>
        <img class='full-width-but' src='blok/zapisyimg/zapisy1.png' style='margin: 10px 0 20px 0;'>
    </div>
    <div class='row'>
        <div class='col-2'>
            <img class='full-width-but' src='blok/zapisyimg/przyp2.png' id='przyp_u'  style='margin: 5px 0 0 0;'>
        </div>
        <div class='col-10'>
            <a href='zapisy_u.php'><img class='full-width-but' src='blok/zapisyimg/zapisy3.png'  style='margin: 0' onmouseover='onHoverU();' onmouseout='offHoverU();''></a>
        </div>
    </div>
    <div class='row'>
        <div class='col-2'>
            <img class='full-width-but' src='blok/zapisyimg/przyp2.png'  style='margin: 5px 0 0 0;' id='przyp_n'>
        </div>
        <div class='col-10'>
            <a href='zapisy_n.php'><img class='full-width-but' src='blok/zapisyimg/zapisy2.png'  style='margin: 0;' onmouseover='onHoverN();' onmouseout='offHoverN();'></a>
        </div>
    </div>
</div>
</div>
<div class='row row-style center-align'>
    <div class='col-2'>";
    $html .= fasolki_noticeboard();
    $html .= "</div><div class='col-3'><h4>Ostatni unikat:</h4>";
    $html .= last_unikat();
    $html .= "</div>
    <div class='col-2'>
        <h4>Gonitwa za Fasolkami!</h4>
        <a href='fasolka_panel.php'><div class='button-or-not'><h4>Wejdź do gry!</h4></div></a>
    </div>
    <div class='col-3'>";
    $html .= top_3_players();
    $html .= "</div>
    <div class='col-2'>
        <h4>Ostatnie wydarzenie:</h4>";
    $html .= last_kradziez();
    $html .= "</div></div>";

    return $html;
}

function giveevalblock($which, $where){
    $sql = "SELECT tresc FROM bloki WHERE strona='$which' ORDER BY kolej";
    $result = simple_db_query($sql);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)) {
            $html .= 'echo "<div class=\'row row-block-' . $where . '\'>";';
            $blok = $row['tresc'];
            $html .= $blok . ";";
            $html .= 'echo "</div>";';
        }
    }
    return $html;
}

function print_important_dates(){

    $sql = "SELECT content_1, content_2, priority, hyperlink FROM dates WHERE TIMESTAMP(expiry_date) > CURRENT_TIMESTAMP() AND approved = 1 ORDER BY expiry_date";
    $result = simple_db_query($sql);

    echo "<div align='center'>
            <img src='blok/n7.png'>
            </div>
            <ul class='no-indent'>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li class='";
        if ($row['priority'] == 1) echo "date imp-date";
        elseif ($row['priority'] == 2) echo "date gryff";
        elseif ($row['priority'] == 3) echo "date huff";
        elseif ($row['priority'] == 4) echo "date rav";
        elseif ($row['priority'] == 5) echo "date slyth";
        else echo "date";
        echo "'>";
        if ($row['hyperlink'] != NULL) echo "<a class='wocolor' href='" . $row['hyperlink'] . "'>";
        echo "<strong>" . $row['content_1'] . "</strong>";
        echo " - " . $row['content_2'];
        if ($row['hyperlink'] != NULL) echo " [KLIK!] </a>";
        echo "</li>";
    }
    echo "</ul>";
}

function print_user_menu($username, $password){
    $sql = "SELECT * FROM users WHERE login = '$username' AND password = '$password'";
    $result = simple_db_query($sql);
    if(mysqli_num_rows($result)>0){
        echo "<p class='narrow center-align'>Zalogowano jako: </p>";
        echo "<p class='colored narrow bold center-align'>$username</p>";
        $sql = "SELECT konto FROM hpotter_bank_skrytki WHERE wlasciciel = '$username'";
        $result = simple_db_query($sql);
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            $konto = $row['konto'];
            echo "<p class='narrow center-align'>Stan konta: </p>";
            echo "<p class='colored narrow bold center-align'><span class='glyphicon glyphicon glyphicon-piggy-bank'></span> $konto G</p>";
        }
    }
    else{
        echo "<form class='form-sleek' method='POST' action='index_x.php' style='padding-top: 0px'>";
        echo "Login: <input type='text' name='login'>";
        echo "Hasło: <input type='password' name='password'>";
        echo "<input type='submit' value='Zaloguj się'></form>";
    }
}

function prepare_blocks_left(){
    $html = 'echo "<div class=\'row row-style\'><div class=\'col-low-res center-align\'>";';
    $html .= giveevalblock('mobilegora', 'right');
    $html .= 'echo "<div class=\'col-1 col-m-0\'></div><div class=\'col-0 col-2 col-m-3\'>";';
    $html .= giveevalblock('lewa', 'left');
    $html .= 'echo "</div>";';
    return $html;

}

function print_time_table_mobile(){
    $day = date('N');

    print_day('I', $day);
    print_day('II', $day);
    print_day('III', $day);
}

function print_day($class, $day){
    switch($class) {
        case 'I':
            $klasa = 1;
            break;
        case 'II':
            $klasa = 2;
            break;
        default:
            $klasa = 3;
            break;
    }

    $sql = "SELECT * FROM plan
              WHERE dzien = $day AND klasa = $klasa ORDER BY godzina";
    $result = simple_db_query($sql);

    if(mysqli_num_rows($result)==0) {return;}
    switch($class) {
        case 'I':
            echo "<div align='center'>
            <img src='blok/n1.png'>
            </div>";
            break;
        case 'II':
            echo "<div align='center'>
            <img src='blok/n2.png'>
            </div>";
            break;
        default:
            echo "<div align='center'>
            <img src='blok/n3.png'>
            </div>";
            break;
    }
    while ($row = mysqli_fetch_assoc($result)){
        echo "<p class='narrow'>".$row['godzina']."</p>";
        echo "<p class='narrow bold colored'>" .$row['przedmiot']."</p>";
        echo "<p class='narrow italic bottom-buffer' style='margin-bottom: 18px;'>".$row['miejsce']."</p>";
    }
}

function print_enroll_menu(){
    $g = h_att('g');
    $h = h_att('h');
    $r = h_att('r');
    $s = h_att('s');
    $all = att('all');
    $res = att('res');
    echo "<div align='center'>
            <img src='blok/3.png'>
            </div>
            <ul class='no-indent'>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/zapisy_u.php'>
                        Zapisy na ucznia
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/zapisy_n.php'>
                        Zapisy na nauczyciela
                    </a>
                </li>
                
             
            </ul><br><table><tr><th></th><th>Uczniów</th></tr>
            <tr><td><p class='narrow gryff'>Gryffindor</p></td><td class='gryff house-att'>$g</td></tr>
            <tr><td><p class='narrow huff'>Hufflepuff</p></td><td class='huff house-att'>$h</td></tr>
            <tr><td><p class='narrow rav'>Ravenclaw</p></td><td class='rav house-att'>$r</td></tr>
            <tr><td><p class='narrow slyth'>Slytherin</p></td><td class='slyth house-att'>$s</td></tr>
            <tr><td><p class='narrow'>Ogółem</p></td><td class='house-att'>$all</td></tr>
            <tr><td><p class='narrow'>W rezerwie</p></td><td class='house-att'>$res</td></tr>
            </table>
            <ul class='no-indent'>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=92'>
                        Zarząd
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=22'>
                        Skład dyrekcji
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/spis.php?show=nauczyciele'>
                        Lista profesorów
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=96'>
                        Lista pracowników
                    </a>
                </li>
                <li class='menu'>
                    <a class = 'pupil' href='http://wh.boo.pl/spis.php?show=uczniowie'>
                        Lista uczniów </a></li><li class='pupils'>
                        <a class='gryff' href='http://wh.boo.pl/spis.php?show=gryffindor'>&#9679;</a>
                        <a class='huff' href='http://wh.boo.pl/spis.php?show=hufflepuff'>&#9679;</a>
                        <a class='rav' href='http://wh.boo.pl/spis.php?show=ravenclaw'>&#9679;</a>
                        <a class='slyth' href='http://wh.boo.pl/spis.php?show=slytherin'>&#9679;</a>
                   
                </li>
                
             
            </ul>";
}