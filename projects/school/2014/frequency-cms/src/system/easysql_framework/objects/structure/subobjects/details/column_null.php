<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: column_null.php                               *|
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

class ColumnNull
{
    // "Column Null" Constants.

    const CT_ALLOWED     = 0;
    const CT_NOT_ALLOWED = 1;

    // "Core" Variables.

    private $selOpt      = null;
	
    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
            $this->setValue($value);
    }
	
    // "Main" Methods.

    public static function allowed() { return new self(self::CT_ALLOWED); }

    public static function notAllowed() { return new self(self::CT_NOT_ALLOWED); }
	
    // "Set" Methods.

    public function setValue($value)
    {
        if ($value == self::CT_ALLOWED || $value == self::CT_NOT_ALLOWED)
            $this->selOpt = $value;
        else if (is_bool($value))
        {
            if ($value)
                $this->selOpt = self::CT_ALLOWED;
            else
                $this->selOpt = self::CT_NOT_ALLOWED;
        }
        else
            new Error("ColumnNull", "You have used a wrong value in the method <i>setValue</i>.");
    }

    // "Get" Methods.

    public function getValue()
    {
        return $this->selOpt;
    }
}

?>