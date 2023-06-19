<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_create.php                               *|
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

if (!defined("CONST_EASY_SQL")) exit("Action not allowed.");

// Class.

class EasyCreate
{
    // "Class" Constants.

    const ECM_DO_NOTHING_IF_EXISTS = 0; // Default Mode.
    const ECM_DROP_IF_EXISTS       = 1;
    const ECM_CREATE_WDN           = 2;
    const ECM_CLEAR_IF_EXISTS      = 3;

    // "Control" Variables.
	
    private static $VAR_MODE       = 0;
    private static $VAR_ENGINE     = "InnoDB"; // Default is "InnoDB";
    private static $VAR_CHARSET    = "UTF8"; // Default is "UTF8".
    private static $VAR_COLLATION  = "utf8_general_ci"; // Default is "utf8_general_ci".
	
    // "Set" Methods.

    public static function setMode($value)
    {
        if ($value != self::ECM_DO_NOTHING_IF_EXISTS &&
            $value != self::ECM_DROP_IF_EXISTS &&
            $value != self::ECM_CREATE_WDN &&
            $value != self::ECM_CLEAR_IF_EXISTS)
        {
            new Notice("EasyCreate", "Illegal value was used in the method <i>setMode</i>.");

            $value = self::ECM_DO_NOTHING_IF_EXISTS; // Default Mode.
        }

        self::$VAR_MODE = $value;
    }
	
    public static function setEngine($value) { self::$VAR_ENGINE = $value; }

    public static function setDefaultCharacterSet($value) { self::$VAR_CHARSET = $value; }

    public static function setDefaultCollation($value) { self::$VAR_COLLATION = $value; }
	
    // "Get" Methods.

    public static function getMode() { return self::$VAR_MODE; }

    public static function getEngine() { return self::$VAR_ENGINE; }

    public static function getDefaultCharacterSet() { return self::$VAR_CHARSET; }

    public static function getDefaultCollation() { return self::$VAR_COLLATION; }
	
    // "Main" Methods.

    public static function execute($object)
    {
        // "Mode" Checks.

        if (self::$VAR_MODE == self::ECM_DO_NOTHING_IF_EXISTS && $object->exists())
            return;
        else if (self::$VAR_MODE == self::ECM_DROP_IF_EXISTS && $object->exists())
            EasyDrop::execute($object);
        else if (self::$VAR_MODE == self::ECM_CLEAR_IF_EXISTS && $object->exists())
        {
            EasyTruncate::execute($object);
            
            return;
        }
        else if (self::$VAR_MODE == self::ECM_CREATE_WDN && $object->exists())
        {
            $name = $object->getName();

            $sufix = 1;

            while ($object->exists())
            {
                $sufix ++;

                $object->setName($name . "_" . $sufix);
            }
        }
		
        // Build the query.

        $queryBuilder = new StructureQueryBuilder();

        $query = $queryBuilder->getQuery($object, StructureQueryBuilder::TP_CREATE);

        new DebugInfo("EasyCreate", $query); // Print debug info.
		
        // Perform the Query.
        
        $result = @mysql_query($query);

        if (!$result)
            new Error("EasyCreate", "The query could not be run.");
    }
	
    public static function structure($object)
    {
        self::execute($object);
    }
}

?>