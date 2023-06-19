<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: chat.php                                    *|
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

// Define root access.
define('_EXECUTION', 1);

// Includes.
require_once 'classes/basics.php';
require_once 'classes/security.php';
require_once 'classes/connection.php';
require_once 'classes/user.php';

$title = "Chat";

// Page content.
function insertPageContent()
{
    $security = new Security();
    $user = null;
    
    $security->checkInstallation();
    
    if (!$security->checkLoginCookies() || !$security->checkCookieData())
    {
        setcookie('username', null);
        setcookie('password', null);
        setcookie('token', null);

        die(header ("Location: log-in.php"));
    }
    else
    {
        $user = new User($_COOKIE['username'], $_COOKIE['password']);
        $connection = mysql_connect($user->db_host, $user->db_username, $user->db_password);
        mysql_set_charset('utf8');
        
        if ($connection)
        {
            mysql_select_db($user->db_database);
            
            if (isset($_POST['f_message']) && strlen($_POST['f_message']) != 0)
            {
                $id = $user->getId();
                $time = date("H:i:s", time());
                $message = addslashes($_POST['f_message']);

                $result = $user->insertData(
                         "messages",
                         "`message_id`, `user_id`, `user_ip`, `message_time`, `message`",
                         "NULL, '$id', '{$_SERVER['REMOTE_ADDR']}', '$time', '$message'"
                 );
            }
            
            echo Basics::addSpaces(5) . "<div class='chat-holder'>\n";
            echo Basics::addSpaces(7) . "<div id='chat-window'>\n";
            echo Basics::addSpaces(9) . "<h3>Chat Window</h3>\n";
            echo Basics::addSpaces(9) . "<iframe src='messages.php' id='area'></iframe>\n";
            echo Basics::addSpaces(9) . "<form name='message' method='post' action='{$_SERVER['PHP_SELF']}'>\n";
            echo Basics::addSpaces(11) . "<input id='chat-input' name='f_message' type='text' maxlength='100' /> <input id='chat-send' type='submit' name='f_submit' value='Send' />\n";
            echo Basics::addSpaces(9) . "</form>\n";
            echo Basics::addSpaces(7) . "</div>\n";
            echo Basics::addSpaces(7) . "<div id='chat-options'>\n";
            echo Basics::addSpaces(9) . "<h3>Chat Options</h3>\n";
            echo Basics::addspaces(11) . "<p><strong>User:</strong> {$_COOKIE['username']}</p>\n";

            $user->generateOptions();

            echo Basics::addSpaces(7) . "</div>\n";
            echo Basics::addSpaces(7) . "<div id='chat-options'>\n";
            echo Basics::addSpaces(9) . "<h3>Five latest users...</h3>\n";
            
            $user->generateUsers();
            
            echo Basics::addSpaces(7) . "</div>\n";
            echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
            echo Basics::addSpaces(5) . "</div>\n";
            echo Basics::addSpaces(5) . "<script>focus('chat-input');</script>\n";
            
            mysql_close($connection);
        }
        else
        {
            $security->displayError(Basics::addSpaces(7), "Error. Failed to connect. You won't be able to use this chat.");
        }
    }
}

// Include theme.
require_once 'includes/theme.php';

?>