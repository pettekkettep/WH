<?php

//if (preg_match("/union|select|pass|update|insert/i", strtolower($_SERVER['REQUEST_URI'])))
//die ('hacking attempt');

/*****************************************************/
/*      jPORTAL - internetowy system portalowy       */
/*****************************************************/
/* autor: Pawel Jaczewski                            */
/* email: info@websys.pl                             */
/*****************************************************/
/* przeczytaj DOKUMENTACJE!  (DOC/INDEX.html)        */
/*****************************************************/
ob_start();
error_reporting( E_NONE ); ini_set( 'display_errors', false );
// stare czasy...
$o = $_GET['o'] = $_POST['o'] = $_REQUEST['o'] = $_SESSION['o'] = $_COOKIE['o'] = $_SERVER['o'] = '';

// uruchomienie licznika
$_MTIME['start'] = explode(' ', microtime());
$_MTIME['begin'] = $_MTIME['start'][0] + $_MTIME['start'][1];
/*****************************************************/
$db_host = 'localhost';
$db_user = 'seanblack_db1';
$db_pass = 'martellcathville';
$db_name = 'seanblack_db1';
$prefix = '';
$globals = false;
/*****************************************************/

/*****************************************************/
# polaczenie z baza i podpiecie nezbednych plikow
/*****************************************************/
if( !@include("errors/function.php") )
die("<b>Brak pliku error/function.php</b>");

if( !@file_exists("uploads/install") )
displayError( 'nie wykryto instalacji', 1, 'System prawdopodobnie nie jest zainstalowany - nie mo¿na odnale¼æ pliku uploads/install<br /><b>Je¶li nie instalowa³e¶ jeszcze tej kopii systemu zrób to <a href="install" title="zainstaluj jPortal">teraz</a>' );

if( !@mysql_connect($db_host, $db_user, $db_pass) )
displayError( 'b³±d po³±czenia z MySQL', mysql_errno(), mysql_error() );

if( !@mysql_select_db($db_name) )
displayError( 'b³±d wybierania bazy danych', mysql_errno(), mysql_error() );

mysql_query("SET NAMES latin2");
/*****************************************************/

/*****************************************************/
# tabele
/*****************************************************/
$config_sys_tbl  = $prefix.'config_sys';
$user_tbl    = $prefix.'admins';
$menu_tbl    = $prefix.'menu';
$info_tbl    = $prefix.'infopages';
$news_tbl    = $prefix.'news';
$art_tbl     = $prefix.'articles';
$php_tbl     = $prefix.'scripts';
$file_a_tbl  = $prefix.'file_categories';
$file_b_tbl  = $prefix.'file_data';
$comm_tbl    = $prefix.'comments';
$forum_a     = $prefix.'forum_a';
$forum_b     = $prefix.'forum_b';
$forum_c     = $prefix.'forum_c';
$links_a_tbl = $prefix.'links_categories';
$links_b_tbl = $prefix.'links_data';
$poll_a_tbl  = $prefix.'poll_desc';
$poll_b_tbl  = $prefix.'poll_data';
$bann_a_tbl  = $prefix.'banners';
$bann_b_tbl  = $prefix.'banners_info';
$topic_tbl   = $prefix.'topic';
$mail_tbl    = $prefix.'mails';
$gbook_tbl   = $prefix.'gbook';
$guest_tbl   = $prefix.'users';
$pw_tbl      = $prefix.'pw';
$ban_tbl     = $prefix.'ban';
$oceny_tbl = $prefix.'oceny';
$dzienniki_tbl = $prefix.'dzienniki';
$skrzydlo_tbl = $prefix.'skrzydlo_u';
$uspr_tbl = $prefix.'uspr';
$anty_f_tbl  = $prefix.'antyflood';
$gazeta  = $prefix.'gazeta';
$gaz_com  =  $prefix.'gaz_com';
$gaz_nr  =  $prefix.'gaz_nr';
$dziennikiwak_tbl = $prefix.'dziennikiwak';
/*****************************************************/

