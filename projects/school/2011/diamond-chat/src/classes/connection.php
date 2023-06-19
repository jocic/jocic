<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: connection.php                                *|
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

class Connection extends Settings
{
    public function dropTable($tableName)
    {
        return mysql_query("DROP TABLE IF EXISTS $this->db_prefix" . "$tableName");
    }
    
    public function createTable($tableName, $data)
    {
        return mysql_query("CREATE TABLE $this->db_prefix" . "$tableName $data");
    }
    
    public function insertData($tableName, $ids, $values)
    {
            return mysql_query("INSERT INTO $this->db_prefix" . "$tableName ($ids) VALUES (" . utf8_encode($values) . ")");
    }
        
    public function updatePassword($password, $id)
    {
        return mysql_query("UPDATE $this->db_prefix" . "users SET password = '$password' WHERE id = '$id'");
    }
    
    public function updateBlocked($id, $values)
    {
        return mysql_query("UPDATE $this->db_prefix" . "blocked SET users_blocked = '$values' WHERE user_id = '$id'");
    }
    
    public function banUnban($id, $values)
    {
        return mysql_query("UPDATE $this->db_prefix" . "users SET status = '$values' WHERE id = '$id'");
    }
    
    public function getData($tableName, $field, $equals)
    {
        return mysql_query("SELECT * FROM $this->db_prefix" . "$tableName WHERE $field = '$equals'");
    }
    
    public function loginCheck($username, $password)
    {
        return mysql_query(
                   sprintf("SELECT * FROM $this->db_prefix" . "users WHERE username = '%s' AND password = '%s'",
                           mysql_real_escape_string($username), mysql_real_escape_string($password)
                   )
               );
    }
}

?>