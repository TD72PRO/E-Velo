<!-- Page qui appelle à répétition la page capteurs-update.php pour rafraîchir les valeurs lues par les capteurs chaque seconde. -->

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
        $("#updateCapteurs").load('capteurs-update.php');
        setInterval(function()
        {
            $("#updateCapteurs").load('capteurs-update.php');
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

        <div id="updateCapteurs"></div>

    </section>
    <footer>
        <div id="alarme"></div>
        <form action="../index.php" method="POST">
            <input type="submit" value="Retour" class="w3-button w3-block w3-indigo w3-xlarge">
        </form>
    </footer>
</body>
</html>
