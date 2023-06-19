<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_selection.php                           *|
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

// Class.

class TableSelection
{
    // "Core" Variables.

    private $tables = null;

    // Constructor/s.

    public function __construct($params = null)
    {
        if ($params != null)
        {
            if (is_array($params))
                $this->addTables($params);
            else
                $this->addTables(func_get_args());
        }
    }

    // "Add" Methods.

    public function addTable($table) { $this->tables[] = @mysql_real_escape_string(trim($table)); }

    public function addTables($tables)
    {
        if (is_array($tables))
        {
            foreach ($tables as $value)
                $this->addTable($value);
        }
        else $this->addTables(func_get_args());
    }

    // "Remove" Methods.

    public function removeTableAt($position)
    {
        unset($this->tables[$position]);

        $this->tables = array_values($this->tables);
    }

    public function removeAllTables()
    {
        $this->tables = null;
    }

    // "Get" Methods.

    public function getTableAt($position) { return $this->tables[$position]; }

    public function getTables() { return $this->tables; }

    // "Set" Methods.

    public function setTableAt($position, $table) { $this->tables[$position] = @mysql_real_escape_string($table); }

    // "Count" Methods.

    public function countTables() { return count($this->tables); }
}

?>