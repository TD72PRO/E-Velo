<!-- Cette page permet d'éteindre les ordinateurs de bord du vélo de façon sécuritaire. -->

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

        <div class="w3-panel w3-light-gray">
            <h3 class="w3-center">Alimentation</h3>
        </div>

        <table class="w3-table w3-center">
            <tr>
                <th class="w3-center">Éteindre L'E-VÉLO ?</th>
            </tr>
            <tr>
                <td class="w3-center"><a href="shutdown-query.php" target="_self"><img style="width:100%;" src="../images/shutdown-confirm.png"></a></td>
            </tr>
        </table>

    </section>
    <footer>
        <div id="alarme"></div>
        <form method="get" action="../index.php">
            <input type="submit" value="Retour" class="w3-button w3-block w3-light-gray w3-xlarge">
        </form>
    </footer>
</body>
</html>
