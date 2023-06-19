<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: assets.php                                    *|
|* ------------------------------------------------------- *|
|* Copyright (C) 2014                                      *|
|* ------------------------------------------------------- *|
|* This program is free software: you can redistribute     *|
|* it and/or modify it under the terms of the GNU Affero   *|
|* General Public License as published by the Free         *|
|* Software Foundation, either version 3 of the License,   *|
|* or any other, later, version of the License.            *|
|* ------------------------------------------------------- *|
|* This program is distributed in the hope that it will    *|
|* be useful, but WITHOUT ANY WARRANTY; without even the   *|
|* implied warranty of MERCHANTABILITY or FITNESS FOR A    *|
|* PARTICULAR PURPOSE.  See the GNU Affero General Public  *|
|* License for more details. You should have received a    *|
|* copy of the GNU Affero General Public License along     *|
|* with this program.                                      *|
|* ------------------------------------------------------- *|
|* If not, see <http://www.gnu.org/licenses/>.             *|
|* ------------------------------------------------------- *|
|* Removal of this copyright header is strictly prohibited *|
|* without written permission from the original author(s). *|
\***********************************************************/

// Security Check.

if (!defined("IND_ACCESS")) exit("Action not allowed.");

class Assets
{
    // "Type" Constants.
    
    const TP_PICTURE_ASSETS  = 0;
    const TP_VIDEO_ASSETS    = 1;
    const TP_AUDIO_ASSETS    = 2;
    const TP_ARCHIVE_ASSETS  = 3;
    const TP_DOCUMENT_ASSETS = 4;
    const TP_OTHER_ASSETS    = 5;
    
    // "Main" Methods.
    
    public static function countAssets($varAssetType)
    {
        if ($varAssetType == self::TP_PICTURE_ASSETS ||
            $varAssetType == self::TP_VIDEO_ASSETS ||
            $varAssetType == self::TP_AUDIO_ASSETS ||
            $varAssetType == self::TP_ARCHIVE_ASSETS ||
            $varAssetType == self::TP_DOCUMENT_ASSETS ||
            $varAssetType == self::TP_OTHER_ASSETS)
        {
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varData = EasyGet::execute
            (
                "TS: assets",
                "CS: COUNT(`id`)",
                "ARGS: type = $varAssetType"
            );
            
            return $varData[0][0];
        }
        else
            return 0;
    }
    
    public static function fetchAssets($varAssetType)
    {
        if ($varAssetType == self::TP_PICTURE_ASSETS ||
            $varAssetType == self::TP_VIDEO_ASSETS ||
            $varAssetType == self::TP_AUDIO_ASSETS ||
            $varAssetType == self::TP_ARCHIVE_ASSETS ||
            $varAssetType == self::TP_DOCUMENT_ASSETS ||
            $varAssetType == self::TP_OTHER_ASSETS)
        {
            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

            $varData = EasyGet::execute
            (
                "TS: assets",
                "CS: *",
                "ARGS: type = $varAssetType"
            );
            
            return $varData;
        }
        else
            return 0;
    }
    
    public static function fetchAssetName($varAssetID)
    {
        $varAssetID = Filter::forNumeric($varAssetID);
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $varData = EasyGet::execute
        (
            "TS: assets",
            "CS: name",
            "ARGS: id = $varAssetID"
        );

        return $varData[0][0];
    }
    
    public static function fetchAssetFilename($varAssetID)
    {
        $varAssetID = Filter::forNumeric($varAssetID);
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $varData = EasyGet::execute
        (
            "TS: assets",
            "CS: filename",
            "ARGS: id = $varAssetID"
        );

        return $varData[0][0];
    }
}

?>