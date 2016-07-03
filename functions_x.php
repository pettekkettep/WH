<?php

function db_statement(){

    #dbConnection
    include('db_config.php');

    $dbConnection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    mysqli_query($dbConnection, 'SET NAMES utf8');
    // Check connection
    if (!$dbConnection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $args = func_get_args();
    if(count($args) < 3){
        $sql = $args[0];
        $result = mysqli_query($dbConnection, $sql);
        return $result;
    } else {
        $sql = $args[0];
        $types = $args[1];
        $params = $args[2];
        $option = $args[3];
        $stmt = mysqli_prepare($dbConnection,$sql);
        if ($stmt === false) {
            trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($dbConnection)), E_USER_ERROR);
            return false;
        }
        $bind = call_user_func_array('mysqli_stmt_bind_param', array_merge (array($stmt, $types), $params));
        //$bind = call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $params));
        if ($bind === false) {
            trigger_error('Bind param failed!', E_USER_ERROR);
            return false;
        }
        $exec = mysqli_stmt_execute($stmt);
        if ($exec === false) {
            trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
            return false;
        } else {
            $result = array();
            if($option == 'news_feed') {
                $stmt->bind_result($id, $title, $author, $date);
                while ($stmt->fetch()) {
                    array_push($result, array("id" => $id, "title" => $title, "author" => $author, "date" => $date));
                }
            }
            if($option == 'pupil_list') {
                $stmt->bind_result($imie, $nazwisko, $nick, $mail, $dom, $klasa);
                while ($stmt->fetch()) {
                    array_push($result, array("imie" => $imie, "nazwisko" => $nazwisko, "nick" => $nick, "dom" => $dom, "mail" => $mail, "klasa" => $klasa));
                }
            }
            if($option == 'login') {
                $stmt->bind_result($id);
                while ($stmt->fetch()) {
                    array_push($result, array("id" => $id));
                }
            }
            if($option == 'login_root') {
                $stmt->bind_result($access);
                while ($stmt->fetch()) {
                    array_push($result, array("access" => $access));
                }
            }
            if($option == 'edit_date') {
                $stmt->bind_result($content_1, $content_2, $expiry_date, $hyperlink);
                while ($stmt->fetch()) {
                    array_push($result, array("content_1" => $content_1, "content_2" => $content_2, "expiry_date" => $expiry_date, "hyperlink" => $hyperlink));
                }
            }
            return $result;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($dbConnection);
        return true;
    }
}

