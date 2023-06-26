#include <iostream>
#include <ff.h>

using namespace std;

FATFS drive;
FIL   file;
UINT  br;
BYTE  buff[512];

int main()
{

    if (f_mount(&drive, "0:", 1) == FR_OK) {

        if (f_open(&file, "CONF.DAT", FA_READ) == FR_OK) {
            
            //
        }
    }
    
    return 0;
}
