<?php

require_once("./ocenyfunctions_x.php");
session_start();

$sql = "SELECT * FROM infos ORDER BY id";
$result = db_statement($sql);

?>

<html>
<head>
    <title>HEJ</title>
    <meta charset="utf-8">
</head>
<body>
<?php
while($row = mysqli_fetch_assoc($result)){
    $id = $row['id'];
    $title = $row['title'];
    echo "<h3>Numer $id: $title</h3>";
}

$sql = "SELECT * FROM infos ORDER BY id";
$result = db_statement($sql);

while($row = mysqli_fetch_assoc($result)){
    $id = $row['id'];
    $title = $row['title'];
    $text = $row['text'];
    $text = str_replace("<","&lt;",$text);
    $text = str_replace(">","&gt;",$text);
    echo "<h1>Numer $id: $title</h1>";
    echo "<p>$text</p><br><br><hr><br><br>";
}
?>
</body>
</html>
