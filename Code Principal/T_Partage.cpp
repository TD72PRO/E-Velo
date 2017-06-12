#include "T_Partage.h"
T_Partage *partage = NULL;


//Cette classe sert à faire un lien entre les classes pour transmettre des données.
T_Partage::T_Partage() {
    vitesse = 0;
    cruise = 0;
    tempExt = 0;
    tempDr = 0;
    tempBt = 0;
    lum = 0;
    vitClign = 0;
    flGau = 0;
    flDr = 0;
    phare = 0;
    klax = 0;
    lumAuto = 0;
    shutdown = 0;
    tonKlax = "car_horn.mp3";
    rsKlax = 0;
    zero = 0;
    gps = 0;
    resetgps=0;
    resetCruise=0;
    hazard = 0;
}

T_Partage::~T_Partage() {
}

void T_Partage::setHazard(int g) {
    piLock(1);
    hazard = g;
    piUnlock(1);
}

int T_Partage::getHazard(void){
    piLock(1);
    int t = hazard;
    piUnlock(1);
    return t;
} 
void T_Partage::setRC(int g) {
    piLock(1);
    resetCruise = g;
    piUnlock(1);
}

int T_Partage::getRC(void){
    piLock(1);
    int t = resetCruise;
    piUnlock(1);
    return t;
} 
void T_Partage::setRGps(int g) {
    piLock(1);
    resetgps = g;
    piUnlock(1);
}

int T_Partage::getRGps(void){
    piLock(1);
    int t = resetgps;
    piUnlock(1);
    return t;
} 

void T_Partage::setGps(int g) {
    piLock(1);
    gps = g;
    piUnlock(1);
}

int T_Partage::getGps(void){
    piLock(1);
    int t = gps;
    piUnlock(1);
    return t;
} 

void T_Partage::setReset(int i) {
    piLock(1);
    zero = i;
    piUnlock(1);
}

int T_Partage::getReset(void) {
    piLock(1);
    int temp = zero;
    piUnlock(1);
    return temp;
}

void T_Partage::setRsKlax(int i) {
    piLock(1);
    rsKlax = i;
    piUnlock(1);
}

int T_Partage::getRsKlax(void) {
    piLock(1);
    int temp = rsKlax;
    piUnlock(1);
    return temp;
}

void T_Partage::setTonKlax(string k) {
    piLock(1);
    tonKlax = k;
    piUnlock(1);
}

string T_Partage::getTonKlax(void) {
    piLock(1);
    string temp = tonKlax;
    piUnlock(1);
    return temp;
}

void T_Partage::setVitesse(float v) {
    piLock(1);
    vitesse = v;
    piUnlock(1);
}

float T_Partage::getVitesse(void) {
    float temp;
    piLock(1);
    temp = vitesse;
    piUnlock(1);
    return temp;
}

void T_Partage::setCruise(char c) {
    piLock(1);
    cruise = c;
    piUnlock(1);
}

char T_Partage::getCruise(void) {
    char temp;
    piLock(1);
    temp = cruise;
    piUnlock(1);
    return temp;
}

void T_Partage::setTempExt(float t) {
    piLock(1);
    tempExt = t;
    piUnlock(1);
}

float T_Partage::getTempExt(void) {
    float temp;
    piLock(1);
    temp = tempExt;
    piUnlock(1);
    return temp;
}

void T_Partage::setTempDr(float t) {
    piLock(1);
    tempDr = t;
    piUnlock(1);
}

float T_Partage::getTempDr(void) {
    float temp;
    piLock(1);
    temp = tempDr;
    piUnlock(1);
    return temp;
}

void T_Partage::setTempBt(float t) {
    piLock(1);
    tempBt = t;
    piUnlock(1);
}

float T_Partage::getTempBt(void) {
    float temp;
    piLock(1);
    temp = tempBt;
    piUnlock(1);
    return temp;
}

void T_Partage::setLum(int l) {
    piLock(1);
    lum = l;
    piUnlock(1);
}

int T_Partage::getLum(void) {
    int temp;
    piLock(1);
    temp = lum;
    piUnlock(1);
    return temp;
}

void T_Partage::setVitClign(float v) {
    piLock(1);
    vitClign = v;
    piUnlock(1);
}

float T_Partage::getVitClign(void) {
    float temp;
    piLock(1);
    temp = vitClign;
    piUnlock(1);
    return temp;
}

void T_Partage::setFlGau(int f) {
    piLock(1);
    flGau = f;
    piUnlock(1);
}

int T_Partage::getFlGau(void) {
    int temp;
    piLock(1);
    temp = flGau;
    piUnlock(1);
    return temp;
}

void T_Partage::setFlDr(int f) {
    piLock(1);
    flDr = f;
    piUnlock(1);
}

int T_Partage::getFlDr(void) {
    int temp;
    piLock(1);
    temp = flDr;
    piUnlock(1);
    return temp;
}

void T_Partage::setPhare(int p) {
    piLock(1);
    phare = p;
    piUnlock(1);
}

int T_Partage::getPhare(void) {
    int temp;
    piLock(1);
    temp = phare;
    piUnlock(1);
    return temp;
}

void T_Partage::setKlax(int k) {
    piLock(1);
    klax = k;
    piUnlock(1);
}

int T_Partage::getKlax(void) {
    int temp;
    piLock(1);
    temp = klax;
    piUnlock(1);
    return temp;
}

void T_Partage::setLumAuto(int l) {
    piLock(1);
    lumAuto = l;
    piUnlock(1);
}

int T_Partage::getLumAuto(void) {
    int temp;
    piLock(1);
    temp = lumAuto;
    piUnlock(1);
    return temp;
}

void T_Partage::setShutDown(int s) {
    piLock(1);
    shutdown = s;
    piUnlock(1);
}

int T_Partage::getShutDown(void) {
    float temp;
    piLock(1);
    temp = shutdown;
    piUnlock(1);
    return temp;
}

