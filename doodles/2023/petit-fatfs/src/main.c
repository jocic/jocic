#include <stdio.h>
#include <stdlib.h>

#include "pff.h"

FATFS   fs;
BYTE    buff[16];
UINT    br;
FRESULT res;

void fatfs_read(const char* filename) {
    
    res = pf_mount(&fs);
    printf("[*] Mounting file system; Code=%d\n", res);
    
    if (res != FR_OK) {
        return;
    }
    
    res = pf_open(filename);
    printf("[*] Attempting to open %s; Code=%d\n", filename, res);
    
    if (res != FR_OK) {
        return;
    }
    
    printf("[*] Dumping contents...\n\n");
    
    while (pf_read(buff, 3, &br) == FR_OK && br > 0) {
        
        for (int i = 0; i < br; i++) {
            printf("%c", buff[i]);
        }
    }
    
    printf("\n");
}

int main() {
    
    fatfs_read("LOGGER.TXT");
    
    return 0;
}
