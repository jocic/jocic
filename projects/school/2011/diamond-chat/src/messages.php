<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: messages.php                                  *|
|* ------------------------------------------------------- *|
|* Copyright (C) 2011                                      *|
|* ------------------------------------------------------- *|
|* This program is free software: you can redistribute     *|
|* it and/or modify it under the terms of the GNU Affero   *|
|* General Public License as published by the Free         *|
|* Software Foundation, either version 3 of the            *|
|* License, or (at your option) any later version.         *|
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

define('_EXECUTION', 1);

// Includes.
require_once 'classes/basics.php';
require_once 'classes/security.php';
require_once 'classes/connection.php';
require_once 'classes/user.php';

$security = new Security();

if (!$security->checkLoginCookies() || !$security->checkCookieData() || !$security->banned())
{
    setcookie('username', null);
    setcookie('password', null);
    setcookie('token', null);
    
    echo "<p>You just got banned.</p>";
}
else
{
    $user = new User($_COOKIE['username'], $_COOKIE['password']);
    $connection = mysql_connect($user->db_host, $user->db_username, $user->db_password);

    if ($connection)
    {
        mysql_select_db($user->db_database);
        
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>\n";
        echo Basics::addSpaces(3) . "<head>\n";
        echo Basics::addSpaces(5) . "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />\n";
        echo Basics::addSpaces(5) . "<meta http-equiv='refresh' content='5' />";
        echo Basics::addSpaces(5) . "<link rel='stylesheet' type='text/css' href='message.css' />\n";
        echo Basics::addSpaces(3) . "</head>\n";
        echo Basics::addSpaces(3) . "<body>\n";
        
        $user->generateMessages();

        echo Basics::addSpaces(3) . "</body>\n";
        echo "</html>";
        
        mysql_close();
    }
    else
    {
        echo "Failed to connect.";
    }
}

?>