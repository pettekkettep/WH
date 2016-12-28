<!doctype HTML>
<html>
<head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Wirtualny Hogwart im. Syriusza Croucha to szkoła z ogromnymi tradycjami i doświadczeniem w nauczaniu młodych adeptów magii! Zapraszamy na XXXII rok szkolny!">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Headland+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/infopage.css">
    <link rel="stylesheet" type="text/css" href="css/index-new.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <?= $header_extras ?>

</head>
<body
    <? if($display_dementor): ?>
        onload = "startTimer()"
    <? endif; ?>
>

<? foreach($blocks as $block): ?>
    <?= $block ?>
<? endforeach; ?>

<? foreach($evalblocks as $evalblock): ?>
    <? eval($evalblock); ?>
<? endforeach; ?>


<!--    <div class="col-6 col-m-6">-->
<!--        <div class="row" id="row-center">-->
<!--            <h1>Tablica ogłoszeń</h1>-->
<!--            --><?// print_feed($_GET['p']); ?>
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    --><?// include ("after_content.php"); ?>

    <!--<div class="dementor hide" id="demi">-->
    <!--    <img src="dem1.png" alt="Dementi" id="demi-img">-->
    <!--    <div class="zapisy-tekst">-->
    <!--        <p class="on-img-1"><a class="wocolor" href="zapisy_u.php" id="on-img-1">ZAPISY SĄ</a></p>-->
    <!--        <p class="on-img-2"><a class="wocolor" href="zapisy_u.php" id="on-img-2">OTWARTE!</a></p>-->
    <!--    </div>-->
    <!--</div>-->
    <script src="js/index_x.js"></script>
</body>
</html>