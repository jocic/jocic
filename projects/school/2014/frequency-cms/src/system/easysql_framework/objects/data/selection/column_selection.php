<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: column_selection.php                          *|
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

class ColumnSelection
{
    // "Core" Variables.

    private $columns = null;

    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
        {
            if (is_array($value))
                $this->addColumns($value);
            else
                $this->addColumns(func_get_args());
        }
    }

    // "Add" Methods.

    public function addColumn($column) { $this->columns[] = @mysql_real_escape_string(trim($column)); }

    public function addColumns($columns)
    {
        if (is_array($columns))
        {
            foreach ($columns as $value)
                $this->addColumn($value);
        }
        else $this->addColumns(func_get_args());
    }

    // "Remove" Methods.

    public function removeColumnAt($position)
    {
        unset($this->columns[$position]);

        $this->columns = array_values($this->columns);
    }

    public function removeAllColumns()
    {
        $this->columns = null;
    }

    // "Get" Methods.

    public function getColumnAt($position) { return $this->columns[$position]; }

    public function getColumns() { return $this->columns; }

    // "Set" Methods.

    public function setColumnAt($position, $column) { $this->columns[$position] = @mysql_real_escape_string($column); }

    // "Other" Methods.

    public function countColumns() { return count($this->columns); }
}

?>