function print_last_news($amount_to_show = 5){

    $sql = "SELECT id, title, author, date FROM news ORDER BY date DESC LIMIT ?";
    $result = db_statement($sql, "i", array(&$amount_to_show), 'news_feed');

//        echo "<ul>";
//        while ($row = mysqli_fetch_assoc($result)) {
//            echo "<li><a href='/news.php?id='" . $row['id'] . ">" . $row['title'] . "</a> autor: " . $row['author'] . "</li>";
//        }
//        echo "</ul>";
    echo "<h4>Ostatnie newsy</h4>";
    echo "<ul class='no-indent'>";
    foreach ($result as $row) {
        echo "<li class='latest'><a href='/news.php?id=" . $row['id'] . "'>" . $row['title'] . "</a> | autor: " . $row['author'] . " | <i>" . time_description($row['date']) ."</i></li>";
    }
    echo "</ul>";
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
    if($days > 7){
        return $mysqldate;
    }
    else if($days < 3) {
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
                || ($minutes < 45 && $minutes > 41) || ($minutes < 55 && $minutes > 51) ||
                ($minutes < 65 && $minutes > 61) || ($minutes == 72)
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

function print_g_points(){
    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                    WHERE zmiana =  'Dodał' AND id_dom = 1 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['suma'];

    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                    WHERE zmiana =  'Odjął' AND id_dom = 1 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['suma'];

    return $plus - $minus;
}

function print_s_points(){
    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                        WHERE zmiana =  'Dodał' AND id_dom = 2 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['suma'];

    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                        WHERE zmiana =  'Odjął' AND id_dom = 2 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['suma'];

    return $plus - $minus;
}

function print_r_points(){
    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                        WHERE zmiana =  'Dodał' AND id_dom = 3 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['suma'];

    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                        WHERE zmiana =  'Odjął' AND id_dom = 3 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['suma'];

    return $plus - $minus;
}

function print_h_points(){
    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                        WHERE zmiana =  'Dodał' AND id_dom = 4 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $plus = $row['suma'];

    $sql = "SELECT id_dom, SUM( ile ) AS suma FROM punkty_opis 
                        WHERE zmiana =  'Odjął' AND id_dom = 4 GROUP BY id_dom";

    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $minus = $row['suma'];

    return $plus - $minus;
}

function print_pts_table(){

    $g = sprintf("%05d", print_g_points());
    $h = sprintf("%05d", print_h_points());
    $r = sprintf("%05d", print_r_points());
    $s = sprintf("%05d", print_s_points());

    echo "<table class='pts'>";
    echo "<tr><td><p class='house gryff'>Gryffindor</p></td><td><p class='score'>$g  </p></td></tr>";
    echo "<tr><td><p class='house huff'>Hufflepuff</p></td><td><p class='score'> $h </p></td></tr>";
    echo "<tr><td><p class='house rav'>Ravenclaw</p></td><td><p class='score'> $r </p></td></tr>";
    echo "<tr><td><p class='house slyth'>Slytherin</p></td><td><p class='score'> $s </p></td></tr>";
    echo "</table>";

}

function days_since(){
    $now = time(); // or your date as well
    $your_date = strtotime("2006-01-15");
    $datediff = $now - $your_date;
    return floor($datediff/(60*60*24));
}

function paginate($sql, $href, $rows_per_page = 10, $page = 1, $array_of_arg = array()){

    include('db_config.php');

    $dbConnection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    $result = mysqli_query($dbConnection, $sql);
    // sprawdzenie, ile rekordów trzeba "spaginować"
    $rows = mysqli_num_rows($result);
    $pages = intval(ceil($rows / $rows_per_page)); //ile stron
    //start, end - sąsiedztwo obecnie wybranej strony
    if(($page < 1 || $page > $pages)){
        $page = 1;
    }
    $start = $page - 2; //page = obecnie wybrana strona
    $end = $start + 4;
    //prev, next - poprzednia, kolejna strona względem obecnej
    $prev = $page - 1;
    $next = $page + 1;

    if ($pages > 1) {
        echo "<row><div class='paginator'><ul class='pagination pagination-sm'>";
        // disable button <<, jeśli ZNAJDUJESZ SIĘ na pierwszej stronie
        if ($page != 1) echo "<li><a href='$href?p=$prev'>&laquo;</span></a></li><li><a href = '$href?p=1'>1   </a></li>";
        else echo "<li class='disabled'><a href='$href?p=$prev'>&laquo;</span></a></li><li class='active'><a>1 </a></li>";
        // jeśli "sąsiedztwo" danej strony wychodzi poza zakres 2:pages-1, odpowiednio ogranicz
        if ($start <= 2) $start = 2;
        else echo "<li><a>...</a></li>";
        if ($end >= $pages) $end = $pages - 1;
        // wyświetl "sąsiedztwo" obecnej strony w pętli
        while ($start <= $end) {
            if ($start == $page) echo "<li class='active'><a>$start</a></li>"; //wybraną stronę zaznacz jako "aktywną"
            else echo "<li><a href = '$href?p=$start'>$start</a></li>";
            $start = $start + 1;
        }
        if ($end != $pages - 1) echo "<li><a>...</a></li>";
        //disable button >> jeśli ZNAJDUJESZ SIĘ na ostatniej stronie
        if ($page != $pages) echo "<li><a href = '$href?p=$pages'>$pages</a></li><li><a href='$href?p=$next'>&raquo;</span></a></li>";
        else {
            if ($pages != 1) echo "<li class='active'><a>$pages</a></li>";
            echo "<li class='disabled'><a>&raquo;</span></a></li>";
        }
        echo "</ul></div>";

    }
    //oblicz, od którego rekordu pokazywać
    $start_limit = ($rows_per_page * ($page - 1));
    //sformułowanie zapytania do SQL
    return $sql . " LIMIT " . $start_limit . "," . $rows_per_page;
}

function print_news_buttons($id, $textcd){
    $extra = "'" . "rest$id" . "'";
    $comment = "'" . "comment$id" . "'";
    $comments = "'" . "comments$id" . "'";
    if($textcd != "" && $textcd != "&nbsp;") echo '<input type="button" class="news-btn" onclick="return toggleMe(' . $extra . ');" value="Pokaż resztę"</input>';
    echo '<input type="button" class="news-btn" onclick="return toggleMe(' . $comment . ');" value="Dodaj komentarz"</input>';
    if(how_many_comments($id) != 0) echo '<input type="button" class="news-btn" onclick="return toggleMe(' . $comments . ');" value="Pokaż komentarze (' . how_many_comments($id). ')"></input>';
}

function print_news_extra($id, $extra){
    echo "<div class='extra' id='rest$id'>" . $extra;
    echo "</div>";
}

function print_comment_box($id){
    echo "<div class='comment-box' id='comment$id'>";
    echo "<div class='basic-form form-sleek'><form action='/index_x.php' method='post'>";
    echo "Podpis <input type='text' name='user' required></input>";
    echo "Treść <input type='text' name='comment' maxlength='200' required></input>";
    echo "<input type='hidden' name='newsid' value='$id'>";
    echo "<p class='robotic' id='pot'><label>Jeśli widzisz to pole, to zostaw je puste</label>";
    echo "<input name='robotest' type='text' id='robotest' class='robotest'>";
    echo "</p>";
    echo "<input class='narrow' type='submit' value='Wyślij komentarz!'></input>";
    echo "</form></div></div>";
}

function print_comments_of_news($id){
    $sql = "SELECT date, name, text FROM comments WHERE wid = $id";
    $result = db_statement($sql);
    echo "<div class='box-of-comments' id='comments" ."$id" ."'>";
    echo "<table class='generic-table-no-borders'>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr><td class='top left'>".$row['name']."</td><td class='top'>".$row['text']."</td><td class='top right'>".time_description($row['date'])."</td></tr>";
    }
    echo "</table></div>";
}

function add_comment_to_news($user, $comment, $newsid){
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO comments (name, text, wid, ip) VALUES(?,?,?,?)";
    $processed = db_statement($sql, 'ssis', array(&$user, &$comment, &$newsid, &$ip));
}

function how_many_comments($id){
    $sql = "SELECT COUNT(*) as ile FROM comments WHERE wid = $id";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['ile'];
}

function print_feed($page){
    $sql = "SELECT id, date, title, text, textcd, comments, icon, author FROM `news` WHERE stat = 1 ORDER BY date DESC";
    $sql_pag = paginate($sql, 'index_x.php', 10, $page);
    $result = db_statement($sql_pag);

    while ($row = mysqli_fetch_assoc($result)){
        $no_of_comments = how_many_comments($row['id']);
        echo "<div class='row row-news'>";
        echo "<p class='news-title'>&#240;''ä'KOMUNIKAT'NR'". $row['id'] . "'ä''ñ</p>";
        echo "<p class='news-details'>Autor: ". $row['author'] ."</p>";
        echo "<p class='news-details'>Dodano: ". $row['date'] ."</p>";
        echo "<p class='news-details'>Liczba komentarzy: ". $no_of_comments . "</p>";
        echo "<img class='news-avatar' src='". $row['icon'] ."'><br><br>";
        echo $row['text'];
        print_news_extra($row['id'], $row['textcd']);
        print_news_buttons($row['id'], $row['textcd']);
        print_comments_of_news($row['id']);
        print_comment_box($row['id']);
        echo "</div>";
    }

    paginate($sql, 'index_x.php', 10, $page);

//    while ($row = mysqli_fetch_assoc($result)){
//        echo "<div class='row row-news'>";
//        echo "<h2> Ogłoszenie nr ". $row['id'] . " podpisano ". $row['author'] ."</h2>";
//        echo "<h3> Wydano: ". $row['date'] .", liczba komentarzy: ". $row['comments']. "</h3>";
//        echo "<img class='news-avatar' src='". $row['icon'] ."'>";
//        echo "</div>";
//    }

}

function print_left_first(){
    echo "<div align='center'>
            <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/menu.png'>
            </div>
            <ul class='no-indent'>
                <li class='menu'>
                    <a href='/panel_enter.php'>
                        Administracja
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl'>
                        Zamek
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=19'>
                        Obrazki do newsów
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/poradnik.pdf'>
                        <b>PORADNIK</b>
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=114'>
                        Regulamin chatu
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=18'>
                        Jak wejść na chat?
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=17'>
                        FAQ
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=22'>
                        Znaczniki HTML
                    </a>
                </li>
            </ul>";
}

function print_left_second(){
    echo "<div align='center'>
            <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/oddyrekcji.png'>
            </div>
            <p class='from-head'>OGLOSZENIE 1</p>
            <p class='from-head'>OGLOSZENIE 2</p>";
}

function h_att($dom){
    switch ($dom) {
        case 'g':
            $kolor = '#ff0000';
            break;
        case 'h':
            $kolor = '#ffcc00';
            break;
        case 'r':
            $kolor = '0066ff';
            break;
        default:
            $kolor = '00cc00';
            break;
    }
    $sql = "SELECT COUNT(*) AS ile FROM zapisy_u WHERE dom = '$kolor'";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['ile'];
}

function print_enroll_menu(){
    $g = h_att('g');
    $h = h_att('h');
    $r = h_att('r');
    $s = h_att('s');
    echo "<div align='center'>
            <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/zapisy.png'>
            </div>
            <ul class='no-indent'>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/zapisy.php?akcja=uczen'>
                        Zapisy na ucznia
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/zapisy.php?akcja=nauczyciel'>
                        Zapisy na nauczyciela
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/zapisy.php?akcja=pracownik'>
                        Zapisy na pracownika
                    </a>
                </li>
             
            </ul><br><table><tr><th></th><th>Uczniów</th></tr>
            <tr><td><p class='gryff'>Gryffindor</p></td><td class='gryff house-att'>$g</td></tr>
            <tr><td><p class='huff'>Hufflepuff</p></td><td class='huff house-att'>$h</td></tr>
            <tr><td><p class='rav'>Ravenclaw</p></td><td class='rav house-att'>$r</td></tr>
            <tr><td><p class='slyth'>Slytherin</p></td><td class='slyth house-att'>$s</td></tr>
            </table>
            <ul class='no-indent'>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=15'>
                        Skład dyrekcji
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/zapisy.php?akcja=nauczyciel'>
                        Lista profesorów
                    </a>
                </li>
                <li class='menu'>
                    <a class = 'pupil' href='http://wh.boo.pl/zapisy.php?akcja=uczen'>
                        Lista uczniów </a></li><li class='pupils'>
                        <a class='gryff' href='http://wh.boo.pl/zapisy.php?dom=gryffindor'>&#9899;</a>
                        <a class='huff' href='http://wh.boo.pl/zapisy.php?dom=hufflepuff'>&#9899;</a>
                        <a class='rav' href='http://wh.boo.pl/zapisy.php?dom=ravenclaw'>&#9899;</a>
                        <a class='slyth' href='http://wh.boo.pl/zapisy.php?dom=slytherin'>&#9899;</a>
                   
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/zapisy.php?akcja=pracownik'>
                        Lista pracowników
                    </a>
                </li>
             
            </ul>";
}

function print_pupil_search(){
    echo "Wyszukaj ucznia:
        <form action='/uczen.php' method='post'>
             <input type='text' name='name' placeholder='Imię/nazwisko/mail/nick' required>
             <span>
                 <button>>></button>
             </span>
        </form>";
}

function print_pupil_search_result($query){

    $query = "%" . $query . "%";
    $sql = "SELECT imie, nazwisko, nick, mail, dom, klasa FROM zapisy_u 
            WHERE (imie LIKE ? OR nazwisko LIKE ? OR nick LIKE ? OR mail LIKE ?) 
            ORDER BY dom";

    $result = db_statement($sql, "ssss", array(&$query, &$query, &$query, &$query), 'pupil_list');
    $rows = sizeof($result);
    if($query == NULL)
    {
        echo "Wprowadź zapytanie";
        exit;
    }
    if($rows == 0){
        echo "Brak uczniów o zadanych kryteriach";
    }
    elseif ($rows > 50){
        echo "Ponad 50 uczniów spełniających zadane kryteria. Więcej konkretów!";
    }
    else {
        echo "<table width=100%><tr><th width=75%>Imię i nazwisko (mail)</th><th width=20%>Nick</th><th width='5%'>Klasa</th></tr>";
        foreach ($result as $row){
            print_pupil($row);
        }
        echo "</table>";
    }

}

function print_pupil($row){
    switch($row['dom']) {
        case '#ff0000':
            $dom = 'gryff';
            break;
        case '#ffcc00':
            $dom = 'huff';
            break;
        case '0066ff':
            $dom = 'rav';
            break;
        case '00cc00':
            $dom = 'slyth';
            break;
    }
    echo "<tr>
        <td class='$dom'>$row[imie] $row[nazwisko] ($row[mail])</td>
        <td class='$dom'>$row[nick]</td>
        <td class='$dom'>$row[klasa]</td>
    </tr>";
}

function print_day($class, $day){
    switch($class) {
        case 'I':
            $db = 'plan_lekcji';
            echo "<div align='center'>
            <img src='http://wh.boo.pl/hogwartsfounders/klasa1.png'>
            </div>";
            break;
        case 'II':
            $db = 'plan_lekcji2';
            echo "<div align='center'>
            <img src='http://wh.boo.pl/hogwartsfounders/klasa2.png'>
            </div>";
            break;
        default:
            $db = 'plan_lekcji3';
            echo "<div align='center'>
            <img src='http://wh.boo.pl/hogwartsfounders/klasa3.png'>
            </div>";
            break;
    }

    $sql = "SELECT godzina, przedmiot, miejsce FROM $db
              WHERE dzien = $day ORDER BY godzina";
    $result = db_statement($sql);
    while ($row = mysqli_fetch_assoc($result)){
        echo $row['godzina'] . $row['przedmiot'] . $row['miejsce'] . "<br>";
    }
}

function print_time_table(){
    echo "<div align='center'>
            <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/planlekcji.png'>
            </div>
            <ul class='no-indent'>
                <li class='menu'>
                    <a href='http://wh.boo.pl/plan.php'>
                        Plan dla klasy I
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/plan2.php'>
                        Plan dla klasy II
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/plan3.php'>
                        Plan dla klasy III
                    </a>
                </li>
             
            </ul>";
    $day = date('N');
    print_day('I', $day);
    print_day('II', $day);
    print_day('III', $day);
}

function print_important_dates(){

    $sql = "SELECT content_1, content_2, priority, hyperlink FROM dates WHERE TIMESTAMP(expiry_date) > CURRENT_TIMESTAMP() AND approved = 1 ORDER BY expiry_date";
    $result = db_statement($sql);

    echo "<div align='center'>
            <img src='http://www.wh.boo.pl/hogwartsfounders/waznedaty.png'>
            </div>
            <ul class='no-indent'>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li class='";
        if ($row['priority'] == 1) echo "date imp-date";
        else echo "date";
        echo "'>";
        if ($row['hyperlink'] != NULL) echo "<a href='" . $row['hyperlink'] . "'>";
        echo "<strong>" . $row['content_1'] . "</strong>";
        echo " - " . $row['content_2'];
        if ($row['hyperlink'] != NULL) echo " [KLIK!] </a>";
        echo "</li>";
    }
    echo "</ul>";
}

