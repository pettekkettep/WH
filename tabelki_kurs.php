<?php

session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

require_once('./logfunctions_x.php');
print_admin_toolbox();




?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>WH - ZARZĄDZANIE ZASOBAMI LUDZKIMI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
</head>
<body>
<div class="row row-style" style="padding: 15px">
<p class="narrow">Jeśli pomyślałaś/eś kiedykolwiek, że chcesz zrobić ładną i czytelną tabelkę do newsa - gratulacje! Wykonałaś/eś pierwszy krok w kierunku opanowania tej użytecznej umiejętności!</p>

<p class="narrow">W poniższym tutorialu (z fabułą) przedstawię, jak krok po kroku stworzyć, przy okazji odpowiadając na najczęstsze pytania i wspominając, jak uniknąć nierzadkich błędów. Nie wszystkie kroki są wymagane, by końcowy rezultat był zadowalający, jednakże sumienne wykonanie kolejnych punktów gwarantuje sukces! PS. Nawet jeśli czujesz się pewny w tej tematyce - przejrzyj tutorial, bo jest kilka nowości, które mogą przyspieszyć pracę</p>

<h1>Krok 1 - Projekt tabelki</h1>
<p class="narrow">Zorganizowałem szkolną olimpiadę z Wampirologii. Chcę w formie tabelarycznej przedstawić wyniki. Tabela ma zawierać 5 kolumn: miejsce, imię, nazwisko, punkty, informacja o awansie do kolejnego etapu i 8 uczniów (tabelka zawierać ma 9 wierszy, bo należy wziąć pod uwagę nagłówek).</p>
<p class="narrow"><span class="bad">Błąd: </span>Za wszelką cenę ogranicz liczbę kolumn ze względu na estetykę wyświetlenia Twojej tabeli na urządzeniach przenośnych. Bez wątpienia imię i nazwisko można zamieścić w jednej kolumnie, co ograniczy ich końcową liczbę do 4.</p>

<h1>Krok 2 - Stworzenie tabelki</h1>
<p class="narrow">Należy wybrać ikonę przedstawiającą tabelę - zaznaczono na czerwono</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/1.PNG">
<p class="narrow">Należy ustawić odpowiednią liczbę kolumn, wierszy i szerokość (proponuję 100%)</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/2.PNG">

<h1>Krok 3 - Uzupełnij tabelę informacjami</h1>
<img style="max-width: 60%; width: auto" src="tabelkikurs/3.PNG">

<h1>Krok 4 - Pokoloruj tabelę</h1>
<p class="narrow">Jeśli chcesz pokolorować całe rzędy tabeli kolorem domu (to dość częsty zabieg) wystarczy do rzędów - elementów <span class="bold">tr</span> dopisać odpowiednią klasę: gryff, huff, rav, slyth lub nau. Aby to zrobić należy przejść do źródła</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/4.PNG">
<img style="max-width: 60%; width: auto" src="tabelkikurs/5.PNG">
<p class="narrow">Chcę jednak, aby ostatnia kolumna zawierała "TAK" pokolorowane na zielono oraz "NIE" pokolorowane na czerwono. Najłatwiej chyba zrobić to ręcznie, wyjść ze źródła i za pomocą narzędzia kolorowania wybrać odpowiedni odcień.</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/6.png">

<h1>Krok 5 - Nagłówki i styl tabeli</h1>
<p class="narrow">Te czynności wykonujemy ponownie w źródle. Pierwszy rząd <span class="bold">tr</span> nie powinien zawierać zwykłych komórek <span class="bold">td</span>, tylko nagłówkowe <span class="bold">th</span>, a zatem dokonujemy ich podmiany.</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/7.PNG">
<p class="narrow">Tabela musi/powinna zawierać klasy: <span class="bold">basic-table</span> oraz <span class="bold">center-align</span></p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/8.PNG">

<h1>Krok 6 - Personalizacja tabelki</h1>
<p class="narrow">Tabelka w obecnym kształcie mogłaby już iść na stronę główną.</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/9.PNG">
<p class="narrow">Jeśli chcesz dokonać pewnych zmian w wyglądzie, np: pogrubienie czcionki, kursywa, wyrównanie niektórych kolumn do lewej itp. to dokonaj ich normalnie w edytorze.</p>
<p class="narrow">Jeśli chcesz, aby któraś z kolumn zajmowała jedynie minimalną wymaganą szerokość, należy odpowiedniemu nagłówkowi <span class="bold">th</span> przypisać klasę <span class="bold">no-wrap-fit</span>. W przypadku naszej tabelki tę klasę można przypisać na przykład kolumnie "Miejsce", będzie ona zajmowała wówczas mniej przestrzeni.</p>
<img style="max-width: 60%; width: auto" src="tabelkikurs/10.PNG">
<img style="max-width: 60%; width: auto" src="tabelkikurs/11.PNG">
<p class="narrow">Przykładowa tabelka, która została tu opisana znajduje się: <a href="news_x.php?id=5692">TUTAJ</a>. Możesz się pobawić kodem i zobaczyć, co się stanie. News nie jest widoczny dla publiki. Jeśli nie będziesz w stanie przywrócić stanu pierwotnemu kodowi źródłowemu, to daj znać dyrekcji - naprawimy go.</p>
</div>
</body>
</html>

