<!-- Page qui permet à l'utilisateur d'interagir avec les clignotants, phares, matrice LED, anti-démarreur et vitesse de croisière du vélo. -->
<!-- Cette page appèle à répétition la page generale-update.php pour rafraîchir l'affichage de la vitesse de croisière et la vitesse actuelle à chaque seconde. -->

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

    <script>
    $(document).ready(function()
    {
        $("#vitesseContainer").load('generale-update.php?parameter=vitesse');
        setInterval(function()
        {
            $("#vitesseContainer").load('generale-update.php?parameter=vitesse');
        }, 1000);
    });
    </script>

    <script>
    $(document).ready(function()
    {
        $("#cruiseContainer").load('generale-update.php?parameter=cruise');
        setInterval(function()
        {
            $("#cruiseContainer").load('generale-update.php?parameter=cruise');
        }, 1000);
    });
    </script>

    <script>
    $(document).ready(function()
    {
        $("#alarme").load('watchdog.php');
        setInterval(function()
        {
            $("#alarme").load('watchdog.php');
        }, 1000);
    });
    </script>
</head>
<body>
    <section class="w3-container">

        <div id="entete" class="w3-panel w3-red">
            <h3 class="w3-center">Tableau de bord</h3>
        </div>

        <?php

        $link = mysqli_connect('localhost','user','1234','VELO');
        if(mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($link,"VELO") or die(mysqli_error($link));

        //FLASHER GAUCHE
        $tableau = mysqli_query($link, "SELECT flasher_gauche FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $flasher_gauche = $row['flasher_gauche'];
        }

        //FLASHER DROIT
        $tableau = mysqli_query($link, "SELECT flasher_droit FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $flasher_droit = $row['flasher_droit'];
        }

        //PHARES
        $tableau = mysqli_query($link, "SELECT phares FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $phares = $row['phares'];
        }

        //MATRICE LED
        $tableau = mysqli_query($link, "SELECT front_display FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $front_display = $row['front_display'];
        }

        echo "
        <table class=\"w3-table w3-border w3-center\">
        <tr>
        <th style=\"width:25%;\"></th>
        <th style=\"width:50%;\" class=\"w3-center\">Vitesse actuelle</th>
        <th style=\"width:25%;\"></th>
        </tr>
        <tr>
        ";

        if($flasher_gauche == 1)
        {
            echo "<td style=\"width:25%;\"><div class=\"w3-center\"><a href=\"generale-query.php?request=left\" target=\"_self\"><img style=\"width:100%;\" src=\"../images/arrow-left.png\"></a></div></td>";
        }
        else if($flasher_gauche == 0)
        {
            echo "<td style=\"width:25%;\"><div class=\"w3-center\"><a href=\"generale-query.php?request=left\" target=\"_self\"><img style=\"width:100%;\" src=\"../images/arrow-left-gray.png\"></a></div></td>";
        }

        echo "<td style=\"width:50%;\"><div class=\"w3-center\"><h2><div id=\"vitesseContainer\"></div></h2></div></td>";

        if($flasher_droit == 1)
        {
            echo "<td style=\"width:25%;\"><div class=\"w3-center\"><a href=\"generale-query.php?request=right\" target=\"_self\"><img style=\"width:90%;\" src=\"../images/arrow-right.png\"></a></div></td>";
        }
        else if($flasher_droit == 0)
        {
            echo "<td style=\"width:25%;\"><div class=\"w3-center\"><a href=\"generale-query.php?request=right\" target=\"_self\"><img style=\"width:90%;\" src=\"../images/arrow-right-gray.png\"></a></div></td>";
        }

        echo "
        </tr>
        </table>

        <br>

        <table class=\"w3-table w3-border w3-center\">
        <tr>
        <th style=\"width:25%;\"></th>
        <th style=\"width:50%;\" class=\"w3-center\">Vitesse de croisière</th>
        <th style=\"width:25%;\"></th>
        </tr>
        <tr>
        <td style=\"width:25%;\"><div class=\"w3-center\"><a href=\"generale-query.php?request=cruise-minus\" target=\"_self\"><img style=\"width:50%; padding-top:15px;\" src=\"../images/minus-sign.png\"></a></div></td>
        <td style=\"width:50%;\"><div class=\"w3-center\"><h2><div id=\"cruiseContainer\"></div></h2></div></td>
        <td style=\"width:25%;\"><div class=\"w3-center\"><a href=\"generale-query.php?request=cruise-plus\" target=\"_self\"><img style=\"width:50%; padding-top:15px;\" src=\"../images/plus-sign.png\"></a></div></td>
        </tr>
        <tr>
        <th style=\"width:25%;\"></th>
        <th style=\"width:50%;\" class=\"w3-center\">
        <form action=\"generale-query.php?request=cruise-toggle\" method=\"POST\">
        <input type=\"submit\" value=\"Désactiver\" class=\"w3-button w3-orange w3-block\">
        </form>
        </th>
        <th style=\"width:25%;\"></th>
        </tr>
        </table>

        <br>

        <table class=\"w3-table w3-border w3-center\">
        <tr>
        ";

        if($phares == 1)
        {
            echo "<td style=\"width:33%;\"><a href=\"generale-query.php?request=headlights\" target=\"_self\"><div class=\"w3-center\"><img style=\"width:50%;\" src=\"../images/headlights.png\"></a></div></td>";
        }
        else if($phares == 0)
        {
            echo "<td style=\"width:33%;\"><a href=\"generale-query.php?request=headlights\" target=\"_self\"><div class=\"w3-center\"><img style=\"width:50%;\" src=\"../images/headlights-gray.png\"></a></div></td>";
        }

        if($front_display == 1)
        {
            echo "<td style=\"width:33%;\"><a href=\"generale-query.php?request=led-matrix\" target=\"_self\"><div class=\"w3-center\"><img style=\"width:50%;\" src=\"../images/led-matrix.png\"></a></div></td>";
        }
        else if($front_display == 0)
        {
            echo "<td style=\"width:33%;\"><a href=\"generale-query.php?request=led-matrix\" target=\"_self\"><div class=\"w3-center\"><img style=\"width:50%;\" src=\"../images/led-matrix-gray.png\"></a></div></td>";
        }

        echo "<td style=\"width:33%;\"><a href=\"generale-query.php?request=antidemarreur\" target=\"_self\"><div class=\"w3-center\"><img style=\"width:50%;\" src=\"../images/antidemarreur-gray.png\" onmouseover=\"this.src='../images/antidemarreur.png';\" onmouseout=\"this.src='../images/antidemarreur-gray.png';\"/></a></div></td>";

        echo "
        </tr>
        </table>";

        ?>

    </section>
    <footer>
        <div id="alarme"></div>
        <form action="../index.php" method="POST">
            <input type="submit" value="Retour" class="w3-button w3-block w3-red w3-xlarge">
        </form>
    </footer>
</body>
</html>
