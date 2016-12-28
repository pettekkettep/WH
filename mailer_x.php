<?php



function send_uczen_zgloszenie_odrzucone($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";
    
//    TEN MAIL JEST SFORMATOWANY POPRAWNIE: polskie znaki, entery i odpowiednie nazwiska
    mail($outcome['mail'], "Zostałeś wyrzucony.", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br><br>
    Z przykrością informujemy, że zostałeś wyrzucony z Wirtualnego Hogwartu,
    ponieważ złamałeś zasady szkolne lub nie spełniłeś wymogów szkolnych. Możesz spróbować swoich sił w kolejnym roku, tym razem przestrzegając regulaminów.<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
}

function send_nauczyciel_zgloszenie_odrzucone($id){//użyte

    $sql = "SELECT * FROM zapisy_n WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Twoje zgłoszenie zostało odrzucone.", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br><br>
    Twoje zgłoszenie na nauczyciela zostało odrzucone.
    Prawdopodobnie było zbyt słabe, źle wypełnione lub po prostu byli lepsi od Ciebie.<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
}

function send_uczen_wyrzucony($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Zostałeś wyrzucony.", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Z przykrością informujemy, że zostałeś wyrzucony z Wirtualnego Hogwartu,
    ponieważ złamałeś zasady szkolne lub nie spełniłeś wymogów szkolnych. Możesz spróbować swoich sił w kolejnym roku, tym razem przestrzegając regulaminów.<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
}

function send_nauczyciel_zwolniony($id){

    $sql = "SELECT * FROM zapisy_n WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Zostałeś zwolniony.", "______WIRTUALNY HOGWART______,<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Z przykrością informujemy, że zostałeś zwolniony z Wirtualnego Hogwartu.<br>
    Dziękujemy za współpracę i życzymy powodzenia w dalszej pracy.<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu, <br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);
}

function send_nauczyciel_przyjety($id){//użyte

    $sql = "SELECT * FROM zapisy_n WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Witamy w WH!", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Z radością informujemy, że zostałeś przyjęty na stanowisko nauczyciela przedmiotu: ".$outcome['przedmiot']."!<br>
    Życzymy powodzenia w pracy w Wirtualnym Hogwarcie, liczymy, że pobyt w naszym zamku będzie dla Ciebie świetnym przeżyciem.<br><br>
    
    Zapoznaj się z ważnymi dla nauczyciela dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Poradnik dla poczatkujących: http://wh.boo.pl/poradnik.pdf<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
}

function send_absolwent($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Ukonczyłeś szkołę!", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br>
    <br>
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Gratulujemy! Zostałeś absolwentem Wirtualnego Hogwartu im. Syriusza Croucha!<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
}

function send_lista_wyposazenia_1($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Lista niezbędnego wyposażenia.", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
  
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    poniżej znajduje się lista wszystkich przedmiotów niezbędnych do nauki w Wirtualnym Hogwarcie. Wszystkie przedmioty znajdziesz na Ulicy Pokątnej oraz w Hogsmeade. Aby dokonać zakupu, musisz posiadać skrytkę w Banku Gringotta.<br><br>
    
    UWAGA!<br>
    Kupowanie przedmiotów nie jest obowiązkowe! Za każdy zakupiony przedmiot Twój dom otrzyma 1 punkt do Rankingu Domów.<br><br>
    
    UMUNDUROWANIE<br>
    Dla studentów klasy I:<br>
    1. Szata uczniowska<br>
    2. Tiara uczniowska<br>
	3. Strój ochronny<br><br>

    PODRĘCZNIKI<br>
    Dla studentów klasy I:<br>
    1. Magiczne wzory i napoje, Arseniusa Jiggera (Eliksiry)<br>
    2. Dzieje magii, Bathildy Bagshot (Historia Magii)<br>
    3. Ciemne moce: Poradnik samoobrony, Quientina Trimble'a (OPCM)<br>
    4. Wprowadzenie do transmutacji (dla poczatkujących), Emerika Switcha (Transmutacja)<br>
    5. Teoria magii, Adalberta Wafflinga (Zaklęcia)<br>
    6. Tysiąc magicznych ziół i grzybów, Phyllidy Spore (Zielarstwo)<br>
    7. Standardowa księga zaklęć (stopień 1), Mirandy Goshawk<br><br>
    
    POZOSTAŁE WYPOSAŻENIE<br>
    Dla studentów klasy I:<br>
    1. Różdżka<br>
    2. Kociołek (cynowy, rozmiar 2)<br>
    3. Zestaw fiolek (zwykłe lub złote)<br>
    4. Teleskop<br>
    5. Waga<br><br>
    
    Studentom pozwala się na posiadanie jednego zwierzaka (wybór: kot, szczur, sowa, ropucha, szpiczak, lelek, memortek, psidwak, kruk, wsiąkiewka).<br><br>
    
    PRZYPOMINA SIĘ RODZICOM, ŻE STUDENTOM PIERWSZEGO ROKU NIE ZEZWALA SIĘ NA POSIADANIE WŁASNYCH MIOTEŁ.<br><br>
	
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);
}

