//Fichier principal du programme du vélo.
#include <wiringPi.h>
#include <wiringPiI2C.h>
#include <stdint.h>
#include <stdlib.h>
#include <stdio.h>
#include <mcp3004.h>
#include "mcp4725.h"
#include <string.h>
#include <cstdlib>
#include <unistd.h>
#include <errno.h>
#include <inttypes.h>
#include "T_SQL.h"
#include "T_Partage.h"
using namespace std;

#define BASE 999
#define LOWSPEED 269
#define HIGHSPEED 797
#define SPI_CHAN 3
//Adresses pour le capteur de luminosité.
#define TSL2561_ADDR_LOW                   (0x29)
#define TSL2561_ADDR_FLOAT                 (0x39)
#define TSL2561_ADDR_HIGH                   (0x49)
#define TSL2561_CONTROL_POWERON             (0x03)
#define TSL2561_CONTROL_POWEROFF          (0x00)
#define TSL2561_GAIN_0X                        (0x00)   //No gain
#define TSL2561_GAIN_AUTO                (0x01)
#define TSL2561_GAIN_1X                 (0x02)
#define TSL2561_GAIN_16X                  (0x12) // (0x10)
#define TSL2561_INTEGRATIONTIME_13MS          (0x00)   // 13.7ms
#define TSL2561_INTEGRATIONTIME_101MS          (0x01) // 101ms
#define TSL2561_INTEGRATIONTIME_402MS         (0x02) // 402ms
#define TSL2561_READBIT                   (0x01)
#define TSL2561_COMMAND_BIT                (0x80)   //Must be 1
#define TSL2561_CLEAR_BIT                (0x40)   //Clears any pending interrupt (write 1 to clear)
#define TSL2561_WORD_BIT                   (0x20)   // 1 = read/write word (rather than byte)
#define TSL2561_BLOCK_BIT                  (0x10)   // 1 = using block read/write
#define TSL2561_REGISTER_CONTROL           (0x00)
#define TSL2561_REGISTER_TIMING            (0x81)
#define TSL2561_REGISTER_THRESHHOLDL_LOW      (0x02)
#define TSL2561_REGISTER_THRESHHOLDL_HIGH     (0x03)
#define TSL2561_REGISTER_THRESHHOLDH_LOW      (0x04)
#define TSL2561_REGISTER_THRESHHOLDH_HIGH     (0x05)
#define TSL2561_REGISTER_INTERRUPT            (0x06)
#define TSL2561_REGISTER_CRC                  (0x08)
#define TSL2561_REGISTER_ID                   (0x0A)
#define TSL2561_REGISTER_CHAN0_LOW            (0x8C)
#define TSL2561_REGISTER_CHAN0_HIGH           (0x8D)
#define TSL2561_REGISTER_CHAN1_LOW            (0x8E)
#define TSL2561_REGISTER_CHAN1_HIGH           (0x8F)
//Delay getLux function
#define LUXDELAY 500
int vitesse;
char kb = ' ';
int speed;
int getLux(int fd);
float valeur;
int CC;
int flag = 0;
string ton;
int go;
char klaxonTon[80];
char commande[80];
double tK, dK;


//Tâche qui traite les données du potentiomètre de poignée et qui gère l'état du moteur.
PI_THREAD(throttle) {
    piHiPri(99);
    valeur = 10;
    int temp;
    int s;
    float erreur;
    float somme_erreurs;
    float commande;
    float ki = 5;
    float kp = 400;
    while (1) {
        //Freins appliqués, éteint le moteur et le cruise control. Allume la lumière arrière.
        if (digitalRead(27) == HIGH || !go) {
            cout << kp << endl;
            analogWrite(100, 0);
            digitalWrite(5, HIGH);
            vitesse = 0;
            partage->setRC(1);
            while (digitalRead(27) || !go) {
                delay(1);
            }
            digitalWrite(5, LOW);
        //Mode manuel du moteur lorsque le cruise est éteint et que les freins sont désactivés.
        } else if (digitalRead(27) == LOW && partage->getCruise() == 0) {
            delay(5);
            temp = analogRead(113);
            vitesse = ((temp - 130)*4096) / 528;
            analogWrite(100, vitesse);
        //Boucle de contrôle pour le cruise control, utilise un PI.
        } else if (partage->getCruise()) {
            valeur = partage->getCruise();
            delay(50);
            int s = partage->getVitesse();
            if (s < 5) {
                analogWrite(100, 2000);
            } else if (s < 32) {
                erreur = valeur - s;

                if (s <= (valeur * 1.20) && s >= (valeur * 0.80)) {
                    somme_erreurs += erreur;
                } else
                    somme_erreurs = 0;
                commande = kp * erreur + 2000 + ki * somme_erreurs;
                if (commande < 0)
                    commande = 0;
                analogWrite(100, commande);
            }
        }
        delayMicroseconds(1000);
    }
    return 0;
}


