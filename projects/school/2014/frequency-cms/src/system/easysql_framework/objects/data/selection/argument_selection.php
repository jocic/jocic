<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: argument_selection.php                        *|
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

class ArgumentSelection
{
    // "Core" Variables.

    private $normalizedArguments = null;

    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
        {
            if (is_array($value))
                $this->addArguments($value);
            else
                $this->addArguments(func_get_args());
        }
    }

    // "Add" Methods"

    public function addArgument($argument)
    {
        if ($argument instanceof Argument)
            $this->normalizedArguments[] = $argument;
        else
            $this->normalizedArguments[] = @mysql_real_escape_string($argument);
    }

    public function addArguments($arguments)
    {
        if (is_array($arguments))
            $this->normalizedArguments = $arguments;
        else
            $this->normalizedArguments = func_get_args();	

        for ($i = 0; $i < count($this->normalizedArguments); $i ++)
        {
            if (!$this->normalizedArguments[$i] instanceof Argument)
                $this->normalizedArguments[$i] = @mysql_real_escape_string($this->normalizedArguments[$i]);
        }
    }

    // "Remove" Methods.

    public function removeArgumentAt($position)
    {
        unset($this->normalizedArguments[$position]);

        $this->normalizedArguments = array_values($this->normalizedArguments);
    }

    public function removeAllArguments()
    {
        $this->normalizedArguments = null;
    }

    // "Set" Methods.

    public function setArgumentAt($position, $value)
    {
        if ($value instanceof Argument)
            $this->normalizedArguments[$position] = $value;
        else
            $this->normalizedArguments[$position] = @mysql_real_escape_string($value);
    }

    // "Get" Methods.

    public function getArgumentAt($pos)
    {
        return $this->normilizedArguments[$pos];
    }

    public function getArguments()
    {
        return $this->normalizedArguments;
    }
}

?>