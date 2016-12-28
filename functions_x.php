<?php

function dd($variable){
    var_dump($variable);
    die;
}

function return_one_row($colname_to_return, $table_where, $colname_where, $value_where){
    $sql = "SELECT " . $colname_to_return . " FROM " . $table_where . " WHERE " . $colname_where . " = " . $value_where;
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==1) {
        $row = mysqli_fetch_assoc($result);
        return $row[$colname_to_return];
    }
    else return '';
}

function convert_color_to_house($color){
    switch($color){
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
        default:
            $dom = '';
            break;
    }
    return $dom;
}
function trim_input($input){
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}

function db_multi_statement(){
    include('db_config.php');

    $dbConnection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    mysqli_query($dbConnection, 'SET NAMES utf8');
    // Check connection
    if (!$dbConnection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $args = func_get_args();
    $sql = $args[0];
    $result = mysqli_multi_query($dbConnection, $sql);
    return $result;
}

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
                $stmt->bind_result($id, $access);
                while ($stmt->fetch()) {
                    array_push($result, array("id" => $id, "access" => $access));
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
            if($option == 'infopage_id') {
                $stmt->bind_result($title, $text, $textnarrow);
                while ($stmt->fetch()) {
                    array_push($result, array("title" => $title, "text" => $text, "textnarrow" => $textnarrow));
                }
            }
            if($option == 'site_vars') {
                $stmt->bind_result($id, $content, $author, $updated);
                while ($stmt->fetch()) {
                    array_push($result, array("id" => $id, "content" => $content, "author" => $author, "updated" => $updated));
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

    $sql = "SELECT id, title, author, date FROM news WHERE stat = 1 ORDER BY date DESC LIMIT ?";
    $result = db_statement($sql, "i", array(&$amount_to_show), 'news_feed');

    echo "<h4>Ostatnie news<a class='wocolor' href='panel.php'>y</a></h4>";
    echo "<ul class='no-indent'>";
    foreach ($result as $row) {
        echo "<li class='latest'><span class='bold colored'><a href='news_x.php?id=".$row['id']."'>" . $row['title'] . "</a></span> | " . $row['author'] . " | <i>" . time_description($row['date']) ."</i></li>";
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
    echo "<tr><td><a class='wocolor' href='/punkty.php?show=gryffindor'><p class='house gryff'>Gryffindor</p></a></td><td><a class='wocolor' href='/punkty.php?show=gryffindor'><p class='score'>$g  </p></a></td></tr>";
    echo "<tr><td><a class='wocolor' href='/punkty.php?show=hufflepuff'><p class='house huff'>Hufflepuff</p></a></td><td><a class='wocolor' href='/punkty.php?show=hufflepuff'><p class='score'> $h </p></a></td></tr>";
    echo "<tr><td><a class='wocolor' href='/punkty.php?show=ravenclaw'><p class='house rav'>Ravenclaw</p></a></td><td><a class='wocolor' href='/punkty.php?show=ravenclaw'><p class='score'> $r </p></a></td></tr>";
    echo "<tr><td><a class='wocolor' href='/punkty.php?show=slytherin'><p class='house slyth'>Slytherin</p></td><td><a class='wocolor' href='/punkty.php?show=slytherin'><p class='score'> $s </p></a></td></tr>";
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
    $button_extra = "btnrest$id";
    $button_comment = "btncomment$id";
    $button_comments = "btncomments$id";
    $button_extrajs = "'" . "btnrest$id" . "'";
    $button_commentjs = "'" . "btncomment$id" . "'";
    $button_commentsjs = "'" . "btncomments$id" . "'";
    if($textcd != "" && $textcd != "&nbsp;") echo '<input type="button" id="'.$button_extra.'" class="news-btn" onclick="return toggleMe(' . $extra . ', ' . $button_extrajs . ');" value="Pokaż resztę komunikatu"</input>';
    echo '<input type="button" id="'.$button_comment.'" class="news-btn" onclick="return toggleMe(' . $comment . ', ' . $button_commentjs . ');" value="Dodaj komentarz"</input>';
    if(how_many_comments($id) != 0) echo '<input type="button" id="'.$button_comments.'" class="news-btn" onclick="return toggleMe(' . $comments . ', ' . $button_commentsjs . ');" value="Pokaż komentarze"></input>';
}

function print_news_extra($id, $extra){
    echo "<div class='extra' id='rest$id'>" . $extra;
    echo "</div>";
}

function print_comment_box($id){
    echo "<div class='comment-box' id='comment$id'>";
    echo "<div class='basic-form form-sleek'><form action='/index_x.php' method='post'>";
    if(!isset($_SESSION['username'])) echo "Podpis <input type='text' name='user' required></input>";
    echo "Treść <input type='text' name='comment' maxlength='200' required></input>";
    echo "<input type='hidden' name='newsid' value='$id'>";
    echo "<p class='robotic' id='pot'><label>Jeśli widzisz to pole, to zostaw je puste</label>";
    echo "<input name='robotest' type='text' id='robotest' class='robotest'>";
    echo "</p>";
    echo "<input class='narrow' type='submit' value='Wyślij komentarz!'></input>";
    echo "</form></div></div>";
}

function print_comments_of_news($id){
    $sql = "SELECT id, date, name, text FROM comments WHERE wid = $id";
    $result = db_statement($sql);
    echo "<div class='box-of-comments' id='comments" ."$id" ."'>";
    echo "<table class='generic-table-no-borders'>";
    while($row = mysqli_fetch_assoc($result)){
        $commentid = $row['id'];
        echo "<tr><td class='top left'>".$row['name'];
        if(users_is_root($_SESSION['username'], $_SESSION['password'])){
            echo " <i><span class='emphasize'><a href='/index_x.php?comment_delete_id=$commentid'>(usuń)</a></span></i>";
        }
        echo "</td><td class='top'><i>".$row['text']."</i></td><td class='top right'><small>".time_description($row['date'])."</small></td></tr>";
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

function delete_comment_id($id){
    $sql = "DELETE FROM comments WHERE id = ?";
    db_statement($sql, 'i', array(&$id));
}

function print_feed($page){
    $sql = "SELECT id, date, title, text, textcd, comments, icon, author FROM `news` WHERE stat = 1 ORDER BY id DESC";
    $sql_pag = paginate($sql, 'index_x.php', 10, $page);
    $result = db_statement($sql_pag);

    while ($row = mysqli_fetch_assoc($result)){
        $no_of_comments = how_many_comments($row['id']);
        $id = $row['id'];
        echo "<div class='row row-news'>";
        if(users_is_root($_SESSION['username'], $_SESSION['password'])){
            echo "<div class='row center-align'>";
            echo "<a href='edytuj_news.php?id=$id'><div class='button-fitted'>E</div></a>";
            echo "<a href='panel_manage_news.php?akcja=delete&id=$id'><div class='button-fitted'>D</div></a>";
            echo "<a href='panel_manage_news.php?akcja=archive&id=$id'><div class='button-fitted'>A</div></a></div>";
        }
        echo "<p class='news-title'><a class='wocolor' href='news_x.php?id=$id'><span class='colored'>". $row['title'] . "</span></p></a>";
        echo "<p class='news-details'><span class='glyphicon glyphicon-user'></span> Autor: ". $row['author'] ."</p>";
        echo "<p class='news-details'><span class='glyphicon glyphicon-calendar'></span> Dodano: ". $row['date'] ."</p>";
        echo "<p class='news-details'><span class='glyphicon glyphicon-comment'></span> Liczba komentarzy: ". $no_of_comments . "</p>";
        if($row['icon'] != "") echo "<img class='news-avatar' src='". $row['icon'] ."'><br><br>";
        echo $row['text'];
        print_news_extra($row['id'], $row['textcd']);
        print_news_buttons($row['id'], $row['textcd']);
        print_comments_of_news($row['id']);
        print_comment_box($row['id']);
        echo "</div>";
    }

    paginate($sql, 'index_x.php', 10, $page);

}

function print_feed_old($page){
    $sql = "SELECT id, date, title, text, textcd, comments, icon, author FROM `news` WHERE stat = 2 ORDER BY date DESC";
    $sql_pag = paginate($sql, 'old_news.php', 10, $page);
    $result = db_statement($sql_pag);

    while ($row = mysqli_fetch_assoc($result)){
        $no_of_comments = how_many_comments($row['id']);
        echo "<div class='row row-news'>";
        echo "<p class='news-title'>". $row['title'] . "</p>";
        echo "<p class='news-details'>Autor: ". $row['author'] ."</p>";
        echo "<p class='news-details'>Dodano: ". $row['date'] ."</p>";
        echo "<p class='news-details'>Liczba komentarzy: ". $no_of_comments . "</p>";
        if($row['icon'] != "") echo "<img class='news-avatar' src='". $row['icon'] ."'><br><br>";
        echo $row['text'];
        print_news_extra($row['id'], $row['textcd']);
        print_news_buttons($row['id'], $row['textcd']);
        print_comments_of_news($row['id']);
        print_comment_box($row['id']);
        echo "</div>";
    }

    paginate($sql, 'old_news.php', 10, $page);


}

function print_left_first(){
    echo "<div align='center'>
            <img src='blok/1.png' alt='Menu główne'>
            </div>
            <ul class='no-indent'>
                <li class='menu'>
                    <a href='/panel_enter.php'>
                        Administracja
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/index_x.php'>
                        Zamek
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=26'>
                        Obrazki do newsów
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/poradnik.pdf'>
                        <b>PORADNIK</b>
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=81'>
                        Regulamin chatu
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=25'>
                        Jak wejść na chat?
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=24'>
                        FAQ
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=27'>
                        Znaczniki HTML
                    </a>
                </li>
            </ul>";
}

function print_left_second(){
    echo "<div align='center'>
            <img src='blok/2.png'>
            </div>
            <p class='from-head'>"; echo get_var_from_db('ann1'); echo"</p>
            <p class='from-head'>"; echo get_var_from_db('ann2'); echo"</p>
            <p class='from-head'>"; echo get_var_from_db('ann3'); echo"</p>";
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
    $sql = "SELECT COUNT(*) AS ile FROM zapisy_u WHERE dom = '$kolor' AND acc=1";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['ile'];
}

function att($kto){
    if($kto == 'all'){
        $sql = "SELECT COUNT(*) AS ile FROM zapisy_u WHERE acc=1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['ile'];
    }
    else{
        $sql = "SELECT COUNT(*) AS ile FROM zapisy_u WHERE acc=0";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['ile'];
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

function print_pupil_search(){
    echo "Wyszukaj ucznia:
        <form action='/spis.php' method='get' class='form-fancy'>
             <input type='text' name='name' placeholder='Imię/nazwisko/mail/nick' required>
             <span>
                 <input type='submit' value='>>' style='margin: 5px 0 0 0; padding-top: 0px; padding-bottom: 0px; w'>
             </span>
        </form>";
}

function print_pupil_search_result($query){

    if($query == NULL)
    {
        echo "Wprowadź zapytanie";
        exit;
    }

    $query = "%" . $query . "%";
    $sql = "SELECT imie, nazwisko, nick, mail, dom, klasa FROM zapisy_u 
            WHERE (imie LIKE ? OR nazwisko LIKE ? OR nick LIKE ? OR mail LIKE ?) 
            ORDER BY dom";

    $result = db_statement($sql, "ssss", array(&$query, &$query, &$query, &$query), 'pupil_list');
    $rows = sizeof($result);

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
    echo "<tr>
        <td class='$dom'>$row[imie] $row[nazwisko] ($row[mail])</td>
        <td class='$dom'>$row[nick]</td>
        <td class='$dom'>$row[klasa]</td>
    </tr>";
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
    $result = db_statement($sql);

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

function print_time_table(){
    $day = date('N');
    echo "<div align='center'>
            <img src='blok/4.png'>
            </div>
            <ul class='no-indent'>
                <li class='menu'>
                    <a href='http://wh.boo.pl/plan_lekcji.php?klasa=1&dzien=all'>
                        Plan dla klasy I
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/plan_lekcji.php?klasa=2&dzien=all'>
                        Plan dla klasy II
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/plan_lekcji.php?klasa=3&dzien=all'>
                        Plan dla klasy III
                    </a>
                </li>
             
            </ul>";
    
    print_day('I', $day);
    print_day('II', $day);
    print_day('III', $day);
}

function print_time_table_mobile(){
    $day = date('N');

    print_day('I', $day);
    print_day('II', $day);
    print_day('III', $day);
}

function print_important_dates(){

    $sql = "SELECT content_1, content_2, priority, hyperlink FROM dates WHERE TIMESTAMP(expiry_date) > CURRENT_TIMESTAMP() AND approved = 1 ORDER BY expiry_date";
    $result = db_statement($sql);

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

function print_pub_czaro(){
    echo "<div align='center'>
            <a href='http://applet.chatsm.pl/?room=pub_czarownica'>
                <img src='blok/czaro.png' alt='Wejdź do szkolnego pubu!'>
            </a>
         </div>";
}

function print_castle(){
    echo "<div align='center'>
             <img src='blok/7.png'>
         </div>
         <ul class='no-indent'>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=1'>
                        Regulamin szkoły
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=4'>
                        System oceniania
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=10'>
                        Oferta edukacyjna
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=11'>
                        Szkolny hymn
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=12'>
                        Programy nauczania
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=29'>
                        Punktowanie uczniów
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=28'>
                        Punktowanie nauczycieli
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/dzienniki_x.php'>
                        <b>DZIENNIKI</b>
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/oceny_x.php'>
                        <b>OCENY</b>
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/rankinguczniow.php'>
                        <b>RANKING UCZNIÓW</b>
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/pracedomowe.php'>
                        <b>ZADANIA DOMOWE</b>
                    </a>
                </li>
                <li class='menu menu-imp'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=13'>
                        <b>OLIMPIADY</b>
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=78'>
                        Ranking Olimpiad
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=83'>
                        Ranking Konkursów
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=30'>
                        Ranking Nauczycieli
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=84'>
                        Złote Feniksy
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=14'>
                        Współpraca
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=80'>
                        Współpraca - Facebook
                    </a>
                </li>
            </ul>";
}

function print_dorm(){
    echo "<div>
            <a href='http://wh.boo.pl/dormitorium.php'>
                <img style='width: 100%' src='http://wh.boo.pl/obrazki/dormitoria.gif' alt='Dormitoria!'>
            </a>
         </div>";
}

function print_houses_details(){
    echo "<div align='center'>
             <img src='blok/8.png'>
         </div>
         <p class='gryff house-info'> GRYFFINDOR </p>
         <p class='narrow ninety-font'>Opiekun: <span class='gryff'>"; echo get_var_from_db('ghead'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='gryff'>"; echo get_var_from_db('gp1'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='gryff'>"; echo get_var_from_db('gp2'); echo"</span></p>
         <p class='narrow ninety-font'>Kapitan <span class='gryff'>"; echo get_var_from_db('gk'); echo"</span></p>
         <p class='narrow ninety-font'>Specjalista: <span class='gryff'>"; echo get_var_from_db('gs'); echo"</span></p>
         
         <p class='huff house-info'> HUFFLEPUFF </p>
         <p class='narrow ninety-font'>Opiekun: <span class='huff'>"; echo get_var_from_db('hhead'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='huff'>"; echo get_var_from_db('hp1'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='huff'>"; echo get_var_from_db('hp2'); echo"</span></p>
         <p class='narrow ninety-font'>Kapitan: <span class='huff'>"; echo get_var_from_db('hk'); echo"</span></p>
         <p class='narrow ninety-font'>Specjalista: <span class='huff'>"; echo get_var_from_db('hs'); echo"</span></p>
         
         <p class='rav house-info'> RAVENCLAW </p>
         <p class='narrow ninety-font'>Opiekun: <span class='rav'>"; echo get_var_from_db('rhead'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='rav'>"; echo get_var_from_db('rp1'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='rav'>"; echo get_var_from_db('rp2'); echo"</span></p>
         <p class='narrow ninety-font'>Kapitan: <span class='rav'>"; echo get_var_from_db('rk'); echo"</span></p>
         <p class='narrow ninety-font'>Specjalista: <span class='rav'>"; echo get_var_from_db('rs'); echo"</span></p>
         
         <p class='slyth house-info'> SLYTHERIN </p>
         <p class='narrow ninety-font'>Opiekun: <span class='slyth'>"; echo get_var_from_db('shead'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='slyth'>"; echo get_var_from_db('sp1'); echo"</span></p>
         <p class='narrow ninety-font'>Prefekt: <span class='slyth'>"; echo get_var_from_db('sp2'); echo"</span></p>
         <p class='narrow ninety-font'>Kapitan: <span class='slyth'>"; echo get_var_from_db('sk'); echo"</span></p>
         <p class='narrow ninety-font'>Specjalista: <span class='slyth'>"; echo get_var_from_db('ss'); echo"</span></p>
         
         <div align='center'><br>
         <p class='narrow ninety-font'>Prefekt naczelny:</p>
         <p class='narrow ninety-font gryff'>"; echo get_var_from_db('p1'); echo"</p><br>
         <p class='narrow ninety-font'>Prefekt naczelny:</p>
         <p class='narrow ninety-font slyth'>"; echo get_var_from_db('p2'); echo"</p></div>";


}

function print_izba_pamieci(){
    echo "<div align='center'><img src='blok/12.png' alt=''></div>";
    echo "<ul class='no-indent'>";
    echo "<li class='menu menu-imp'><a href='http://wh.boo.pl/infopage_x.php?id=2'>KRONIKA SZKOLNA</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=5'>Lata szkolne</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=6'>Absolwenci</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=7'>Wydane certyfikaty</a></li>";
    echo "<li class='menu menu-imp'><a href='http://wh.boo.pl/infopage_x.php?id=51'>RYWALIZACJA DOMÓW</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=52'>Nagrody dyrektora</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=68'>Wypady do Hogsmeade</a></li>";
    echo '<li class="menu"><a href="http://wh.boo.pl/infopage_x.php?id=82">Dzień z "Kleksem"</a></li>';
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=85'>Chrzest Kotów</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/old_news.php?p=1'>Archiwum ogłoszeń</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=67'>Mur zasłużonych</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=86'>Laureaci Złotych Feniksów</a></li></ul>";

    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=53'>Dyrektorzy</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=93'>Zarząd</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=3'>Nauczyciele</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=54'>Pracownicy</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=55'>Opiekunowie</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=56'>Prefekci naczelni</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=77'>Specjaliści ds. rozrywki</a></li></ul>";

    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=57'>Ligi Quidditcha</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=58'>Turnieje Quidditcha</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=63'>Opiekunowie SLQ</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=62'>Kapitanowie w Quidditchu</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=59'>Mecze międzyszkolne</a></li></ul>";

    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=8'>Ligi Pojedynków</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=94'>Turnieje Pojedynków</a></li></ul>";

    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=60'>Olimpiady szkolne</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=61'>Olimpiady międzyszkolne</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=79'>Mistrzowie Olimpiad</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=87'>Mistrzowie Konkursów</a></li></ul>";

    echo "<!-- stat.4u.pl NiE KaSoWaC --> 
<a target=_top href=\"http://stat.4u.pl/?whboopl\" title=\"statystyki stron WWW\"><img alt=\"stat4u\" src=\"http://adstat.4u.pl/s4u.gif\" border=\"0\"></a> 
<script language=\"JavaScript\" type=\"text/javascript\"> 
<!-- 
function s4upl() { return \"&amp;r=er\";} 
//--> 
</script> 
<script language=\"JavaScript\" type=\"text/javascript\" src=\"http://adstat.4u.pl/s.js?whboopl\"></script> 
<script language=\"JavaScript\" type=\"text/javascript\"> 
<!-- 
s4uext=s4upl(); 
document.write('<img alt=\"stat4u\" src=\"http://stat.4u.pl/cgi-bin/s.cgi?i=whboopl'+s4uext+'\" width=\"1\" height=\"1\">') 
//--> 
</script> 
<noscript><img alt=\"stat4u\" src=\"http://stat.4u.pl/cgi-bin/s.cgi?i=whboopl&amp;r=ns\" width=\"1\" height=\"1\"></noscript> </center>
<!-- stat.4u.pl KoNiEc -->
";
}

function print_kleks(){
    echo "<div align='center'>
             <img src='blok/9.png'>
             <p>Najnowszy numer kleksa już <span class='from-head'>"; echo get_var_from_db('kdate'); echo"!</span></p></div>
             <p class='narrow'>Red. naczelny: <span class='from-head'>"; echo get_var_from_db('knacz'); echo"</span></p>
             <p class='narrow'>Sowa: <span class='from-head'>"; echo get_var_from_db('ksowa'); echo"</span></p>
             <p class='narrow'>Nabór: <span class='from-head'>"; echo get_var_from_db('knab'); echo"</span></p>
         
         <ul class='no-indent'>
                <li class='menu menu-imp'>
                    <a href='http://www.wh.boo.pl/kleks/kleks119.pdf'>
                        Najnowszy numer
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=64'>
                        'Kleks'
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=34'>
                        Kalendarium 'Kleksa'
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=65'>
                        Redakcja
                    </a>
                </li>
                <li class='menu'>
                    <a href='http://wh.boo.pl/infopage_x.php?id=66'>
                        Działy
                    </a>
                </li>
         </ul>";
}

function users_is_admin($login, $password){
    $sql = "SELECT id, access FROM admins WHERE nick = ? AND pass = ?";
    $result = db_statement($sql, 'ss', array(&$login, &$password), 'login');
    if(sizeof($result) == 1){
        $row = $result[0];
        $access = $row['access'];
        if($access == "n-n-n-n-n-n-n-n-n-n-n") return false;
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
        echo "<div id='admin'> Jesteś: " . $_SESSION['username'];
        echo "<a class='wocolor' href='index_x.php?logout=1'><h4><span class='glyphicon glyphicon-log-out'></span> Wyloguj</h4></a>";
        echo "<a class='wocolor' href='index_x.php'><h4><span class='glyphicon glyphicon-home'></span> Strona główna</h4></a>";
        echo "<a class='wocolor' href='panel.php'><h4><span class='glyphicon glyphicon-briefcase'></span> Panel</h4></a>";
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
        echo "<a href='/panel_manage_dates.php?action=show&id=" . $id . "'><div class='button-fitted'>POKAŻ</div></a>";
    }
}

function print_hide_date($approved, $id){
    if($approved == 1){
        echo "<a href='/panel_manage_dates.php?action=hide&id=" . $id . "'><div class='button-fitted'>UKRYJ</div></a>";
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
    echo "<td class='td-center'>" . "<a href='/panel_add_date.php?action=edit&id=" . $row['id']  . "'><div class='button-fitted'>EDYTUJ</div></a>" . "</td>";
    echo "<td class='td-center'>" . "<a href='/panel_manage_dates.php?action=delete&id=" . $row['id']  . "'><div class='button-fitted'>USUŃ</div></a>". "</td>";
    echo "</tr>";
}

function print_dates_to_manage(){

    $sql = "SELECT * FROM dates ORDER BY expiry_date DESC";
    $result = db_statement($sql);

    if(mysqli_num_rows($result) == 0) {
        echo "Trochę to dziwne, ale w bazie nie ma żadnych ważnych dat.";
    }
    else {
        echo "<table class='generic-table dimmed-center-table'><tr><th>Autor (dodano)</th><th>Treść</th><th>Data ważności</th><th>Obecny status</th><th>Link</th><th>POKAŻ</th><th>UKRYJ</th><th>EDYTUJ</th><th>USUŃ</th>";
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

function edit_page_variables($result){

    $ann1 = mysqli_fetch_assoc($result);
    $ann2 = mysqli_fetch_assoc($result);
    $ann3 = mysqli_fetch_assoc($result);
    $ghead = mysqli_fetch_assoc($result);
    $gk = mysqli_fetch_assoc($result);
    $gp1 = mysqli_fetch_assoc($result);
    $gp2 = mysqli_fetch_assoc($result);
    $gs = mysqli_fetch_assoc($result);
    $hhead = mysqli_fetch_assoc($result);
    $hk = mysqli_fetch_assoc($result);
    $hp1 = mysqli_fetch_assoc($result);
    $hp2 = mysqli_fetch_assoc($result);
    $hs = mysqli_fetch_assoc($result);
    $kdate = mysqli_fetch_assoc($result);
    $knab = mysqli_fetch_assoc($result);
    $knacz = mysqli_fetch_assoc($result);
    $ksowa = mysqli_fetch_assoc($result);
    $p1 = mysqli_fetch_assoc($result);
    $p2 = mysqli_fetch_assoc($result);
    $rhead = mysqli_fetch_assoc($result);
    $rk = mysqli_fetch_assoc($result);
    $rp1 = mysqli_fetch_assoc($result);
    $rp2 = mysqli_fetch_assoc($result);
    $rs = mysqli_fetch_assoc($result);
    $shead = mysqli_fetch_assoc($result);
    $sk = mysqli_fetch_assoc($result);
    $sp1 = mysqli_fetch_assoc($result);
    $sp2 = mysqli_fetch_assoc($result);
    $ss = mysqli_fetch_assoc($result);

    echo "<form action='/panel_manage_site_vars.php' method='post'>";
    echo "<div class='col-3'>";
    echo "<div class='basic-form form-sleek'>";
    echo "Od dyrekcji - ogłoszenie 1 <input type='text' name='ann1' value='".$ann1['content']."' required></input>";
    echo "Od dyrekcji - ogłoszenie 2 <input type='text' name='ann2' value='".$ann2['content']."'required></input>";
    echo "Od dyrekcji - ogłoszenie 3 <input type='text' name='ann3' value='".$ann3['content']."'required></input>";
    echo "</div>";
    echo "<div class='basic-form form-sleek'>";
    echo "Gryffindor - opiekun <input type='text' name='ghead' value='".$ghead['content']."'required></input>";
    echo "Hufflepuff - opiekun <input type='text' name='hhead' value='".$hhead['content']."'required></input>";
    echo "Ravenclaw - opiekun <input type='text' name='rhead' value='".$rhead['content']."'required></input>";
    echo "Slytherin - opiekun <input type='text' name='shead' value='".$shead['content']."'required></input>";
    echo "Prefekt naczelny I <input type='text' name='p1' value='".$p1['content']."'required></input>";
    echo "Prefekt naczelny II <input type='text' name='p2' value='".$p2['content']."'required></input>";
    echo "</div></div>";

    echo "<div class='col-3'>";
    echo "<div class='basic-form form-sleek'>";
    echo "Gryffindor - prefekt I <input type='text' name='gp1' value='".$gp1['content']."' required></input>";
    echo "Gryffindor - prefekt II <input type='text' name='gp2' value='".$gp2['content']."' required></input>";
    echo "Hufflepuff - prefekt I <input type='text' name='hp1' value='".$hp1['content']."' required></input>";
    echo "Hufflepuff - prefekt II <input type='text' name='hp2' value='".$hp2['content']."' required></input>";
    echo "Ravenclaw - prefekt I <input type='text' name='rp1' value='".$rp1['content']."'required></input>";
    echo "Ravenclaw - prefekt II <input type='text' name='rp2' value='".$rp2['content']."'required></input>";
    echo "Slytherin - prefekt I <input type='text' name='sp1' value='".$sp1['content']."' required></input>";
    echo "Slytherin - prefekt II <input type='text' name='sp2' value='".$sp2['content']."' required></input>";
    echo "</div></div>";
    echo "<div class='col-3'>";
    echo "<div class='basic-form form-sleek'>";
    echo "Gryffindor - kapitan <input type='text' name='gk' value='".$gk['content']."' required></input>";
    echo "Gryffindor - specjalista <input type='text' name='gs' value='".$gs['content']."' required></input>";
    echo "Hufflepuff - kapitan <input type='text' name='hk' value='".$hk['content']."' required></input>";
    echo "Hufflepuff - specjalista <input type='text' name='hs' value='".$hs['content']."' required></input>";
    echo "Ravenclaw - kapitan <input type='text' name='rk' value='".$rk['content']."'required></input>";
    echo "Ravenclaw - specjalista <input type='text' name='rs' value='".$rs['content']."'required></input>";
    echo "Slytherin - kapitan <input type='text' name='sk' value='".$sk['content']."' required></input>";
    echo "Slytherin - specjalista <input type='text' name='ss' value='".$ss['content']."' required></input>";
    echo "</div></div>";
    echo "<div class='col-3'>";
    echo "<div class='basic-form form-sleek'>";
    echo "Kolejny Kleks - data <input type='text' name='kdate' value='".$kdate['content']."' required></input>";
    echo "Naczelny Kleksa <input type='text' name='knacz' value='".$knacz['content']."' required></input>";
    echo "Sowa Kleksa <input type='text' name='ksowa' value='".$ksowa['content']."' required></input>";
    echo "Nabór Kleksa <input type='text' name='knab' value='".$knab['content']."' required></input>";
    echo "<input class='narrow' type='submit' value='Zapisz zmiany'></input>";
    echo "</div></div>";
    echo "</form>";
}

function get_var_from_db($var){
    $var_st = $var;
    $var = "'".$var."'";
    $sql = "SELECT content FROM main_page_vars WHERE id=$var";
    $result = db_statement($sql);
    $row = mysqli_fetch_assoc($result);
    $text = $row['content'];
    if($var_st != "ann1" && $var_st != "ann2" && $var_st != "ann3" && $var_st != "knacz"&& $var_st != "knab") $text = str_replace(" ","&nbsp;",$text);
    return $text;
}

function print_future_pupils_list(){
    $sql = "SELECT id, imie, nazwisko, nick, mail, why, dom FROM zapisy_u WHERE acc = 0 ORDER BY id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0){
        echo "Nie ma nikogo takiego!";
        return;
    }

    echo "<table class='generic-table dimmed-center-table'><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Nick</th><th>E-mail</th><th>Dlaczego do tego domu?</th><th>Dom marzeń</th><th>Info</th><th>Przyjmij</th><th>Odrzuć</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        switch($row['dom']){
            case '#ff0000':
                $dom = 'gryff';
                $dom_opis = "Gryffindor";
                break;
            case '#ffcc00':
                $dom = 'huff';
                $dom_opis = "Hufflepuff";
                break;
            case '0066ff':
                $dom = 'rav';
                $dom_opis = "Ravenclaw";
                break;
            case '00cc00':
                $dom = 'slyth';
                $dom_opis = "Slytherin";
                break;
        }
        echo "<tr>
                <td class='$dom'>".$row['id']."</td>
                <td class='$dom'>".$row['imie']."</td>
                <td class='$dom'>".$row['nazwisko']."</td>
                <td class='$dom'>".$row['nick']."</td>
                <td class='$dom'>".$row['mail']."</td>
                <td class='$dom'>".$row['why']."</td>
                <td class='$dom'>".$dom_opis."</td>
                <td><a href='profil.php?id=$id&group=u'><div class='button-fitted'>INFO</div></a></td>
                <td><a href='panel_zapisy.php?akcja=przyjmijg&id=$id'><div class='button-fitted'><span class='gryff'>G</span></div></a><a href='panel_zapisy.php?akcja=przyjmijh&id=$id'><div class='button-fitted'><span class='huff'>H</span></div></a><a href='panel_zapisy.php?akcja=przyjmijr&id=$id'><div class='button-fitted'><span class='rav'>R</span></div></a><a href='panel_zapisy.php?akcja=przyjmijs&id=$id'><div class='button-fitted'><span class='slyth'>S</span></div></a></td>
                <td><a href='panel_zapisy.php?akcja=odrzucu&id=$id'><div class='button-fitted'>ODRZUĆ</div></a></td>
             </tr>";
    }
    echo "</table>";
}

function print_pupils_list(){
    $sql = "SELECT id, imie, nazwisko, nick, mail, dom, klasa FROM zapisy_u WHERE acc = 1 ORDER BY dom, klasa";
    $result = db_statement($sql);

    if(mysqli_num_rows($result) == 0){
        echo "Nie ma nikogo takiego!";
        return;
    }

    echo "<table class='generic-table dimmed-center-table'><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Nick</th><th>E-mail</th><th>Klasa</th><th>Info</th><th>Przenieś</th><th>Wyrzuć</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
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
                <td class='$dom'>".$row['id']."</td>
                <td class='$dom'>".$row['imie']."</td>
                <td class='$dom'>".$row['nazwisko']."</td>
                <td class='$dom'>".$row['nick']."</td>
                <td class='$dom'>".$row['mail']."</td>
                <td class='$dom'>".$row['klasa']."</td>
                <td><a href='profil.php?id=$id&group=u'><div class='button-fitted'>INFO</div></a></td>
                <td><a href='panel_zapisy.php?akcja=przenies1&id=$id'><div class='button-fitted'>1</div></a>  <a href='panel_zapisy.php?akcja=przenies2&id=$id'><div class='button-fitted'>2</div></a> <a href='panel_zapisy.php?akcja=przenies3&id=$id'><div class='button-fitted'>3</div></a> <a href='panel_zapisy.php?akcja=absolwent&id=$id'><div class='button-fitted'>ABSOLWENT</div></a></td>
                <td><a href='panel_zapisy.php?akcja=wyrzucu&id=$id'><div class='button-fitted'>WYRZUĆ</div></a></td>
             </tr>";
    }
    echo "</table>";
}

function print_future_teachers_list(){
    $sql = "SELECT id, imie, nazwisko, nick, mail, przedmiot, why, opis, podrecznik FROM zapisy_n WHERE acc = 0 ORDER BY przedmiot, id";
    $result = db_statement($sql);

    if(mysqli_num_rows($result) == 0){
        echo "Nie ma nikogo takiego!";
        return;
    }

    echo "<table class='generic-table dimmed-center-table'><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Nick</th><th>E-mail</th><th>Przedmiot</th><th>Dlaczego ja?</th><th>Akcje</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['imie']."</td>
                <td>".$row['nazwisko']."</td>
                <td>".$row['nick']."</td>
                <td>".$row['mail']."</td>
                <td>".$row['przedmiot']."</td>
                <td><p><span class='emphasize'>Dlaczego ten przedmiot: </span>".$row['why']."</p>
                <p><span class='emphasize'>Opis: </span>".$row['opis']."</p>
                <p><span class='emphasize'>Podręcznik / materiały:</span>".$row['podrecznik']."</p></td>
                <td><a href='profil.php?id=$id&group=n'><div class='button-fitted'>INFO</div></a><a href='panel_zapisy.php?akcja=przyjmijn&id=$id'><div class='button-fitted'>PRZYJMIJ</div></a><a href='panel_zapisy.php?akcja=odrzucn&id=$id'><div class='button-fitted'>ODRZUĆ</div></a></td>
             </tr>";
    }
    echo "</table>";
}

function print_teachers_list(){
    $sql = "SELECT id, imie, nazwisko, nick, mail, przedmiot FROM zapisy_n WHERE acc = 1 ORDER BY id";
    $result = db_statement($sql);

    if(mysqli_num_rows($result) == 0){
        echo "Nie ma nikogo takiego!";
        return;
    }

    echo "<table class='generic-table dimmed-center-table'><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Nick</th><th>E-mail</th><th>Przedmiot</th><th>Akcje</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['imie']."</td>
                <td>".$row['nazwisko']."</td>
                <td>".$row['nick']."</td>
                <td>".$row['mail']."</td>
                <td>".$row['przedmiot']."</td>
                <td><a href='profil.php?id=$id&group=n'><div class='button-fitted'>INFO</div><a href='panel_zapisy.php?akcja=wyrzucn&id=$id'><div class='button-fitted'>WYRZUĆ</div></a></td>
             </tr>";
    }
    echo "</table>";
}

function print_profile($id, $group){
    if($group == "u"){
        $sql = "SELECT * FROM zapisy_u WHERE id = $id";
        $result = db_statement($sql);
        if(mysqli_num_rows($result) != 1) echo("<h1>Nie ma takiego ucznia!</h1>");
        else {
            $row = mysqli_fetch_assoc($result);

            switch ($row['dom']) {
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
            echo "<h1 class='$dom img-logo'>" . $row['imie'] . " " . $row['nazwisko'] . "</h1>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z5.png'>";
            echo "<ul>";
            echo "<li><span class='$dom'>Imię i nazwisko</span>: " . $row['imie'] . " " . $row['nazwisko'];
            echo "<li><span class='$dom'>Nick na chacie</span>: " . $row['nick'];
            echo "<li><span class='$dom'>Sowa (e-mail)</span>: " . $row['mail'];
            echo "</ul></div>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z1.png'>";
            echo "<ul>";
            echo "<li><span class='$dom'>Drewno</span>: " . $row['drewno'];
            echo "<li><span class='$dom'>Rdzeń</span>: " . $row['rdzen'];
            echo "<li><span class='$dom'>Długość</span>: " . $row['dlugosc1'] . " " . $row['dlugosc2'];
            echo "<li><span class='$dom'>Elastyczność</span>: " . $row['elastycznosc'];
            echo "<li><span class='$dom'>Specjalna właściwość</span>: " . $row['wlasciwosc'];
            echo "</ul></div>";
            echo "<div class='row'>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z2.png'>";
            echo "<div align='center'><img src = 'http://www.wh.boo.pl/uploads/sklepy/przedmioty/" . $row['miotla'] . "'</div></div></div><br>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z3.png'>";
            echo "<div align='center'><img src = 'http://www.wh.boo.pl/uploads/sklepy/przedmioty/" . $row['zwierze'] . "'<br><p class='$dom'><b>" . $row['name'] . "</b></p></div></div></div>";
        }
    }

    if($group == "n"){
        $sql = "SELECT * FROM zapisy_n WHERE id = $id";
        $result = db_statement($sql);
        if(mysqli_num_rows($result) != 1) echo("<h1>Nie ma takiego nauczyciela!</h1>");
        else {
            $row = mysqli_fetch_assoc($result);

            echo "<h1 class='img-logo'>" . $row['imie'] . " " . $row['nazwisko'] . "</h1>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z4.png'>";
            echo "<ul>";
            echo "<li><span>Imię i nazwisko</span>: " . $row['imie'] . " " . $row['nazwisko'];
            echo "<li><span>Przedmiot</span>: " . $row['przedmiot'];
            echo "<li><span>Nick na chacie</span>: " . $row['nick'];
            echo "<li><span>Sowa (e-mail)</span>: " . $row['mail'];
            echo "</ul></div>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z1.png'>";
            echo "<ul>";
            echo "<li><span>Drewno</span>: " . $row['drewno'];
            echo "<li><span>Rdzeń</span>: " . $row['rdzen'];
            echo "<li><span>Długość</span>: " . $row['dlugosc1'] . " " . $row['dlugosc2'];
            echo "<li><span>Elastyczność</span>: " . $row['elastycznosc'];
            echo "<li><span>Specjalna właściwość</span>: " . $row['wlasciwosc'];
            echo "</ul></div>";
            echo "<div class='row'>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z2.png'>";
            echo "<div align='center'><img src = 'http://www.wh.boo.pl/uploads/sklepy/przedmioty/" . $row['miotla'] . "'</div></div></div><br>";
            echo "<div class='col-6'>";
            echo "<img src='http://wh.boo.pl/belki/Z3.png'>";
            echo "<div align='center'><img src = 'http://www.wh.boo.pl/uploads/sklepy/przedmioty/" . $row['zwierze'] . "'<br><p><b>" . $row['name'] . "</b></p></div></div></div>";
        }
    }
}

function calc_delay($lesson, $created){
//    $lesson = strtotime($lesson);
//    $lesson = date( 'Y-m-d', $lesson);
    $lesson = date_create($lesson);
//    $created = strtotime($created);
//    $created = date ('Y-m-d', $created);
    $created = date_create($created);
    $spoznienie = date_diff($created, $lesson);
    $spoznienie = $spoznienie->days;
    $spoznienie = intval($spoznienie);
    if($spoznienie > 3){
        $spoznienie = $spoznienie - 3;
        return "NIE (dni spóźnienia: $spoznienie)";
    }
    else{
        $spoznienie = 3 - $spoznienie;
        if($spoznienie == 0) return "TAK";
        return "TAK (dni wyprzedzenia: $spoznienie)";
    }
}

function print_table_of($show){
    if($show == "uczniowie"){
        $sql = "SELECT id, imie, nazwisko, dom, nick, mail, klasa FROM zapisy_u ORDER BY dom, klasa";
        $result = db_statement($sql);
        if($result == false){
            echo "<h1>Tak się nie bawimy</h1>";
            return;
        }
        if(mysqli_num_rows($result)<1) echo "<h1>Brak uczniów</h1>";
        else {
            echo "<h1>Spis uczniów</h1>";
//            echo "<table class='spis-table img-logo spis-table-gen'><tr><th>Imię i nazwisko</th><th class='no-wrap-fit'>Klasa</th><th>Mail | Nick</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
            echo "<table class='spis-table img-logo spis-table-gen'><tr><th>Dane</th><th class='no-wrap-fit'>Klasa</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
            while ($uczen = mysqli_fetch_assoc($result)) {
                $imie = $uczen['imie'];
                $nazwisko = $uczen['nazwisko'];
                $mail = $uczen['mail'];
                $nick = $uczen['nick'];
                $id = $uczen['id'];
                $klasa = $uczen['klasa'];
                $dom = convert_color_to_house($uczen['dom']);
                echo "<tr class='$dom'>";
                echo "<td><div class='spis-hover'>$imie $nazwisko<div class='spis-details'><p class='narrow'>Mail: $mail</p><p class='narrow'>Nick: $nick</p></div></div></td>";
                echo "<td>$klasa</td>";
                echo "<td class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></td></tr>";
                echo "</tr>";
//                if (strlen($imie.$nazwisko) > 20) echo "<tr class='$dom no-wrap'><td class='small' rowspan='2'>$imie $nazwisko</td>";
//                else echo "<tr class='$dom no-wrap'><td rowspan='2'>$imie $nazwisko</td>";
//                echo "<td rowspan='2'>$klasa</td>";
//                if (strlen($mail) > 20) echo "<td class='tiny'>$mail</td>";
//                elseif (strlen($mail) > 40) echo "<td></td>";
//                else echo "<td class='small'>$mail</td>";
//                echo "<td rowspan='2' class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td rowspan='2' class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td rowspan='2' class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></tr>";
//                echo "<tr class='$dom'>";
//                if (strlen($nick) > 20) echo "<td class='tiny'>$nick</td>";
//                elseif (strlen($nick) > 40) echo "<td></td>";
//                else echo "<td class='small'>$nick</td>";
//                echo "</tr>";
            }
            echo "</table>";
        }
    }
    elseif($show == "nauczyciele"){
        $sql = "SELECT id, imie, nazwisko, przedmiot, mail FROM zapisy_n WHERE acc = 1 ORDER BY przedmiot";
        $result = db_statement($sql);
        if($result == false){
            echo "<h1>Tak się nie bawimy</h1>";
            return;
        }
        if(mysqli_num_rows($result)<1) echo "<h1>Brak nauczycieli. We don't need no education.</h1>";
        else {
            echo "<h1>Spis nauczycieli</h1>";
            echo "<table class='spis-table img-logo spis-table-gen'><tr><th>Imię i nazwisko</th><th>Mail</th><th>Przedmiot</th><th></th></tr>";
            while ($nauczyciel = mysqli_fetch_assoc($result)) {
                $imie = $nauczyciel['imie'];
                $nazwisko = $nauczyciel['nazwisko'];
                $mail = $nauczyciel['mail'];
                $przedmiot = $nauczyciel['przedmiot'];
                $id = $nauczyciel['id'];
                echo "<tr class='no-wrap'><td>$imie $nazwisko</td>";
                if (strlen($mail) > 40) echo "<td></td>";
                elseif (strlen($mail) > 20) echo "<td class='tiny'>$mail</td>";
                else echo "<td class='small'>$mail</td>";
                echo "<td class='small'>$przedmiot</td>";
                echo "<td class='no-wrap-fit only-big'><a href='profil.php?id=$id&group=n'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td></tr>";
            }
            echo "</table>";
        }
    }
    elseif($show == "gryffindor"){
        $sql = "SELECT id, imie, nazwisko, dom, nick, mail, klasa FROM zapisy_u WHERE dom='#ff0000' ORDER BY klasa";
        $result = db_statement($sql);
        if(mysqli_num_rows($result)<1) echo "<h1>Brak uczniów</h1>";
        else {
            echo "<h1>Spis Gryfonów</h1>";
            echo "<table class='spis-table img-logo spis-table-g'><tr><th>Dane</th><th class='no-wrap-fit'>Klasa</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
            while ($uczen = mysqli_fetch_assoc($result)) {
                $imie = $uczen['imie'];
                $nazwisko = $uczen['nazwisko'];
                $mail = $uczen['mail'];
                $nick = $uczen['nick'];
                $id = $uczen['id'];
                $klasa = $uczen['klasa'];
                $dom = convert_color_to_house($uczen['dom']);
                echo "<tr class='$dom'>";
                echo "<td><div class='spis-hover'>$imie $nazwisko<div class='spis-details'><p class='narrow'>Mail: $mail</p><p class='narrow'>Nick: $nick</p></div></div></td>";
                echo "<td>$klasa</td>";
                echo "<td class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></td></tr>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    elseif($show == "hufflepuff"){
        $sql = "SELECT id, imie, nazwisko, dom, nick, mail, klasa FROM zapisy_u WHERE dom='#ffcc00' ORDER BY klasa";
        $result = db_statement($sql);
        if(mysqli_num_rows($result)<1) echo "<h1>Brak uczniów</h1>";
        else {
            echo "<h1>Spis Puchonów</h1>";
            echo "<table class='spis-table img-logo spis-table-h'><tr><th>Dane</th><th class='no-wrap-fit'>Klasa</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
            while ($uczen = mysqli_fetch_assoc($result)) {
                $imie = $uczen['imie'];
                $nazwisko = $uczen['nazwisko'];
                $mail = $uczen['mail'];
                $nick = $uczen['nick'];
                $id = $uczen['id'];
                $klasa = $uczen['klasa'];
                $dom = convert_color_to_house($uczen['dom']);
                echo "<tr class='$dom'>";
                echo "<td><div class='spis-hover'>$imie $nazwisko<div class='spis-details'><p class='narrow'>Mail: $mail</p><p class='narrow'>Nick: $nick</p></div></div></td>";
                echo "<td>$klasa</td>";
                echo "<td class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></td></tr>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    elseif($show == "ravenclaw"){
        $sql = "SELECT id, imie, nazwisko, dom, nick, mail, klasa FROM zapisy_u WHERE dom='0066ff' ORDER BY klasa";
        $result = db_statement($sql);
        if(mysqli_num_rows($result)<1) echo "<h1>Brak uczniów</h1>";
        else {
            echo "<h1>Spis Krukonów</h1>";
            echo "<table class='spis-table img-logo spis-table-r'><tr><th>Dane</th><th class='no-wrap-fit'>Klasa</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
            while ($uczen = mysqli_fetch_assoc($result)) {
                $imie = $uczen['imie'];
                $nazwisko = $uczen['nazwisko'];
                $mail = $uczen['mail'];
                $nick = $uczen['nick'];
                $id = $uczen['id'];
                $klasa = $uczen['klasa'];
                $dom = convert_color_to_house($uczen['dom']);
                echo "<tr class='$dom'>";
                echo "<td><div class='spis-hover'>$imie $nazwisko<div class='spis-details'><p class='narrow'>Mail: $mail</p><p class='narrow'>Nick: $nick</p></div></div></td>";
                echo "<td>$klasa</td>";
                echo "<td class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></td></tr>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    elseif($show == "slytherin"){
        $sql = "SELECT id, imie, nazwisko, dom, nick, mail, klasa FROM zapisy_u WHERE dom='00cc00' ORDER BY klasa";
        $result = db_statement($sql);
        if(mysqli_num_rows($result)<1) echo "<h1>Brak uczniów</h1>";
        else {
            echo "<h1>Spis Ślizgonów</h1>";
            echo "<table class='spis-table img-logo spis-table-s'><tr><th>Dane</th><th class='no-wrap-fit'>Klasa</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
            while ($uczen = mysqli_fetch_assoc($result)) {
                $imie = $uczen['imie'];
                $nazwisko = $uczen['nazwisko'];
                $mail = $uczen['mail'];
                $nick = $uczen['nick'];
                $id = $uczen['id'];
                $klasa = $uczen['klasa'];
                $dom = convert_color_to_house($uczen['dom']);
                echo "<tr class='$dom'>";
                echo "<td><div class='spis-hover'>$imie $nazwisko<div class='spis-details'><p class='narrow'>Mail: $mail</p><p class='narrow'>Nick: $nick</p></div></div></td>";
                echo "<td>$klasa</td>";
                echo "<td class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></td></tr>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    else{
        echo "<h1>Wsadź se w tyłek to całe $show</h1>";
    }
}


function print_search_of($query){
    $query = trim_input($query);
    $sql = "SELECT id, imie, nazwisko, dom, nick, mail, klasa 
              FROM zapisy_u 
              WHERE (imie LIKE '%$query%' OR nazwisko LIKE '%$query%' OR nick LIKE '%$query%' OR mail LIKE '%$query%')  
              ORDER BY dom, klasa";
    $result = db_statement($sql);
    if($result == false){
        echo "<h1>Tak się nie bawimy</h1>";
        return;
    }
    if(mysqli_num_rows($result)<1) echo "<h1>Brak uczniów</h1>";
    else {
        echo "<h1>Spis uczniów</h1>";
        echo "<table class='spis-table img-logo spis-table-gen'><tr><th>Dane</th><th class='no-wrap-fit'>Klasa</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
        while ($uczen = mysqli_fetch_assoc($result)) {
            $imie = $uczen['imie'];
            $nazwisko = $uczen['nazwisko'];
            $mail = $uczen['mail'];
            $nick = $uczen['nick'];
            $id = $uczen['id'];
            $klasa = $uczen['klasa'];
            $dom = convert_color_to_house($uczen['dom']);
            echo "<tr class='$dom'>";
            echo "<td><div class='spis-hover'>$imie $nazwisko<div class='spis-details'><p class='narrow'>Mail: $mail</p><p class='narrow'>Nick: $nick</p></div></div></td>";
            echo "<td>$klasa</td>";
            echo "<td class='smaller'><a href='profil.php?id=$id&group=u'><div class='button-fitted'>WIĘCEJ&nbsp;INFO</div></a></td><td class='smaller'><a href='oceny_x.php?id=$id'><div class='button-fitted'>OCENY</div></a></td><td class='smaller'><a href='punkty.php?id=$id'><div class='button-fitted'>PUNKTY</div></a></td></tr>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function print_plan_all($klasa){
    $i = 1;
    while($i <= 7){
        $sql = "SELECT * FROM plan WHERE klasa = $klasa AND dzien = $i ORDER BY godzina";
        $result = db_statement($sql);

        switch($i){
            case 1:
                $nazwadnia = "Poniedziałek";
                break;
            case 2:
                $nazwadnia = "Wtorek";
                break;
            case 3:
                $nazwadnia = "Środa";
                break;
            case 4:
                $nazwadnia = "Czwartek";
                break;
            case 5:
                $nazwadnia = "Piątek";
                break;
            case 6:
                $nazwadnia = "Sobota";
                break;
            case 7:
                $nazwadnia = "Niedziela";
                break;
            default:
                $nazwadnia = "";
        }
        echo "<h3 class='top-buffer'>$nazwadnia</h3>";


        if(mysqli_num_rows($result) == 0){
            echo "<h4>Brak lekcji</h4>";
        } else {


            echo "<table class='basic-table center-align sixty-size'>";
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
                echo "<tr><td>";
                echo "<p class='narrow'>" . $row['godzina'] . "</p>";
                echo "<p class='narrow colored bold'>" . $row['przedmiot'];
                if(users_is_root($_SESSION['username'], $_SESSION['password'])) {
                    echo " <a href='/panel_plan_dodaj.php?id=$id'>(edytuj)</a> <a href='/plan_lekcji.php?action=delete&id=$id'>(usuń)</a></p>";
                }
                echo "<p class='narrow italic'>" . $row['miejsce'] . "</p>";
                echo "</td></tr>";
            }
            echo "</table>";
        }
        $i = $i + 1;
    }
}

function print_plan($klasa, $dzien){

    $sql = "SELECT * FROM plan WHERE klasa = $klasa AND dzien = $dzien ORDER BY godzina";
    $result = db_statement($sql);

    if(mysqli_num_rows($result) == 0){
        echo "<h1 class='top-buffer'>Brak lekcji</h1>";
    } else {
        switch($dzien){
            case 1:
                $nazwadnia = "poniedziałek";
                break;
            case 2:
                $nazwadnia = "wtorek";
                break;
            case 3:
                $nazwadnia = "środę";
                break;
            case 4:
                $nazwadnia = "czwartek";
                break;
            case 5:
                $nazwadnia = "piątek";
                break;
            case 6:
                $nazwadnia = "sobotę";
                break;
            case 7:
                $nazwadnia = "niedzielę";
                break;
            default:
                $nazwadnia = "";
        }

        echo "<h1>Plan klasy $klasa na $nazwadnia</h1>";
        echo "<table class='basic-table center-align sixty-size'>";
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>";
            echo "<p class='narrow'>" . $row['godzina'] . "</p>";
            echo "<p class='narrow colored bold'>" . $row['przedmiot'] . "</p>";
            echo "<p class='narrow italic'>" . $row['miejsce'] . "</p>";
            echo "</td></tr>";
        }
        echo "</table>";
    }
    
    $jutro = $dzien + 1;
    if($jutro > 7) $jutro = 1;

    switch($jutro){
        case 1:
            $nazwadniajutro = "poniedziałek";
            break;
        case 2:
            $nazwadniajutro = "wtorek";
            break;
        case 3:
            $nazwadniajutro = "środę";
            break;
        case 4:
            $nazwadniajutro = "czwartek";
            break;
        case 5:
            $nazwadniajutro = "piątek";
            break;
        case 6:
            $nazwadniajutro = "sobotę";
            break;
        case 7:
            $nazwadniajutro = "niedzielę";
            break;
        default:
            $nazwadniajutro = "";
    }
    

    echo "<p class='narrow center-align'><a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=$jutro'>Plan na jutro ($nazwadniajutro)</a></p>";
    if($dzien != 1) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=1'>";
    echo "Poniedziałek";
    if($dzien != 1) echo "</a>";
    echo " | ";
    if($dzien != 2) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=2'>";
    echo "Wtorek";
    if($dzien != 2) echo "</a>";
    echo " | ";
    if($dzien != 3) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=3'>";
    echo "Środę";
    if($dzien != 3) echo "</a>";
    echo " | ";
    if($dzien != 4) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=4'>";
    echo "Czwartek";
    if($dzien != 4) echo "</a>";
    echo " | ";
    if($dzien != 5) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=5'>";
    echo "Piątek";
    if($dzien != 5) echo "</a>";
    echo " | ";
    if($dzien != 6) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=6'>";
    echo "Sobotę";
    if($dzien != 6) echo "</a>";
    echo " | ";
    if($dzien != 7) echo "<a class='wo' href='http://wh.boo.pl/plan_lekcji.php?klasa=$klasa&dzien=7'>";
    echo "Niedzielę";
    if($dzien != 7) echo "</a>";

}

function print_sale(){
    echo "<div align='center'>";
    echo "    <img src='blok/5.png'>";
    echo "</div>";
    echo "<ul class='no-indent'>";
    echo "    <li class='menu menu-imp'> <a href='http://applet.chatsm.pl/?room=pub_czarownica'><b>PUB CZAROWNICA</b></a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_sala_1'>Sala lekcyjna - klasa I</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_sala_2'>Sala lekcyjna - klasa II</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_sala_3'>Sala lekcyjna - klasa III</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_wielka_sala'>Wielka Sala</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_lochy'>Lochy</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_blonia'>Błonia</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_cieplarnia'>Cieplarnia</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_wieza_astronomiczna'>Wieża Astronomiczna</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_wieza_polnocna'>Wieża Północna</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_stadion'>Stadion Quidditcha</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_treningi'>Sala treningowa</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_biblioteka'>Biblioteka</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_nauczyciele'>Pokój nauczycielski</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_kleks'>Pokój redakcji Kleksa</a></li>";
    echo "    <li class='menu'> <a href='http://applet.chatsm.pl/?room=wh_specjalisci'>Pokój Specjalistów</a></li>";
    echo "    <li class='menu'> <a href='http://wh.boo.pl/dormitorium.php'>Dormitoria</a></li>";
    echo "    <li class='menu'> <a class='gryff' href='http://applet.chatsm.pl/?room=wh_gryffindor'>Dormitorium Gryffindoru</a></li>";
    echo "    <li class='menu'> <a class='huff' href='http://applet.chatsm.pl/?room=wh_hufflepuff'>Dormitorium Hufflepuffu</a></li>";
    echo "    <li class='menu'> <a class='rav' href='http://applet.chatsm.pl/?room=wh_ravenclaw'>Dormitorium Ravenclawu</a></li>";
    echo "    <li class='menu'> <a class='slyth' href='http://applet.chatsm.pl/?room=wh_slytherin'>Dormitorium Slytherinu</a></li>";
    echo "</ul>";

}

function print_pokatna(){
    echo "<div align='center'><img src='blok/6.png' alt='' /> <img src='blok/n4.png' alt='' /></div>";
    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='bank_x.php'>Bank Gringotta</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=27'>Apteka</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=28'>Centrum Handlowe Eeylopa</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=30'>Kociołki Potagea</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=31'>Sklep Madame Malkin</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=32'>Magiczna Menażeria</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=33'>Różdżki Ollivandera</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=34'>Magiczne Dowcipy Weasleyów</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=35'>Markowy Sprzęt do Quidditcha</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=36'>Esy i Floresy</a></li>";
    echo "</ul>";
    echo "<div align='center'><img src='blok/n5.png' alt='' /></div>";
    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_hogsmeade'>Rynek Główny</a></li>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_trzy_miotly'>Pub Pod Trzema Miotłami</a></li>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_swinski_leb'>Gospoda Pod Świńskim Łbem</a></li>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_miodowe_krolestwo'>Miodowe Królestwo</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=38'>Sklep Zonka</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=39'>Sklep z Ubraniami Gladraga</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=40'>Sklep Scrivenshafta</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=41'>Dominic Maestro</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=42'>Dogweed & Deathcap</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=29'>Niespodzianki Gambola i Japesa</a></li>";
    echo "<li class='menu'><a href='pokatna_x.php?sklep=37'>Sprzęt Czarodziejski Wiseacra</a></li>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_herbaciarnia'>Herbaciarnia Pani Puddifoot</a></li>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_wrzeszczaca_chata'>Wrzeszcząca Chata</a></li>";
    echo "<li class='menu'><a href='http://applet.chatsm.pl/?room=wh_stacja_kolejowa'>Stacja Kolejowa</a></li>";
    echo "</ul>";
    echo "<div align='center'><img src='blok/n6.png' alt='' /></div>";
    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='pokatna.php?cmd=sklep&sklep=44'>Borgin & Burkes</a></li>";
    echo "</ul>";
}

function print_kp_block(){
    echo "<div align='center'><img src='blok/10.png' alt=''></div>";
    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=15'>Regulamin KP</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=16'>Zaklęcia KP</a></li>";
    echo "<li class='menu menu-imp'><a href='http://wh.boo.pl/infopage_x.php?id=17'>RANKING LIGI POJEDYNKÓW</a></li></ul>";
}

function print_quidd_block(){
    echo "<div align='center'><img src='blok/11.png' alt=''></div>";
    echo "<ul class='no-indent'>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=18'>Zasady Quidditcha</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=19'>Mecze Ligi</a></li>";
    echo "<li class='menu'><a href='http://wh.boo.pl/infopage_x.php?id=20'>Drużyny Ligi</a></li>";
    echo "<li class='menu menu-imp'><a href='http://wh.boo.pl/infopage_x.php?id=21'>RANKING LIGI QUIDDITCHA</a></li></ul>";
}

function print_best_pupils(){
    $best_1 = print_best_pupil(1, 'all');
    $best_1_week = print_best_pupil(1, 'tydzien');
    $best_2 = print_best_pupil(2, 'all');
    $best_2_week = print_best_pupil(2, 'tydzien');
    $best_3 = print_best_pupil(3, 'all');
    $best_3_week = print_best_pupil(3, 'tydzien');
    echo "<div align='center'>";
    echo "<table class='full-width points-table center-align'>";
    echo "<th colspan='3' class='planewalker'>Najlepsi uczniowie</th></tr>";
    echo "<th class='no-wrap-fit'></th><th class='planewalker forty-size'>W tym roku szkolnym</th><th class='planewalker forty-size'>Ostatnie 7 dni</th></tr>";
    echo "<tr><td class='hasTooltip planewalker'>I<span>Klasa I</span></td><td>$best_1</td><td>$best_1_week</td></tr>";
    echo "<tr><td class='hasTooltip planewalker'>II<span>Klasa II</span></td><td>$best_2</td><td>$best_2_week</td></tr>";
    echo "<tr><td class='hasTooltip planewalker'>III<span>Klasa III</span></td><td>$best_3</td><td>$best_3_week</td></tr>";
    echo "</table>";
    echo "<a class='wocolor' href='rankinguczniow.php'><div class='button-best'>POKAŻ CAŁY RANKING</div></a>";
    echo "</div>";
}

function print_best_pupil($klasa, $kiedy){
    if($kiedy == "tydzien"){
        $sql = "SELECT uczen_id, sum(ile) AS suma FROM punkty_opis WHERE zmiana = 'Dodał' AND created >= DATE(NOW()) - INTERVAL 7 DAY AND uczen_id IN (SELECT id FROM zapisy_u WHERE klasa = $klasa)  GROUP BY uczen_id ORDER BY suma DESC LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['uczen_id'];
        $wynik = $row['suma'];

        $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
        $result = db_statement($sql);
        if($result == false) return "";
        $row = mysqli_fetch_assoc($result);
        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];
        $dom = $row['dom'];

        $style = convert_color_to_house($dom);
        return "<span class='$style bold'>".$imie." ".$nazwisko."</span><span class='$style bold bit-smaller'> (".$wynik.")</span>";

    }
    else {
        $sql = "SELECT uczen_id, sum(ile) AS suma FROM punkty_opis WHERE zmiana = 'Dodał' AND uczen_id IN (SELECT id FROM zapisy_u WHERE klasa = $klasa) GROUP BY uczen_id ORDER BY suma DESC LIMIT 1";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['uczen_id'];
        $wynik = $row['suma'];

        $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
        $result = db_statement($sql);
        if($result == false) return "";
        $row = mysqli_fetch_assoc($result);
        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];
        $dom = $row['dom'];

        $style = convert_color_to_house($dom);
        return "<span class='$style bold'>".$imie." ".$nazwisko."</span><span class='$style bold bit-smaller'> (".$wynik.")</span>";
    }
}


function print_best_list($klasa, $kiedy)
{
    if($klasa != 1 && $klasa != 2 && $klasa != 3) $klasa = 1;

    echo "<table class='full-width center-align'><tr><td colspan='2'>";
    echo "<a href='rankinguczniow.php?klasa=1&kiedy=$kiedy' class='wocolor'><div class='";
    if($klasa == 1) echo "button-table-sel";
    else echo "button-table";
    echo "'>KLASA I</div></a></td><td colspan='2'>";
    echo "<a href='rankinguczniow.php?klasa=2&kiedy=$kiedy' class='wocolor'><div class='";
    if($klasa == 2) echo "button-table-sel";
    else echo "button-table";
    echo "'>KLASA II</div></a></td><td colspan='2'>";
    echo "<a href='rankinguczniow.php?klasa=3&kiedy=$kiedy' class='wocolor'><div class='";
    if($klasa == 3) echo "button-table-sel";
    else echo "button-table";
    echo "'>KLASA III</div></a></td></tr>";
    echo "<tr><td colspan='3'>";
    echo "<a href='rankinguczniow.php?klasa=$klasa&kiedy=tydzien' class='wocolor'><div class='";
    if($kiedy == "tydzien") echo "button-table-sel";
    else echo "button-table";
    echo "'>OSTATNI TYDZIEŃ</div></a></td><td colspan='3'>";
    echo "<a href='rankinguczniow.php?klasa=$klasa&kiedy=all' class='wocolor'><div class='";
    if($kiedy != "tydzien") echo "button-table-sel";
    else echo "button-table";
    echo "'>OGÓŁEM</div></a></td></tr></table>";


    if ($kiedy == "tydzien") {
        $sql = "SELECT uczen_id, sum(ile) AS suma FROM punkty_opis WHERE zmiana = 'Dodał' AND created >= DATE(NOW()) - INTERVAL 7 DAY AND uczen_id IN (SELECT id FROM zapisy_u WHERE klasa = $klasa)  GROUP BY uczen_id ORDER BY suma DESC";
        $result = db_statement($sql);
        if (mysqli_num_rows($result) == 0) {
            echo "<h2>Nic do wyświetlenia</h2>";
        } else {
            echo "<table class='black-back basic-table eighty-size center-align'><tr><th>Uczeń/Uczennica</th><th class='hasTooltip'>PKT<span>Liczba punktów</span></th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['uczen_id'];
                $wynik = $row['suma'];

                $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
                $outcome = db_statement($sql);
                $row = mysqli_fetch_assoc($outcome);
                $imie = $row['imie'];
                $nazwisko = $row['nazwisko'];
                $dom = $row['dom'];

                $style = convert_color_to_house($dom);
                echo "<tr class='$style'><td>" . $imie . " " . $nazwisko . "</td><td> " . $wynik . "</td></tr>";
            }
            echo "</table>";
        }


    } else {
        $sql = "SELECT uczen_id, sum(ile) AS suma FROM punkty_opis WHERE zmiana = 'Dodał' AND uczen_id IN (SELECT id FROM zapisy_u WHERE klasa = $klasa)  GROUP BY uczen_id ORDER BY suma DESC";
        $result = db_statement($sql);
        if (mysqli_num_rows($result) == 0) {
            echo "<h2>Nic do wyświetlenia</h2>";
        } else {
            echo "<table class='black-back basic-table eighty-size center-align'><tr><th>Uczeń/Uczennica</th><th class='hasTooltip'>PKT<span>Liczba punktów</span></th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['uczen_id'];
                $wynik = $row['suma'];

                $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
                $outcome = db_statement($sql);
                $row = mysqli_fetch_assoc($outcome);
                $imie = $row['imie'];
                $nazwisko = $row['nazwisko'];
                $dom = $row['dom'];

                $style = convert_color_to_house($dom);
                echo "<tr class='$style'><td>" . $imie . " " . $nazwisko . "</td><td> " . $wynik . "</td></tr>";
            }
            echo "</table>";
        }
    }
}

function print_punkty_of_id($id){
    $sql = "SELECT imie, nazwisko FROM zapisy_u WHERE id=$id";
    $outcome = db_statement($sql);
    if(mysqli_num_rows($outcome)==0) return;
    $osoba = mysqli_fetch_assoc($outcome);
    $imie = $osoba['imie'];
    $nazwisko = $osoba['nazwisko'];
    echo "<h1>Punkty zdobyte przez $imie $nazwisko</h1>";
    echo "<table class='generic-table-no-borders'><tr><th>Dodał</th><th>Ile</th><th class='forty-size'>Za co?</th><th>Kiedy?</th></tr>";

    $sql = "SELECT kto, ile, uzasadnienie, created FROM punkty_opis WHERE uczen_id = $id";
    $result = db_statement($sql);
    while ($row = mysqli_fetch_assoc($result)){
        $kto = $row['kto'];
        $ile = $row['ile'];
        $uzasadnienie = $row['uzasadnienie'];
        $created = $row['created'];
        echo "<tr><td>$kto</td><td>$ile</td><td>$uzasadnienie</td><td>$created</td></tr>";
    }
    echo "</table>";
}

function print_punkty_of_dom($show){

    switch($show){
        case "gryffindor":
            $dom = 1;
            break;
        case "slytherin":
            $dom = 2;
            break;
        case "ravenclaw":
            $dom = 3;
            break;
        case "hufflepuff":
            $dom = 4;
            break;
    }
    $show = ucfirst($show);
    echo "<h1>Punkty zdobyte przez $show</h1>";
    echo "<table class='generic-table-no-borders'><tr><th>Kto</th><th>Dodał</th><th>Ile</th><th class='forty-size'>Za co?</th><th>Kiedy?</th>";
    if(users_is_root($_SESSION['username'], $_SESSION['password'])){
        echo "<th></th>";
    }
    echo "</tr>";

    $sql = "SELECT id, uczen_id, kto, ile, uzasadnienie, created FROM punkty_opis WHERE id_dom = $dom";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==0) {
        echo "</table>";
        return;
    }
    while ($row = mysqli_fetch_assoc($result)){
        $kto = $row['kto'];
        $ile = $row['ile'];
        $uzasadnienie = $row['uzasadnienie'];
        $created = $row['created'];
        $uczen_id = $row['uczen_id'];
        $id = $row['id'];

        $sql = "SELECT imie, nazwisko FROM zapisy_u WHERE id=$uczen_id";
        $outcome = db_statement($sql);
        $osoba = mysqli_fetch_assoc($outcome);
        $imie = $osoba['imie'];
        $nazwisko = $osoba['nazwisko'];
        echo "<tr><td>$imie $nazwisko</td><td>$kto</td><td>$ile</td><td>$uzasadnienie</td><td>$created</td>";
        if(users_is_root($_SESSION['username'], $_SESSION['password'])){
            echo "<td><a href='punkty.php?action=delete&id=$id'><div class='button-fitted'>USUŃ</div></a></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

function print_infopages_list(){
    echo "<table class='generic-table dimmed-center-table'><tr><th class='no-wrap-fit'>ID</th><th>Tytuł</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
    $sql = "SELECT id, title FROM infos";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td><a href='add_infopage.php?id=" . $row['id'] . "'><div class='button-fitted'>EDYTUJ</div></a></td>";
        echo "<td><a href='manage_infopages.php?action=delete&id=" . $row['id'] . "'><div class='button-fitted'>USUŃ</div></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function print_admins_list(){
    echo "<table class='generic-table dimmed-center-table'><tr><th class='no-wrap-fit'>ID</th><th>Nick</th><th>Mail</th><th>Status</th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th><th class='no-wrap-fit'></th></tr>";
    $sql = "SELECT id, nick, access, mail FROM admins ORDER BY added";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nick'] . "</td>";
        echo "<td>" . $row['mail'] . "</td>";
        if($row['access'] == "root") $status = "ROOT";
        elseif($row['access'] == "t-n-n-n-n-n-n-n-n-n-n") $status = "ADMIN";
        else $status = "BEZ UPRAWNIEŃ";
        echo "<td>$status</td>";
        if($status == "ROOT"){
            echo "<td><a href='panel_admin.php?action=admin&id=" . $row['id'] . "'><div class='button-fitted'>DEGRADUJ&nbsp;DO&nbsp;ADMINA</div></a></td>";
            echo "<td>-</td>";
            echo "<td><a href='panel_admin.php?action=delete&id=" . $row['id'] . "'><div class='button-fitted'>USUŃ</div></a></td>";
        }
        elseif($status == "ADMIN"){
            echo "<td><a href='panel_admin.php?action=bez&id=" . $row['id'] . "'><div class='button-fitted'>ODBIERZ&nbsp;UPRAWNIENIA</div></a></td>";
            echo "<td><a href='panel_admin.php?action=root&id=" . $row['id'] . "'><div class='button-fitted'>AWANSUJ&nbsp;NA&nbsp;ROOTA</div></a></td>";
            echo "<td><a href='panel_admin.php?action=delete&id=" . $row['id'] . "'><div class='button-fitted'>USUŃ</div></a></td>";
        }
        elseif($status == "BEZ UPRAWNIEŃ"){
            echo "<td>-</td>";
            echo "<td><a href='panel_admin.php?action=admin&id=" . $row['id'] . "'><div class='button-fitted'>AWANSUJ&nbsp;NA&nbsp;ADMINA</div></a></td>";
            echo "<td><a href='panel_admin.php?action=delete&id=" . $row['id'] . "'><div class='button-fitted'>USUŃ</div></a></td>";
        }

        echo "</tr>";
    }
    echo "</table>";
}

function print_top_5($dom){

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

    $sql = "SELECT uczen_id, sum(ile) AS suma FROM punkty_opis WHERE zmiana = 'Dodał' AND uczen_id IN (SELECT id FROM zapisy_u WHERE dom = '$kolor') GROUP BY uczen_id ORDER BY suma DESC LIMIT 5";
    $result = db_statement($sql);
    echo "<table class='full-width'>";
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['uczen_id'];
        $wynik = $row['suma'];

        $sql = "SELECT imie, nazwisko, dom FROM zapisy_u WHERE id = $id";
        $outcome = db_statement($sql);
        if($outcome == false) echo "";
        $row = mysqli_fetch_assoc($outcome);
        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];
        $dom = $row['dom'];
        $style = convert_color_to_house($dom);

        echo "<tr><td class='bold'>".$imie." ".$nazwisko."</td><td class='no-wrap-fit'> ".$wynik."&nbsp;pkt</span></td></tr>";
    }

    echo "</table>";
}

function print_mobile_top(){
    $sql = "SELECT tresc FROM bloki WHERE strona='mobilegora' ORDER BY kolej";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<div class=\"row row-block-right\">";
            $blok = $row['tresc'];
            eval("?><?".$blok."?><?");
            echo "</div>";
        }
    }
}

function print_mobile_bottom(){
    $sql = "SELECT tresc FROM bloki WHERE strona='mobiledol' ORDER BY kolej";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<div class=\"row row-block-right\">";
            $blok = $row['tresc'];
            eval("?><?".$blok."?><?");
            echo "</div>";
        }
    }
}

function print_left_blocks(){
    $sql = "SELECT tresc FROM bloki WHERE strona='lewa' ORDER BY kolej";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<div class=\"row row-block-left\">";
            $blok = $row['tresc'];
            eval("?><?".$blok."?><?");
            echo "</div>";
        }
    }
}

function print_right_blocks(){
    $sql = "SELECT tresc FROM bloki WHERE strona='prawa' ORDER BY kolej";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<div class=\"row row-block-right\">";
            $blok = $row['tresc'];
            eval("?><?".$blok."?><?");
            echo "</div>";
        }
    }
}

function print_blocks_to_manage(){
    if(isset($_GET['id'])){
        $id = trim_input($_GET['id']);
        $sql = "SELECT nazwa, kolej, tresc, strona FROM bloki WHERE id=$id";
        $result = db_statement($sql);
        $row = mysqli_fetch_assoc($result);
        $nazwa = $row['nazwa'];
        $kolej = $row['kolej'];
        $tresc = $row['tresc'];
        $strona = $row['strona'];
        $_SESSION['edit'] = $id;
    }
    echo "<div class='row'>";
    echo "<div class='col-5'>";
    echo "<div class='basic-form form-sleek'><form action='/panel_manage_blocks.php' method='post'>";
    echo "Nazwa <input type='text' name='nazwa' value='$nazwa' required></input>";
    echo "Miejsce (im mniejsze, tym wyżej) <input type='text' name='kolej' value='$kolej' required></input>";
    echo "Gdzie? <select name='strona'>
            <option "; if ($strona == 'lewa') {echo "selected ";} echo "value='lewa'>Lewa strona</option>
<option "; if ($strona == 'prawa') {echo "selected ";} echo "value='prawa'>Prawa strona</option>
<option "; if ($strona == 'mobilegora') {echo "selected ";} echo "value='mobilegora'>Nad newsami (małe ekrany)</option>
<option "; if ($strona == 'mobiledol') {echo "selected ";} echo "value='mobiledol'>Pod newsami (małe ekrany)</option>
<option "; if ($strona == 'inne') {echo "selected ";} echo "value='inne'>Ukryty</option>
</select>";

    echo "Zawartość <textarea name='tresc' rows='20' required>$tresc</textarea>";
    echo "<input type='submit' value='Stwórz/edytuj blok'></input>";
    echo "</form></div></div>";
    echo "<div class='col-7'>";
    echo "<div class='row'>";
    echo "<h2>Blok lewy (screen)</h2>";
    print_bloki('lewa');
    echo "</div>";
    echo "<div class='row'>";
    echo "<h2>Blok prawy (screen)</h2>";
    print_bloki('prawa');
    echo "</div>";
    echo "<div class='row'>";
    echo "<h2>Blok górny (mobile)</h2>";
    print_bloki('mobilegora');
    echo "</div>";
    echo "<div class='row'>";
    echo "<h2>Blok dolny (mobile)</h2>";
    print_bloki('mobiledol');
    echo "</div>";
    echo "<div class='row'>";
    echo "<h2>Nieużyte bloki</h2>";
    print_bloki('inne');
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

function print_bloki($which){
    $sql = "SELECT * FROM bloki WHERE strona = '$which' ORDER BY kolej";
    echo "<table class='generic-table dimmed-center-table'>";
    echo "<th>Tytuł</th><th>Pozycja</th><th>Pozycja&nbsp;w&nbsp;bloku</th><th>Edycja/usuń</th>";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $nazwa = $row['nazwa'];
        $kolej = $row['kolej'];
        $id = $row['id'];
        echo "<tr><td>$nazwa</td><td>$kolej</td>";
        echo "<td class='no-wrap-fit'><a href='panel_manage_blocks.php?id=$id&action=up'><div class='button-fitted'>GÓRA</div></a><a href='panel_manage_blocks.php?id=$id&action=down'><div class='button-fitted'>DÓŁ</div></a></td>";
        echo "<td class='no-wrap-fit'><a href='panel_manage_blocks.php?id=$id'><div class='button-fitted'>E</div></a><a href='panel_manage_blocks.php?id=$id&action=delete'><div class='button-fitted'>D</div></a></td></tr>";
    }
    echo "</table>";
}

function print_personal($ip){
    $sql = "SELECT kto, data FROM log WHERE ip = '$ip'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) echo "<h3>Log z panelu</h3><table class='basic-table dimmed-center-table' style='width: 40%; margin-left: 30%'><tr><th>Kto?</th><th>Data</th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        $kto = $row['kto'];
        $data = $row['data'];
        echo "<tr><td>$kto</td><td>$data</td></tr>";
    }
    if(mysqli_num_rows($result)>0) echo "</table>";
    else echo "<p>Nic nie znaleziono w logach panelu</p>";
    $sql = "SELECT name, date FROM comments WHERE ip = '$ip'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) echo "<h3>Log z komentarzy</h3><table class='basic-table dimmed-center-table' style='width: 40%; margin-left: 30%'><tr><th>Kto?</th><th>Data</th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        $kto = $row['name'];
        $data = $row['date'];
        echo "<tr><td>$kto</td><td>$data</td></tr>";
    }
    if(mysqli_num_rows($result)>0) echo "</table>";
    else echo "<p>Nic nie znaleziono w logach komentarzy</p>";

    $sql = "SELECT imie, data FROM pokatna_log WHERE ip = '$ip'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) echo "<h3>Log z pokątnej</h3><table class='basic-table dimmed-center-table' style='width: 40%; margin-left: 30%'><tr><th>Kto?</th><th>Data</th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        $kto = $row['imie'];
        $data = $row['data'];
        echo "<tr><td>$kto</td><td>$data</td></tr>";
    }
    if(mysqli_num_rows($result)>0) echo "</table>";
    else echo "<p>Nic nie znaleziono w logach pokątnej</p>";
}

function print_user_menu($username, $password){
    $sql = "SELECT * FROM users WHERE login = '$username' AND password = '$password'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0){
        echo "<p class='narrow center-align'>Zalogowano jako: </p>";
        echo "<p class='colored narrow bold center-align'>$username</p>";
        $sql = "SELECT konto FROM hpotter_bank_skrytki WHERE wlasciciel = '$username'";
        $result = db_statement($sql);
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

function correct_password($username, $password){
    $sql = "SELECT * FROM users WHERE login = '$username' AND password = '$password'";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) return $username;
    else return false;
}

function change_password($username, $password){
    $sql = "UPDATE users SET password = '$password' WHERE login = '$username'";
    db_statement($sql);
}

?>