#Ce script utilise gpspipe pour récupérer les données GPS et les envoyer dans un fichier.
#Les données de la nouvelle position GPS inscrites dans le fichier sont ensuite ajoutées à l'historique des positions GPS.
gpspipe -r -n 11 | grep '$G' | tee newposition.nmea
cat newposition.nmea >> position.nmea
