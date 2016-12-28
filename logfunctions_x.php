<?php

require_once('functions_x.php');

function add_event($string, $kind, $kto = ""){
    if($kto == "") $kto = $_SESSION['username'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $string = trim_input($string);
    $kind = trim_input($kind);
    $ip = trim_input($ip);
    $sql = "INSERT INTO log(kto, tresc, rodzaj, ip) VALUES ('$kto', '$string', '$kind', '$ip')";
    db_statement($sql);
}

function print_log_feed(){
    $sql = "SELECT * FROM log WHERE data > CURRENT_TIMESTAMP - INTERVAL 1 DAY ORDER BY data desc";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) > 0){
        echo "<table class='simplest'><th>Data</th><th>Zdarzenie</th><th>IP</th>";
        while($row = mysqli_fetch_assoc($result)){
            $glyph = choose_glyph($row['rodzaj']);
            $data = $row['data'];
            $ip = $row['ip'];
            $tresc = $row['tresc'];
            $kto = $row['kto'];
            $data_str = str_replace(" ","&nbsp;",$data);
            $data_str = str_replace("-","&#8209;",$data_str);
            echo "<tr><td>$data_str</td>";
            $komunikat = "<span class='bit-bigger'>$glyph</span>" ."&nbsp; &nbsp;".$kto ." ". time_description($data) ." ". $tresc;
            echo "<td>$komunikat</td><td>$ip</td></tr>";
        }
        echo "</table>";
    }
}

function msg_enable($user){
    $user = trim_input($user);
    $sql = "SELECT id FROM log WHERE kto = '$user' AND rodzaj = 'msg' AND data > CURRENT_TIMESTAMP - INTERVAL 24 HOUR";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) < 3) return true;
    else return false;

}

function choose_glyph($rodzaj)
{
//news
    if ($rodzaj == "dod_news" || $rodzaj == "ed_news" || $rodzaj == "arch_news" || $rodzaj == "przywr_news" || $rodzaj == "us_news" || $rodzaj == "usall_news") return "<span class='glyphicon glyphicon-pencil'></span>";
    // gring
    elseif ($rodzaj == "gring_dod") return "<span class='glyphicon glyphicon-euro'></span>";
    // dzienniki
    elseif ($rodzaj == "add_dz" || $rodzaj == "ed_dz" || $rodzaj == "dz_acc" || $rodzaj == "dz_us") return "<span class='glyphicon glyphicon-list-alt'></span>";
    // komentarze
    elseif ($rodzaj == "dod_kom" || $rodzaj == "us_kom") return "<span class='glyphicon glyphicon-comment'></span>";
    elseif ($rodzaj == "msg") return "<span class='glyphicon glyphicon-glass' style='color: blue;'></span>";
    elseif ($rodzaj == "dod_data" || $rodzaj == "ed_data" || $rodzaj == "pok_data" || $rodzaj == "ukr_data" || $rodzaj == "us_data") return "<span class='glyphicon glyphicon-list-alt'></span>";
    elseif ($rodzaj == "info_dod" || $rodzaj == "info_ed" || $rodzaj == "info_us") return "<span class='glyphicon glyphicon-folder-open'></span>";
    elseif ($rodzaj == "admin_odeb" || $rodzaj == "admin_nad" || $rodzaj == "root_nad" || $rodzaj == "admin_us" || $rodzaj == "admin_dod") return "<span class='glyphicon glyphicon-tower'></span>";
    elseif ($rodzaj == "dzp_us" || $rodzaj == "dzo_us" || $rodzaj == "dzpall_us" || $rodzaj == "dzoall_us") return "<span class='glyphicon glyphicon-trash'></span>";
    elseif ($rodzaj == "login") return "<span class='glyphicon glyphicon-sunglasses'></span>";
    elseif ($rodzaj == "blok_zm" || $rodzaj == "blok_us" || $rodzaj == "blok_ed" || $rodzaj == "blok_dod") return "<span class='glyphicon glyphicon-th-list'></span>";
    elseif ($rodzaj == "ed_vars") return "<span class='glyphicon glyphicon-info-sign'></span>";
    elseif ($rodzaj == "plan_dod" || $rodzaj == "plan_ed" || $rodzaj == "plan_us") return "<span class='glyphicon glyphicon-time'></span>";
    elseif ($rodzaj == "pkt_dod") return "<span class='glyphicon glyphicon-ice-lolly'></span>";
    elseif ($rodzaj == "ucz_g") return "<span class='glyphicon glyphicon-education' style='color: #ff0000'></span>";
    elseif ($rodzaj == "ucz_h") return "<span class='glyphicon glyphicon-education' style='color: #ffcc00'></span>";
    elseif ($rodzaj == "ucz_r") return "<span class='glyphicon glyphicon-education' style='color: #0066ff'></span>";
    elseif ($rodzaj == "ucz_s") return "<span class='glyphicon glyphicon-education' style='color: #00cc00'></span>";
    elseif ($rodzaj == "nau_przyj" || $rodzaj == "nau_odrz" || $rodzaj == "nau_wyrz" || $rodzaj == "ucz_wyrz" || $rodzaj == "ucz_odrz" || $rodzaj == "ucz_1" || $rodzaj == "ucz_2" || $rodzaj == "ucz_3" || $rodzaj == "ucz_abs")
        return "<span class='glyphicon glyphicon-user'></span>";
    else return "<span class='glyphicon glyphicon-alert' style='color: red'></span>";


}

?>