function print_pub_czaro(){
    echo "<div align='center'>
            <a href='http://chatownik.pl/czat.php?pokoj=pub_czarownica'>
                <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/czaro.png' alt='Wejdź do szkolnego pubu!'>
            </a>
         </div>";
}

function print_castle(){
    echo "<div align='center'>
             <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/zamek.png'>
         </div>
         <ul class='no-indent'>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=1'>
                        Regulamin szkoły
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=2'>
                        System oceniania
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=3'>
                        Oferta edukacyjna
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=4'>
                        Szkolny hymn
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=5'>
                        Programy nauczania
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=24'>
                        Punktowanie uczniów
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=23'>
                        Punktowanie nauczycieli
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/dzienniki.php'>
                        <b>DZIENNIKI</b>
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/oceny.php'>
                        <b>OCENY</b>
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/infopage.php?id=6'>
                        <b>OLIMPIADY</b>
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=108'>
                        Ranking Olimpiad
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=117'>
                        Ranking Konkursów
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=25'>
                        Ranking nauczycieli
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=118'>
                        Złote Feniksy
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=7'>
                        Współpraca
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=112'>
                        Współpraca - Facebook
                    </a>
                </li>
            </ul>";
}

function print_dorm(){
    echo "<div align='center'>
            <a href='http://wh.boo.pl/dormitorium.php'>
                <img src='http://wh.boo.pl/obrazki/dormitoria.gif' alt='Wejdź do szkolnego pubu!'>
            </a>
         </div>";
}

