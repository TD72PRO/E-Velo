<!-- Cette page permet de gérer les commandes envoyées par l'utilisateur à partir de la page treshold.php. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

if(isset($_GET['choix']) && isset($_GET['valeur']))
{
    $choix = $_GET['choix'];
    $valeur = $_GET['valeur'];
    mysqli_query($link, "UPDATE DATA SET $choix = $valeur") or die(mysqli_error($link));

}

header('Location: treshold.php');

?>
