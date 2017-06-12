<!-- Cette page permet à l'utilisateur de personnaliser la tonalité du klaxon, ainsi que l'image affichée sur la matrice LED. -->

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

        <div class="w3-panel w3-pink">
            <h3 class="w3-center">Personnalisation</h3>
        </div>

        <form method="GET" action="personnalisation-query.php">
            <table class="w3-table w3-center">
                <tr>
                    <th class="w3-center">Personnaliser la matrice LED</th>
                </tr>
                <tr>
                    <td>
                        <?php

                        $link = mysqli_connect('localhost','user','1234','VELO');
                        if(mysqli_connect_errno())
                        {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }
                        mysqli_select_db($link,"VELO") or die(mysqli_error($link));

                        $tableau = mysqli_query($link, "SELECT image_front_display FROM DATA") or die(mysqli_error($link));
                        $row = mysqli_fetch_array($tableau);
                        if (mysqli_num_rows($tableau) > 0)
                        {
                            $currentPath = $row['image_front_display'];
                        }

                        echo "<select class=\"w3-select w3-pink\" name=\"selectFrontDisplay\">";

                        $tableau = mysqli_query($link, "SELECT * FROM images") or die(mysqli_error($link));

                        while($row = mysqli_fetch_assoc($tableau))
                        {
                            if($currentPath == $row['Chemin'])
                            {
                                echo "<option value=\"";
                                echo $row['Chemin'];
                                echo "\" selected>";
                                echo $row['Nom'];
                                echo "</option>";
                            }
                            else
                            {
                                echo "<option value=\"";
                                echo $row['Chemin'];
                                echo "\">";
                                echo $row['Nom'];
                                echo "</option>";
                            }

                        }

                        echo "</select>";

                        ?>

                    </td>
                </tr>
            </table>


            <table class="w3-table w3-center">
                <tr>
                    <th class="w3-center">Personnaliser le klaxon</th>
                </tr>
                <tr>
                    <td>
                        <?php

                        $tableau = mysqli_query($link, "SELECT tonalite_klaxon FROM DATA") or die(mysqli_error($link));
                        $row = mysqli_fetch_array($tableau);
                        if (mysqli_num_rows($tableau) > 0)
                        {
                            $klaxon = $row['tonalite_klaxon'];
                        }

                        if($klaxon == "car_horn.mp3")
                        {
                            echo "
                            <select class=\"w3-select w3-pink\" name=\"selectKlaxon\">
                            <option value=\"car_horn.mp3\" selected>Car Horn</option>
                            <option value=\"boat_horn.mp3\">Boat Horn</option>
                            <option value=\"duke.mp3\">Duke</option>
                            <option value=\"air_raid.mp3\">Air Raid</option>
                            <option value=\"simon.mp3\">Simon</option>
                            </select>
                            ";
                        }
                        else if($klaxon == "boat_horn.mp3")
                        {
                            echo "
                            <select class=\"w3-select w3-pink\" name=\"selectKlaxon\">
                            <option value=\"car_horn.mp3\" selected>Car Horn</option>
                            <option value=\"boat_horn.mp3\" selected>Boat Horn</option>
                            <option value=\"duke.mp3\">Duke</option>
                            <option value=\"air_raid.mp3\">Air Raid</option>
                            <option value=\"simon.mp3\">Simon</option>
                            </select>
                            ";
                        }
                        else if($klaxon == "duke.mp3")
                        {
                            echo "
                            <select class=\"w3-select w3-pink\" name=\"selectKlaxon\">
                            <option value=\"car_horn.mp3\">Car Horn</option>
                            <option value=\"boat_horn.mp3\">Boat Horn</option>
                            <option value=\"duke.mp3\" selected>Duke</option>
                            <option value=\"air_raid.mp3\">Air Raid</option>
                            <option value=\"simon.mp3\">Simon</option>
                            </select>
                            ";
                        }
                        else if($klaxon == "air_raid.mp3")
                        {
                            echo "
                            <select class=\"w3-select w3-pink\" name=\"selectKlaxon\">
                            <option value=\"car_horn.mp3\">Car Horn</option>
                            <option value=\"boat_horn.mp3\">Boat Horn</option>
                            <option value=\"duke.mp3\">Duke</option>
                            <option value=\"air_raid.mp3\" selected>Air Raid</option>
                            <option value=\"simon.mp3\">Simon</option>
                            </select>
                            ";
                        }
                        else if($klaxon == "simon.mp3")
                        {
                            echo "
                            <select class=\"w3-select w3-pink\" name=\"selectKlaxon\">
                            <option value=\"car_horn.mp3\">Car Horn</option>
                            <option value=\"boat_horn.mp3\">Boat Horn</option>
                            <option value=\"duke.mp3\">Duke</option>
                            <option value=\"air_raid.mp3\">Air Raid</option>
                            <option value=\"simon.mp3\" selected>Simon</option>
                            </select>
                            ";
                        }
                        else
                        {
                            echo "
                            <select class=\"w3-select w3-pink\" name=\"selectKlaxon\">
                            <option value=\"car_horn.mp3\" selected>Car Horn</option>
                            <option value=\"boat_horn.mp3\">Boat Horn</option>
                            <option value=\"duke.mp3\">Duke</option>
                            <option value=\"air_raid.mp3\">Air Raid</option>
                            <option value=\"simon.mp3\">Simon</option>
                            </select>
                            ";
                        }

                        ?>

                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <input type="submit" name="Refresh" value="Rafraîchir" style="width:100%;" class="w3-button w3-block w3-pink w3-xlarge">
                        <br>
                        <input type="submit" name="Sauvegarder" value="Sauvegarder" style="width:100%;" class="w3-button w3-block w3-pink w3-xlarge">
                    </td>
                </tr>
            </table>
        </form>

    </section>

    <footer>
        <div id="alarme"></div>
        <form method="get" action="../index.php">
            <input type="submit" value="Retour" class="w3-button w3-block w3-pink w3-xlarge">
        </form>
    </footer>
</body>
</html>
