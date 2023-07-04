<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_connection.php                           *|
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

class EasyConnection
{
    // "Core" Variables.

    private static $CONN_LINK        = null;
    private static $CONN_ACTIVE      = false;
	
    // "Start" Methods.

    public static function start($dbConfig = null)
    {
        if ($dbConfig == null)
            $dbConfig = new DBConfig(); // Fetch SQL server info.
		
        self::$CONN_LINK = @mysql_connect // Connect.
        (
            $dbConfig->getHostname(),
            $dbConfig->getUsername(),
            $dbConfig->getPassword()
        );

        if (!self::$CONN_LINK)
        {
            new Error("EasyConnect", "Connection to the DB couldn't be established.");
            
            return;
        }
        else
            self::$CONN_ACTIVE = true; // Set the "connection is active" variable.

        // Create DB Schema if it doesn't exists.

        $dbSchema = new EasySchema($dbConfig->getSchemaName());

        if (!$dbSchema->exists())
            EasyCreate::execute($dbSchema);
			
        // Select DB Schema.
			
        if (!@mysql_select_db($dbConfig->getSchemaName(), self::$CONN_LINK)) // Select the DB.
            new Error("EasyConnect", "DB couldn't be selected.");
		
            // Set character set.
		
        if (!@mysql_query("SET CHARACTER SET utf8"))
            new Error("EasyConnect", "Character set couldn't be set to UTF8.");
		
        // Perform initial settings.

        EasyCore::setSchemaName($dbConfig->getSchemaName());
        EasyCore::setTablePrefix($dbConfig->getTablePrefix());
        EasyCore::setViewPrefix($dbConfig->getViewPrefix());
		
        // Check the users IP.

        $iph = new IPHandler();

        $iph->checkIP();
    }
	
    public static function initialize($dbConfig = null)
    {
        self::start($dbConfig);
    }
	
    public static function establish($dbConfig = null)
    {
        self::start($dbConfig);
    }
	
    public static function connect($dbConfig = null)
    {
        self::start($dbConfig);
    }
	
    // "Stop" Methods.

    public static function stop()
    {
        $result = @mysql_close(self::$CONN_LINK);

        self::$CONN_ACTIVE = !$result; // Set the "connection is active" variable.
    }
	
    public static function terminate()
    {
        self::stop();
    }
	
    public static function abort()
    {
        self::stop();
    }
	
    public static function disconnect()
    {
        self::stop();
    }
	
    // "Other" Methods.

    public static function established()
    {
        return self::$CONN_ACTIVE;
    }
	
    public static function active()
    {
        return self::$CONN_ACTIVE;
    }
}

?>