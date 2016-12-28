<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./index_functions.php');

// wyświetlanie wiadomości w prawym górnym rogu (jeśli jest)
if(isset($_SESSION['msg'])) {
    print_session_msg();
}

// obsługiwanie logowania, gdy przekazane są pola login i password metodą POST
if(isset($_POST['login']) && isset($_POST['password'])){
    login_handler();
}

// obsługiwanie dodawania komentarza, gdy przekazane są pola comment i newsid metodą POST
if(isset($_POST['comment']) && isset($_POST['newsid'])){
    add_comment_handler();
}

// obsługiwanie usuwania komentarza przez użytkownika o poziomie uprawnień >root<
if(isset($_GET['comment_delete_id']) && users_is_root($_SESSION['username'], $_SESSION['password'])){
    delete_comment_handler();
}

// obsługa wylogowania
if($_GET['logout'] == 1){
    logout();
}


// obsługa logowania przy użyciu mechanizmu cookies
if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
    cookie_login_handler();
}

// jeśli użytkownik nie wybierze inaczej, wyświetlaj pierwszą stronę newsów
if(!isset($_GET['p'])){
    $_GET['p'] = 1;
}

// oznaczenie użytkownika przy użyciu pliku cookie (identyfikacja ludzi o zmiennym ip)
if(isset($_COOKIE['token'])){
    // użytkownik posiada token
    // sprawdzanie czy to IP użytkownika jest znane
    is_this_ip_stored();
}
else{
    // użytkownik nie posiada tokenu
    create_new_token();
}
$title = 'Wirtualny Hogwart';
$header_extras = '';
$display_dementor = false;
$blocks['punkty'] = prepare_punkty_block();
$blocks['headers'] = prepare_headers();
$evalblocks['topleft'] = prepare_blocks_left();

include('index.view.php');

?>

