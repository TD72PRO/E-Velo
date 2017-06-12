#ifndef T_PARTAGE_H
#define T_PARTAGE_H
#include <wiringPi.h>
#include <cstddef>
#include <stdio.h>
#include <string>
using std::string;
class T_Partage {
public:
    T_Partage();
    virtual ~T_Partage();
    void setReset(int i);
    int getReset(void);
    void setRsKlax(int i);
    int getRsKlax(void);
    void setVitesse(float v);
    float getVitesse(void);
    void setCruise(char c);
    char getCruise(void);
    void setTempExt(float t);
    float getTempExt(void);
    void setTempDr(float t);
    float getTempDr(void);
    void setTempBt(float t);
    float getTempBt(void);
    void setLum(int l);
    int getLum(void);
    void setVitClign(float v);
    float getVitClign(void);
    void setFlGau(int f);
    int getFlGau(void);
    void setFlDr(int f);
    int getFlDr(void);
    void setPhare(int p);
    int getPhare(void);
    void setKlax(int k);
    int getKlax(void);
    void setLumAuto(int l);
    int getLumAuto(void);
    void setShutDown(int s);
    int getShutDown(void);
    void setTonKlax(string k);
    string getTonKlax(void);
    int getGps(void);
    void setGps(int g);
    int getRGps(void);
    void setRGps(int g);
    int getRC(void);
    void setRC(int g);
    int getHazard(void);
    void setHazard(int g);
private:
    char cruise;
    float vitesse,tempExt,tempDr,tempBt,vitClign;
    int flGau,flDr,phare,klax,lumAuto,shutdown,lum,zero,rsKlax,gps,resetgps,resetCruise, hazard;
    string tonKlax;

};
extern T_Partage *partage;
#endif /* T_PARTAGE_H */

