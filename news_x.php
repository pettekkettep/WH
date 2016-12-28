<?php
require_once("./functions_x.php");
if(!isset($_GET['id'])){
    header("Location: index_x.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $id = trim_input($id);

    $sql = "SELECT id, date, title, text, textcd, comments, icon, author FROM news WHERE id=$id";
    $result = db_statement($sql);
    if($result == false){
        header("Location: index_x.php");
        exit();
    }
    if(sizeof($result) != 1){
        header("Location: index_x.php");
        exit();
    }

    $no_of_comments = how_many_comments($id);
    $row = mysqli_fetch_assoc($result);
}
?>

<? include("before_content.php"); ?>

<div class="col-6 col-m-6">
    <?php
    echo "<div class='row row-news'>";
    if(users_is_root($_SESSION['username'], $_SESSION['password'])){
        echo "<div class='row center-align'>";
        echo "<a href='edytuj_news.php?id=$id'><div class='button-fitted'>E</div></a>";
        echo "<a href='panel_manage_news.php?akcja=delete&id=$id'><div class='button-fitted'>D</div></a>";
        echo "<a href='panel_manage_news.php?akcja=archive&id=$id'><div class='button-fitted'>A</div></a></div>";
    }
    echo "<p class='news-title'>". $row['title'] . "</p>";
    echo "<p class='news-details'>Autor: ". $row['author'] ."</p>";
    echo "<p class='news-details'>Dodano: ". $row['date'] ."</p>";
    echo "<p class='news-details'>Liczba komentarzy: ". $no_of_comments . "</p>";
    if($row['icon'] != "") echo "<img class='news-avatar' src='". $row['icon'] ."'><br><br>";
    echo $row['text'];
    echo "</div>";
    echo "<div class='row row-news'>";
    echo $row['textcd'];
    echo "</div>";
    $sql = "SELECT id, date, name, text FROM comments WHERE wid = $id";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)>0) echo "<h1>Komentarze:</h1>";
    echo "<div class='box-of-comments' style='display: block;'>";
    echo "<table class='generic-table-no-borders'>";
    while($row = mysqli_fetch_assoc($result)){
        $commentid = $row['id'];
        echo "<tr><td class='top left'>".$row['name'];
        if(users_is_root($_SESSION['username'], $_SESSION['password'])){
            echo " <i><span class='emphasize'><a href='/index_x.php?comment_delete_id=$commentid'>(usuń)</a></span></i>";
        }
        echo "</td><td class='top'><i>".$row['text']."</i></td><td class='top right'><small>".time_description($row['date'])."</small></td></tr>";
    }
    echo "</table></div>";
    ?>
</div>

<? include("after_content.php"); ?>
<script src="js/index_x.js"></script>
</body>
</html>