//Tâche qui gère l'affichage de la vitesse à l'aide de la lecture du capteur à effet hall.
PI_THREAD(speedometre) {
    double temp;
    double diff;
    double temp2;
    double diff2;
    float total;
    int flag = 0;
    temp = millis();
    piHiPri(98);
    while (1) {
        if (digitalRead(17)) {
            flag = 0;
            diff = millis();
            speed = (0.00189 / ((diff - temp) / 3600))*1000;
            if (speed < 50 && speed > 0)
                partage->setVitesse(speed);
            temp = diff;
            while (digitalRead(17) == 0) {
                temp2 = millis();
                if (flag == 0) {
                    diff2 = millis();
                    flag = 1;
                }
                if (temp2 - diff2 == 1500) {
                    partage->setVitesse(0);
                }
            }
        }
    }
    return 0;
}


//Démarre la tâche des communications SQL dans un autre objet qui s'appelle T_SQL.
PI_THREAD(tsql) {
    piHiPri(86);
    sql->task();
    return 0;
}


//Tâche de traitement des capteurs de température et de luminosité. C'est ici qu'on allume les phares automatiquement quand la
//luminosité est trop basse.
PI_THREAD(capteurs) {
    tK = millis();
    dK = millis();
    piHiPri(80);
    float lm0 = 0;
    float lm1 = 0;
    float lm2 = 0;
    while (1) {
        delay(100);
        lm0 = analogRead(110);
        lm0 = ((lm0 * 3.3) / 1024)*100;
        lm1 = analogRead(111);
        lm1 = ((lm1 * 3.3) / 1024)*100;
        lm2 = analogRead(112);
        lm2 = ((lm2 * 3.3) / 1024)*100;
        int fd = wiringPiI2CSetup(TSL2561_ADDR_FLOAT);

        partage->setLum(getLux(fd));
        partage->setTempExt(lm0);
        partage->setTempDr(lm1);
        partage->setTempBt(lm2);

        if ((partage->getLum() < 100 && partage->getLumAuto()) || partage->getPhare()) {
            digitalWrite(19, HIGH);
            digitalWrite(26, HIGH);
        } else {
            digitalWrite(19, LOW);
            digitalWrite(26, LOW);
        }
    }
    return 0;
}

//Tâche de traitement des clignotants en fonction de leur vitesse désirée.
PI_THREAD(flash) {
    piHiPri(1);
    while (1) {
        if (partage->getFlDr())
            digitalWrite(6, HIGH);
        else
            digitalWrite(6, LOW);
        if (partage->getFlGau())
            digitalWrite(13, HIGH);
        else
            digitalWrite(13, LOW);
        delay(1000 - partage->getVitClign()*90);
        digitalWrite(13, LOW);
        digitalWrite(6, LOW);
        delay(1000 - partage->getVitClign()*90);
    }
}

//Tâche de traitement du GPS. Démarre la lecture grâce à une commande bash et sauvegarde chacune des données l'une à
//la suite de l'autre dans un fichier .nmea. Permet aussi la suppression des données enregistrées par le même principe.
PI_THREAD(gps) {
    piHiPri(2);
    bool flaGps = 1;
    while (1) {
        if (partage->getGps()) {
            flaGps = 0;
            system("gpspipe -r -n 11 | grep '$G' | tee /home/pi/newposition.nmea");
            system("cat /home/pi/newposition.nmea >> /home/pi/position.nmea");
            delay(2000);
        } else {
            if (!flaGps) {
                system("gpsbabel -i nmea -f /home/pi/position.nmea -o kml -F /home/pi/position.kml");
                flaGps = 1;
            }
        }
        if (partage->getRGps()) {
            system("cat /dev/null > /home/pi/position.nmea");
            partage->setRGps(2);
        }
    }
    return 0;
}


