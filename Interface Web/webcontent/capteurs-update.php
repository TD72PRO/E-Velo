<!-- Page qui récupère et affiche les valeurs des capteurs de luminosité et de température. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

//TEMPÉRATURE EXTÉRIEURE
$tableau = mysqli_query($link, "SELECT temperature_exterieure FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $temperature_exterieure = $row['temperature_exterieure'];
}

//TEMPÉRATURE BOÎTE
$tableau = mysqli_query($link, "SELECT temperature_boite FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $temperature_boite = $row['temperature_boite'];
}

//TEMPÉRATURE DRIVE
$tableau = mysqli_query($link, "SELECT temperature_drive FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $temperature_drive = $row['temperature_drive'];
}

//Luminosité
$tableau = mysqli_query($link, "SELECT luminosite FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $luminosite = $row['luminosite'];
}

//TENSION BATTERIE
$tableau = mysqli_query($link, "SELECT tension_batterie FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $tension_batterie = $row['tension_batterie'];
}

//COURANT BATTERIE
$tableau = mysqli_query($link, "SELECT courant_batterie FROM DATA") or die(mysqli_error($link));
$row = mysqli_fetch_array($tableau);
if (mysqli_num_rows($tableau) > 0)
{
    $courant_batterie = $row['courant_batterie'];
}

echo "
<div class=\"w3-panel w3-indigo\">
<h3 class=\"w3-center\">Capteurs</h3>
</div>

<table class=\"w3-table w3-bordered w3-border w3-center\">
<tr>
<td style=\"width:80%;\"><strong>Température extérieure:</strong></td>
<td style=\"width: 20%;\">"; echo $temperature_exterieure; echo " °C</td>
</tr>
</table>

<br>

<table class=\"w3-table w3-bordered w3-border w3-center\">
<tr>
<td style=\"width:80%;\"><strong>Température boîte électrique:</strong></td>
<td style=\"width: 20%;\">"; echo $temperature_boite; echo " °C</td>
</tr>
</table>

<br>

<table class=\"w3-table w3-bordered w3-border w3-center\">
<tr>
<td style=\"width:80%;\"><strong>Température drive moteur:</strong></td>
<td style=\"width: 20%;\">"; echo $temperature_drive; echo " °C</td>
</tr>
</table>

<br>

<table class=\"w3-table w3-bordered w3-border w3-center\">
<tr>
<td style=\"width:80%;\"><strong>Niveau de luminosité détecté:</strong></td>
<td style=\"width: 20%;\">"; echo $luminosite; echo " </td>
</tr>
</table>
";

?>