function print_houses_details(){
    echo "<div align='center'>
             <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/domy.png'>
         </div>
         <p class='gryff house-info'> GRYFFINDOR </p>
         <p class='narrow'>Opiekun: <span class='gryff'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='gryff'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='gryff'>Martin McCarthy </span></p>
         
         <p class='huff house-info'> HUFFLEPUFF </p>
         <p class='narrow'>Opiekun: <span class='huff'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='huff'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='huff'>Martin McCarthy </span></p>
         
         <p class='rav house-info'> RAVENCLAW </p>
         <p class='narrow'>Opiekun: <span class='rav'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='rav'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='rav'>Martin McCarthy </span></p>
         
         <p class='slyth house-info'> SLYTHERIN </p>
         <p class='narrow'>Opiekun: <span class='slyth'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='slyth'>Martin McCarthy </span></p>
         <p class='narrow'>Prefekt: <span class='slyth'>Martin McCarthy </span></p>
         
         <div align='center'><br>
         <p class='narrow'>Prefekt naczelny:</p>
         <p class='narrow'>Martin McCarthy</p><br>
         <p class='narrow'>Prefekt naczelny:</p>
         <p class='narrow'>Martin McCarthy</p></div>";


}

function print_kleks(){
    echo "<div align='center'>
             <img src='http://www.wh.boo.pl/hogwartsfounders/bloki/kleks.png'>
             <p>Najnowszy numer kleksa już 27 czerwca!</p>
          </div>
             <p class='narrow'>Red. naczelny: A. Sloan</p>
             <p class='narrow'>Sowa: redakcja.kleks@gmail.com</p>
             <p class='narrow'>Nabór: OTWARTY</p>
         
         <ul class='no-indent'>
                <li class='menu menu-imp'>
                    <a href='http://www.wh.boo.pl/kleks/kleks115.pdf'>
                        Najnowszy numer
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=84'>
                        \"Kleks\"
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=29'>
                        Kalendarium \"Kleksa\"
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=85'>
                        Redakcja
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage.php?id=86'>
                        Działy
                    </a>
                </li>
         </ul>";
}