function send_lista_wyposazenia_2($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Lista niezbędnego wyposażenia.", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Szanowna/y Pani/e " . $outcome['nazwisko'] . ",<br>
    poniżej znajduje się lista wszystkich przedmiotów niezbędnych do nauki w Wirtualnym Hogwarcie. Wszystkie przedmioty znajdziesz na Ulicy Pokątnej oraz w Hogsmeade. Aby dokonać zakupu, musisz posiadać skrytkę w Banku Gringotta.<br><br>
    
    UWAGA!<br>
    Kupowanie przedmiotów nie jest obowiązkowe! Za każdy zakupiony przedmiot Twój dom otrzyma 1 punkt do Rankingu Domów.<br><br>
    
    UMUNDUROWANIE<br>
    Dla studenta klasy II:<br>
    1. Szata uczniowska<br>
    2. Tiara uczniowska<br>
    3. Strój ochronny<br><br>
    
    PODRĘCZNIKI<br>
    Dla studenta klasy II:<br>
    1. Eliksiry dla zaawansowanych, Libacjusza Borage (Eliksiry)<br>
    2. Dzieje magii, Bathildy Bagshot (Historia Magii)<br>
    3. Teoria obrony magicznej, Wilberta Slinkharda (OPCM)<br>
    4. Natychmiastowa transmutacja (Transmutacja)<br>
    5. Wybitne osiagnięcia w czarowaniu (Zaklęcia)<br>
    6. Tysiąc magicznych ziół i grzybów, Phyllidy Spore (Zielarstwo)<br>
    7. Standardowa księga zaklęć (stopien 2), Mirandy Goshawk<br>
    oraz podreczniki dodatkowe (z wybranych przedmiotow):<br>
    1. Fantastyczne zwierzęta i jak je znaleźć, Newta Skamandera (ONMS)<br>
    2. Sylabariusz Spellmana (Runy)<br>
    3. Demaskowanie przyszłości, Kasandry Vablatsky (Wróżbiarstwo)<br>
    4. Życie domowe i obyczaje brytyjskich mugoli, Wilhelma Wigworthy'ego (Mugoloznawstwo)<br>
    5. Nowa teoria numerologii (Numerologia)<br><br>
    
    POZOSTAŁE WYPOSAŻENIE<br>
    Dla studenta klasy II:<br>
    1. Różdżka<br>
    2. Kociołek (cynowy, rozmiar 2)<br>
    3. Zestaw fiolek (zwykłe lub złote)<br>
    4. Teleskop<br>
    5. Waga<br><br>
    
    Studentom pozwala się na posiadanie jednego zwierzaka (wybór: kot, szczur, sowa, ropucha, szpiczak, lelek, memortek, psidwak, kruk, wsiąkiewka).<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);
}

