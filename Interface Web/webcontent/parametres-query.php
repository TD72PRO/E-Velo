<!-- Cette page gère les commandes envoyées par l'utilisateur à partir de la page parametres.php. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

if(isset($_GET['slider_clignotants']))
{
    $val = $_GET['slider_clignotants'];
    mysqli_query($link, "UPDATE DATA SET vitesse_clignotants = $val") or die(mysqli_error($link));
}

if(isset($_GET['onOff']))
{
    $val = $_GET['onOff'];

    if($val == "ON")
    {
        mysqli_query($link, "UPDATE DATA SET activation_lumieres_auto = 1") or die(mysqli_error($link));
    }
    else if($val == "OFF")
    {
        mysqli_query($link, "UPDATE DATA SET activation_lumieres_auto = 0") or die(mysqli_error($link));
    }
}

header('Location: parametres.php');

?>
