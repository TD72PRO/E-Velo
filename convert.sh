#Ce script utilise gpsbabel pour transformer les données GPS "NMEA" en données GPS "KML".
gpsbabel -i nmea -f position.nmea -o kml -F position.kml
