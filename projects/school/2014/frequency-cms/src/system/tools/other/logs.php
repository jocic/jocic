<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: logs.php                                      *|
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

class Logs
{
    // "Log Code" Contants.
    
    const LC_LOGGED_IN      = 0;
    const LC_LOGGED_OUT     = 1;
    const LC_CAPTCHA_FAILED = 2;
    
    // "Main" Methods.
    
    public static function insertLog($parCode, $parInfo)
    {
        if (Core::get(Core::SECURITY_LOGGING) == "yes")
        {
            // Filter Parameters.

            $parCode = Filter::forNumeric($parCode);
            $parInfo = Filter::forText($parInfo);
            $parIP   = $_SERVER["REMOTE_ADDR"];

            // Custom Value Selection.

            $customSelection = new ValueSelection();

            $customSelection->setOption(ValueSelection::OPT_ENCODE);

            $customSelection->addValues($parCode, $parInfo, $parIP);

            // Perform Insertion.

            EasyInsert::execute
            (
                "TS: logs",
                "CS: code, info, ip",
                $customSelection
            );
        }
    }
    
    // "Is" Methods.
    
    public static function isSomethingLogged()
    {
        return self::getLogCount() != 0;
    }
    
    // "Get" Methods.
    
    public static function getLogCount()
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $varData = EasyGet::execute
        (
            "TS: logs",
            "CS: COUNT(`id`)"
        );

        return $varData[0][0];
    }
 
    public static function getLatestLogs($parNumber)
    {
        // Filter Parameters.
        
        $parNumber = Filter::forNumeric($parNumber);
        
        // Perform Fetching.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setOrderBy("id", EasyGet::OB_DESC);
        
        EasyGet::setLimit($parNumber);

        $varData = EasyGet::execute
        (
            "TS: logs",
            "CS: *"
        );

        return $varData;
    }
    
    /*
     * Returns 20 or less logs.
     */
    
    public static function getLogs($parStartFrom)
    {
        // Filter Parameters.
        
        $parStartFrom = Filter::forNumeric($parStartFrom);
        
        // Perform Fetching.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setOrderBy("id", EasyGet::OB_DESC);
        
        EasyGet::setLimit(20, $parStartFrom);

        $varData = EasyGet::execute
        (
            "TS: logs",
            "CS: *"
        );

        return $varData;
    }
}

?>