function send_lista_wyposazenia_3($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Lista niezbędnego wyposażenia.", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    poniżej znajduje się lista wszystkich przedmiotów niezbędnych do nauki w Wirtualnym Hogwarcie. Wszystkie przedmioty znajdziesz na Ulicy Pokątnej oraz w Hogsmeade. Aby dokonać zakupu, musisz posiadać skrytkę w Banku Gringotta.<br><br>
    
    UWAGA!<br>
    Kupowanie przedmiotów nie jest obowiązkowe! Za każdy zakupiony przedmiot Twój dom otrzyma 1 punkt do Rankingu Domów.<br><br>
    
    UMUNDUROWANIE<br>
    Dla studenta klasy III:<br>
    1. Szata uczniowska<br>
    2. Tiara uczniowska<br>
    3. Strój ochronny<br><br>
    
    PODRĘCZNIKI<br>
    Dla studenta klasy III (zgodnie z wybranymi przedmiotami):<br>
    1. Eliksiry dla zaawansowanych, Libacjusza Borage (Eliksiry)<br>
    2. Dzieje magii, Bathildy Bagshot (Historia Magii)<br>
    3. Konfrontacje z bezimiennymi (OPCM)<br>
    4. Poradnik transmutacji dla zaawansowanych (Transmutacja)<br>
    5. Wybitne osiagnięcia w czarowaniu (Zaklęcia)<br>
    6. Mięsożerne drzewa świata (Zielarstwo)<br>
    7. Standardowa księga zaklęć (stopień 3), Mirandy Goshawk<br>
    8. Potworna księga potworów (ONMS)<br>
    9. Runy dla zaawansowanych (Runy)<br>
    10. Sennik, Iniga Imago (Wróżbiarstwo)<br>
    11. Życie domowe i obyczaje brytyjskich mugoli, Wilhelma Wigworthy'ego (Mugoloznawstwo)<br><br>
    
    POZOSTAŁE WYPOSAŻENIE<br>
    Dla studenta klasy III:<br>
    1. Różdżka<br>
    2. Kociołek (cynowy, rozmiar 2)<br>
    3. Zestaw fiolek (zwykłe lub złote)<br>
    4. Teleskop<br>
    5. Waga<br><br>
    
    Studentom pozwala się na posiadanie jednego zwierzaka (wybór: kot, szczur, sowa, ropucha, szpiczak, lelek, memortek, psidwak, kruk, wsiąkiewka).<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);
}

function send_uczen_gryffindor($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Witamy w WH!", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx.<br><Br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Mamy przyjemność poinformowania, że został/a Pan/Pani przyjęta/y do Wirtualnego Hogwartu! Twój dom to Gryffindor - bądź jemu wierny!<br>
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Poradnik dla poczatkujących: http://wh.boo.pl/poradnik.pdf<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);

}

function send_uczen_hufflepuff($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Witamy w WH!", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx.<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Mamy przyjemność poinformowania, że został/a Pan/Pani przyjęta/y do Wirtualnego Hogwartu! Twój dom to Hufflepuff - bądź jemu wierny!<br>
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Poradnik dla poczatkujących: http://wh.boo.pl/poradnik.pdf<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
   
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);

}

function send_uczen_ravenclaw($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Witamy w WH!", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Mamy przyjemność poinformowania, że został/a Pan/Pani przyjęta/y do Wirtualnego Hogwartu! Twój dom to Ravenclaw - bądź jemu wierny!<br>
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Poradnik dla poczatkujących: http://wh.boo.pl/poradnik.pdf<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);

}

function send_uczen_slytherin($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Witamy w WH!", "______WIRTUALNY HOGWART______<br>
    SZKOŁA MAGII I CZARODZIEJSTWA<br><br>
    
    Dyrektor Marlen Cruciusx.<br><br>
    
    Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Mamy przyjemność poinformowania, że został/a Pan/Pani przyjęta/y do Wirtualnego Hogwartu! Twój dom to Slytherin - bądź jemu wierny!<br>
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Poradnik dla poczatkujących: http://wh.boo.pl/poradnik.pdf<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);

}

function send_uczen_przeniesiony_do_1($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Zostałeś przeniesiony!", "Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Informujemy, że zostałeś przeniesiony do klasy I.<br><br>
    
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);
    
}

function send_uczen_przeniesiony_do_2($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Zostałeś przeniesiony!", "Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Informujemy, że zostałeś przeniesiony do klasy II.<br>
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
	- System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);

}

