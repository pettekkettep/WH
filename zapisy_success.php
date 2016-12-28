<?php
require_once("./functions_x.php");
session_start();

if(isset($_SESSION['msg'])){
    echo "<div id='msg'>" . $_SESSION['msg'] . "</div>";
    unset($_SESSION['msg']);
}

if(isset($_SESSION['kto'])){
    if($_SESSION['kto'] == "u") {
        $text = "<h2>Twoje zgłoszenie zostało przyjęte do rozpatrzenia (nie powinno to trwać dłużej niż 24 godziny)</h2>
            <h3>Wiadomość o przyjęciu otrzymasz na sowę (skrzynkę mailową). Ze względu na ilość wysyłanych wiadomości, zdarza się, że   wiadomości od nas są traktowane jako SPAM, więc należy też sprawdzać ten folder. Czekając na rozpatrzenie Twojego zgłoszenia zapoznaj się z ważnymi dla ucznia dokumentami:</h3>
            <ul>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=25'>Samouczek</a></li>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=1'>Regulamin szkoły</a></li>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=4'>System oceniania</a></li>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=10'>Oferta edukacyjna</a></li>
            </ul>";
        unset($_SESSION['kto']);
    }
    if($_SESSION['kto'] == "n") {
        $text = "<h2>Twoje zgłoszenie zostało przyjęte do rozpatrzenia</h2>
            <h3>Wiadomość zarówno o pozytywnym, jak i negatywnym rozpatrzeniu zgłoszenia otrzymasz na sowę (skrzynkę mailową). Ze względu na ilość wysyłanych wiadomości, zdarza się, że wiadomości od nas są traktowane jako SPAM, więc należy też sprawdzać ten folder. Czekając na rozpatrzenie Twojego zgłoszenia zapoznaj się z ważnymi dla ucznia dokumentami:</h3>
            <h3>Jeśli nie zostaniesz przyjęta/y na posadę nauczyciela, rozważ rozpoczęcie kariery ucznia - ukończenie szkoły niemalże gwarantuję stanowisko w naszej placówce!</h3>
            <ul>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=25'>Samouczek</a></li>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=1'>Regulamin szkoły</a></li>
            <li><a href='http://wh.boo.pl/infopage_x.php?id=4'>System oceniania</a></li>
            </ul>";
        unset($_SESSION['kto']);
    }
    if($_SESSION['kto'] == "nn") {
        $text = "<h2>Nie ma żadnych wolnych posad!</h2>
            <h3>Dziękujemy za zainteresowanie uczeniem w naszej szkole, ale obecnie nie poszukujemy nauczycieli</h3>
            <h3>Ale nie martw się! Sprawdzaj co jakiś czas, czy nie uruchomiliśmy rekrutacji na któreś ze stanowisk bądź zapisz się jako uczeń!</h3>";
        unset($_SESSION['kto']);
    }
} else {
    header("Location: index_x.php");
}
?>

<? include("before_content.php"); ?>

    <div class="col-6 col-m-6">
        <div class="row">
            <? echo $text ?>
        </div>
    </div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>