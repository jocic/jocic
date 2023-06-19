<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: security.php                                  *|
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

class Security
{
    public static $COOKIES_ENABLED;
    
    public function checkLoginCookies()
    {
        if (!isset($_COOKIE['username']) || !isset($_COOKIE['password']) || !isset($_COOKIE['token']))
            return false;
        
        return true;
    }
    
    public function checkRequestMethod($usedMethod)
    {
        $usedMethod = strtoupper($usedMethod);
        
        return $_SERVER['REQUEST_METHOD'] == $usedMethod;
    }
    
    public function checkFormPost($formNames)
    {
        for ($i = 0; $i < sizeof($formNames); $i++)
            if (!isset($_POST[$formNames[$i]]))
                return false;
                
        return true;
    }
    
    public function checkFromGet($formNames)
    {
        for ($i = 0; $i < sizeof($formNames); $i++)
            if (!isset($_GET[$formNames[$i]]))
                return false;
                
        return true;
    }
    
    public function checkNullPost($formNames)
    {
        for ($i = 0; $i < sizeof($formNames); $i++)
            if ($_POST[$formNames[$i]] == null)
                return false;
                
        return true;
    }
    
    public function checkNullGet($formNames)
    {
        for ($i = 0; $i < sizeof($formNames); $i++)
            if ($_GET[$formNames[$i]] == null)
                return false;
                
        return true;
    }
    
    function checkInput($input, $type)
    {
        $input = trim($input);

        if ($type == 'alpha')
            if (preg_match('/^[a-zA-Z0-9]+$/', $input)) return true;
        else if ($type == 'page')
            if (preg_match('/^[a-z\-šđčćž]+$/', $input)) return true;
        else if ($type == 'mail')
            if (preg_match('/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+.[a-z]{2,3}$/', $input)) return true;
        else if ($type == 'title')
            if (preg_match('/^[a-zA-Z0-9.,:\- ]+$/', $input)) return true;
        else if ($type == 'msg')
            if (preg_match('/^[a-zA-Z0-9.,:\- ()]+$/', $input)) return true;

        return false;
    }
    
    // Error and notice functions.
    public function displayError($prefix, $input)
    {
        echo $prefix . "<div class='error'>\n";
        echo $prefix . Basics::addSpaces(2) . "<h3>Error!</h3>\n";
        echo $prefix . Basics::addSpaces(2) . "<p>$input</p>\n";
        echo $prefix . "</div>\n";
    }
    
    public function checkInstallation()
    {
        if (is_dir("installation"))
        {
            echo Basics::addSpaces(5) . "<div class='error'>\n";
            echo Basics::addSpaces(7) . "<h3>Warning!</h3>\n";
            echo Basics::addSpaces(7) . "<p style='text-align: center;'>For security reasons, please <strong>delete</strong> 'installation' directory.</p>\n";
            echo Basics::addSpaces(5) . "</div>\n";
        }
    }
    
    public function createToken()
    {
        return 'START DC_TOKEN ' . $_SERVER['REMOTE_ADDR'] . " - " . $_SERVER['HTTP_USER_AGENT'] . ' - END';
    }
    
    public function checkCookieData()
    {
        $temp = new Connection();
        
        $connection = mysql_connect($temp->db_host, $temp->db_username, $temp->db_password);
        
        if ($connection)
        {
            if ($_COOKIE['token'] == sha1($this->createToken()))
            {
                mysql_select_db($temp->db_database);
                
                if (mysql_num_rows($temp->loginCheck($_COOKIE['username'], $_COOKIE['password'])) == 1)
                {
                    mysql_close($connection);
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function banned()
    {
        $temp = new Connection();
        
        $connection = mysql_connect($temp->db_host, $temp->db_username, $temp->db_password);
        
        if ($connection)
        {
            if ($_COOKIE['token'] == sha1($this->createToken()))
            {
               mysql_select_db($temp->db_database);
                
               $row = mysql_fetch_row($temp->loginCheck($_COOKIE['username'], $_COOKIE['password']));
            }
            
            mysql_close($connection);
        }
        
        return $row[4];
    }
}

?>