<?php

include('mailer_x.php');
include('functions_x.php');

function przyjmij_nauczyciela($id){

    $sql = "SELECT id FROM zapisy_n WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego nauczyciela ubiegającego się o pracę! :((");
    else {
        $sql = "UPDATE zapisy_n SET acc = 1 WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_nauczyciel_przyjety($id);
        }
        else die("Błąd! Nie udało się zmienić statusu nauczyciela w bazie danych! :((");
    }

    $_SESSION['msg'] = "Nauczyciel przyjęty!";

}

function odrzuc_nauczyciela($id){


    $sql = "SELECT id FROM zapisy_n WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego nauczyciela ubiegającego się o pracę! :((");
    else {
        $sql = "DELETE FROM zapisy_n WHERE id = $id";
        send_nauczyciel_zgloszenie_odrzucone($id);
        db_statement($sql);
    }

    $_SESSION['msg'] = "Nauczyciel odrzucony!";

}

function dodaj_ucznia_do_gryff($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia starającego się o przyjęcie! :((");
    else {
        $sql = "UPDATE zapisy_u SET acc = 1, dom = '#ff0000' WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_gryffindor($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przyjęty do Gryffindoru!";

}

function dodaj_ucznia_do_huff($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia starającego się o przyjęcie! :((");
    else {
        $sql = "UPDATE zapisy_u SET acc = 1, dom = '#ffcc00' WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_hufflepuff($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przyjęty do Hufflepuffu!";

}

function dodaj_ucznia_do_rav($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia starającego się o przyjęcie! :((");
    else {
        $sql = "UPDATE zapisy_u SET acc = 1, dom = '0066ff' WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_ravenclaw($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przyjęty do Ravenclaw!";

}

function dodaj_ucznia_do_slyth($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia starającego się o przyjęcie! :((");
    else {
        $sql = "UPDATE zapisy_u SET acc = 1, dom = '00cc00' WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_slytherin($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przyjęty do Slytherinu!";

}

function odrzuc_ucznia($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 0";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia starającego się o przyjęcie! :((");
    else {
        $sql = "DELETE FROM zapisy_u WHERE id = $id";
        send_uczen_zgloszenie_odrzucone($id);
        db_statement($sql);
    }

    $_SESSION['msg'] = "Uczeń odrzucony!";

}

function przenies_ucznia_do_klasy_1($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 1";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia na liście uczniów! :((");
    else {
        $sql = "UPDATE zapisy_u SET klasa = 1 WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_przeniesiony_do_1($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przeniesiony do klasy 1!";

}

function przenies_ucznia_do_klasy_2($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 1";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia na liście uczniów! :((");
    else {
        $sql = "UPDATE zapisy_u SET klasa = 2 WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_przeniesiony_do_2($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przeniesiony do klasy 2!";

}

function przenies_ucznia_do_klasy_3($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 1";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia na liście uczniów! :((");
    else {
        $sql = "UPDATE zapisy_u SET klasa = 3 WHERE id = $id";
        $result = db_statement($sql);
        if($result){
            send_uczen_przeniesiony_do_3($id);
        }
        else die("Błąd! Nie udało się zmienić statusu ucznia w bazie danych! :((");
    }

    $_SESSION['msg'] = "Uczeń przeniesiony do klasy 3!";

}

function absolwentuj_ucznia($id){

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 1";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia na liście uczniów! :((");
    else {
        $sql = "DELETE FROM zapisy_u WHERE id = $id";
        send_absolwent($id);
        db_statement($sql);
    }

    $_SESSION['msg'] = "Uczeń stał się absolwentem! :)";

}

function wyrzuc_ucznia($id){

    
    

    $sql = "SELECT id FROM zapisy_u WHERE id = $id AND acc = 1";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego ucznia na liście uczniów! :((");
    else {
        $sql = "DELETE FROM zapisy_u WHERE id = $id";
        send_uczen_wyrzucony($id);
        db_statement($sql);
    }

    $_SESSION['msg'] = "Wyrzuciłeś ucznia. Feels good, doesn't it?";

}

function wyrzuc_nauczyciela($id){
    

    $sql = "SELECT id FROM zapisy_n WHERE id = $id AND acc = 1";
    $result = db_statement($sql);
    if(mysqli_num_rows($result) == 0) die("Błąd! Nie ma takiego nauczyciela wśród zatrudnionych :((");
    else {
        $sql = "DELETE FROM zapisy_n WHERE id = $id";
        send_nauczyciel_zwolniony($id);
        db_statement($sql);
    }

    $_SESSION['msg'] = "Wyrzuciłaś/eś nauczyciela. Na pewno zasługiwał!";

}

?>