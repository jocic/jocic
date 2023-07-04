<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: argument.php                                  *|
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

class Argument
{
    // Class "Constants".

    const AO_AND = "AND";
    const AO_OR  = "OR";

    // "Core" Variables.

    private $argumentValues = null;

    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
        {
            if (is_array($value))
                $this->setArgument($value);
            else
                $this->setArgument(func_get_args());
        }
    }
	
    // "Add" Methods.

    private function addArgumentValue($value)
    {   
        if (is_string($value))
            $this->argumentValues[] = @mysql_real_escape_string(trim($value));
        else
            new Error("Argument", "Argument value need to be a string.");
    }
	
    // "Set" Methods.

    public function setArgument($values)
    {
        if (is_array($values))
        {
            $this->argumentValues = null;

            if (count($values) == 3)
            {
                foreach ($values as $value)
                    $this->addArgumentValue($value);
            }
            else new Notice("Argument", "Argument must consists from 3 parts.");
        }
        else $this->setArgument(func_get_args());
    }
	
    // "Get" Methods.

    public function getArgument() { return $this->argumentValues; }
}

?>