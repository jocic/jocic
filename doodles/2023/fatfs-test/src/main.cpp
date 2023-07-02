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

        if (f_open(&file, "TEST.DAT", FA_WRITE | FA_CREATE_NEW) == FR_OK) {
            
            cout << ":D" << endl;
        }
    }
    
    return 0;
}
