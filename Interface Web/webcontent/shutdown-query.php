<!-- Cette page gère les commandes envoyées par l'utilisateur à partir de la page shutdown.php. -->

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
        <?php

        $link = mysqli_connect('localhost','user','1234','VELO');
        if(mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($link,"VELO") or die(mysqli_error($link));

        mysqli_query($link, "UPDATE DATA SET shutdown = 1") or die(mysqli_error($link));

        echo "<h3>Merci d'avoir utilisé L'E-VÉLO.</h3>";

        echo "
        <footer>
        <form method=\"get\" action=\"../index.php\">
            <input type=\"submit\" value=\"Retour\" class=\"w3-button w3-block w3-light-gray w3-xlarge\">
        </form>
        </footer>
        ";

        ?>
    </section>
</body>
</html>
