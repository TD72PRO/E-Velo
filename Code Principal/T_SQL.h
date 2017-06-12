#ifndef T_SQL_H
#define T_SQL_H
#include <iostream>
#include <mysql/mysql.h>
#include <wiringPi.h>
#include <stdlib.h>
#include "T_Partage.h"
#include <sstream>
#include <string>
#include <stdio.h>

class T_SQL {
public:
    T_SQL();
    virtual ~T_SQL();
    void task(void);
    void remiseZero(void);
private:


};
extern T_SQL *sql;
#endif /* T_SQL_H */

