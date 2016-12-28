<?php

session_start();

include("logfunctions_x.php");

$sql = "SELECT * FROM wolne_posady";
$result = db_statement($sql);
if(mysqli_num_rows($result) == 0){
    $_SESSION['kto'] = "nn";
    header("Location: zapisy_success.php");
}

if($_POST){
    $imie = trim_input($_POST['imie']);
    $nazwisko = trim_input($_POST['nazwisko']);
    $nick = trim_input($_POST['nick']);
    $przedmiot = trim_input($_POST['przedmiot']);
    $mail = trim_input($_POST['mail']);
    $why = trim_input($_POST['why']);
    $opis = trim_input($_POST['opis']);
    $podrecznik = trim_input($_POST['podrecznik']);
    $nowe = trim_input($_POST['nowe']);
    $drewno = trim_input($_POST['drewno']);
    $rdzen = trim_input($_POST['rdzen']);
    $dlugosc1 = trim_input($_POST['dlugosc1']);
    $dlugosc2 = trim_input($_POST['dlugosc2']);
    $elastycznosc = trim_input($_POST['elastycznosc']);
    $wlasciwosc = trim_input($_POST['wlasciwosc']);
    $miotla = trim_input($_POST['miotla']);
    $zwierze = trim_input($_POST['zwierze']);
    $name = trim_input($_POST['animal_name']);
    $acc = 0;

    $sql = "INSERT INTO zapisy_n (imie, nazwisko, nick, mail, przedmiot, why, opis, podrecznik, nowe, drewno, rdzen, dlugosc1, dlugosc2, elastycznosc, wlasciwosc, miotla, zwierze, name, acc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    db_statement($sql, "ssssssssssssssssssi", array(&$imie, &$nazwisko, &$nick, &$mail, &$przedmiot, &$why, &$opis, &$podrecznik, &$nowe, &$drewno, &$rdzen, &$dlugosc1, &$dlugosc2, &$elastycznosc, &$wlasciwosc, &$miotla, &$zwierze, &$name, &$acc));
    $_SESSION['msg'] = "Zgłoszenie wysłane!";
    $_SESSION['kto'] = "n";
    add_event("zapisał(a) się na nauczyciela", "nau_odrz", "$imie $nazwisko");
    header("Location: zapisy_success.php");
}


?>

