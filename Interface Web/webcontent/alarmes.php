<!-- Page qui affiche les alarmes détectées par le "watchdog". -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>L'E-VÉLO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/w3-style.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <script src="../javascript/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>
<body>
    <section class="w3-container">

        <div class="w3-panel w3-orange">
            <h3 class="w3-center">Alarmes</h3>
        </div>

        <?php

        $temperature_exterieure = $_GET['tempExt'];
        $temperature_drive = $_GET['tempDrive'];
        $temperature_boite = $_GET['tempBoite'];
        $vitesse_actuelle = $_GET['vitesse'];

        $treshold_temperature_exterieure = $_GET['treshExt'];
        $treshold_temperature_boite = $_GET['treshBoite'];
        $treshold_temperature_drive = $_GET['treshDrive'];
        $treshold_vitesse = $_GET['treshVitesse'];

        echo "<h1 class=\"w3-text-red w3-center\">ATTENTION</h1>";

        if($temperature_exterieure > $treshold_temperature_exterieure)
        {
            echo "<p>Le capteur de température extérieure capte une valeur anormalement élevée.</p>";
        }

        if($temperature_drive > $treshold_temperature_drive)
        {
            echo "<p>Le capteur de température du contrôleur de moteur capte une valeur anormalement élevée.</p>";
        }

        if($temperature_boite > $treshold_temperature_boite)
        {
            echo "<p>Le capteur de température de la boîte capte une valeur anormalement élevée.</p>";
        }

        if($vitesse_actuelle > $treshold_vitesse)
        {
            echo "<p>La vitesse actuelle captée est anormalement élevée.</p>";
        }

        ?>

    </section>
    <footer>
        <form method="get" action="../index.php">
            <input type="submit" value="Retour" class="w3-button w3-block w3-orange w3-xlarge">
        </form>
    </footer>
</body>
</html>
