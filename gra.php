<?php
    session_start();
    if (!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - gra</title>
</head>

<body>

    <?php

    echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się</a> ]</p>';
    echo "<p><b>Drewno</b>: ".$_SESSION['drewno'];
    echo " | <b>Kamień</b>: ".$_SESSION['kamien'];
    echo " | <b>Zboże</b>: ".$_SESSION['zboze']."</p>";

    echo "<p><b>E-mail</b>: ".$_SESSION['email'];
    echo "<br/><b>Data wygaśnięcia premium</b>: ".$_SESSION['dnipremium']."</p>";

    $dataczas = new DateTime('2150-05-01 09:33:59');

    echo "Data i czas serwera: ".$dataczas->format('Y-m-d H:i:s')."<br>";
    
    $konice = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);

    $roznica = $dataczas->diff($konice);

    if ($dataczas < $konice)
        echo "Pozostało premium: ".$roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s sek');
    else
    echo "Premium nie aktywane od: ".$roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s sek');
    ?>

</body>

</html>