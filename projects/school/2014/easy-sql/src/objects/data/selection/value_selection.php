<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: values.php                                    *|
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

class ValueSelection
{
    // "Options" Constants.
    
    const OPT_DEFAULT = 0;
    const OPT_ENCODE  = 1;
    
    // "Core" Variables.

    private $values = null;
    private $option = 0;

    // "Constructor/s".

    public function __construct($params = null)
    {
        if ($params != null)
        {
            if (is_array($params))
                $this->addValues($params);
            else
                $this->addValues(func_get_args());
        }
    }
	
    // "Add" Methods.

    public function addValue($value)
    {   
        if ($this->getOption() == self::OPT_ENCODE)
            $this->values[] = @mysql_real_escape_string(htmlentities($value));
        else
            $this->values[] = @mysql_real_escape_string($value);
    }

    public function addValues($values)
    {
        if (is_array($values))
        {
            foreach ($values as $value)
                $this->addValue($value);
        }
        else $this->addValues(func_get_args());
    }
	
    // "Remove" Methods.

    public function removeValueAt($position)
    {
        unset($this->values[$position]);

        $this->values = array_values($this->values);
    }
	
    public function removeAllValues()
    {
        $this->values = null;
    }
	
    // "Set" Methods.

    public function setValueAt($position, $value)
    {
        if ($this->option == self::OPT_ENCODE)
            $this->values[$position] = @mysql_real_escape_string($value);
        else
            $this->values[$position] = @mysql_real_escape_string($value);
    }
    
    public function setOption($opt)
    {
        $this->option = $opt;
    }

    // "Get" Methods.

    public function getValueAt($position)
    {
        return $this->values[$position];
    }

    public function getValues()
    {
        return $this->values;
    }
    
    public function getOption()
    {
        return $this->option;
    }

    // "Count" Methods.

    public function countValues()
    {
        return count($this->values);
    }
}

?>