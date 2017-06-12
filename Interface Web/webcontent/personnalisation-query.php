<!-- Cette page gère les commandes envoyées par l'utilisateur à partir de la page personnalisation.php. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

if(isset($_GET['Refresh']))
{
    mysqli_query($link, "UPDATE DATA SET refresh_images_list = 1") or die(mysqli_error($link));
}
else
{
    if(isset($_GET['selectFrontDisplay']))
    {
        $val = $_GET['selectFrontDisplay'];
        mysqli_query($link, "UPDATE DATA SET image_front_display = '$val'") or die(mysqli_error($link));
    }

    if(isset($_GET['selectKlaxon']))
    {
        $val = $_GET['selectKlaxon'];
        mysqli_query($link, "UPDATE DATA SET tonalite_klaxon = '$val'") or die(mysqli_error($link));
    }
}

header('Location: personnalisation.php');

?>
