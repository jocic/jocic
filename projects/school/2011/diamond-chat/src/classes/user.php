<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: user.php                                      *|
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
defined('_EXECUTION') or die();

// Include files.
require_once 'settings.php';

class User extends Connection
{
    private $username,
            $password;
    
    private $adminOptions = array(
        'Ban a User' => 'profile.php?option=ban',
        'Unban a User' => 'profile.php?option=unban'
    );
    
    private $defaultOptions = array(
        'Block User' => 'profile.php?option=block',
        'Unblock User' => 'profile.php?option=unblock',
        'Change Password' => 'profile.php?option=password',
        'Log Out' => 'index.php?option=logout'
    );
    
    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    
    public function getId()
    {
        $result = mysql_query("SELECT id FROM $this->db_prefix" . "users WHERE username = '$this->username' AND password = '$this->password'");
        $row = mysql_fetch_row($result);
        
        return $row[0];
    }
    
    public function getUsername($id)
    {
        $result = mysql_query("SELECT username FROM $this->db_prefix" . "users WHERE id = '$id'");
        $row = mysql_fetch_row($result);
        
        return $row[0];
    }
    
    public function generateOptions()
    {
        $result = mysql_query("SELECT privilegies FROM $this->db_prefix" . "users WHERE username = '$this->username' AND password = '$this->password'");
        $row = mysql_fetch_row($result);
        
        echo Basics::addSpaces(11) . "<ul>\n";
        
        if ($row[0] == 1)
        {
            foreach ($this->adminOptions as $key => $value)
                echo Basics::addSpaces(13) . "<li><a href='$value'>$key</a></li>\n";
            
            foreach ($this->defaultOptions as $key => $value)
                echo Basics::addSpaces(13) . "<li><a href='$value'>$key</a></li>\n";
        }
        else
        {
            foreach ($this->defaultOptions as $key => $value)
                echo Basics::addSpaces(13) . "<li><a href='$value'>$key</a></li>\n";
        }
        
        echo Basics::addSpaces(11) . "</ul>\n";
    }
    
    public function generateMessages()
    {
        $result = mysql_query("SELECT user_id, message_time, message, message_id FROM $this->db_prefix" . "messages ORDER BY message_id DESC");
        $resultTwo = mysql_query("SELECT users_blocked FROM $this->db_prefix" . "blocked WHERE user_id = '" . $this->getId() . "'");
        
        $rowTwo= mysql_fetch_row($resultTwo);
        
        $temp = 0;
        $number = mysql_num_rows($result);
        
        if ($number > 30) $number = 30;
        
        echo Basics::addSpaces(5) . "<table>\n";
        
        for ($i = 0; $i < $number; $i++)
        {
            $row = mysql_fetch_row($result);
            
            if (strpos($rowTwo[0], $row[0]) === false)
            {
                $username = $this->getUsername($row[0]);

                echo Basics::addSpaces(7) . "<tr>\n";
                echo Basics::addSpaces(9) . "<td class='date'>[$row[1]] | </td>\n";
                echo Basics::addSpaces(9) . "<td class='username'><span class='username$temp' align='left'>$username</span></td>\n";
                echo Basics::addSpaces(7) . "</tr>\n";
                echo Basics::addSpaces(7) . "<tr>\n";
                echo Basics::addSpaces(9) . "<td class='message' colspan='2'><p>" . htmlspecialchars($row[2]) . "</p></td>\n";
                echo Basics::addSpaces(7) . "</tr>\n";

                if ($temp == 3) $temp = 0;
                else $temp ++;
            }
        }
        
        echo Basics::addSpaces(5) . "</table>\n";
    }
    
    public function generateUsers()
    {
        $result = mysql_query("SELECT user_id, message_id FROM $this->db_prefix" . "messages ORDER BY message_id DESC");
        
        $i = 0;
        $temp = array();

        while ($row = mysql_fetch_row($result))
        {
            if ($i >= 5) break;
            
            if (!in_array($this->getUsername($row[0]), $temp))
            {
                $temp[$i] = $this->getUsername($row[0]);
                echo Basics::addSpaces(9) . "<p><strong>" . ($i + 1) . ".</strong> {$temp[$i]}</p>\n";
                $i++;
            }
        }
    }
}

?>