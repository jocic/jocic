<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: log-in.php                                    *|
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

// Includes.
require_once 'classes/basics.php';
require_once 'classes/security.php';
require_once 'classes/connection.php';
    
$title = "Registration";

// Start session.
session_start();

// Page content.
function insertPageContent()
{
    $security = new Security();
    
    $security->checkInstallation();
    
    if ($_POST == null)
    {
        // Simple anti-spam.
        $_SESSION['dcRegFirstNumber'] = rand(0, 9);
        $_SESSION['dcRegSecondNumber'] = rand(0, 9);
        $_SESSION['dcRegResult'] = $_SESSION['dcRegFirstNumber'] + $_SESSION['dcRegSecondNumber'];
        
        echo Basics::addSpaces(5) . "<div class='content'>\n";
        echo Basics::addSpaces(7) . "<h3>Registration Form</h3>\n";
        echo Basics::addSpaces(7) . "<form name='log-in' method='post' action='{$_SERVER['PHP_SELF']}'>\n";
        echo Basics::addSpaces(9) . "<div class='left'>\n";
        echo Basics::addSpaces(11) . "<p style='height: 40px;'>Username:</p>\n";
        echo Basics::addSpaces(11) . "<p style='height: 40px;'>Password:</p>\n";
        echo Basics::addSpaces(11) . "<p style='height: 40px;'>Simple anti-spam test:</p>\n";
        echo Basics::addSpaces(9) . "</div>\n";
        echo Basics::addSpaces(9) . "<div class='right'>\n";
        echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='username' class='box' type='text' name='f_username' maxlength='20' /></p>\n";
        echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='password' class='box' type='password' name='f_password' maxlength='30' /></p>\n";
        echo Basics::addSpaces(11) . "<p style='height: 40px;'>{$_SESSION['dcRegFirstNumber']} + {$_SESSION['dcRegSecondNumber']} = <input class='box' style='width: 50px; float: none;' type='text' name='f_antispam' maxlength='2' /></p>\n";
        echo Basics::addSpaces(9) . "</div>\n";
        echo Basics::addSpaces(11) . "<p><input class='button' type='submit' name='f_submit' value='Register' /></p>\n";
        echo Basics::addSpaces(7) . "</form>\n";
        echo Basics::addSpaces(7) . "<p>Thank you for registering!</p>\n";
        echo Basics::addSpaces(7) . "<p>If you already have an account, click <a href='log-in.php'>here</a>!</p>\n";
        echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
        echo Basics::addSpaces(5) . "</div>\n";
        echo Basics::addSpaces(5) . "<script>focus('username');</script>";
    }
    else if ((isset($_POST['f_antispam']) && isset($_SESSION['dcRegResult'])) && $_POST['f_antispam'] == $_SESSION['dcRegResult'])
    {
        unset($_SESSION['dcRegResult']);
        
        if ($security->checkRequestMethod('post') &&
            $security->checkFormPost(array('f_username', 'f_password', 'f_antispam', 'f_submit')) &&
            $security->checkNullPost(array('f_username', 'f_password', 'f_antispam', 'f_submit')))
        {
            if (strlen($_POST['f_username']) > 3  && strlen($_POST['f_username']) <= 20  && $security->checkInput($_POST['f_username'], 'alpha') &&
                strlen($_POST['f_password']) > 7 && strlen($_POST['f_password']) <= 30 && $security->checkInput($_POST['f_password'], 'alpha'))
            {
                $conn = new Connection();
                
                $connection = mysql_connect($conn->db_host, $conn->db_username, $conn->db_password);
                
                if ($connection)
                {
                    mysql_select_db($conn->db_database);
                    
                    if (mysql_num_rows($conn->getData("users", "username", $_POST['f_username'])) == 0)
                    {
                        $_POST['f_password'] = sha1($_POST['f_password']);

                        $conn->insertData(
                                "users",
                                "`id`, `username`, `password`, `privilegies`",
                                "NULL, '{$_POST['f_username']}', '{$_POST['f_password']}', 0"
                        );
                                
                        echo Basics::addSpaces(7) . "<div class='content'>\n";
                        echo Basics::addSpaces(9) . "<p>Congratulations! You can start using your account now.</p>\n";
                        echo Basics::addSpaces(9) . "<p style='margin: 5px 0 0 0;'>Go <a href='log-in.php'>back</a> to start using it!</p>\n";
                        echo Basics::addSpaces(7) . "</div>\n";
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "Sorry, that username has already been taken.");
                        echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='registration.php'>back</a>.</div>\n";
                    }
                            
                    mysql_close($connection);
                }
                else
                {
                    $security->displayError(Basics::addSpaces(7), "Error. Failed to connect.");
                    echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='registration.php'>back</a>.</div>\n";
                }
            }
            else
            {
                $security->displayError(Basics::addSpaces(7), "Error. Your <strong>username</strong> needs to be atleast 3 - 20 characters long, and your password needs to be atleast 7 - 30 characters long. Also they have to be made from <strong>alpha-numeric</strong> characters.");
                echo Basics::addSpaces(7) . "<div class='content'>Go <a href='registration.php'>back</a> and fix it.</div>\n";
            }
        }
        else
        {
            $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
            echo Basics::addSpaces(7) . "<div class='content'>Go <a href='registration.php'>back</a> and fix it.</div>\n";
        }
    }
    else
    {
        unset($_SESSION['dcRegResult']);
        
        $security->displayError(Basics::addSpaces(7), "Error. You failed the anti-spam test.");
        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='registration.php'>back</a> and fix it.</div>\n";
    }
}

// Include theme.
require_once 'includes/theme.php';

?>