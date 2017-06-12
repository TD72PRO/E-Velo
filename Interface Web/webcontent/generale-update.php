<!-- Page qui affiche les valeurs de vitesse actuelle et de vitesse de croisière. -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

if(isset($_GET['parameter']))
{
    if($_GET['parameter'] == "vitesse")
    {
        $tableau = mysqli_query($link, "SELECT vitesse_actuelle FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            echo $row['vitesse_actuelle'];
            echo " Km/h";
        }
    }
    else if($_GET['parameter'] == "cruise")
    {
        $tableau = mysqli_query($link, "SELECT vitesse_cruise FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            echo $row['vitesse_cruise'];
            echo " Km/h";
        }
    }
}

?>
