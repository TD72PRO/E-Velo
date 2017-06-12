<!-- Cette page permet à l'utilisateur de démarrer ou arrêter l'enregistrement de positions GPS. Elle permet aussi de supprimer l'historiquede positions GPS. -->

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

        <div class="w3-panel w3-green">
            <h3 class="w3-center">GPS</h3>
        </div>

        <form method="GET" action="gps-query.php">
            <table class="w3-table w3-center">
                <tr>
                    <td>
                        <?php

                        $link = mysqli_connect('localhost','user','1234','VELO');
                        if(mysqli_connect_errno())
                        {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }
                        mysqli_select_db($link,"VELO") or die(mysqli_error($link));

                        $tableau = mysqli_query($link, "SELECT enregistrement_gps FROM DATA") or die(mysqli_error($link));
                        $row = mysqli_fetch_array($tableau);
                        if (mysqli_num_rows($tableau) > 0)
                        {
                            $enregistrement_gps = $row['enregistrement_gps'];
                        }

                        if($enregistrement_gps == 1)
                        {
                            echo "
                            <input type=\"submit\" name=\"stop\" style=\"width:100%;\" value=\"Arrêter l'enregistrement\" class=\"w3-button w3-block w3-green w3-xlarge\">
                            ";
                        }
                        else if($enregistrement_gps == 0)
                        {
                            echo "
                            <input type=\"submit\" name=\"start\" style=\"width:100%;\" value=\"Démarrer l'enregistrement\" class=\"w3-button w3-block w3-green w3-xlarge\">
                            ";
                        }

                        ?>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>En utilisant le logiciel E-VÉLO Compute Software il vous sera possible d'extraire les données GPS de L'E-VÉLO pour les consulter sur une carte interactive à l'ordinateur.</p>
                        <p>Vous pourrez ainsi voir le trajet emprunté et avec le temps, travailler à optimiser votre trajet en essayant différentes routes.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="reset_gps_history" style="width:100%;" value="Supprimer l'historique GPS" class="w3-button w3-block w3-green w3-xlarge">
                    </td>
                </tr>
            </table>
        </form>

    </section>
    <footer>
        <div id="alarme"></div>
        <form method="get" action="../index.php">
            <input type="submit" value="Retour" class="w3-button w3-block w3-green w3-xlarge">
        </form>
    </footer>
</body>
</html>
