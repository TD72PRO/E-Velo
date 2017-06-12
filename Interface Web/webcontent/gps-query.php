<!-- Cette page gère les commandes envoyées par l'utilisateur à partir de la page gps.php. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

if(isset($_GET['start']))
{
    mysqli_query($link, "UPDATE DATA SET enregistrement_gps = 1") or die(mysqli_error($link));

}
else if(isset($_GET['stop']))
{
    mysqli_query($link, "UPDATE DATA SET enregistrement_gps = 0") or die(mysqli_error($link));
}
else if(isset($_GET['reset_gps_history']))
{
    mysqli_query($link, "UPDATE DATA SET reset_gps_history = 1") or die(mysqli_error($link));
}

header('Location: gps.php');

?>
