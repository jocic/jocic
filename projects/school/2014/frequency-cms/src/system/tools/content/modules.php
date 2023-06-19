<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: modules.php                                   *|
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

class Modules
{
    // "Main" Methods.
    
    public static function getModuleBlockName($moduleName)
    {
        // Filter Module Name.
        
        $moduleName = Filter::forTableNames($moduleName);
        
        // Fetch Module Block Name.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: modules",
            "CS: block",
            "ARGS: name = " . $moduleName
        );
        
        // Return Value.
        
        return $data[0][0];
    }
    
    public static function moveModuleUp($moduleName)
    {
        // Filter Module Name.
        
        $moduleName = Filter::forTableNames($moduleName);
        
        // Fetch Module Block.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $moduleBlock = EasyGet::execute
        (
            "TS: modules",
            "CS: block",
            "ARGS: name = $moduleName"
        );
        
        $moduleBlock = $moduleBlock[0][0];
        
        // Fetch Modules Tied To The Block.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setOrderBy("position", EasyGet::OB_ASC);
        
        $modules = EasyGet::execute
        (
            "TS: modules",
            "CS: name, position",
            "ARGS: block = " . $moduleBlock
        );
        
        for ($i = 0; $i < count($modules); $i ++)
        {
            if ($modules[$i]["name"] == $moduleName)
            {
                if (isset($modules[$i - 1]))
                {
                    EasyUpdate::execute
                    (
                        "TS: modules",
                        "CS: position",
                        "VLS: " . $modules[$i]["position"],
                        "ARGS: name = " . $modules[$i - 1]["name"]
                    );

                    EasyUpdate::execute
                    (
                        "TS: modules",
                        "CS: position",
                        "VLS: " . $modules[$i - 1]["position"],
                        "ARGS: name = " . $modules[$i]["name"]
                    );
                }
            }
        }
    }
    
    public static function moveModuleDown($moduleName)
    {
        // Filter Module Name.
        
        $moduleName = Filter::forTableNames($moduleName);
        
        // Fetch Module Block.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $moduleBlock = EasyGet::execute
        (
            "TS: modules",
            "CS: block",
            "ARGS: name = $moduleName"
        );
        
        $moduleBlock = $moduleBlock[0][0];
        
        // Fetch Modules Tied To The Block.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setOrderBy("position", EasyGet::OB_ASC);
        
        $modules = EasyGet::execute
        (
            "TS: modules",
            "CS: name, position",
            "ARGS: block = " . $moduleBlock
        );
        
        for ($i = 0; $i < count($modules); $i ++)
        {
            if ($modules[$i]["name"] == $moduleName)
            {
                if (isset($modules[$i + 1]))
                {
                    EasyUpdate::execute
                    (
                        "TS: modules",
                        "CS: position",
                        "VLS: " . $modules[$i]["position"],
                        "ARGS: name = " . $modules[$i + 1]["name"]
                    );

                    EasyUpdate::execute
                    (
                        "TS: modules",
                        "CS: position",
                        "VLS: " . $modules[$i + 1]["position"],
                        "ARGS: name = " . $modules[$i]["name"]
                    );
                }
            }
        }
    }
}

?>