//Gère l'activation du klaxon en fonction d'une commande modifiée dans le main
PI_THREAD(klax) {
    piHiPri(98);
    while (1) {
        if (digitalRead(21)) {
            system(commande);
            while (digitalRead(21)) {
                delay(10);
            }
        }
        delay(10);
    }
}

//Vérifie si un téléphone android est connecté sur le reseau Wi-Fi et débloque le vélo
PI_THREAD(conn) {
    piHiPri(98);
    while (1) {
        delay(6000);
        if (partage->getHazard()) {
            system("nmap -sn 192.168.3.1/24 | grep 'android' | tee /home/pi/network.txt");
            cin.clear();

            char ch;
            FILE *f = fopen("/home/pi/network.txt", "r");
            if (fscanf(f, "%c", &ch) == EOF)
                go = 0;
            else
                go = 1;
            fclose(f);
            partage->setHazard(0);
        }
    }
}


//Fait l'initialisation et la fermeture du programme. Met a jour le klaxon lorsque celui-ci change dans la base de donnée.
int main(int argc, char **argv) {
    wiringPiSetupGpio();
    partage = new T_Partage;
    sql = new T_SQL;
    pinMode(27, INPUT);
    pinMode(17, INPUT);
    pinMode(21, INPUT);
    pinMode(5, OUTPUT);
    pinMode(6, OUTPUT);
    pinMode(13, OUTPUT);
    pinMode(19, OUTPUT);
    pinMode(26, OUTPUT);
    strcpy(klaxonTon, "mpg123 -q /home/pi/Music/klaxon/car_horn.mp3 &");
    mcp3004Setup(110, 0);
    mcp4725Setup(100, MCP4725);
    sql->remiseZero();
    piThreadCreate(tsql);
    piThreadCreate(klax);
    piThreadCreate(flash);
    piThreadCreate(throttle);
    piThreadCreate(capteurs);
    piThreadCreate(speedometre);
    piThreadCreate(gps);
    piThreadCreate(conn);
    while (partage->getShutDown() == 0) {
        if (ton != partage->getTonKlax()) {
            strcpy(klaxonTon, "mpg123 -q /home/pi/Music/klaxon/");
            strcat(klaxonTon, partage->getTonKlax().c_str());
            strcat(klaxonTon, " &");
            strcpy(commande, klaxonTon);
        }
        delay(1000);
    }

    delay(200);
    //delete sql;
    //delete partage;
    partage->setShutDown(0);
    partage->setGps(0);
    system("gpsbabel -i nmea -f /home/pi/position.nmea -o kml -F /home/pi/position.kml");

    analogWrite(100, 0);

    digitalWrite(6, LOW);
    digitalWrite(13, LOW);
    digitalWrite(5, LOW);
    digitalWrite(19, LOW);
    digitalWrite(26, LOW);
    delay(5000);
    system("sudo shutdown now");
    return 0;
}


//fonction qui lis la luminosité et qui retourne une valeur en Lux
int getLux(int fd) {
    // Enable the device
    wiringPiI2CWriteReg8(fd, TSL2561_COMMAND_BIT, TSL2561_CONTROL_POWERON);
    // Set timing (101 mSec)
    wiringPiI2CWriteReg8(fd, TSL2561_REGISTER_TIMING, TSL2561_GAIN_AUTO);
    //Wait for the conversion to complete
    delay(LUXDELAY);
    //Reads visible + IR diode from the I2C device auto
    uint16_t visible_and_ir = wiringPiI2CReadReg16(fd, TSL2561_REGISTER_CHAN0_LOW);
    // Disable the device
    wiringPiI2CWriteReg8(fd, TSL2561_COMMAND_BIT, TSL2561_CONTROL_POWEROFF);
    return visible_and_ir * 2;

}
