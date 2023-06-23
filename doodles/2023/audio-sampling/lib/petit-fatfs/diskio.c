/*-----------------------------------------------------------------------*/
/* Low level disk I/O module skeleton for Petit FatFs (C)ChaN, 2014      */
/*-----------------------------------------------------------------------*/

#include <stdlib.h>
#include <stdio.h>

#include "diskio.h"

#define VOLUME_PATH "C:/Users/jocic/Desktop/GitHub/jocic/doodles/2023/audio-sampling/assets/test.img"

FILE* disk;

/*-----------------------------------------------------------------------*/
/* Initialize Disk Drive                                                 */
/*-----------------------------------------------------------------------*/

DSTATUS disk_initialize (void)
{
    DSTATUS stat = RES_ERROR;
    
    disk = fopen(VOLUME_PATH, "r+b");
    
    if (disk != 0) {
        stat = RES_OK;
    }
    
    return stat;
}

/*-----------------------------------------------------------------------*/
/* Read Partial Sector                                                   */
/*-----------------------------------------------------------------------*/

DRESULT disk_readp (
    BYTE* buff,        /* Pointer to the destination object */
    DWORD sector,    /* Sector number (LBA) */
    UINT offset,    /* Offset in the sector */
    UINT count        /* Byte count (bit15:destination) */
)
{
    DRESULT res = RES_ERROR;
    
    if (fseek(disk, sector * 512 + offset, SEEK_SET) == 0) {
        
        int  bytes_read = fread(buff, 1, count, disk);
        
        if (bytes_read == count) {
            return RES_OK;
        }
    }
    
    return res;
}

/*-----------------------------------------------------------------------*/
/* Write Partial Sector                                                  */
/*-----------------------------------------------------------------------*/

DRESULT disk_writep (
    const BYTE* buff,        /* Pointer to the data to be written, NULL:Initiate/Finalize write operation */
    DWORD sc        /* Sector number (LBA) or Number of bytes to send */
)
{
    DRESULT res = RES_ERROR;
    
    if (buff == 0 && sc) { // Initiate Sector Transaction
        
        if (fseek(disk, sc * 512, SEEK_SET) == 0) {
            res = RES_OK;
        }
    }
    else if (buff && sc) { // Regular Write Operation
            
        int bytes_written = fwrite(buff, 1, sc, disk);
        
        if (bytes_written == sc) {
            res = RES_OK;
        }
    }
    else if (buff == 0 && sc == 0) { // Finalize Sector Transaction
        
        if (fflush(disk) == 0) {
            res = RES_OK;
        }
    }
    
    return res;
}