function users_is_admin($login, $password){
    $sql = "SELECT id FROM admins WHERE nick = ? AND pass = ?";
    $result = db_statement($sql, 'ss', array(&$login, &$password), 'login');
    if(sizeof($result) == 1){
        return true;
    }
    else return false;
}

function users_is_root($login, $password){
    $login = "'" . $login . "'";
    $password = "'" . $password . "'";
    $sql = "SELECT access FROM admins WHERE nick = $login AND pass = $password";/////////////NIE PODOBA MI SIĘ TO
    $result = db_statement($sql);
    if(sizeof($result) == 0){
        die("NIGDY NIE ZNAJDĘ TEGO BłĘDU POZDRO");
    }
    if(sizeof($result) == 1){
        $result = mysqli_fetch_assoc($result);
        if($result['access'] == 'root') return true;
        else return false;
    }
    else return false;
}

function print_admin_toolbox(){
    if(users_is_admin($_SESSION['username'], $_SESSION['password'])) {
        echo "<div id='top'> Zalogowano jako: " . $_SESSION['username'] . " <span class='logout'><a href='?logout=1'>(wyloguj)</a></span><br>";
        echo "<span class='admin'><a href='/panel_add_date.php'>/a/Dodaj ważną datę </a></span>";
    }
    if(users_is_root($_SESSION['username'], $_SESSION['password'])) {
        echo "<span class='root'><a href='/panel_manage_dates.php'>/s/Zatwierdź ważną datę</a></span>";
    }
    echo "</div>";
}

