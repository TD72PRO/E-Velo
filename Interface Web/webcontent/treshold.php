<!-- Cette page permet à l'utilisateur de gérer les niveaux d'alarmes de température et de vitesse. -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>L'E-VÉLO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/w3-style.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
    <section class="w3-container">

        <div class="w3-panel w3-gray">
            <h3 class="w3-center">Niveaux d'alarmes</h3>
        </div>

        <form method="GET" action="treshold-query.php">
            <table class="w3-table w3-center">
                <tr>
                    <td>
                        <select class="w3-select w3-gray" name="choix">
                            <option value="" disabled selected>Choississez la limite à modifier</option>
                            <option value="treshold_temperature_exterieure">Température extérieure</option>
                            <option value="treshold_temperature_boite">Température boîte</option>
                            <option value="treshold_temperature_drive">Température contrôleur de moteur</option>
                            <option value="treshold_vitesse">Vitesse</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="w3-input" name="valeur">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" style="width:100%;" value="Sauvegarder" class="w3-button w3-block w3-gray w3-xlarge">
                    </td>
                </tr>
            </table>
        </form>

    </section>
    <footer>
        <form method="get" action="parametres.php">
            <input type="submit" value="Retour" class="w3-button w3-block w3-gray w3-xlarge">
        </form>
    </footer>
</body>
</html>
