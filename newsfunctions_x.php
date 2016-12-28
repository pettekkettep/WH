<?php

include('functions_x.php');

function print_current_news(){

    $sql = "SELECT * FROM news WHERE stat = 1 ORDER BY date desc";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)<1) echo "<h3>Brak newsów</h3>";
    else {
        echo "<table class='generic-table dimmed-center-table'><tr><th>Kiedy</th><th>Tytuł</th><th>Autor</th><th>Akcje</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td><a href='panel_manage_news.php?akcja=archive&id=$id'><div class='button-fitted'>ARCHIWIZUJ</div></a> <a href='edytuj_news.php?id=$id'><div class='button-fitted'>EDYTUJ</div></a> <a href='panel_manage_news.php?akcja=delete&id=$id'><div class='button-fitted'>USUŃ</div></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function print_archived_news(){
    echo "<table class='generic-table dimmed-center-table'><tr><th>Kiedy</th><th>Tytuł</th><th>Autor</th><th>Akcje</th></tr>";
    $sql = "SELECT * FROM news WHERE stat = 2 ORDER BY date desc";
    $result = db_statement($sql);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        echo "<tr>";
        echo "<td>".$row['date']."</td>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['author']."</td>";
        echo "<td><a href='panel_manage_news.php?akcja=unarchive&id=$id'><div class='button-fitted'>PRZYWRÓĆ</div></a> <a href='edytuj_news.php?id=$id'><div class='button-fitted'>EDYTUJ</div></a> <a href='panel_manage_news.php?akcja=delete&id=$id'><div class='button-fitted'>USUŃ</div></a></td>";

        echo "</tr>";
    }
    echo "</table>";
}

function print_my_news($user){

    $sql = "SELECT * FROM news WHERE author = '$user' ORDER BY date desc";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)<1) echo "<h3>Brak newsów</h3>";
    else {
        echo "<table class='generic-table dimmed-center-table'><tr><th>Kiedy</th><th>Tytuł</th><th>Autor</th><th>Akcje</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td class='no-wrap-fit'><a class='subtle' href='edytuj_news.php?id=$id'><div class='button-fitted'>EDYTUJ</div></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

?>