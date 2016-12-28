<?php
require_once("./fasolkifunctions_x.php");

function print_best_three_beans($id){
    $sql = "SELECT id FROM beans WHERE id IN (SELECT DISTINCT fasolka FROM beans_owners WHERE skrytka = $id) ORDER BY realvalue LIMIT 3";
    $result = db_statement($sql);
    if(mysqli_num_rows($result)==3){
        echo "<div class='row' style='border-top: 2px solid #764134; border-radius: 20px; margin: 10px; padding: 10px;'><h3>Najcenniejsze zdobycze</h3>";
    }
    while($row = mysqli_fetch_assoc($result)){
        echo "<div class='col-4'>";
        print_fasolka_state($id, $row['id']);
        echo "</div>";
    }
    if(mysqli_num_rows($result)==3){
        echo "</div>";
    }
}

function print_order($hmo, $miejsce, $za_co){
    if($miejsce == 0) return $hmo;
    if($hmo == 4){
        echo "</div><div class='row'>";
        $hmo = 0;
    }
    $hmo = $hmo + 1;
    echo "<div class='col-3' style='text-align: center; border-radius: 20px;'>";
    if($miejsce == 1) echo "<span class='medal' style='color: gold'>C</span>";
    elseif($miejsce == 2) echo "<span class='medal' style='color: lightsteelblue'>C</span>";
    elseif($miejsce == 3) echo "<span class='medal' style='color: saddlebrown'>C</span>";
    else echo "<span class='medal' style='color: darkcyan'>C</span>";
    echo "<h2>$miejsce.</h2>";
    echo "<p>$za_co</p>";
    echo "</div>";
    return $hmo;
}

function rank_from_table($id, $colname, $dbname){
    if($dbname == 'hpotter_bank_skrytki') $id_name = 'numer';
    else $id_name = 'id';
    $sql = "SELECT ".$id_name.", ".$colname." FROM ".$dbname." ORDER BY ".$colname." DESC LIMIT 10";
    $result = db_statement($sql);
    $miejsce = 0;
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        $i = $i + 1;
        if($id == $row[$id_name]) $miejsce = $i;
    }
    return $miejsce;
}

function rank_from_table_diff($id, $colname1, $colname2, $dbname){
    if($dbname == 'hpotter_bank_skrytki') $id_name = 'numer';
    else $id_name = 'id';
    $sql = "SELECT ".$id_name.", ".$colname1." FROM ".$dbname." ORDER BY ".$colname2." DESC LIMIT 10";
    $result = db_statement($sql);
    $miejsce = 0;
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        $i = $i + 1;
        if($id == $row[$id_name]) $miejsce = $i;
    }
    return $miejsce;
}