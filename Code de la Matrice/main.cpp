//Fichier principal du programme de contrôle de la matrice LED.
#include <dirent.h>
#include <errno.h>
#include <vector>
#include <mysql/mysql.h>
#include <cstdlib>
#include <stdio.h>
#include <string>
#include <string.h>
#include <iostream>
#include <unistd.h>
#include <sys/types.h>
#include <signal.h>
using namespace std;
using std::string;
MYSQL *connection, mysql;
MYSQL_RES *result;
MYSQL_ROW row;
int query_state;
string query;
string photo;
string tmpPho;
int go;
char comm[80];
int on;
char bufStr[50];
string str = ".ppm";
string filename;
int r;

#define HOST "192.168.3.1" 
#define USER "user" 
#define PASSWD "1234" 
#define DB "VELO"

//Fonction qui retourne les fichiers contenus dans le dossier d'images du pi de la matrice.
int getdir(string dir, vector<string> &files) {
    DIR *dp;
    struct dirent *dirp;
    if ((dp = opendir(dir.c_str())) == NULL) {
        cout << "Error(" << errno << ") opening " << dir << endl;
        return errno;
    }

    while ((dirp = readdir(dp)) != NULL) {
        files.push_back(string(dirp->d_name));
    }
    closedir(dp);
    return 0;
}

//Met a jour la liste d'images dans la base de données.
void refresh(void) {
    query = "UPDATE `VELO`.`DATA` SET `shutdown` = 0";
    query_state = mysql_query(connection, query.c_str());
    query = "DELETE FROM `images`";
    query_state = mysql_query(connection, query.c_str());
    string dir = string("/home/pi/LED");
    vector<string> files = vector<string>();
    getdir(dir, files);
    for (unsigned int i = 0; i < files.size(); i++) {
        if (files[i].find(str) != std::string::npos) {
            filename = files[i].substr(0, files[i].length() - 4);
            //filename[0] = toupper(str[0]);
            query = "INSERT INTO `VELO`.`images` (`ImageID`,`Nom`,`Chemin`) VALUES (NULL,\"" + filename + "\",\"" + files[i] + "\")";
            cout << query << endl;
            query_state = mysql_query(connection, query.c_str());
        }
    }
}


//Fonction principale qui permet la lecture d'images sur la matrice.
int main(int argc, char** argv) {
    on = 0;
    sleep(15);
    cout << "1" << endl;
    strcpy(comm, "cd /home/pi/LED && sudo ./panneau -R 180 --led-rows=16 -D 1 ");
    mysql_init(&mysql);

    connection = mysql_real_connect(&mysql, HOST, USER, PASSWD, DB, 0, 0, 0);
    if (connection == NULL) {
        cout << mysql_error(&mysql) << endl;
    }
    if (connection) {
        cout << "Sql good" << endl;
    }
    refresh();
    while (on == 0) {
        query_state = mysql_query(connection, "select * from DATA");
        result = mysql_store_result(connection);

        while ((row = mysql_fetch_row(result)) != NULL) {
            usleep(500000);
            tmpPho = row[11];
            go = atoi(row[12]);
            on = atoi(row[20]);
            r = atoi(row[22]);
            //Si la photo est différente et qu'on l'active, le programme lance un second process qui roule l'image.
            if (go && tmpPho != photo) {
                system("sudo killall panneau");
                sleep(1);
                photo = row[11];
                strcat(comm, photo.c_str());
                cout << comm << endl;
                pid_t pid = fork();
                if (!pid) {
                    cout << "child" << endl;
                    system(comm);
                    system("sudo killall panneau");
                    exit(127);
                }
                sleep(1);
                cout << "parent" << endl;
                strcpy(comm, "cd /home/pi/LED && sudo ./panneau -R 180 --led-rows=16 -D 1 ");

            } else if (go == 0) {
                photo = " ";
                system("sudo killall panneau");
                sleep(1);
            }
            if (r) {
                refresh();
                query = "UPDATE `VELO`.`DATA` SET `refresh_images_list` = 0";
                query_state = mysql_query(connection, query.c_str());
                r = 0;
            }
        }
    }
    system("sudo killall panneau");
    system("sudo shutdown now");

    return 0;
}

