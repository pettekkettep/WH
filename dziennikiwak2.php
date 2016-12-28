<? 

/*****************************************************/ 

/*      jPORTAL - internetowy system portalowy       */ 

/*****************************************************/ 

/* autor: Pawel 'jaco' Jaczewski                     */ 

/* email: info@websys.pl                             */ 

/*****************************************************/ 

/*        Panel Administratora                       */ 

/*****************************************************/ 

/*               Modu³ dzienników                    */ 

/*               by Max Potter                       */ 

/*****************************************************/ 

include ("config.php"); 

function site_main() { 
global $wpis, $inne, $dziennikiwak_tbl; 

main_title_open(); 
echo 'Dzienniki'; 
main_title_close(); 
main_text_open(); 
if($wpis=='' OR $inne==''){ 
echo '<center><table><tr><td><center><a href=dziennikiwak.php?wpis=analityka><img 

src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" /></a><br><a href=dziennikiwak.php?

wpis=analityka><small><center><font color=#CCCCCC>Analityka Transmutacyjna</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=bialamagia><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=bialamagia><small><center><font color=#CCCCCC>Bia³a 

Magia</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=kulturyswiata><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=kulturyswiata><small><center><font color=#CCCCCC>Kultury 

¦wiata</font></center></small></a></td></tr>
<tr><td><center><a href=dziennikiwak.php?wpis=teleportacja><img 

src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" /></a><br><a href=dziennikiwak.php?

wpis=teleportacja><small><center><font color=#CCCCCC>Kurs Teleportacji</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=rosliny><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=rosliny><small><center><font color=#CCCCCC>Magia 

Ro¶lin</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=tarot><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=tarot><small><center><font color=#CCCCCC>Magia 

Tarota</font></center></small></a></td></tr>
<tr><td><center><a href=dziennikiwak.php?wpis=obrona><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=obrona><small><center><font color=#CCCCCC>Magiczna 

Obrona</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=szamanstwo><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=szamanizm><small><center><font 

color=#CCCCCC>Szamanizm</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=elfy><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=elfy><small><center><font color=#CCCCCC>Pogaduszki z 

Elfami</font></center></small></a></td></tr></table></center>
<center><table><tr><td><center><a href=dziennikiwak.php?wpis=smoki><img 

src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" /></a><br><a href=dziennikiwak.php?

wpis=smoki><small><center><font color=#CCCCCC>Smocze Podró¿e</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=tajemnice><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=tajemnice><small><center><font color=#CCCCCC>Tajemnice 

Ginnungagapa</font></center></small></a></td></tr>
<tr><td><center><a href=dziennikiwak.php?wpis=transmutacja><img 

src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" /></a><br><a href=dziennikiwak.php?

wpis=transmutacja><small><center><font color=#CCCCCC>Transmutacja w ¯C</font></center></small></a></td>
<td><center><a href=dziennikiwak.php?wpis=wywary><img src="http://wh.boo.pl/hogwartsfounders/symbole/wakacje.png" 

/></a><br><a href=dziennikiwak.php?wpis=wywary><small><center><font color=#CCCCCC>Wywary i 

Trucizny</font></center></small></a></td></tr></table></center>


'; 
} 
main_text_close(); 
if($inne=='dodaj'){ 
dodaj(); 
} 
if($inne=='wynik'){ 
wynik(); 
acc(); 
} 
if($inne=='stopka'){ 
stopka(); 
} 
if($wpis=='analityka'){ 
ana(); 
} 
if($wpis=='bialamagia'){ 
bm(); 
} 
if($wpis=='kulturyswiata'){ 
ks(); 
} 
if($wpis=='teleportacja'){ 
tele(); 
} 
if($wpis=='rosliny'){ 
rosliny(); 
} 
if($wpis=='tarot'){ 
tarot(); 
} 
if($wpis=='obrona'){ 
moo();  
} 
if($wpis=='szamanizm'){ 
szam(); 
} 
if($wpis=='elfy'){ 
elfy(); 
} 
if($wpis=='smoki'){ 
smoki(); 
} 
if($wpis=='tajemnice'){ 
taje(); 
} 
if($wpis=='transmutacja'){ 
trans(); 
} 
if($wpis=='wywary'){ 
wywary(); 

} 
if($wpis=='wiecej'){ 
wiecej(); 
}   
} 
function dodaj(){ 

echo '<stan class="uni_01"><br><form action=dziennikiwak.php?inne=wynik method=post>
<font color=#cccccc>Dziennik wype³nia siê za pomoc± HTMLu (<a href="http://wh.boo.pl/infopage.php?id=22"><font 

color=#6699CC>znaczniki HTML</a></font>)</font><br><br> 
Data lekcji (R-M-D):<br> 
<input type=text name="data" /><br> <br>
Numer lekcji z programu nauczania:<br>
<input type=text name="nr" /><br><br>
Temat lekcji:<br>
<input type=text name="temat" /><br><br>
Notatka:<br> 
<html><textarea name="notatka" rows="10" cols="100"></textarea></html><br><br> 
Lista obecno¶ci(i przyznane punkty oraz oceny):<br> 
<textarea name="obecnosc" rows="10" cols="100"></textarea><br><br>
Klasa:<br> 
<select name="klasa"> 
<option value="-" SELECTED>Wybierz</option> 
<option value="1">1</option> 

</select><br> <br>
Profesor:<br> 
<input type=text name="prof" /><br><br>
Praca domowa (je¶li nie ma - wpisz "brak"):<br> 
<textarea name="praca" rows="5" cols="50"></textarea><br><br>
Nauczany przedmiot:<br> 
<select name="przedmiot"> 
<option value="-" SELECTED>Wybierz</option>
<option value="analityka">Analityka Transmutacyjna</option> 
<option value="bialamagia">Bia³a Magia</option> 
<option value="kulturyswiata">Kiltiry ¦wiata</option> 
<option value="teleportacja">Kurs Teleportacji</option> 
<option value="rosliny">Magia Ro¶lin</option>
<option value="tarot">Magia Tarota</option> 
<option value="obrona">Magiczna Obrona Osobista</option>
<option value="szamanizm">Szamanizm</option>
<option value="elfy">Pogaduszki z Elfami</option> 
<option value="smoki">Smocze Podró¿e</option> 
<option value="tajemnice">Tajemnice Ginnungagapa</option> 
<option value="transmutacja">Transmutacja w ¯yciu Cz³owieka</option> 
<option value="wywary">Wywary i Trucizny w praktyce</option> 
</select><br> 
<br><br> 
<input type="submit" value="Wy¶lij"/></stan>'; 
} 
function wynik(){ 
global $stan, $data, $nr, $temat, $notatka, $obecnosc, $klasa, $prof, $praca, $przedmiot, $dziennikiwak_tbl; 

if($data==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj datê!</stan>";} 
elseif($nr==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj numer lekcji!</stan>";}
elseif($temat==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj temat lekcji!</stan>";}
elseif($notatka==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj notatkê lub wpisz brak!</stan>";} 
elseif($obecnosc==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj listê obecno¶ci</stan>";} 
elseif($klasa=='-'){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj klasê ucznia!</stan>";} 
elseif($prof==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj nazwisko profesora!</stan>";} 
elseif($praca==''){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj pracê domowa (lub wpisz brak)!

</stan>";} 
elseif($przedmiot=='-'){echo"<stan class='uni_01'>Formularz nie wype³niono poprawnie: Podaj przedmiot, którego uczysz!

</stan>";} 

else { $potwierdz = 1; } 

if($potwierdz=='1'){ 

$sql = "INSERT INTO $dziennikiwak_tbl VALUES (NULL, 'not', '{$_POST['nr']}', '{$_POST['data']}', '{$_POST['temat']}', '{$_POST['notatka']}', '{$_POST['obecnosc']}', '{$_POST['prof']}', '{$_POST['klasa']}', '{$_POST['praca']}', '{$_POST['przedmiot']}')"; 
$result = mysql_query($sql); 
if($result) echo '<stan class="uni_01"><br>Dziennik zosta³ wype³niony poprawnie. Teraz musi byæ zaakceptowany przez 

Dyrekcjê.<br /></stan>'; 
else { 
echo '<stan class="uni_01">B³±d, zg³o¶ to administracji.<br /></stan>'; 
echo mysql_error(); 
exit; 
}
} 
}

function acc(){ 
global $dziennikiwak_tbl; 
echo '<stan class="uni_01"><br>Wpisy czekajace na akceptacjê:</stan>  <br> 

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PRZEDMIOT</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='not' ORDER BY klasa ASC, przedmiot ASC, id ASC"; 
$result = mysql_query($sql); 
echo mysql_error();

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
$przedmiot = $r['przedmiot']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><b>'.$przedmiot.'<b></center></font></td>
</tr>'; 
} 
echo ' 
</table>';
}


function ana(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>  

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1' AND `przedmiot`='analityka' ORDER BY data ASC"; 
$result = mysql_query($sql); 
echo mysql_error();

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>';


}
function bm(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>  

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='bialamagia' ORDER BY klasa 

ASC, id ASC"; 
$result = mysql_query($sql); 
echo mysql_error();

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>';



} 
function ks(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='kulturyswiata' ORDER BY klasa 

ASC, id ASC"; 
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 



} 
function eliks(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='eliksiry' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='eliksiry' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>';
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='eliksiry' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data'];
$nr = $r['nr']; 
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function historiahogwartu(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><br>Zajêcia dodatkowe</stan>  <br>  

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='historiahogwartu' ORDER BY 

klasa ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

 } 
function hm(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='historia magii' ORDER BY 

klasa ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>  

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='historia magii' ORDER BY 

klasa ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='historia magii' ORDER BY 

klasa ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 


} 
function jezyki(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='jezykoznawstwo' ORDER BY 

klasa ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>  

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='jezykoznawstwo' ORDER BY 

klasa ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function kp(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>ZAJÊCIA DODATKOWE</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='kp' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 


} 
function numa(){ 
global $dziennikiwak_tbl; 

echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='numerologia' ORDER BY klasa 

ASC, id ASC"; 
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>';  
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='numerologia' ORDER BY klasa 

ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='numerologia' ORDER BY klasa 

ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td> 
</tr>'; 
} 
echo ' 
</table>'; 

} 
function onms(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='onms' ORDER BY klasa ASC, id 

ASC"; 
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='onms' ORDER BY klasa ASC, id 

ASC"; 
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td> 
</tr>'; 
} 
echo ' 
</table>'; 

} 
function opcm(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='opcm' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='opcm' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='opcm' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 



} 
function quid(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='quidditch' ORDER BY klasa 

ASC, id ASC"; 
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>';  
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II i III</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='quidditch' ORDER BY klasa 

ASC, id ASC"; 
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>';

} 
function runy(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='runy' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td> 
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='runy' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function trans(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='transmutacje' ORDER BY klasa 

ASC, data ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='transmutacje' ORDER BY klasa 

ASC, data ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td> 
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='transmutacje' ORDER BY klasa 

ASC, data ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function wohp(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='wohp' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='wohp' ORDER BY klasa ASC, id 

ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function wrozby(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='wrozbiarstwo' ORDER BY klasa 

ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='wrozbiarstwo' ORDER BY klasa 

ASC, id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function wommir(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='wommir' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td> 
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td> 
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='wommir' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function zakl(){ 
global $dziennikiwak_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='zaklecia' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='zaklecia' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>   

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dziennikiwak_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='zaklecia' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dziennikiwak.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 

} 
function ziel(){ 
global $dzienniki_tbl; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA I</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dzienniki_tbl WHERE `stan`='yes' AND `klasa`='1'  AND `przedmiot`='zielarstwo' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dzienniki.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA II</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dzienniki_tbl WHERE `stan`='yes' AND `klasa`='2'  AND `przedmiot`='zielarstwo' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dzienniki.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
echo '<center><stan class="uni_01"><p><big><b><font color=#6699CC>KLASA III</font></b></big></stan> </p>    

<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0"> 
<tr> 
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>DATA</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>TEMAT</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>PROFESOR</b></center></font></td>
<td bgcolor="#6699CC" class="uni_01"><font color="#000000"><center><b>WIÊCEJ</b></center></font></td>
</tr>'; 

$sql = "SELECT * FROM $dzienniki_tbl WHERE `stan`='yes' AND `klasa`='3'  AND `przedmiot`='zielarstwo' ORDER BY klasa ASC, 

id ASC";  
$result = mysql_query($sql); 

while($r = mysql_fetch_array($result)){ 

$id = $r['id']; 
$data = $r['data']; 
$nr = $r['nr'];
$temat = $r['temat']; 
$klasa = $r['klasa']; 
$prof = $r['prof']; 
$praca = $r['praca']; 
$notatka = $r['notatka']; 
$obecnosc = $r['obecnosc']; 
 

echo ' 
<tr> 
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$data.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC">('.$nr.') '.$temat.'</font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center>'.$prof.'</center></font></td>
<td bgcolor="#111111" class="uni_01"><font color="#6699CC"><center><a href="dzienniki.php?wpis=wiecej&id='.$id.'"><i>

[wiêcej]</i></a></center></font></td>
</tr>'; 
} 
echo ' 
</table>'; 
} 
function stopka(){ 
echo '<br>Dzienniki'; // to bez komentarza zastawie 
} 
function wiecej() {
global $id, $dzienniki_tbl; 

$z="SELECT * FROM $dzienniki_tbl WHERE id=$id";
$w=mysql_query($z);
$r=mysql_fetch_array($w);

echo("<span class='uni_01'>
<br>Data lekcji: $r[data]
<br>Przedmiot: $r[przedmiot]
<br>Profesor: $r[prof]
<br>Klasa: $r[klasa]
<br>Temat lekcji: ($r[nr]) $r[temat]
<br>Lista obecno¶ci:<br><html>$r[obecnosc]</html>
<br>Notatka:<br><html>$r[notatka]</html>
<br>Praca domowa:<br> <html>$r[praca]</html></span>");
}

#############################################
$site_title = 'Dzienniki'; 
$meta_info = ''; 
include ("theme/$theme/normal.php") 


?>