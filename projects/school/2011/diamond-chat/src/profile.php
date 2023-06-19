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
require_once 'classes/connection.php';
require_once 'classes/user.php';
require_once 'classes/security.php';

if (isset($_GET['option']))
{
    if ($_GET['option'] == 'password') $title = "Password Change";
    else if ($_GET['option'] == 'block') $title = "Block a User";
    else if ($_GET['option'] == 'unblock') $title = "Unlock a User";
    else if ($_GET['option'] == 'ban') $title = "Ban a User";
    else if ($_GET['option'] == 'unban') $title = "Unban a User";
    else die(header("Location: log-in.php"));
}
else die(header("Location: log-in.php"));

// Page content.
function insertPageContent()
{
    $security = new Security();

    if (!$security->checkLoginCookies() || !$security->checkCookieData())
    {
        setcookie('username', null);
        setcookie('password', null);
        setcookie('token', null);

        die(header("Location: log-in.php"));
    }
    else
    {
        if (isset($_GET['option']))
        {
            $conn = new User($_COOKIE['username'], $_COOKIE['password']);
            
            if ($_GET['option'] == 'password')
            {
                if ($_POST == null)
                {
                    echo Basics::addSpaces(7) . "<div class='content'>\n";
                    echo Basics::addSpaces(9) . "<h3>Change your password!</h3>\n";
                    echo Basics::addSpaces(7) . "<form name='log-in' method='post' action   ='{$_SERVER['PHP_SELF']}?option=password'>\n";
                    echo Basics::addSpaces(9) . "<div class='left'>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'>New password:</p>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'>New password (re-enter):</p>\n";
                    echo Basics::addSpaces(9) . "</div>\n";
                    echo Basics::addSpaces(9) . "<div class='right'>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='password' class='box' type='password' name='f_password' maxlength='20' /></p>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='password-re' class='box' type='password' name='f_password_re' maxlength='30' /></p>\n";
                    echo Basics::addSpaces(9) . "</div>\n";
                    echo Basics::addSpaces(11) . "<p><input class='button' style='margin-top: 5px;' type='submit' name='f_submit' value='Change' /></p>\n";
                    echo Basics::addSpaces(7) . "</form>\n";
                    echo Basics::addSpaces(7) . "<p style='float: left;'>Or go <a href='chat.php'>back</a> to chat.</p>\n";
                    echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
                    echo Basics::addSpaces(7) . "</div>\n";
                    echo Basics::addSpaces(7) . "<script>focus('password');</script>\n";
                }
                else
                {
                    if ($security->checkRequestMethod('post') &&
                        $security->checkFormPost(array('f_password', 'f_password_re', 'f_submit')) &&
                        $security->checkNullPost(array('f_password', 'f_password_re', 'f_submit')))
                    {
                        if ($_POST['f_password'] == $_POST['f_password_re'])
                        {
                            if (strlen($_POST['f_password']) > 7 && strlen($_POST['f_password']) <= 30 && $security->checkInput($_POST['f_password'], 'alpha'))
                            {
                                $connection = mysql_connect($conn->db_host, $conn->db_username, $conn->db_password);

                                if ($connection)
                                {
                                    mysql_select_db($conn->db_database);

                                    $_POST['f_password'] = sha1($_POST['f_password']);

                                    $conn->updatePassword($_POST['f_password'], $conn->getId());
                                    
                                    echo Basics::addSpaces(7) . "<div class='content'>\n";
                                    echo Basics::addSpaces(9) . "<h3>Congratulations!</h3>\n";
                                    echo Basics::addSpaces(9) . "<p>You have changed your password.</p>\n";
                                    echo Basics::addSpaces(9) . "<p style='margin: 5px 0 0 0;'>Go <a href='log-in.php'>back</a> to start using it!</p>\n";
                                    echo Basics::addSpaces(7) . "</div>\n";

                                    mysql_close($connection);
                                }
                                else
                                {
                                    $security->displayError(Basics::addSpaces(7), "Error. Failed to connect.");
                                    echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='profile.php?option=password'>back</a>.</div>\n";
                                }
                            }
                            else
                            {
                                $security->displayError(Basics::addSpaces(7), "Your password needs to be atleast 7 - 30 characters long. Also it needs to be made from <strong>alpha-numeric</strong> characters.");
                                echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=password'>back</a> and fix it.</div>\n";
                            }
                        }
                        else
                        {
                            $security->displayError(Basics::addSpaces(7), "Your passwords are not equal.");
                            echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=password'>back</a> and fix it.</div>\n";
                        }
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
                        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=password'>back</a> and fix it.</div>\n";
                    }
                }
            }
            else if ($_GET['option'] == 'block')
            {
                if ($_POST == null)
                {
                    echo Basics::addSpaces(7) . "<div class='content'>\n";
                    echo Basics::addSpaces(9) . "<h3>Block a user.</h3>\n";
                    echo Basics::addSpaces(7) . "<form name='log-in' method='post' action='{$_SERVER['PHP_SELF']}?option=block'>\n";
                    echo Basics::addSpaces(9) . "<div class='left'>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'>His / Hers handle:</p>\n";
                    echo Basics::addSpaces(9) . "</div>\n";
                    echo Basics::addSpaces(9) . "<div class='right'>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='username' class='box' type='text' name='f_username' maxlength='20' /></p>\n";
                    echo Basics::addSpaces(9) . "</div>\n";
                    echo Basics::addSpaces(11) . "<p><input class='button' style='margin-top: 5px;' type='submit' name='f_submit' value='Block' /></p>\n";
                    echo Basics::addSpaces(7) . "</form>\n";
                    echo Basics::addSpaces(7) . "<p style='float: left;'>Or go <a href='chat.php'>back</a> to chat.</p>\n";
                    echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
                    echo Basics::addSpaces(7) . "</div>\n";
                    echo Basics::addSpaces(7) . "<script>focus('username');</script>\n";
                }
                else
                {
                    if ($security->checkRequestMethod('post') &&
                        $security->checkFormPost(array('f_username', 'f_submit')) &&
                        $security->checkNullPost(array('f_username', 'f_submit')))
                    {
                        if (strlen($_POST['f_username']) > 3 && strlen($_POST['f_username']) <= 20 && $security->checkInput($_POST['f_username'], 'alpha'))
                        {
                            $connection = mysql_connect($conn->db_host, $conn->db_username, $conn->db_password);

                            if ($connection)
                            {
                                mysql_select_db($conn->db_database);
                                
                                // Geting id of a blocked user.
                                $blockedId = $conn->getData("users", "username", $_POST['f_username']);
                                
                                if (mysql_num_rows($blockedId) != 0)
                                {
                                    $userId = $conn->getId();

                                    $blocked = $conn->getData("blocked", "user_id", $userId);
                                    
                                    $rowOne = mysql_fetch_row($blockedId);
                                    $rowTwo = mysql_fetch_row($blocked);

                                    if (strpos($rowTwo[1], $rowOne[0]) === false)
                                    {
                                        if ($rowOne[0] != $userId)
                                        {
                                            if (mysql_num_rows($blocked) == 0)
                                            {
                                                $conn->insertData(
                                                        "blocked",
                                                        "user_id, users_blocked",
                                                        "'$userId', '$rowOne[0]'"
                                                );
                                            }
                                            else
                                            {
                                                $conn->updateBlocked($rowTwo[0], $rowTwo[1] . $rowOne[0]);
                                            }

                                            echo Basics::addSpaces(7) . "<div class='content'>\n";
                                            echo Basics::addSpaces(9) . "<h3>User blocked!</h3>\n";
                                            echo Basics::addSpaces(9) . "<p>You've just blocked user <strong>{$_POST['f_username']}</strong>.</p>\n";
                                            echo Basics::addSpaces(9) . "<p style='margin: 5px 0 0 0;'>Go <a href='chat.php'>back</a> to chat!</p>\n";
                                            echo Basics::addSpaces(7) . "</div>\n";
                                        }
                                        else
                                        {
                                            $security->displayError(Basics::addSpaces(7), "You can't block yourself.");
                                            echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=block'>here</a>.</div>\n";
                                        }
                                    }
                                    else
                                    {
                                        $security->displayError(Basics::addSpaces(7), "You already blocked that user.");
                                        echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=block'>here</a>.</div>\n";
                                    }
                                }
                                else
                                {
                                    $security->displayError(Basics::addSpaces(7), "User with such a handle does not exist!");
                                    echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=block'>here</a>.</div>\n";
                                }

                                mysql_close($connection);
                            }
                            else
                            {
                                $security->displayError(Basics::addSpaces(7), "Error. Failed to connect.");
                                echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='profile.php?option=block'>here</a>.</div>\n";
                            }
                        }
                        else
                        {
                            $security->displayError(Basics::addSpaces(7), "User handle needs to be atleast 3 - 20 characters long. Also it needs to be made from <strong>alpha-numeric</strong> characters.");
                            echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=block'>back</a> and fix it.</div>\n";
                        }
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
                        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=block'>back</a> and fix it.</div>\n";
                    }
                }
            }
            else if ($_GET['option'] == 'unblock')
            {
                if ($_POST == null)
                {
                    echo Basics::addSpaces(7) . "<div class='content'>\n";
                    echo Basics::addSpaces(9) . "<h3>Unblock a user.</h3>\n";
                    echo Basics::addSpaces(7) . "<form name='log-in' method='post' action='{$_SERVER['PHP_SELF']}?option=unblock'>\n";
                    echo Basics::addSpaces(9) . "<div class='left'>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'>His / Hers handle:</p>\n";
                    echo Basics::addSpaces(9) . "</div>\n";
                    echo Basics::addSpaces(9) . "<div class='right'>\n";
                    echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='username' class='box' type='text' name='f_username' maxlength='20' /></p>\n";
                    echo Basics::addSpaces(9) . "</div>\n";
                    echo Basics::addSpaces(11) . "<p><input class='button' style='margin-top: 5px;' type='submit' name='f_submit' value='Unblock' /></p>\n";
                    echo Basics::addSpaces(7) . "</form>\n";
                    echo Basics::addSpaces(7) . "<p style='float: left;'>Or go <a href='chat.php'>back</a> to chat.</p>\n";
                    echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
                    echo Basics::addSpaces(7) . "</div>\n";
                    echo Basics::addSpaces(7) . "<script>focus('username');</script>\n";
                }
                else
                {
                    if ($security->checkRequestMethod('post') &&
                        $security->checkFormPost(array('f_username', 'f_submit')) &&
                        $security->checkNullPost(array('f_username', 'f_submit')))
                    {
                        if (strlen($_POST['f_username']) > 3 && strlen($_POST['f_username']) <= 20 && $security->checkInput($_POST['f_username'], 'alpha'))
                        {
                            $connection = mysql_connect($conn->db_host, $conn->db_username, $conn->db_password);

                            if ($connection)
                            {
                                mysql_select_db($conn->db_database);
                                
                                // Geting id of user to be blocked.
                                $blockedId = $conn->getData("users", "username", $_POST['f_username']);
                                
                                if (mysql_num_rows($blockedId) != 0)
                                {
                                    $userId = $conn->getId();

                                    $list = $conn->getData("blocked", "user_id", $userId);
                                    
                                    $rowOne = mysql_fetch_row($blockedId);
                                    
                                    if (mysql_num_rows($list) != 0)
                                    {
                                        $rowTwo = mysql_fetch_row($list);
                                        
                                        $conn->updateBlocked($rowTwo[0], str_replace($rowOne[0], '', $rowTwo[1]));
                                        
                                        echo Basics::addSpaces(7) . "<div class='content'>\n";
                                        echo Basics::addSpaces(9) . "<h3>User unblocked!</h3>\n";
                                        echo Basics::addSpaces(9) . "<p>You've just unblocked user <strong>{$_POST['f_username']}</strong>.</p>\n";
                                        echo Basics::addSpaces(9) . "<p style='margin: 5px 0 0 0;'>Go <a href='log-in.php'>back</a> now!</p>\n";
                                        echo Basics::addSpaces(7) . "</div>\n";
                                    }
                                    else
                                    {
                                        $security->displayError(Basics::addSpaces(7), "Your blocked list is empty");
                                        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='chat.php'>back</a> to chat.</div>\n";
                                    }
                                }
                                else
                                {
                                    $security->displayError(Basics::addSpaces(7), "User with such a handle does not exist!");
                                    echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=unblock'>here</a>.</div>\n";
                                }

                                mysql_close($connection);
                            }
                            else
                            {
                                $security->displayError(Basics::addSpaces(7), "Error. Failed to connect.");
                                echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='profile.php?option=unblock'>here</a>.</div>\n";
                            }
                        }
                        else
                        {
                            $security->displayError(Basics::addSpaces(7), "User handle needs to be atleast 3 - 20 characters long. Also it needs to be made from <strong>alpha-numeric</strong> characters.");
                            echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=unblock'>back</a> and fix it.</div>\n";
                        }
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
                        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=unblock'>back</a> and fix it.</div>\n";
                    }
                }
            }
            else if ($_GET['option'] == 'ban')
            {
                $connection = mysql_connect($conn->db_host, $conn->db_username, $conn->db_password);

                if ($connection)
                {
                    mysql_select_db($conn->db_database);
                    $result = ($conn->getData("users", "username", $_COOKIE['username']));
                    $row = mysql_fetch_row($result);
                
                    if ($row[3] == 1)
                    {
                        if ($_POST == null)
                        {
                            echo Basics::addSpaces(7) . "<div class='content'>\n";
                            echo Basics::addSpaces(9) . "<h3>Ban a user.</h3>\n";
                            echo Basics::addSpaces(7) . "<form name='log-in' method='post' action   ='{$_SERVER['PHP_SELF']}?option=ban'>\n";
                            echo Basics::addSpaces(9) . "<div class='left'>\n";
                            echo Basics::addSpaces(11) . "<p style='height: 40px;'>His / Hers handle:</p>\n";
                            echo Basics::addSpaces(9) . "</div>\n";
                            echo Basics::addSpaces(9) . "<div class='right'>\n";
                            echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='username' class='box' type='text' name='f_username' maxlength='20' /></p>\n";
                            echo Basics::addSpaces(9) . "</div>\n";
                            echo Basics::addSpaces(11) . "<p><input class='button' style='margin-top: 5px;' type='submit' name='f_submit' value='Ban a User' /></p>\n";
                            echo Basics::addSpaces(7) . "</form>\n";
                            echo Basics::addSpaces(7) . "<p style='float: left;'>Or go <a href='chat.php'>back</a> to chat.</p>\n";
                            echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
                            echo Basics::addSpaces(7) . "</div>\n";
                            echo Basics::addSpaces(7) . "<script>focus('username');</script>\n";
                        }
                        else
                        {
                            if ($security->checkRequestMethod('post') &&
                                $security->checkFormPost(array('f_username', 'f_submit')) &&
                                $security->checkNullPost(array('f_username', 'f_submit')))
                            {
                                if (strlen($_POST['f_username']) > 3 && strlen($_POST['f_username']) <= 20 && $security->checkInput($_POST['f_username'], 'alpha'))
                                {       
                                    $userId = $conn->getId();

                                    $banned = $conn->getData("users", "username", $_POST['f_username']);

                                    if (mysql_num_rows($banned) != 0)
                                    {
                                        $row = mysql_fetch_row($banned);

                                        if ($row[0] != $userId)
                                        {
                                            if ($row[4] != 0)
                                            {
                                                $conn->banUnban($row[0], "0");

                                                echo Basics::addSpaces(7) . "<div class='content'>\n";
                                                echo Basics::addSpaces(9) . "<h3>User banned!</h3>\n";
                                                echo Basics::addSpaces(9) . "<p>You've just banned user <strong>{$_POST['f_username']}</strong>.</p>\n";
                                                echo Basics::addSpaces(9) . "<p style='margin: 5px 0 0 0;'>Go <a href='chat.php'>back</a> to chat!</p>\n";
                                                echo Basics::addSpaces(7) . "</div>\n";
                                            }
                                            else
                                            {
                                                $security->displayError(Basics::addSpaces(7), "User is already banned.");
                                                echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=ban'>here</a>.</div>\n";
                                            }
                                        }
                                        else
                                        {
                                            $security->displayError(Basics::addSpaces(7), "You can't ban yourself.");
                                            echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=ban'>here</a>.</div>\n";
                                        }
                                    }
                                    else
                                    {
                                        $security->displayError(Basics::addSpaces(7), "User with such a handle does not exist!");
                                        echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=ban'>here</a>.</div>\n";
                                    }
                                }
                                else
                                {
                                    $security->displayError(Basics::addSpaces(7), "User handle needs to be atleast 3 - 20 characters long. Also it needs to be made from <strong>alpha-numeric</strong> characters.");
                                    echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=ban'>back</a> and fix it.</div>\n";
                                }
                            }
                            else
                            {
                                $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
                                echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=ban'>back</a> and fix it.</div>\n";
                            }
                        }
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "You don't have enough privilegies.");
                        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='chat.php'>back</a> to chat.</div>\n";
                    }
                    
                    mysql_close($connection);
                }
                else
                {
                    $security->displayError(Basics::addSpaces(7), "Error. Failed to connect.");
                    echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='profile.php?option=ban'>here</a>.</div>\n";
                }
            }
            else if ($_GET['option'] == 'unban')
            {
                $connection = mysql_connect($conn->db_host, $conn->db_username, $conn->db_password);

                if ($connection)
                {
                    mysql_select_db($conn->db_database);
                    $result = ($conn->getData("users", "username", $_COOKIE['username']));
                    $row = mysql_fetch_row($result);
                
                    if ($row[3] == 1)
                    {
                        if ($_POST == null)
                        {
                            echo Basics::addSpaces(7) . "<div class='content'>\n";
                            echo Basics::addSpaces(9) . "<h3>Unban a user.</h3>\n";
                            echo Basics::addSpaces(7) . "<form name='log-in' method='post' action   ='{$_SERVER['PHP_SELF']}?option=unban'>\n";
                            echo Basics::addSpaces(9) . "<div class='left'>\n";
                            echo Basics::addSpaces(11) . "<p style='height: 40px;'>His / Hers handle:</p>\n";
                            echo Basics::addSpaces(9) . "</div>\n";
                            echo Basics::addSpaces(9) . "<div class='right'>\n";
                            echo Basics::addSpaces(11) . "<p style='height: 40px;'><input id='username' class='box' type='text' name='f_username' maxlength='20' /></p>\n";
                            echo Basics::addSpaces(9) . "</div>\n";
                            echo Basics::addSpaces(11) . "<p><input class='button' style='margin-top: 5px;' type='submit' name='f_submit' value='Unban a User' /></p>\n";
                            echo Basics::addSpaces(7) . "</form>\n";
                            echo Basics::addSpaces(7) . "<p style='float: left;'>Or go <a href='chat.php'>back</a> to chat.</p>\n";
                            echo Basics::addSpaces(7) . "<div class='clr'></div>\n";
                            echo Basics::addSpaces(7) . "</div>\n";
                            echo Basics::addSpaces(7) . "<script>focus('username');</script>\n";
                        }
                        else
                        {
                            if ($security->checkRequestMethod('post') &&
                                $security->checkFormPost(array('f_username', 'f_submit')) &&
                                $security->checkNullPost(array('f_username', 'f_submit')))
                            {
                                if (strlen($_POST['f_username']) > 3 && strlen($_POST['f_username']) <= 20 && $security->checkInput($_POST['f_username'], 'alpha'))
                                {       
                                    $userId = $conn->getId();

                                    $banned = $conn->getData("users", "username", $_POST['f_username']);

                                    if (mysql_num_rows($banned) != 0)
                                    {
                                        $row = mysql_fetch_row($banned);

                                        if ($row[0] != $userId)
                                        {
                                            if ($row[4] != 1)
                                            {
                                                $conn->banUnban($row[0], "1");

                                                echo Basics::addSpaces(7) . "<div class='content'>\n";
                                                echo Basics::addSpaces(9) . "<h3>User unbanned!</h3>\n";
                                                echo Basics::addSpaces(9) . "<p>You've just unbanned user <strong>{$_POST['f_username']}</strong>.</p>\n";
                                                echo Basics::addSpaces(9) . "<p style='margin: 5px 0 0 0;'>Go <a href='chat.php'>back</a> to chat!</p>\n";
                                                echo Basics::addSpaces(7) . "</div>\n";
                                            }
                                            else
                                            {
                                                $security->displayError(Basics::addSpaces(7), "User is not banned.");
                                                echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=unban'>here</a>.</div>\n";
                                            }
                                        }
                                        else
                                        {
                                            $security->displayError(Basics::addSpaces(7), "You can't unban yourself.");
                                            echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=unban'>here</a>.</div>\n";
                                        }
                                    }
                                    else
                                    {
                                        $security->displayError(Basics::addSpaces(7), "User with such a handle does not exist!");
                                        echo Basics::addSpaces(7) . "<div class='content'>Try again by clicking <a href='profile.php?option=unban'>here</a>.</div>\n";
                                    }
                                }
                                else
                                {
                                    $security->displayError(Basics::addSpaces(7), "User handle needs to be atleast 3 - 20 characters long. Also it needs to be made from <strong>alpha-numeric</strong> characters.");
                                    echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=unban'>back</a> and fix it.</div>\n";
                                }
                            }
                            else
                            {
                                $security->displayError(Basics::addSpaces(7), "Error. Something went wrong or you left some form fields blank.");
                                echo Basics::addSpaces(7) . "<div class='content'>Go <a href='profile.php?option=unban'>back</a> and fix it.</div>\n";
                            }
                        }
                    }
                    else
                    {
                        $security->displayError(Basics::addSpaces(7), "You don't have enough privilegies.");
                        echo Basics::addSpaces(7) . "<div class='content'>Go <a href='chat.php'>back</a> to chat.</div>\n";
                    }
                    
                    mysql_close($connection);
                }
                else
                {
                    $security->displayError(Basics::addSpaces(7), "Error. Failed to connect.");
                    echo Basics::addSpaces(7) . "<div class='content'>Try again later by clicking <a href='profile.php?option=unban'>here</a>.</div>\n";
                }
            }
        }
    }
}

// Include theme.
require_once 'includes/theme.php';

?>