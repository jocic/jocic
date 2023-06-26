/*-----------------------------------------------------------------------*/
/* Low level disk I/O module SKELETON for FatFs     (C)ChaN, 2019        */
/*-----------------------------------------------------------------------*/
/* If a working storage control module is available, it should be        */
/* attached to the FatFs via a glue function rather than modifying it.   */
/* This is an example of glue functions to attach various exsisting      */
/* storage control modules to the FatFs module with a defined API.       */
/*-----------------------------------------------------------------------*/

#include <stdlib.h>
#include <stdio.h>

#include "ff.h"			/* Obtains integer types */
#include "diskio.h"		/* Declarations of disk functions */

#define VOLUME_PATH "C:/Users/jocic/Desktop/GitHub/jocic/doodles/2023/petit-fatfs/assets/1.img"

FILE* disk = NULL;

/*-----------------------------------------------------------------------*/
/* Get Drive Status                                                      */
/*-----------------------------------------------------------------------*/

DSTATUS disk_status (
	BYTE pdrv		/* Physical drive nmuber to identify the drive */
)
{
    DSTATUS stat = RES_ERROR;
    
    if (disk != 0) {
        stat = RES_OK;
    }
    
    return stat;
}



/*-----------------------------------------------------------------------*/
/* Inidialize a Drive                                                    */
/*-----------------------------------------------------------------------*/

DSTATUS disk_initialize (
	BYTE pdrv				/* Physical drive nmuber to identify the drive */
)
{
    DSTATUS stat = RES_ERROR;
    
    disk = fopen(VOLUME_PATH, "r+b");
    
    if (disk != 0) {
        stat = RES_OK;
    }
    
    return stat;
}



/*-----------------------------------------------------------------------*/
/* Read Sector(s)                                                        */
/*-----------------------------------------------------------------------*/

DRESULT disk_read (
	BYTE pdrv,		/* Physical drive nmuber to identify the drive */
	BYTE *buff,		/* Data buffer to store read data */
	LBA_t sector,	/* Start sector in LBA */
	UINT count		/* Number of sectors to read */
)
{
    DRESULT res = RES_ERROR;
    
    if (fseek(disk, sector * 512, SEEK_SET) == 0) {
        
        int bytes_read = fread(buff, 1, 512 * count, disk);
        
        if (bytes_read == 512 * count) {
            return RES_OK;
        }
    }
    
    return res;
}



/*-----------------------------------------------------------------------*/
/* Write Sector(s)                                                       */
/*-----------------------------------------------------------------------*/

#if FF_FS_READONLY == 0

DRESULT disk_write (
	BYTE pdrv,			/* Physical drive nmuber to identify the drive */
	const BYTE *buff,	/* Data to be written */
	LBA_t sector,		/* Start sector in LBA */
	UINT count			/* Number of sectors to write */
)
{
    DRESULT res = RES_ERROR;
    
    if (fseek(disk, sector, SEEK_SET) == 0) {
        
        int bytes_written = fwrite(buff, 1, 512 * count, disk);
    }
    
    return res;
}

#endif


/*-----------------------------------------------------------------------*/
/* Miscellaneous Functions                                               */
/*-----------------------------------------------------------------------*/

DRESULT disk_ioctl (
	BYTE pdrv,		/* Physical drive nmuber (0..) */
	BYTE cmd,		/* Control code */
	void *buff		/* Buffer to send/receive control data */
)
{
    DRESULT res = RES_OK;
    
    return res;
}

