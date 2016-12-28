<?php

session_start();

include("logfunctions_x.php");

if($_POST){
    $imie = trim_input($_POST['imie']);
    $nazwisko = trim_input($_POST['nazwisko']);
    $nick = trim_input($_POST['nick']);
    $mail = trim_input($_POST['mail']);
    $dom = trim_input($_POST['dom']);
    $why = trim_input($_POST['why']);
    $drewno = trim_input($_POST['drewno']);
    $rdzen = trim_input($_POST['rdzen']);
    $dlugosc1 = trim_input($_POST['dlugosc1']);
    $dlugosc2 = trim_input($_POST['dlugosc2']);
    $elastycznosc = trim_input($_POST['elastycznosc']);
    $wlasciwosc = trim_input($_POST['wlasciwosc']);
    $miotla = trim_input($_POST['miotla']);
    $zwierze = trim_input($_POST['zwierze']);
    $name = trim_input($_POST['animal_name']);
    $klasa = trim_input($_POST['klasa']);
    $acc = 0;

    $sql = "INSERT INTO zapisy_u (imie, nazwisko, nick, mail, dom, why, drewno, rdzen, dlugosc1, dlugosc2, elastycznosc, wlasciwosc, miotla, zwierze, name, klasa, acc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    db_statement($sql, "sssssssssssssssii", array(&$imie, &$nazwisko, &$nick, &$mail, &$dom, &$why, &$drewno, &$rdzen, &$dlugosc1, &$dlugosc2, &$elastycznosc, &$wlasciwosc, &$miotla, &$zwierze, &$name, &$klasa, &$acc));
    $_SESSION['msg'] = "Zgłoszenie wysłane!";
    $_SESSION['kto'] = "u";
    add_event("zapisał(a) się na ucznia", "ucz_odrz", "$imie $nazwisko");
    header("Location: zapisy_success.php");
}


?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row">
            <div class="col-12"><h1>Formularz zgłoszeniowy na ucznia</h1>
            <h3>Wypełnienie formularza nie powinno zająć Ci dłużej niż 3 minuty, aczkolwiek nad niektórymi decyzjami warto się dłużej zastanowić!</h3>
            <h4>Gwiazdką (*) oznaczone się pola wymagane. </h4></div>
            <form action="/zapisy_u.php" method="post">
                <div class="row">
                    <div class="col-6">
                        <div class="form-fancy">
                            Imię* <p class="form-descr">Imię to Twoja wizytówką w Świecie Magii. Nie musisz podawać swoich realnych danych. Bądź kreatywnym człowiekiem!</p><input type="text" name="imie" required></input>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-fancy">
                            Nazwisko* <p class="form-descr">Zanim wybierzesz nazwisko Potter lub Granger pomyśl, czy nie przychodzi Ci do głowy jakieś nieco bardziej oryginalne!</p><input type="text" name="nazwisko" required></input>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-fancy">
                            Nick na czacie* (<a target=_blank href="http://wh.boo.pl/infopage_x.php?id=25">jak założyć</a>) <input type="text" name="nick" required></input>
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
                            Preferowany dom* (<a target=_blank href="http://wh.boo.pl/infopage_x.php?id=74">przeczytaj opisy</a>)
                            <div class="radio-btn">
                                <input type="radio" class="radio" name="dom" id='rbg' value="#ff0000" required>
                                <label for="rbg" class="gryff">Gryffindor</label>
                            </div>
                            <div class="radio-btn">
                                <input type="radio" class="radio" name="dom" id='rbh' value="#ffcc00" required>
                                <label for="rbh" class="huff">Hufflepuff</label>
                            </div>
                            <div class="radio-btn">
                                <input type="radio" class="radio" name="dom" id='rbr' value="0066ff" required>
                                <label for="rbr" class="rav">Ravenclaw</label>
                            </div>
                            <div class="radio-btn">
                                <input type="radio" class="radio" name="dom" id='rbs' value="00cc00" required>
                                <label for="rbs" class="slyth">Slytherin</label>
                            </div><br><br>
                            Dlaczego właśnie ten dom?* <p class="form-descr">Pamiętaj, że jakość tej wypowiedzi wpływa na przyjęcie Cię do wybranego domu.</p>
                            <textarea name="why" required></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-fancy">
                            Klasa* <p class="form-descr">Przy wyborze klasy pamiętaj, że im wyższa, tym większe stawiamy wymagania! Oceń swoje możliwości i dokonaj właściwego wyboru!</p>
                            <div class="radio-btn">
                                <input type="radio" class="radio" name="klasa" id='rbi' value="1" required>
                                <label for="rbi">I</label>
                            </div>
                            <div class="radio-btn">
                                <input type="radio" class="radio" name="klasa" id='rbii' value="2" required>
                                <label for="rbii">II</label>
                            </div>
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
                                <option value="DebowyGrom79.jpg">Dębowy Grom 79</option>
                                <option value="KsiezycowaBrzytwa.jpg">Księżycowa Brzytwa</option>
                                <option value="SrebrnaStrzala.jpg">Srebrna Strzała</option>
                                <option value="SwietlistaSmuga.jpg">Świetlista Smuga</option>
                                <option value="SpadajacaGwiazda.jpg">Spadająca Gwiazda</option>
                                <option value="ZmiataczJedenastka.jpg">Zmiatacz Jedenastka</option>
                                <option value="Kometa290.jpg">Kometa 290</option>
                                <option value="Nimbus2001.jpg">Nimbus 2001</option></select><br><br><br>

                            <img src="http://wh.boo.pl/belki/Z3.png">
                            Gatunek (<a href="http://wh.boo.pl/infopage_x.php?id=72" target="_blank">przeczytaj opisy</a>):<br />
                            <select name="zwierze">
                                <option value="" disabled selected>(Wybierz)</option>
                                <option value="KotEuropejski.jpg">Kot - Europejski</option>
                                <option value="MainCoon.jpg">Kot - Main Coon</option>
                                <option value="Sfinks.jpg">Kot - Sfinks</option>
                                <option value="Pers.jpg">Kot - Pers</option>
                                <option value="RosyjskiNiebieski.jpg">Kot - Rosyjski Niebieski</option>
                                <option value="Puszczyk.jpg">Sowa - Puszczyk</option>
                                <option value="Plomykowka.jpg">Sowa - Płomykówka</option>
                                <option value="PuchaczSniezny.jpg">Sowa - Puchacz Śnieżny</option>
                                <option value="wlochatka.jpg">Sowa - Włochatka</option>
                                <option value="SowaUszata.jpg">Sowa - Uszata</option>
                                <option value="RopuchaSzara.jpg">Ropucha - Szara</option>
                                <option value="RopuchaPaskowka.jpg">Ropucha - Paskówka</option>
                                <option value="RopuchaAga.jpg">Ropucha - Aga </option>
                                <option value="RzekotkaSzara.jpg">Ropucha - Rzekotka Szara</option>
                                <option value="Karlik.jpg">Ropucha - Karlik</option>
                                <option value="SzczurCzarny.jpg">Szczur - Czarny</option>
                                <option value="SzczurMink.jpg">Szczur - Mink</option>
                                <option value="SzczurAgouti.jpg">Szczur - Aguoti</option>
                                <option value="SzczurFawn.jpg">Szczur - Fawn</option>
                                <option value="SzczurKapturek.jpg">Szczur - Kapturek</option>
                                <option value="Kuguchar.jpg">Kuguchar</option>
                                <option value="Pufek.jpg">Pufek Pigmejski</option>
                                <option value="Szczuroszczet.jpg">Szczuroszczet</option></select>
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