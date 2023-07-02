
#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>

#include "pff.h"
#include "diskio.h"

FATFS   fs;
BYTE    buff[16];
UINT    br, bw;
FRESULT res;

int gen_rand(int from, int to) {
    
    static bool init = false;
    
    if (!init) {
        init = true;
        srand(time(NULL));
    }
    
    int num = rand() & to;
    
    if (num < from) {
        num += from;
    }
    
    return num;
}

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
    
    printf("[*] Dumping contents...\n");
    
    while (pf_read(buff, 3, &br) == FR_OK && br > 0) {
        
        for (int i = 0; i < br; i++) {
            printf("%c", buff[i]);
        }
    }
    
    printf("\n");
}

void fatfs_seek(const char* filename) {
    
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
    
    char buff[5];
    int  num;
    
    int param_offset = 15;
    int line_offset  = 22;
    
    for (int i = 0; i < 3; i++) {
        
        res = pf_lseek(param_offset + line_offset * i);
        printf("[*] Attempting to seek; Code=%d\n", res);
        
        if (res != FR_OK) {
            return;
        }
        
        pf_read(buff, 5, &br);
        printf("[*] Attempting to read; Code=%d\n", res);
        
        if (res != FR_OK) {
            return;
        }
        
        num = atoi(buff);
        
        printf("#%d = %d\n", (i + 1), num);
    }
}

void fatfs_write_1(const char* filename) {
    
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
    
    int a = gen_rand(100, 100000);    
    int b = gen_rand(100, 100000);    
    int c = gen_rand(100, 100000);
    
    char buffer[255];
    
    int char_count = sprintf(buffer,
        "RANDOM_NUM_1 = %05d\n\n"
        "RANDOM_NUM_2 = %05d\n\n"
        "RANODM_NUM_3 = %05d\n\n",
            a, b, c);
    
    res = pf_write(buffer, char_count, &bw);
    printf("[*] Attempting to write to file; Code=%d\n", res);
    
    if (res != FR_OK) {
        return;
    }
    
    pf_write(0, 0, &bw);
}

void fatfs_write_2(const char* filename) {
    
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
    
    int  num;
    char buffer[5];
    int  char_count;
    
    for (int i = 0; i < 2048; i++) {
        
        num = gen_rand(1, 9999);
        
        char_count = sprintf(buffer, "%04d ", num);
        
        res = pf_write(buffer, char_count, &bw);
        
        if (res != 0) {
            printf("WTF: %d\n", res);
        }
    }
    
    pf_write(0, 0, &bw);
}

int main() {
    
    fatfs_read("LOGS.TXT");
    fatfs_seek("CONF.DAT");
    fatfs_write_1("CONF.DAT");
    fatfs_write_2("RAND.TXT");
    
    return 0;
}
