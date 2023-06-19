<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: index.php                                     *|
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

// No direct access.
define('_EXECUTION', 1);

// Classes.
require_once '../classes/basics.php';
require_once '../classes/security.php';

// Ini settings.
ini_set( "display_errors", 0);

// Page content.
function insertPageContent()
{
    // Class objects.
    $security = new Security();
    // Other.
    $checkFiles = array(
        "../classes/settings.php" => false
    );
    $buttonValue = "Next";
    $passed = true;
    
    // Check if file/s is writtable.
    foreach ($checkFiles as $key => $value)
        if (file_exists($key) && is_writable($key)) $checkFiles[$key] = true;
        else { $passed = false; break; }
        
    if ($_POST == null || !$passed)
    {   
        if (!$passed) $buttonValue = "Try Again";
        
        // File settings.
        echo Basics::addSpaces(7) . "<div class='content' style='height: 95px;'>\n";
        echo Basics::addSpaces(9) . "<h3>File Settings</h3>\n";
        echo Basics::addSpaces(9) . "<p>In order to finish the setup, the following file must be writable.</p>\n";
        echo Basics::addSpaces(11) . "<div class='left'>\n";
        
        foreach ($checkFiles as $key => $value)
            echo Basics::addSpaces(13) . "<p>$key</p>\n";
        
        echo Basics::addSpaces(11) . "</div>\n";
        echo Basics::addSpaces(11) . "<div class='right'>\n";
        
        foreach ($checkFiles as $key => $value)
            if ($value) echo Basics::addSpaces(13) . "<p class='passed'>passed</p>\n";
            else echo Basics::addSpaces(13) . "<p class='failed'>failed</p>\n";
        
        echo Basics::addSpaces(11) . "</div>\n";
        echo Basics::addSpaces(9) . "<div class='clr'></div>\n";
        echo Basics::addSpaces(7) . "</div>\n";
        
        // Database settings.
        echo Basics::addSpaces(7) . "<div class='content'>\n";
        echo Basics::addSpaces(9) . "<h3>Database Settings</h3>\n";
        echo Basics::addSpaces(9) . "<form id='database' method='post' action='" . $_SERVER['PHP_SELF'] . "'>\n";
        echo Basics::addSpaces(11) . "<div class='left'>\n";
        echo Basics::addSpaces(13) . "<p>Database Hostname:</p>\n";
        echo Basics::addSpaces(13) . "<p>Database Username:</p>\n";
        echo Basics::addSpaces(13) . "<p>Database Password:</p>\n";
        echo Basics::addSpaces(13) . "<p>Database Name:</p>\n";
        echo Basics::addSpaces(13) . "<p>Database Prefix:</p>\n";
        echo Basics::addSpaces(11) . "</div>\n";
        echo Basics::addSpaces(11) . "<div class='right'>\n";
        echo Basics::addSpaces(13) . "<p><input class='box' type='text' name='f_host' value='localhost' maxlength='30' /></p>\n";
        echo Basics::addSpaces(13) . "<p><input class='box' type='text' name='f_username' maxlength='30' /></p>\n";
        echo Basics::addSpaces(13) . "<p><input class='box' type='password' name='f_password' maxlength='50' /></p>\n";
        echo Basics::addSpaces(13) . "<p><input class='box' type='text' name='f_name' maxlength='30' /></p>\n";
        echo Basics::addSpaces(13) . "<p><input class='box' type='text' name='f_prefix' value='dc_' maxlength='10' /></p>\n";
        echo Basics::addSpaces(11) . "</div>\n";
        echo Basics::addSpaces(11) . "<p><input class='button' type='submit' name='f_submit' value='$buttonValue' /></p>\n";
        echo Basics::addSpaces(9) . "</form>\n";
        echo Basics::addSpaces(9) . "<div class='clr'></div>\n";
        echo Basics::addSpaces(7) . "</div>\n";
    }
    else
    {
        if ($security->checkRequestMethod('post') &&
            $security->checkFormPost(array('f_host', 'f_username', 'f_password', 'f_name', 'f_prefix', 'f_submit')) &&
            $security->checkNullPost(array('f_host', 'f_username', 'f_name', 'f_prefix')))
        {
            $connected = mysql_connect($_POST['f_host'], $_POST['f_username'], $_POST['f_password']);
            
            if ($connected) 
            {
                $checkDatabase = mysql_query("CREATE DATABASE IF NOT EXISTS {$_POST['f_name']}");

                if ($checkDatabase)
                {
                    $settings = "<?php\n" .
                                "/***********************************************************\\\n" .
                                "|* Diamond Chat v1.0.0                                     *|\n" .
                                "|* Author: Đorđe Jocić                                     *|\n" .
                                "|* Year: 2011                                              *|\n" .
                                "|* ------------------------------------------------------- *|\n" .
                                "|* Filename: settings.php                                  *|\n" .
                                "|* ------------------------------------------------------- *|\n" .
                                "|* Copyright (C) 2011                                      *|\n" .
                                "|* ------------------------------------------------------- *|\n" .
                                "|* This program is free software: you can redistribute     *|\n" .
                                "|* it and/or modify it under the terms of the GNU Affero   *|\n" .
                                "|* General Public License as published by the Free         *|\n" .
                                "|* Software Foundation, either version 3 of the            *|\n" .
                                "|* License, or (at your option) any later version.         *|\n" .
                                "|* ------------------------------------------------------- *|\n" .
                                "|* This program is distributed in the hope that it will    *|\n" .
                                "|* be useful, but WITHOUT ANY WARRANTY; without even the   *|\n" .
                                "|* implied warranty of MERCHANTABILITY or FITNESS FOR A    *|\n" .
                                "|* PARTICULAR PURPOSE.  See the GNU Affero General Public  *|\n" .
                                "|* License for more details. You should have received a    *|\n" .
                                "|* copy of the GNU Affero General Public License along     *|\n" .
                                "|* with this program.                                      *|\n" .
                                "|* ------------------------------------------------------- *|\n" .
                                "|* If not, see <http://www.gnu.org/licenses/>.             *|\n" .
                                "|* ------------------------------------------------------- *|\n" .
                                "|* Removal of this copyright header is strictly prohibited *|\n" .
                                "|* without written permission from the original author(s). *|\n" .
                                "\***********************************************************/\n\n" .
                                "class Settings\n" .
                                "{\n" .
                                Basics::addSpaces(4) . "public \$db_host = \"{$_POST['f_host']}\";\n\n" .
                                Basics::addSpaces(4) . "public \$db_username = \"{$_POST['f_username']}\";\n\n" .
                                Basics::addSpaces(4) . "public \$db_password = \"{$_POST['f_password']}\";\n\n" .
                                Basics::addSpaces(4) . "public \$db_database = \"{$_POST['f_name']}\";\n\n" .
                                Basics::addSpaces(4) . "public \$db_prefix = \"{$_POST['f_prefix']}\";\n\n" .
                                Basics::addSpaces(4) . "public \$redirect = \"log-in.php\";\n" .
                                "}\n\n" .
                                "?>";
                    
                    
                    $temp = fopen("../classes/settings.php", "wb");
                    
                    if (fwrite($temp, $settings))
                    {
                        fclose($temp);
                        
                        require_once '../classes/connection.php';
                        
                        $conn = new Connection();
                        
                        mysql_select_db($conn->db_database);
                        $conn->dropTable("users");
                        $conn->createTable(
                                "users",
                                "(
                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                  `username` varchar(20) NOT NULL,
                                  `password` varchar(40) NOT NULL,
                                  `privilegies` int(1) NOT NULL,
                                  `status` tinyint(1) NOT NULL DEFAULT '1',
                                  PRIMARY KEY (`id`)
                                 )
                                 ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2"
                        );
                        $conn->insertData(
                                "users",
                                "`id`, `username`, `password`, `privilegies`",
                                "1, 'Administrator', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', 1"
                        );
                        $conn->dropTable('blocked');
                        $conn->createTable(
                                "blocked",
                                "(
                                  `user_id` int(10) NOT NULL,
                                  `users_blocked` text NOT NULL,
                                  PRIMARY KEY (`user_id`)
                                )
                                ENGINE=MyISAM DEFAULT CHARSET=utf8;"
                        );
                        $conn->dropTable('messages');
                        $conn->createTable(
                                "messages",
                                "(
                                  `message_id` int(10) NOT NULL AUTO_INCREMENT,
                                  `user_id` int(10) NOT NULL,
                                  `user_ip` varchar(255) NOT NULL,
                                  `message_time` varchar(255) NOT NULL,
                                  `message` text NOT NULL,
                                  PRIMARY KEY (`message_id`)
                                )
                                ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;"
                        );

                        mysql_close($connected);

                        echo Basics::addSpaces(7) . "<div class='content' style='height: 170px;'>\n";
                        echo Basics::addSpaces(9) . "<p>Congratulations! You have installed <strong>" . Basics::$INF_TITLE . "</strong>!</p>\n";
                        echo Basics::addSpaces(9) . "<p style='height: 45px;'>Your administrative username is: <strong>Administrator</strong>, and passwords is <strong>qwerty123</strong>.\n";
                        echo Basics::addSpaces(9) . "<p>Be sure to change it as soon as posible.</p>\n";
                        echo Basics::addSpaces(9) . "<p>Go <a href='../index.php'>back</a> to start using it!</p>\n";
                        echo Basics::addSpaces(9) . "<p>And don't forget to remove the install folder and reset CHMOD.</p>\n";
                        echo Basics::addSpaces(7) . "</div>\n";
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "Error. Failed to edit the file/s..");
                    }
                }
                else
                {
                    $security->displayError(Basics::addSpaces(7), "Error. Database couldn't be created (insuficent rights) or doesn't exist.");
                    echo Basics::addSpaces(7) . "<div class='content'>Go <a href='index.php'>back</a> and fix it.</div>\n";
                }
            }
            else
            {
                $security->displayError(Basics::addSpaces(7), "Error. Database information you provided is not correct.");
                echo Basics::addSpaces(7) . "<div class='content'>Go <a href='index.php'>back</a> and fix it.</div>\n";
            }
        }
        else
        {
            $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
            echo Basics::addSpaces(7) . "<div class='content'>Go <a href='index.php'>back</a> and fix it.</div>\n";
        }
    }
}

// Include theme.
require_once 'includes/theme.php';

?>
