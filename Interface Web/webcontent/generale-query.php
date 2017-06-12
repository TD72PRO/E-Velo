<!-- Page qui gère les commandes envoyées par l'utilisateur à partir de la page generale.php -->

<?php

$link = mysqli_connect('localhost','user','1234','VELO');
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($link,"VELO") or die(mysqli_error($link));

if(isset($_GET['request']))
{
    $request = $_GET['request'];

    if($request == "left")
    {
        mysqli_query($link, "UPDATE DATA SET flasher_gauche = NOT flasher_gauche") or die(mysqli_error($link));
        header('Location: generale.php');
    }
    else if($request == "right")
    {
        mysqli_query($link, "UPDATE DATA SET flasher_droit = NOT flasher_droit") or die(mysqli_error($link));
        header('Location: generale.php');
    }
    else if($request == "cruise-minus")
    {
        $tableau = mysqli_query($link, "SELECT vitesse_cruise FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $vitesse_cruise = $row['vitesse_cruise'];
        }

        if($vitesse_cruise <= 10)
        {
            mysqli_query($link, "UPDATE DATA SET vitesse_cruise = 0") or die(mysqli_error($link));
        }
        else
        {
            mysqli_query($link, "UPDATE DATA SET vitesse_cruise = vitesse_cruise - 2") or die(mysqli_error($link));
        }

        header('Location: generale.php');
    }
    else if($request == "cruise-plus")
    {
        $tableau = mysqli_query($link, "SELECT vitesse_cruise FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $vitesse_cruise = $row['vitesse_cruise'];
        }

        if($vitesse_cruise < 10)
        {
            mysqli_query($link, "UPDATE DATA SET vitesse_cruise = 10") or die(mysqli_error($link));
        }
        else
        {
            mysqli_query($link, "UPDATE DATA SET vitesse_cruise = vitesse_cruise + 2") or die(mysqli_error($link));
        }

        header('Location: generale.php');
    }
    else if($request == "headlights")
    {
        mysqli_query($link, "UPDATE DATA SET phares = NOT phares") or die(mysqli_error($link));
        header('Location: generale.php');
    }
    else if($request == "led-matrix")
    {
        mysqli_query($link, "UPDATE DATA SET front_display = NOT front_display") or die(mysqli_error($link));
        header('Location: generale.php');
    }
    else if($request == "cruise-toggle")
    {
        mysqli_query($link, "UPDATE DATA SET vitesse_cruise = 0") or die(mysqli_error($link));
        header('Location: generale.php');
    }
    else if($request == "antidemarreur")
    {
            mysqli_query($link, "UPDATE DATA SET antidemarreur = 1") or die(mysqli_error($link));
            header('Location: generale.php');
    }
}

?>
