<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: column_name.php                               *|
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

class ColumnName
{
    // "Core" Variables.

    private $columnName = null;

    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
            $this->setValue($value);
    }

    // "Use" Methods.

    public static function useName($value) { return new self($value); }

    public static function useValue($value) { return new self($value); }

    // "Set" Methods.

    public function setName($value)
    {
        if (!is_string($value))
                new Error("ColumnName", "Column name must be string.");
        else if (strlen($value) > 30)
                new Error("ColumnName", "Column name must be between 1 and 30 characters.");
        else if (!preg_match("/^[a-z0-9_#$]+$/", $value))
                new Error("ColumnName", "Column name constains illegal characters. You can use A-Z, 0-9, _, $ and #.");

        $this->columnName = @mysql_real_escape_string($value);
    }

    public function setValue($value)
    {
        self::setName($value);
    }

    // "Get" Methods.

    public function getName() { return $this->columnName; }

    public function getValue() { return $this->columnName; }
}

?>