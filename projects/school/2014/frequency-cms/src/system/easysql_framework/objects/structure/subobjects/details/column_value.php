<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: column_value.php                              *|
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

class ColumnValue
{
    // "Class" Constants.

    const VL_AUTO_INCREMENT    = "AUTO_INCREMENT";
    const VL_CURRENT_TIMESTAMP = "CURRENT_TIMESTAMP";

    // "Core" Variables.

    private $defaultValue = null;

    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
            $this->setValue($value);
    }

    // "Use" Methods.

    public static function useValue($value = null) { return new self($value); }

    public static function useAutoIncrementValue() { return new self(self::VL_AUTO_INCREMENT); }

    public static function useCurrentTimeStampValue() { return new self(self::VL_CURRENT_TIMESTAMP); }

    // "Set" Methods.

    public function setValue($value = null)
    {
        if (is_bool($value))
        {
            if ($value)
                $value = "1";
            else
                $value = "0";
        }

        $this->defaultValue = @mysql_real_escape_string($value);
    }

    // "Get" Methods.

    public function getValue()
    {
        return $this->defaultValue;
    }
}

?>