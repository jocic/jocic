<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_user.php                                 *|
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

class EasyUser
{
    // "Main" Methods.

    public static function addUser($username, $password)
    {
        // Fetch Hostname. 

        $dbConfig = new DBConfig();

        $hostname = $dbConfig->getHostname();

        // Filter Variables.

        $username = @mysql_real_escape_string($username);
        $password = @mysql_real_escape_string($password);
        $hostname = @mysql_real_escape_string($hostname);

        // Perform the Query.

        $query = "CREATE USER '$username'@'$hostname' IDENTIFIED BY '$password'";

        new DebugInfo("EasyUser", $query); // Print debug info.

        $result = @mysql_query($query); // Drop the table if exists.

        if (!$result)
            new Error("EasyUser", "The query could not be run.");
    }
	
    public static function renameUser($oldUsername, $newUsername)
    {
        // Fetch Hostname. 

        $dbConfig = new DBConfig();

        $hostname = $dbConfig->getHostname();

        // Filter Variables.

        $oldUsername = @mysql_real_escape_string($oldUsername);
        $newUsername = @mysql_real_escape_string($newUsername);
        $hostname    = @mysql_real_escape_string($hostname);

        // Perform the Query.

        $query = "RENAME USER '$oldUsername'@'$hostname' TO '$newUsername'@'$hostname'";

        new DebugInfo("EasyUser", $query); // Print debug info.

        $result = @mysql_query($query); // Drop the table if exists.

        if (!$result)
            new Error("EasyUser", "The query could not be run.");
    }

    public static function removeUser($username)
    {
        // Fetch Hostname. 

        $dbConfig = new DBConfig();

        $hostname = $dbConfig->getHostname();

        // Filter Variables.

        $username = @mysql_real_escape_string($username);
        $hostname = @mysql_real_escape_string($hostname);

        // Perform the Query.

        $query = "DROP USER '$username'@'$hostname'";

        new DebugInfo("EasyUser", $query); // Print debug info.

        $result = @mysql_query($query); // Drop the table if exists.

        if (!$result)
            new Error("EasyUser", "The query could not be run.");
    }

    public static function setPassword($username, $password)
    {
        // Fetch Hostname. 

        $dbConfig = new DBConfig();

        $hostname = $dbConfig->getHostname();

        // Filter Variables.

        $username = @mysql_real_escape_string($username);
        $password = @mysql_real_escape_string($password);
        $hostname = @mysql_real_escape_string($hostname);
		
        // Perform the Query.

        $query = "SET PASSWORD FOR '$username'@'$hostname' = PASSWORD('$password')";

        new DebugInfo("EasyUser", $query); // Print debug info.

        $result = @mysql_query($query); // Drop the table if exists.

        if (!$result)
            new Error("EasyUser", "The query could not be run.");
    }
	
    // Short "Main" Methods.

    public static function add($username, $password)
    {
        self::addUser($username, $password);
    }

    public static function rename($oldUsername, $newUsername)
    {
        self::renameUser($oldUsername, $newUsername);
    }
	
    public static function remove($username)
    {
        self::removeUser($username);
    }
	
    public static function setPass($username, $password)
    {
        self::setPassword($username, $password);
    }
}

?>