function send_uczen_przeniesiony_do_3($id){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail($outcome['mail'], "Zostałeś przeniesiony!", "Szanowna/y Pani/e ".$outcome['nazwisko'].",<br>
    Informujemy, że zostałeś przeniesiony do klasy III.<br><br>
    
    Dołączamy listę niezbędnych dokumentów, książek i wyposażenia.<br><br>
    
    Zapoznaj się z ważnymi dokumentami:<br>
    - Szkolny Regulamin: http://wh.boo.pl/infopage.php?id=1<br>
    - System Oceniania: http://wh.boo.pl/infopage.php?id=2<br>
    - Oferta Edukacyjna: http://wh.boo.pl/infopage.php?id=3<br>
    - Samouczek: http://wh.boo.pl/infopage.php?id=18<br>
    - FAQ: http://wh.boo.pl/infopage.php?id=17<br><br>
    
    Z wyrazami szacunku, <br>
    Dyrekcja Wirtualnego Hogwartu,<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
     ",$headers);
}

function send_wszyscy_uczniowie($id, $text, $podpis){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail("".$outcome['mail']."", "Wiadomość do Uczniów WH!", "Wiadomość do uczniów Wirtualnego Hogwartu:<br><br>

    ".$text."<br><br>
    
    Z wyrazami szacunku, <br>
    ".$podpis.",<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
    
}

function send_wszyscy_nauczyciele($id, $text, $podpis){

    $sql = "SELECT * FROM zapisy_n WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail("".$outcome['mail']."", "Wiadomość do Nauczycieli WH!", "Wiadomość do nauczycieli Wirtualnego Hogwartu:<br><br>

    ".$text."<br><br>
    
    Z wyrazami szacunku,<br>
    ".$podpis.",<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
    
}

function send_wszyscy_gryfoni($id, $text, $podpis){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail("".$outcome['mail']."", "Wiadomość do Gryfonów WH!", "Wiadomość do Gryfonów Wirtualnego Hogwartu:<br><br>

    ".$text."<br><br>
    
    Z wyrazami szacunku,<br>
    ".$podpis.",<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
    
}

function send_wszyscy_puchoni($id, $text, $podpis){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail("".$outcome['mail']."", "Wiadomość do Puchonów WH!", "Wiadomość do Puchonów Wirtualnego Hogwartu:<br><br>

    ".$text."<br><br>
    
    Z wyrazami szacunku,<br>
    ".$podpis.",<br>
    www.wh.boo.pl<br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
    
}

function send_wszyscy_krukoni($id, $text, $podpis){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail("".$outcome['mail']."", "Wiadomość do Krukonów WH!", "Wiadomość do Krukonów Wirtualnego Hogwartu:<br><br>

    ".$text."<br><br>
    
    Z wyrazami szacunku,<br>
    ".$podpis.",<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
    
}

function send_wszyscy_slizgoni($id, $text, $podpis){

    $sql = "SELECT * FROM zapisy_u WHERE id=$id";
    $result = db_statement($sql);
    $outcome = mysqli_fetch_assoc($result); $headers = "Content-Type: text/html; charset=UTF-8";

    mail("".$outcome['mail']."", "Wiadomość do Ślizgonów WH!", "Wiadomość do Ślizgonów Wirtualnego Hogwartu:<br><br>

    ".$text."<br><br>
    
    Z wyrazami szacunku,<br>
    ".$podpis.",<br>
    www.wh.boo.pl<br><br>
    
    Sowa została wysłana automatycznie.
    ",$headers);
    
}

function send_to_all_uczen($temat, $text){//użyte

    $sql = "SELECT * FROM zapisy_u";
    $result = db_statement($sql);
    $headers = "Content-Type: text/html; charset=UTF-8";
    $status = "";

    while($outcome = mysqli_fetch_assoc($result)){
        $success = mail($outcome['mail'], $temat, "______WIRTUALNY HOGWART______<br><br>
        Dyrektor Marlen Cruciusx<br><br>

        Szanowna/y Pani/e ".$outcome['nazwisko'].",<br><br>
                ".$text."<br><br>
         Z wyrazami szacunku, <br>
        Dyrekcja Wirtualnego Hogwartu,<br>
        www.wh.boo.pl<br><br>", $headers);
        if($success) $success = "OK";
        else $success = "BŁĄD";

        $status = $status . "<p class='narrow'>".$outcome['mail']." - $success</p>";
    }
    return $status;
}


?>
