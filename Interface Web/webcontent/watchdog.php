<!-- Cette page compare les niveaux d'alarmes déterminés par l'utilisateur avec les valeurs lues par les capteurs de température et de vitesse. -->
<!-- Une alarme sera déclenchée et invitera l'utilisateur à se rendre sur la page alarmes.php pour constater le problème. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

$tableau = mysqli_query($link, "SELECT temperature_exterieure FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $temperature_exterieure = $row['temperature_exterieure'];
}

$tableau = mysqli_query($link, "SELECT temperature_drive FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $temperature_drive = $row['temperature_drive'];
}

$tableau = mysqli_query($link, "SELECT temperature_boite FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $temperature_boite = $row['temperature_boite'];
}

$tableau = mysqli_query($link, "SELECT vitesse_actuelle FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $vitesse_actuelle = $row['vitesse_actuelle'];
}

$tableau = mysqli_query($link, "SELECT treshold_temperature_exterieure FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $treshold_temperature_exterieure = $row['treshold_temperature_exterieure'];
}

$tableau = mysqli_query($link, "SELECT treshold_temperature_boite FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $treshold_temperature_boite = $row['treshold_temperature_boite'];
}

$tableau = mysqli_query($link, "SELECT treshold_temperature_drive FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $treshold_temperature_drive = $row['treshold_temperature_drive'];
}

$tableau = mysqli_query($link, "SELECT treshold_vitesse FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $treshold_vitesse = $row['treshold_vitesse'];
}

if(($temperature_exterieure > $treshold_temperature_exterieure) || ($temperature_drive > $treshold_temperature_drive) || ($temperature_boite > $treshold_temperature_boite) || ($vitesse_actuelle > $treshold_vitesse))
{
    echo "<form method=\"post\" action=\"alarmes.php?tempExt=";
    echo $temperature_exterieure;
    echo "&tempDrive=";
    echo $temperature_drive;
    echo "&tempBoite=";
    echo $temperature_boite;
    echo "&vitesse=";
    echo $vitesse_actuelle;
    echo "&treshDrive=";
    echo $treshold_temperature_drive;
    echo "&treshBoite=";
    echo $treshold_temperature_boite;
    echo "&treshExt=";
    echo $treshold_temperature_exterieure;
    echo "&treshVitesse=";
    echo $treshold_vitesse;
    echo "\">";
    echo "<input type=\"submit\" value=\"ALERTE\" class=\"w3-button w3-block w3-yellow w3-xlarge\">";
    echo "</form>";
    echo "<br><br><br>";
}

?>