function dates_add_date($author, $content_1, $content_2, $expiry, $priority, $hyperlink){

    $sql = "INSERT INTO dates (author, content_1, content_2, expiry_date, priority, hyperlink) VALUES (?, ?, ?, ?, ?, ?)";
    $processed = db_statement($sql, 'ssssis', array(&$author, &$content_1, &$content_2, &$expiry, &$priority, &$hyperlink));
    return (!$processed);

}

function dates_edit_date($author, $content_1, $content_2, $expiry, $priority, $hyperlink, $id){

    $sql = "UPDATE dates SET author = ?, content_1 = ?, content_2 = ?, expiry_date = ?, priority = ?, hyperlink = ? WHERE id = ?";
    $processed = db_statement($sql, 'ssssisi', array(&$author, &$content_1, &$content_2, &$expiry, &$priority, &$hyperlink, &$id));
    return (!$processed);

}

function print_date_status($date, $approved){
    if(time() > strtotime($date)) {
        echo "przeterminowana";
    }
    else {
        if($approved == 0){
            echo "w poczekalni";
        } else {
            echo "<span class='emphasize'>NA WIDOKU</span>";
        }
    }
}

function print_show_date($approved, $id){
    if($approved == 0){
        echo "<a href='/panel_manage_dates.php?action=show&id=" . $id . "'>[POKAŻ]</a>";
    }
}

