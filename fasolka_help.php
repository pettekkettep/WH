<?php

session_start();
require_once('./fasolkifunctions_x.php');

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>FASOLKI | help</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<div class="row row-style" style="padding: 15px 50px 15px 30px;">
    <h3 style="font-size: 300%">FASOLKI - z czym to jeść?!</h3>
    <h2>1. Nie mam czasu, o co w tym chodzi? W kilku zwięzłych zdaniach...</h2>
    <p style="text-align: justify">
        Nie chcemy, aby Ulica Pokątna była martwa, a liczba galeonów na Twoim koncie była nikomu nie potrzebną liczbą w tabelce. Stworzyliśmy grę, które polega na kolekcjonowaniu (poprzez losowanie, wypełnianie zadań i uczestnictwo w szkolnych wydarzeniach) fasolek. Celem gry jest posiadanie większej liczby (w szczególności <span class="rav">unikatowych</span>) fasolek w swojej kolekcji. Wylosowanie jednej fasolki kosztuje 5 galeonów i można uzyskać fasolki: pospolite, <span class="colored">rzadkie</span> oraz <span class="rav">unikatowe</span>. Poprzez wykonywanie zadań (tzw. questów) można otrzymać fasolki <span class="huff">legendarne</span>. Obecnie możliwych do zebrania jest 106 fasolek. Nie tak łatwo je wszystkie zebrać! Do gry konieczne jest posiadanie konta w naszym Banku Gringotta!
    </p>

    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">2. Po co gra została stworzona?</h2>
    <ul>
        <li>Chcemy, żebyście mieli co robić na naszej stronie internetowej poza czytaniem (niewątpliwie ważnych) newsów</li>
        <li>Chcemy nadać galeonom znaczenie, przedstawiana gra jest pierwszym (być może pojawią się kolejne) sposobem gospodarowania zawartości swojej skrytki</li>
        <li>Planujemy, aby konto w Banku Gringotta było w przyszłości kontem użytkownika na stronie WH: możliwe kierunki rozwoju to: personalizacja zawartości strony dla każdego użytkownika, łatwiejsza identyfikacja użytkownika (np. bardziej rozbudowany system komentowania newsów)</li>
        <li>To w sumie nawet wciągająca rozrywka szczególnie, że grać można na swoim urządzeniu mobilnym, np. <span class="strike">na nudnej lekcji w szkole</span></li>
    </ul>

    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">3. Jaki jest cel gry?</h2>
    <p style="text-align: justify">
        Celem gry jest posiadanie najlepszego wyniku spośród wszystkich graczy. Obecny ranking znajduje się <a href="fasolka_rank.php">[TUTAJ]</a>. Wynik obliczany jest w sposób opisany w pytaniu 5.
    </p>

    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">4. Na czym polega losowanie fasolek?</h2>
    <p style="text-align: justify">
        Aby przejść do losowanie fasolek należy wejść na <a href="losuj_fasolke.php">[tę]</a> podstronę. Kliknięcie przycisku "LOSUJ FASOLKĘ" powoduje wylosowanie fasolki spośród fasolek pospolitych, <span class="colored">rzadkich</span> i <span class="rav">unikatowych</span>. W sumie jest to 85 fasolek. Masz 80% szans, że wylosujesz fasolkę pospolitą, 19.5% szans na <span class="colored">rzadką</span> i 0.5% na <span class="rav">unikatową</span>.
    </p>
    <p style="text-align: justify">
        Jeśli wylosowana fasolka jest pierwszą o danym smaku w Twojej kolekcji otrzymasz odpowiednią liczbę punktów rankingowych oraz wyświetli się jasny komunikat o tym mówiący. Jeśli natomiast wylosowany smak został już wcześniej przez Ciebie poznany to również zostanie to zakomunikowane. Jeśli posiadasz więcej niż jedną fasolkę danego smaku to nadmiarowe fasolki możesz (a nawet powinnaś/powinieneś) sprzedać.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">5. Jak obliczany jest ranking?</h2>
    <p style="text-align: justify">
        Gdy znajdujesz nową fasolkę do Twojego rankingu dodawane są punkty:
        <ul>
        <li>1 punkt za pospolitą</li>
        <li>10 punktów za <span class="colored">rzadką</span></li>
        <li>1000 punktów za <span class="rav">unikatową</span></li>
        <li>2000 punktów za <span class="huff">legendarną</span></li>
        <li>5000 punktów za <span class="gryff">bezcenną</span> (obecnie jeszcze niewprowadzone)</li>
    </ul>
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">6. Czy gra będzie rozwijana?</h2>
    <p style="text-align: justify">
        Jeśli będzie odpowiednie zainteresowanie - tak.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">7. Jakie wyróżnia się grupy fasolek?</h2>
    <p style="text-align: justify">
        <li>pospolite - warte 1 punkt, można je sprzedać w skupie za 1 galeon, można je wylosować z prawdopodobieństwem 80%</li>
        <li><span class="colored">rzadkie</span> - warte 10 punktów, można je sprzedać w skupie za 10 galeonów, można je wylosować z prawdopodobieństwem 19.5%</li>
        <li><span class="rav">unikatowe</span> - warte 1000 punktów, można je sprzedać w skupie za 100 galeonów, można je wylosować z prawdopodobieństwem 0.5%</li>
        <li><span class="huff">legendarne</span> - warte 2000 punktów, można je sprzedać w skupie za 1000 galeonów (chociaż obecnie jest to praktycznie niemożliwe), można je otrzymać tylko za wykonanie zadania</li>
        <li><span class="gryff">bezcenne</span> (obecnie nieistniejące) - warte 5000 punktów, można je sprzedać w skupie za 10000 galeonów</li>
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">8. Na czym polegają zadania (tzw. questy)?</h2>
    <p style="text-align: justify">
        Po wejściu na stronę zadań tj. <a href="fasolka_quest.php">[tutaj]</a> Twoim oczom ukaże się lista zadań, które można zrealizować. Możesz tu także obserwować swój postęp w wykonaniu każdego zadania. Jeśli wykonasz dane zadanie, wróć na tę stronę i odbierz swoją nagrodę, tj. <span class="huff">legendarną</span> fasolkę. Odbieranie nagrody odbywa się podczas kliknięcie na napis "NAGRODA!" obok danego zadania. Napis ten pojawi się wtedy, kiedy wypełnisz warunki zadania. Fasolkę za dane zadanie można odebrać tylko raz!
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">9. Jak zalogować się do gry?</h2>
    <p style="text-align: justify">
        Wejdź do panelu gry, tj. <a href="fasolka_panel.php">[tutaj]</a> i podaj dane do swojej skrytki w Banku Gringotta. Jeśli konta nie posiadasz kliknij na odpowiedni przycisk.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">10. Czy mogę grać na komórce/tablecie?</h2>
    <p style="text-align: justify">
        Tak. Gra jest tak skonstruowana, że wyświetla tylko istotną dla gry zawartość przez co zmniejsza zużycie pakietu danych, a także szybkość załadowania strony. Wszystkie funkcjonalności gry są dostępnie mobilnie. Ponadto wygląd gry został odpowiednio zmodyfikowany, aby na smartfonie czy tablecie był równie czytelny co na urządzeniu stacjonarnym.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">11. Zapomniałam/em hasło do swojej skrytki. Co zrobić?</h2>
    <p style="text-align: justify">
        Napisz krótką wiadomość na dyrekcjawh@gmail.com z maila, z którego prawdopodobnie założyłaś/eś konto z prośbą o nowe hasło. Jeśli nie pamiętasz, z której skrytki mailowej dokonywałaś/eś rejestracji bądź zapomniałaś/eś hasła do tejże, wpadnij do pubu i pogadaj z kimś z dyrekcji, może się uda. Szkoda przecież, żebyś stracił(a) dostęp do swoich własnych galeonów!
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">12. Jak działa skup fasolek?</h2>
    <p style="text-align: justify">
        Dość często zdarzy się, że wylosujesz fasolkę o smaku, który już wcześniej wylosowałaś/eś. Po co trzymać wiele egzemplarzy tego samego smaku, skoro możesz je wymienić na trochę gotówki. Ile dokładnie? Sprawdź w pytaniu 7.
    </p>
    <p style="text-align: justify">
        Po wejściu do skupu czyli <a href="fasolka_skup.php">[tutaj]</a> oczom ukazuje się lista fasolek, które możemy sprzedać oraz widoczny przycisk. Po jego sprzedane zostaną wszystkie zbędne fasolki i koncie pojawią się galeony. Jeśli posiadasz więcej niż 50 zbędnych fasolek, jednorazowe przyciśnięcie spowoduje sprzedanie 50 losowo wybranych. Spowodowane jest to szybkością działania algorytmu. Nie chcieliśmy, żeby trwało to zbyt długo i sprawiało wrażenie zawieszenia się gry. Zachęcamy zatem do systematycznego korzystania za skupu fasolek.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">13. Czy można wymieniać się fasolkami?</h2>
    <p style="text-align: justify">
        Nie chcieliśmy dawać żadnej motywacji do prób oszustwa, np. tworzenia dodatkowych kont, a zatem każdy zbiera fasolki dla siebie. Aczkolwiek nie wykluczamy takiej możliwości w przyszłości. Po prostu nie chcieliśmy dawać pokus.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">14. Czy przewidziane są punkty dla domów uczniów, którzy są najlepsi w zbieraniu fasolek?</h2>
    <p style="text-align: justify">
        ...może? Ale powtórzę: gra musi być czysta.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">15. Jestem nowa/y. Mam mało galeonów. Nie mam szans, nie ma sensu grać, co zrobić...?</h2>
    <p style="text-align: justify">
        <ul>
        <li>Sprzedawaj zbędne fasolki w skupie, aby mieć więcej gotówki</li>
        <li>Bierz udział w konkursach, w których nagrodami są galeony, np. wypady do Hogsmeade</li>
        <li>Wpadaj na szkolne wydarzenia, mogą się pojawić niespodzianki</li>
        <li>Przyjdź do pubu i zagadaj do Xeme_Werdyen, może Cię poratuje</li>
        <li>Przyjmij taką strategię gry, by najpierw pomnożyć galeony (dobór odpowiednich czar)</li>
    </ul>
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">16. Czym są bileciki?</h2>
    <p style="text-align: justify">
        Są to losy, które gwarantują wylosowanie fasolki rzadkiej lub unikatowej. Wyróżnia się trzy rodzaje bilecików: brązowe, srebrne i złote. Brązowe dają bardzo dużą szansę wylosowania rzadkiej, złote - unikatowej, natomiast w przypadku srebrnych szanse dzielą się po równo.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">17. Jak zdobyć bileciki?</h2>
    <p style="text-align: justify">
        Obecnie jedyną metodą jest uczestnictwo w szkolnych wydarzeniach, podczas których administrator gry może w ten sposób nagradzać graczy. W przyszłości będą inne sposoby otrzymania bileciku.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">18. Na czym polega kradzież w grze?</h2>
    <p style="text-align: justify">
        Każdy gracz ma możliwość podjęcia próby kradzieży własności innego gracza. Prawdopodobieństwo sukcesu wynosi bazowo 11%, przy czym poprzez podniesienie poziomu czary rozbójnika można to prawdopodobieństwo zwiększyć o 20 punktów procentowych. Podobnie każdy może bronić swoich zasobów poprzez rozwijanie czary stróża, co zmniejsza prawdopodobieństwo bycia ofiarą kradzieży nawet o 30 punktów procentowych (na 10. poziomie).
    </p>
    <p style="text-align: justify">
        Aby prawdopodobieństwo udanej kradzieży było maksymalne należy odczekać 1 godzinę pomiędzy kolejnymi próbami. Powoduje to odbudowanie bazowego prawdopodobieństwa do 11%. Bonus wynikający z czary rozbójnika jest stały w czasie.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">19. Jak bronić się przed kradzieżą?</h2>
    <p style="text-align: justify">
        <ul>
        <li>Podnoszenie poziomu czary stróża</li>
        <li>Posiadanie w swojej kolekcji dodatkowych (nadmiarowych) fasolek pospolitych, zwiększa to szansę, że właśnie fasolka pospolita stanie się obiektem kradzieży, co nie jest tak bolesne</li>
    </ul>
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">20. Na czym polega rozwój postaci?</h2>
    <p style="text-align: justify">
    Polega on na podnoszeniu poziomu czar, które dostępne są pod "Moje czary" w panelu. Za odpowiednią ilość galeonów można podnieść poziom wybranej czary. Efekt działania każdej z nich jest dokładnie opisany. Podobnie jasno jest określony obecny poziom czary i wartość jej efektu. Każde kolejne ulepszenie jest droższe (o około 15% od poprzedniego). Cena ulepszenia <span class="bold">nie zależy</span> od czary, dlatego polecane jest ulepszenie najpierw jednej czary do maksimum, zanim będzie się podnosiło poziom kolejnej.
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px" id="21">21. Ile wynoszą bonusy czar na kolejnych poziomach?</h2>
    <p style="text-align: justify">
        <table class="sixty-size basic-table center-align">
        <tr><th>Poziom</th><th>Skąpca</th><th>Szczęściarza</th><th>Stróża</th><th>Kupca</th><th>Rozbójnika</th></tr>
        <?php
        for($i = 1; $i <= 10; $i = $i + 1){
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".skapiec_pts($i)."%</td>";
            echo "<td>".szczesciarz_pts($i)."%</td>";
            echo "<td>".stroz_pts($i)."%</td>";
            echo "<td>".kupiec_pts($i)."%</td>";
            echo "<td>".rozbojnik_pts($i)."%</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px" id="22">22. Ile kosztują kolejne ulepszenia?</h2>
    <p style="text-align: justify">
    <table class="sixty-size basic-table center-align">
        <tr><th>Poziom ulepszenia (suma wszystkich)</th><th>Koszt</th><th>Koszt skumulowany</th></tr>
        <?php
        for($i = 1; $i <= 50; $i = $i + 1){
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".next_lvl_cost($i)." gal.</td>";
            echo "<td>".cost_to_this_lvl($i)." gal.</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </p>
    <h2 style="border-top: 1px #f9d0b9 solid; padding-top: 10px">23. Znalazłam/em błąd w grze.</h2>
    <p style="text-align: justify">
    Zrób screena, opisz, co się stało na xwerdyen@gmail. Może akurat jakąś nagrodę za to zgarniesz.
    </p>

    <h1 id="hodowla">HODOWLA - minitutorial</h1>
    <h4>
        -1. Czy Ty serio sądzisz, że to przeczytam?
    </h4>
    <p>
        Nieśmiało na to liczę...
    </p>
    <h4>
        0. Dlaczego to takie skomplikowane?
    </h4>
    <p>
        To wcale nie jest takie skomplikowane, po prostu ja jestem słaby w tłumaczeniu tego. Jak czegoś nie rozumiesz, wpadnij do Pubu Czarownica, może Ci ktoś wytłumaczy.
    </p>
    <h4>
        1. Jaka jest korzyść hodowli fasolek?
    </h4>
    <p>
        To jedyna możliwość uzyskania fasolek bezcennych dostępna obecnie w grze. Poza tym jeśli poprawnie zajmujesz się swoją uprawą masz naprawdę spore szansę uzyskać z każdej sadzonki przynajmniej unikatową fasolkę. <span class="gryff">KLUCZEM JEST CIĄGŁE ZWIĘKSZANIE POTENCJAŁU SWOJEGO NASIONKA POPRZEZ PODLEWANIE I ZACHĘCANIE INNYCH GRACZY DO NAWOŻENIA NASZEGO NASIONKA</span>
    </p>
    <h4>
        2. Jak wyhodować fasolkę - krok po kroku
    </h4>
    <p>
        <ul>
        <li>Zbieraj nasionka - przy okazji losowania fasolek</li>
        <li>Kup doniczkę w ekranie hodowli</li>
        <li>Zasadź nasionko w ekranie hodowli</li>
        <li>Ustal nagrodę za nawiezienie Twojej fasolki - koszt nawozu to 10 galeonów, więc jeśli ustalisz nagrodę na 12 galeonów, to inni gracze dostaną 2 galeony na swoje konto za nawiezienie Twojej fasolki. Nagrody nie można zmieniać później. Każdą fasolkę można nawieźć 10-krotnie, zatem jeśli ustalisz nagrodę na 12 galeonów musisz się liczyć w potencjalnym kosztem 120 galeonów</li>
        <li>Podlej nasionka 10-krotnie, najlepiej w odstępach 8-godzinnych</li>
        <li>Zbierz fasolki (pojawi się odpowiedni przycisk po 10. podlaniu)</li>
        <li>Wybierz smak wyhodowanej fasolki spośród 3 zaproponowanych (wyliczonych na podstawie potencjału) albo nazwij nowy niepoznany smak</li>
    </ul>
    </p>
    <h4>
        3. Jak wyhodować najlepszą fasolkę - krok do kroku
    </h4>
    <p>
        <ul>
        <li>
            Normalnie losuj fasolki, średnio co 70 losowań wylosujesz nasionko. Jego jakość będzie opisana słownie i oznacza POCZĄTKOWY POTENCJAŁ nasiona, od najsłabszych to: marne, przeciętne, dobre, wyjątkowe i doskonałe. Potencjał zawiera się pomiędzy 100 a 200. Doskonałe nasiona posiadają przynajmniej 180 potencjału.
        </li>
        <li>
            Gdy przejdziesz do ekranu hodowli znajdziesz tabelę zawierającą niewykorzystane nasiona, które są uszeregowane od najlepszego do najgorszego, więć bardzo dobrą zasadą jest zawsze sadzić to nasiono, które znajduje się w pierwszym wierszu tabeli.
        </li>
        <li>
            Aby zasadzić nasiono potrzebujesz doniczki - możesz ją kupić w ekranie hodowli, im droższa, tym więcej razy można jej użyć
        </li>
        <li>
            W tabeli nieużytych nasion naciśnij ZASADŹ, dokonaj wyboru doniczki oraz nagrody za nawożenie. Nagroda ta jest bardzo ważna, ponieważ motywuje do nawożenia Twojego nasiona przez innych graczy. Jeśli ustalisz tę nagrodę na 0, to każdy, kto będzie chciał nawieźć Twoje nasiono będzie tracił 10 galeonów (bo tyle wynosi koszt pojedynczego nawożenia). Jeśli ustalisz tę nagrodę na 15, to będziesz wypłacał(a) każdemu nawożącemu 15 galeonów, ponieważ koszt nawozu to 10 galeonów, zyska on netto 5 galeonów. PAMIĘTAJ, że w tabeli nawożenia pojawia się tylko 10 najlepszych ofert, więc jeśli będziesz słabo nagradzać graczy za nawożenie Twojego nasionka, to tego po prostu nie zrobią.
        </li>
        <li>
            Aby zebrać plon z nasionka należy je 10-krotnie podlać (warunek konieczny), a w tym czasie może ono być 10-krotnie nawiezione przez innych graczy (ale nie jest to wymagane). Każde podlanie i każde nawożenie zwiększa potencjał nasiona, a tym samym szansę na dobry plon.
        </li>
        <li>
            Kiedy podlewanie jest najbardziej efektywne: jeśli odbywa się co 8 godzin, zegar jest widoczny pod każdą doniczką w ekranie hodowla
        </li>
        <li>
            Kiedy nawożenie jest najbardziej efektywne: jak najwcześniej po zasadzeniu (dlatego też dobra nagroda na początku jest ważna - nagrody nie można później zmienić)
        </li>
        <li>
            Po 10. podlaniu przycisk PODLEJ zamieni się w przycisk ZBIERZ. Po jego kliknięciu ukażą się graczowi 3 opcje fasolek do wyboru, ponieważ czasami na wyborem trzeba się zastanowić, gracz może przełączyć okno i podjąć decyzję później. Jeśli graczowi uda się wyhodować fasolkę o nieznanym do tej pory smaku otrzyma prawo do nazwania tego smaku. Proszę o godne nazywanie fasolek. Z obawy przed wygaśnięciem sesji na stronie proszę o szybkie wymyślanie smaku fasolki, aby nie stracić tego prawa (tego byśmy nie chcieli).
        </li>

    </ul>
    </p>
    <h4>
        4. Zapomniałam/em podlać fasolkę przez kilka dni
    </h4>
    <p>
        Wróć i podlej. Przy tym podlaniu potencjał Twojej fasolki może ulec pogorszeniu, ale jeśli zaczniesz zachowywać 8-godzinne odstępy, dalej jest szansa na dobrą fasolkę na koniec.
    </p>
    <h4>
        5. Jak ustalić optymalną nagrodę za nawożenie?
    </h4>
    <p>
        Sprawdź w ekranie Inni gracze, jakie są obecnie najbardziej korzystne oferty. Jeśli w kolumnie "Zysk dla Ciebie" największa wartość wynosi 15, to jeśli ustalisz nagrodę na 26 galeonów masz pewność, że Twoja oferta będzie na samej górze.
    </p>
    <h4>
        6. Czy da się wyhodować naprawdę dobrą fasolkę bez nawożenia innych?
    </h4>
    <p>
        Nie
    </p>
    <h4>
        7. Co jest ważniejsze podlewanie czy nawożenie?
    </h4>
    <p>
        Optymalne podlewanie zwiększa potencjał o 30% względem obecnego, nawożenie o 10%. Magia procentu składanego.
    </p>
    <h4>
        8. Od jakiego potencjału mam szansę na fasolkę unikatową i bezcenną?
    </h4>
    <p>
        Unikatową - 2500, bezcenną - ok. 4200
    </p>
    <h4>
        9. Jaki jest maksymalny potencjał, jaki może mieć fasolka?
    </h4>
    <p>
        Ok. 7000. To jest wykonalne.
    </p>


</div>
</body>
</html>