/*****************************************************/
# coonfig i ustawienia
/*****************************************************/
$configQuery = mysql_query("SELECT * FROM $config_sys_tbl");
while($config = mysql_fetch_object($configQuery)) ${$config->config_name} = $config->config_value;
$rank_1 	  = 1;
$mailer['admin'] = $web_mail;
/*****************************************************/

/*****************************************************/
# ustawienia listy subskrybcyjnej
/*****************************************************/
$slist_from  = '&quot;Info z '.$site_name.'&quot; &lt;'.$mailer['admin'].'&gt;';
$slist_topic = '';
$slist_head  = 'Otrzymujesz te wiadomosc poniewaz jestes na liscie subskrypcyjnej'."\n".'serwisu '.$site_name.'. Informacje dotyczace subskrypcji na koncu tego listu.'."\n".'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'."\n\n";
$slist_foot  = "\n\n\n".'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'."\n".'Aby wypisac siê z listy wejdz na podana nizej strone:'."\n".'**link**';
/*****************************************************/

/*****************************************************/
# tu nic nie zmieniaj !!!
/*****************************************************/
$acc['news']   = 1;
$acc['arts']   = 2;
$acc['info']   = 3;
$acc['sonda']  = 4;
$acc['links']  = 5;
$acc['forum']  = 6;
$acc['comm']   = 7;
$acc['down']   = 8;
$acc['menu']   = 9;
$acc['banner'] = 10;
$acc['topic']  = 11;
/*****************************************************/

/*****************************************************/
# sesje dla adminow
/*****************************************************/

session_start();
include('globals.php');

/*****************************************************/

/*****************************************************/
# podpiecie nezbednych plikow
/*****************************************************/

if( $_GET['o']==$o AND $o<>'' )
displayError( 'b³±d w zmiennych systemowych', 1, 'System wykry³ obecno¶æ nieprawid³owej zmiennej w adresie URL. Prawdopodobnie próba w³amania siê do systemu...' );

if( !@file_exists($o.'logs/config.log') )
displayError( 'brak pliku', 1, 'System nie mo¿e odnale¼æ pliku - logs/config.log.' );

if( !@include($o.'module/bonus.inc.php') )
displayError( 'brak pliku', 1, 'System nie mo¿e odnale¼æ pliku - module/bonus.inc.php.' );

if( !@include($o.'module/banner.inc.php') )
displayError( 'brak pliku', 1, 'System nie mo¿e odnale¼æ pliku - module/banner.inc.php.' );

if( !@include($o.'messages.php') )
displayError( 'brak pliku', 1, 'System nie mo¿e odnale¼æ pliku - messages.php.' );

if( !@include($o.'main.php') )
displayError( 'brak pliku', 1, 'System nie mo¿e odnale¼æ pliku - main.php.' );

if (is_dir("install") && file_exists("uploads/install")) {
displayError( 'b³±d systemu', 1, 'System zosta³ zainstalowany, aby rozpoczac korzystanie z niego wykasuj lub zmien nazwe folderu <b>install</b>' );
}

if (preg_match("/union|select/i", strtolower($_SERVER['REQUEST_URI']))) {
displayError( 'b³±d w zmiennych systemowych', 1, 'System wykry³ obecno¶æ nieprawid³owej zmiennej w adresie URL. Prawdopodobnie próba w³amania siê do systemu...' );
exit();
}

/*****************************************************/

/*****************************************************/
# ostatnie ustawienia przed wyswietleniem
/*****************************************************/

save_member($gnick);
$members = (int) act_member(180);
save_guest(300);
$guests = (int) act_guest(180);
check_ip();

/*****************************************************/

/*****************************************************/
# ustawienia cache
/*****************************************************/

header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');

/*****************************************************/
//if(preg_match("#(UNION|SELECT|UPDATE|INSERT|DELETE|EXEC|\*|;)#si",urldecode($_SERVER['QUERY_STRING']))) exit;
// by darecki

if (preg_match("/union|select|pass|update|insert/i", strtolower($_SERVER['REQUEST_URI'])))
die (hacking_alert());

?>