function print_hide_date($approved, $id){
    if($approved == 1){
        echo "<a href='/panel_manage_dates.php?action=hide&id=" . $id . "'>[UKRYJ]</a>";
    }
}

function print_date($row){
    echo "<tr>";
    echo "<td>" . $row['author'] . "  (" . $row['created'] . ")" . "</td>";
    echo "<td>" . $row['content_1'] . " - " . $row['content_2'] . "</td>";
    echo "<td>" . $row['expiry_date'] . "</td>";
    echo "<td>"; print_date_status($row['expiry_date'], $row['approved']); echo "</td>";
    echo "<td>" . $row['hyperlink'] . "</td>";
    echo "<td class='td-center'>"; print_show_date($row['approved'], $row['id']); echo "</td>";
    echo "<td class='td-center'>"; print_hide_date($row['approved'], $row['id']); echo "</td>";
    echo "<td class='td-center'>" . "<a href='/panel_add_date.php?action=edit&id=" . $row['id']  . "'>[EDYTUJ]</a>" . "</td>";
    echo "<td class='td-center'>" . "<a href='/panel_manage_dates.php?action=delete&id=" . $row['id']  . "'>[USUŃ]</a>". "</td>";
    echo "</tr>";
}

function print_dates_to_manage(){

    $sql = "SELECT * FROM dates ORDER BY expiry_date DESC";
    $result = db_statement($sql);

    if(mysqli_num_rows($result) == 0) {
        echo "Trochę to dziwne, ale w bazie nie ma żadnych ważnych dat.";
    }
    else {
        echo "<table class='generic-table'><tr><th>Autor (dodano)</th><th>Treść</th><th>Data ważności</th><th>Link</th><th>Obecny status</th><th>POKAŻ</th><th>UKRYJ</th><th>EDYTUJ</th><th>USUŃ</th>";
        while ($row = mysqli_fetch_assoc($result)) {
            print_date($row);
        }
        echo "</table>";
    }
}

function date_show($id){
    $sql = "UPDATE dates SET approved = 1 WHERE id = ?";
    $processed = db_statement($sql, 'i', array(&$id));
    return !$processed;
}

function date_hide($id){
    $sql = "UPDATE dates SET approved = 0 WHERE id = ?";
    $processed = db_statement($sql, 'i', array(&$id));
    return !$processed;
}

function date_delete($id){
    $sql = "DELETE FROM dates WHERE id = ?";
    $processed = db_statement($sql, 'i', array(&$id));
    return !$processed;
}


?>


