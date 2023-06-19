<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_grant.php                                *|
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

class EasyGrant
{
    // "Class" Constants.

    const PRIV_ALL           = "ALL";
    const PRIV_SELECT        = "SELECT";
    const PRIV_UPDATE        = "UPDATE";
    const PRIV_INSERT        = "INSERT";
    const PRIV_DELETE        = "DELETE";

    // "Core" Variables.

    private static $VAL_USR  = null;
    private static $VAL_PRIV = null;
    private static $VAL_OBJ  = null;

    // "Set" Methods.

    public static function setUser($value)
    {
        self::$VAL_USR = @mysql_real_escape_string($value);
    }
	
    public static function setPrivileges($params = null)
    {
        if (!is_array($params))
            $params = func_get_args();

        foreach ($params as $value)
        {
            if ($value == "ALL" ||
                $value == "SELECT" ||
                $value == "UPDATE" ||
                $value == "INSERT" ||
                $value == "DELETE")
                self::$VAL_PRIV[] = $value;
            else
                new Error("EasyGrant", "You have used a wrong option in the method <i>setPrivileges</i>.");
        }
    }

    public static function setObject($value)
    {
        $dqb = new DataQueryBuilder();

        self::$VAL_OBJ = @mysql_real_escape_string($value);

        self::$VAL_OBJ = $dqb->buildTableSelection(new TableSelection(self::$VAL_OBJ), null);
    }
	
    // "Get" Methods.

    public static function getUser() { return self::$VAL_USR; }

    public static function getPrivileges() { return self::$VAL_PRIV; }

    public static function getObject() { return self::$VAL_OBJ; }

    // "Main" Methods.

    public static function execute()
    {
        // Fetch Hostname. 

        $dbConfig = new DBConfig();

        $hostname = $dbConfig->getHostname();

        // Create Privileges List.

        $privileges = "";

        for ($i = 0; $i < count(self::$VAL_PRIV); $i ++)
        {
            if ($i > 0)
                $privileges .= ", ";

            $privileges .= self::$VAL_PRIV[$i];
        }

        // Perform the Query.

        $query = "GRANT $privileges ON " . self::$VAL_OBJ . " TO '" . self::$VAL_USR . "'@'$hostname'";

        new DebugInfo("EasyUser", $query); // Print debug info.

        $result = @mysql_query($query); // Drop the table if exists.

        if (!$result)
            new Error("EasyUser", "The query could not be run.");

        // Reset Variables.

        self::$VAL_USR  = null;
        self::$VAL_PRIV = null;
        self::$VAL_OBJ  = null;
    }
	
    // "Other" Methods.

    public static function privileges($params = null)
    {
        self::setPrivileges(func_get_args());
    }
	
    public static function toUser($value)
    {
        self::setUser($value);
    }
	
    public static function onObject($value)
    {
        self::setObject($value);
    }
}

?>