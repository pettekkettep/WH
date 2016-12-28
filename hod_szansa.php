<?php

require_once "pokatnafunctions_x.php";

$tekst = calc_harvest_prob(trim_input($_GET['potential']));
echo "<h2>$tekst</h2>";

