#include "T_SQL.h"


//Classe qui connecte le programme a la base de données.
using namespace std;
MYSQL *connection, mysql;
MYSQL_RES *result;
MYSQL_ROW row;
int query_state;
int start;
string query;
char bufStr[50];

#define HOST "localhost"
#define USER "root"
#define PASSWD "1234"
#define DB "VELO"
T_SQL *sql = NULL;


//Initialisation de la connexion SQL.
T_SQL::T_SQL() {
    mysql_init(&mysql);
    connection = mysql_real_connect(&mysql, HOST, USER, PASSWD, DB, 0, 0, 0);
    if (connection == NULL) {
        cout << mysql_error(&mysql) << endl;
    }
    if (connection) {
        query = "UPDATE `VELO`.`DATA` SET `klaxon` = 0";
        query_state = mysql_query(connection, query.c_str());
    }
    query_state = mysql_query(connection, "select * from DATA");
    result = mysql_store_result(connection);
    while ((row = mysql_fetch_row(result)) != NULL) {

    }
}

T_SQL::~T_SQL() {

}
//Cette tâche met a jour la classe partage continuellement et se charge également de changer les
//données de la base en fonction de ce qu'elle reçoit.
void T_SQL::task(void) {
    while (1) {
        delay(200);
        sprintf(bufStr, "%.1f", partage->getVitesse());
        query = "UPDATE `VELO`.`DATA` SET `vitesse_actuelle` = ";
        query += bufStr;
        query_state = mysql_query(connection, query.c_str());

        sprintf(bufStr, "%.1f", partage->getTempExt());
        query = "UPDATE `VELO`.`DATA` SET `temperature_exterieure` = ";
        query += bufStr;
        query_state = mysql_query(connection, query.c_str());

        sprintf(bufStr, "%.1f", partage->getTempDr());
        query = "UPDATE `VELO`.`DATA` SET `temperature_drive` = ";
        query += bufStr;
        query_state = mysql_query(connection, query.c_str());

        sprintf(bufStr, "%.1f", partage->getTempBt());
        query = "UPDATE `VELO`.`DATA` SET `temperature_boite` = ";
        query += bufStr;
        query_state = mysql_query(connection, query.c_str());

        sprintf(bufStr, "%d", partage->getLum());
        query = "UPDATE `VELO`.`DATA` SET `luminosite` = ";
        query += bufStr;
        query_state = mysql_query(connection, query.c_str());
        if (partage->getRC() == 1) {
            query = "UPDATE `VELO`.`DATA` SET `vitesse_cruise` = 0";
            query_state = mysql_query(connection, query.c_str());
            partage->setRC(0);
        }
        query_state = mysql_query(connection, "select * from DATA");
        result = mysql_store_result(connection);
        if (partage->getRsKlax()) {
            query = "UPDATE `VELO`.`DATA` SET `klaxon` = 0";
            query_state = mysql_query(connection, query.c_str());
            partage->setRsKlax(0);
        }
        if (partage->getRGps() == 2) {
            query = "UPDATE `VELO`.`DATA` SET `reset_gps_history` = 0";
            query_state = mysql_query(connection, query.c_str());
            partage->setRGps(0);
        }


        while ((row = mysql_fetch_row(result)) != NULL) {

            partage->setCruise(atoi(row[1]));
            partage->setFlGau(atoi(row[2]));
            partage->setFlDr(atoi(row[3]));
            partage->setPhare(atoi(row[4]));
            partage->setKlax(atoi(row[5]));
            partage->setGps(atoi(row[10]));
            partage->setVitClign(atoi(row[15]));
            partage->setLumAuto(atoi(row[16]));
            partage->setShutDown(atoi(row[20]));
            partage->setTonKlax(row[13]);
            partage->setRGps(atoi(row[21]));
            if(atoi(row[23]))
                start=1;
        }
        if (start==1) {
            partage->setHazard(1);
            query = "UPDATE `VELO`.`DATA` SET `antidemarreur` = 0";
            query_state = mysql_query(connection, query.c_str());
            start=0;
        }
    }

    delay(10);
}
//Fonction de remise a zéro de la base de données.
void T_SQL::remiseZero() {
    query = "UPDATE `VELO`.`DATA` SET `shutdown` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `vitesse_actuelle` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `temperature_exterieure` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `temperature_drive` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `temperature_boite` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `vitesse_cruise` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `flasher_gauche` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `flasher_droit` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `phares` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `klaxon` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `enregistrement_gps` = 0";
    query_state = mysql_query(connection, query.c_str());

    query = "UPDATE `VELO`.`DATA` SET `front_display` = 0";
    query_state = mysql_query(connection, query.c_str());

}