<? include("before_content.php"); ?>
    <div class="col-6 col-m-6">
        <div class="row">
            <div class="col-12"><h1>Formularz zgłoszeniowy na nauczyciela</h1>
                <h3>Jeśli nie poświęcisz kilku minut na szczerą odpowiedź na poniższe pytania, to dlaczego mielibyśmy sądzić, że jesteś profesorem, którego szukamy?</h3>
                <h4>Gwiazdką (*) oznaczone się pola wymagane. </h4></div>
            <form action="/zapisy_n.php" method="post">
                <div class="row">
                    <div class="col-6">
                        <div class="form-fancy">
                            Imię* <input type="text" name="imie" required></input>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-fancy">
                            Nazwisko* <input type="text" name="nazwisko" required></input>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-fancy">
                            Nick na czacie* (<a target=_blank href="http://wh.boo.pl/infopage_x.php?id=25">jak założyć</a>) <input type="text" name="nick" required></input><br><br>
                            Przedmiot
                            <select name="przedmiot" required>
                                <option value="" disabled selected>(Wybierz)</option>
                                <?php
                                $sql = "SELECT * FROM wolne_posady";
                                $result = db_statement($sql);
                                while ($row = mysqli_fetch_assoc($result)){
                                    echo "<option>".$row['przedmiot']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-fancy">
                            Sowa (adres e-mail)* <input type="email" name="mail" required></input>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-fancy">
                            Dlaczego właśnie ten przedmiot?* <p class="form-descr">Jeśli posiadasz jakieś doświadczenie, pochwal się nim</p>
                            <textarea name="why" required></textarea>
                            <br>Opisz się w kilku słowach*
                            <textarea name="opis" required></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-fancy">
                            Czy posiadasz jakieś materiały stworzone przez siebie? <p class="form-descr">Chodzi o materiały dotyczące danego przedmiotu</p>
                            <textarea name="podrecznik"></textarea>
                            <br>Czy masz jakieś pomysły dotyczące rozwoju szkoły?
                            <textarea name="nowe"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-fancy">
                            <img src="http://wh.boo.pl/belki/Z1.png">
                            Drewno (<a href="http://wh.boo.pl/infopage_x.php?id=75" target="_blank">przeczytaj opisy</a>)
                            <select name="drewno">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option>Buk</option>
                                <option>Cis</option>
                                <option>Dąb</option>
                                <option>Drewno różane</option>
                                <option>Dziki bez</option>
                                <option>Grab</option>
                                <option>Grusza</option>
                                <option>Heban</option>
                                <option>Hikora</option>
                                <option>Jabłoń</option>
                                <option>Jarzębina</option>
                                <option>Jesion</option>
                                <option>Kasztanowiec</option>
                                <option>Klon</option>
                                <option>Leszczyna</option>
                                <option>Lipa</option>
                                <option>Mahoń</option>
                                <option>Orzech włoski</option>
                                <option>Ostrokrzew</option>
                                <option>Sosna</option>
                                <option>Tarnina</option>
                                <option>Topola</option>
                                <option>Wierzba</option>
                                <option>Wiśnia</option>
                            </select>

                            Rdzeń (<a href="http://wh.boo.pl/infopage_x.php?id=76" target="_blank">przeczytaj opisy</a>):<br>
                            <select name="rdzen">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option>Kieł widłowęża</option>
                                <option>Łuska chimery</option>
                                <option>Pióro feniksa</option>
                                <option>Popiół z popiełka</option>
                                <option>Szpon hipogryfa</option>
                                <option>Włos demimoza</option>
                                <option>Włos z głowy wili</option>
                                <option>Włos z grzywy jednorożca</option>
                                <option>Włos z ogona testrala</option>
                                <option>Włókno z pachwiny nietoperza</option>
                                <option>Włókno z serca smoka</option>
                            </select><br><br>

                            Długość (w calach):<br>
                            <select name="dlugosc1">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                            </select>

                            <select name="dlugosc2">
                                <option value="cali" disabled selected>(Wybierz)</option>
                                <option value="i 1/2 cala">1/2</option>
                                <option value="i 1/4 cala">1/4</option>
                                <option value="i 3/4 cala">3/4</option>
                            </select><br><br>

                            Elastyczność:<br> <select name="elastycznosc">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option>Zwykła</option>
                                <option>Sztywna</option>
                                <option>Krucha</option>
                                <option>Bardzo giętka</option>
                                <option>Niezbyt giętka</option>
                            </select><br><br>

                            Specjalna właściwość:<br> <select name="wlasciwosc">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option>Dobra do Zaklęć</option>
                                <option>Znakomita do obrony</option>
                                <option>Świetna do pojedynków</option>
                                <option>Idealna do Transmutacji</option>
                                <option>Dobra do rzucania uroków</option>
                                <option>Świetna do czarnej magii</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-fancy">
                            <img src="http://wh.boo.pl/belki/Z2.png">
                            Model (<a href="http://wh.boo.pl/infopage_x.php?id=73" target="_blank">przeczytaj opisy</a>):<br />
                            <select name="miotla">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option value="DebowyGrom79.png">Dębowy Grom 79</OPTION>
                                <option value="KsiezycowaBrzytwa.png">Księżycowa Brzytwa</OPTION>
                                <option value="SrebrnaStrzala.png">Srebrna Strzała</OPTION>
                                <option value="SwietlistaSmuga.png">Świetlista Smuga</OPTION>
                                <option value="SpadajacaGwiazda.png">Spadająca Gwiazda</OPTION>
                                <option value="ZmiataczJedenastka.png">Zmiatacz Jedenastka</OPTION>
                                <option value="Kometa290.png">Kometa 290</OPTION>
                                <option value="Nimbus2001.png">Nimbus 2001</OPTION>
                                <option value="Blyskawica.png">Błyskawica</OPTION></SELECT><br><br>


                            <img src="http://wh.boo.pl/belki/Z3.png">
                            Gatunek (<a href="http://wh.boo.pl/infopage_x.php?id=72" target="_blank">przeczytaj opisy</a>):<br />
                            <select name="zwierze">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option value="KotEuropejski.png">Kot - Europejski</OPTION>
                                <option value="MainCoon.png">Kot - Main Coon</OPTION>
                                <option value="Sfinks.png">Kot - Sfinks</OPTION>
                                <option value="Pers.png">Kot - Pers</OPTION>
                                <option value="RosyjskiNiebieski.png">Kot - Rosyjski Niebieski</OPTION>
                                <option value="Puszczyk.png">Sowa - Puszczyk</OPTION>
                                <option value="Plomykowka.png">Sowa - Płomykówka</OPTION>
                                <option value="PuchaczSniezny.png">Sowa - Puchacz Śnieżny</OPTION>
                                <option value="wlochatka.png">Sowa - Włochatka</OPTION>
                                <option value="SowaUszata.png">Sowa - Uszata</OPTION>
                                <option value="RopuchaSzara.png">Ropucha - Szara</OPTION>
                                <option value="RopuchaPaskowka.png">Ropucha - Paskówka</OPTION>
                                <option value="RopuchaAga.png">Ropucha - Aga </OPTION>
                                <option value="RzekotkaSzara.png">Ropucha - Rzekotka Szara</OPTION>
                                <option value="Karlik.png">Ropucha - Karlik</OPTION>
                                <option value="SzczurCzarny.png">Szczur - Czarny</OPTION>
                                <option value="SzczurMink.png">Szczur - Mink</OPTION>
                                <option value="SzczurAgouti.png">Szczur - Aguoti</OPTION>
                                <option value="SzczurFawn.png">Szczur - Fawn</OPTION>
                                <option value="SzczurKapturek.png">Szczur - Kapturek</OPTION>
                                <option value="Ciamarnica.png">Ciamarnica</OPTION>
                                <option value="Demimoz.png">Demimoz</OPTION>
                                <option value="Feniks.png">Feniks</OPTION>
                                <option value="Kuguchar.png">Kuguchar</OPTION>
                                <option value="LelekWrozebnik.png">Lelek Wróżebnik</OPTION>
                                <option value="Memortek.png">Memrotek</OPTION>
                                <option value="OgnistyKrab.png">Ognisty Krab</OPTION>
                                <option value="Psidwak.png">Psidwak</OPTION>
                                <option value="Pufek.png">Pufek Pigmejski</OPTION>
                                <option value="Ramora.png">Ramora</OPTION>
                                <option value="Szpiczak.png">Szpiczak</OPTION>
                                <option value="Szczuroszczet.png">Szczuroszczet</OPTION>
                                <option value="Swiergotnik.png">Świergotnik</OPTION>
                                <option value="Wsiakiewka.png">Wsiąkiewka</OPTION>
                                <option value="Znikacz.png">Złoty Znikacz</OPTION>
                            </SELECT>

                            <br><br>

                            Imię zwierzaka<input type="text" name="animal_name">
                            <p class="robotic" id="pot"><label>Jeśli widzisz to pole, to zostaw je puste</label>
                                <input name="robotest" type="text" id="robotest" class="robotest"></p><br><br>
                        </div>
                    </div>
                    <div class="form-fancy col-12">
                        <input type="submit" value="Wyślij zgłoszenie!">
                    </div>
                </div>
            </form>
        </div>
    </div>





<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>