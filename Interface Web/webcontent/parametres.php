<!-- Cette page permet à l'utilisateur de modifier la vitesse des clignotants, l'activation automatique des lumières et donne accès à la page de gestion de niveaux d'alarmes. -->

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

        <div class="w3-panel w3-gray">
            <h3 class="w3-center">Paramètres</h3>
        </div>

        <?php

        $link = mysqli_connect('localhost','user','1234','VELO');
        if(mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($link,"VELO") or die(mysqli_error($link));

        echo "
        <table class=\"w3-table w3-center\">
        <tr>
        <th class=\"w3-center\">Vitesse des clignotants</th>
        </tr>
        <tr>
        <td>
        <form method=\"GET\" action=\"parametres-query.php\">
        <input style=\"width:100%;\" type=\"range\" name=\"slider_clignotants\" min=\"1\" max=\"10\"
        ";

        $tableau = mysqli_query($link, "SELECT vitesse_clignotants FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            echo ' value="';
            echo $row['vitesse_clignotants'];
            echo '" ';
        }

        echo "
        step=\"1\"/>
        </td>
        </tr>
        <tr>
        <th class=\"w3-center\">Activation automatique des phares</th>
        </tr>
        <tr>
        <td class=\"w3-center\">";

        $tableau = mysqli_query($link, "SELECT activation_lumieres_auto FROM DATA") or die(mysqli_error($link));
        $row = mysqli_fetch_array($tableau);
        if (mysqli_num_rows($tableau) > 0)
        {
            $result = $row['activation_lumieres_auto'];
        }

        if($result)
        {
            echo "
            <input class=\"w3-radio\" type=\"radio\" name=\"onOff\" value=\"ON\" checked>
            <label class=\"w3-validate\">ON</label>
            <input class=\"w3-radio\" type=\"radio\" name=\"onOff\" value=\"OFF\">
            <label class=\"w3-validate\">OFF</label>
            ";
        }
        else
        {
            echo "
            <input class=\"w3-radio\" type=\"radio\" name=\"onOff\" value=\"ON\">
            <label class=\"w3-validate\">ON</label>
            <input class=\"w3-radio\" type=\"radio\" name=\"onOff\" value=\"OFF\" checked>
            <label class=\"w3-validate\">OFF</label>
            ";
        }

        echo "
        </td>
        </tr>
        <tr>
        <td>
        <br>
        <input type=\"submit\" value=\"Sauvegarder\" style=\"width:100%;\" class=\"w3-button w3-block w3-gray w3-xlarge\">
        </td>
        </tr>
        </form>
        </table>
        ";

        ?>

        <table class="w3-table w3-center">
            <tr>
                <td>
                    <form method="get" action="treshold.php">
                        <input type="submit" value="Niveaux d'alarmes" style="width:100%;" class="w3-button w3-block w3-gray w3-xlarge">
                    </form>
                </td>
            </tr>
        </table>

    </section>
    <footer>
        <div id="alarme"></div>
        <form method="get" action="../index.php">
            <input type="submit" value="Retour" class="w3-button w3-block w3-gray w3-xlarge">
        </form>
    </footer>
</body>
</html>
