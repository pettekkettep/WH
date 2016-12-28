<html>
<head>
    <meta charset="UTF-8">
</head>
</html>
<body style="background: #f66">
<?php

require_once('functions_x.php');

//$sql = "SELECT smak, obrazek FROM beans";
//$result = db_statement($sql);
//echo "<ul>";
//while($row = mysqli_fetch_assoc($result)){
//    $smak = $row['smak'];
//    echo "<h4>$smak</h4>";
//    $obrazek = $row['obrazek'];
//    echo "<img src='$obrazek'>";
//}
//echo "</ul>";

//for($i=1;$i<=30;$i++){
//    echo "INSERT INTO beans(smak, wartosc, obrazek) VALUES('nieznanym',5,'$i.png');";
//}

//$sql = "SELECT why FROM zapisy_u";
//$result = db_statement($sql);
//while($row = mysqli_fetch_assoc($result)){
//    echo "<p>".$row['why']."</p>";
//}
//for($i = 5132; $i <= 5205; $i++){
//    $sql = "INSERT INTO hpotter_bank_skrytki_q(id) VALUES($i)";
//    db_statement($sql);
//    echo $i;
//}
for ($i = 1; $i <= 154; $i++){
    $sql = "SELECT id FROM beans_owners WHERE fasolka = $i GROUP BY skrytka";
    $result = db_statement($sql);
    $ilu = mysqli_num_rows($result);

    $sql = "UPDATE beans SET realvalue = $ilu WHERE id = $i";
    db_statement($sql);
    echo "<p>$i</p>";
}
?>
</body>
</html>