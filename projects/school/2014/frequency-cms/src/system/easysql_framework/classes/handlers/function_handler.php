<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: function_handler.php                          *|
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

class FunctionHandler
{
    // "Function Expression" Array.

    private $expArray = array
    (
        "*"      => "/^\*$/i",
        "avg"    => "/^AVG\(.*?\)$/i",
        "count"  => "/^COUNT\(.*?\)$/i",
        "first"  => "/^FIRST\(.*?\)$/i",
        "last"   => "/^LAST\(.*?\)$/i",
        "min"    => "/^MIN\(.*?\)$/i",
        "max"    => "/^MAX\(.*?\)$/i",
        "sum"    => "/^SUM\(.*?\)$/i",
        "ucase"  => "/^UCASE\(.*?\)$/i",
        "upper"  => "/^UPPER\(.*?\)$/i",
        "lcase"  => "/^LCASE\(.*?\)$/i",
        "lower"  => "/^LOWER\(.*?\)$/i",
        "mid"    => "/^MID\(.*?\)$/i",
        "len"    => "/^LEN\(.*?\)$/i",
        "round"  => "/^ROUND\(.*?\)$/i",
        "now"    => "/^NOW\(\)$/i",
        "format" => "/^FORMAT\(.*?\)$/i"
    );

    // "Main" Methods.

    public function handleFunction($value)
    {
        // Handle specific functions

        if (preg_match($this->expArray["format"], $value)) // Handle "format" function.
        {
            $temp = substr(stripslashes($value), 7, -1);

            $splitValue = preg_split("/,/", $temp);

            if (count($splitValue) == 2)
            {
                // Remove certain characters.

                $splitValue[0] = preg_replace("/`/", "", $splitValue[0]); // Remove "`" if there are any.
                $splitValue[1] = preg_replace("/'/", "", $splitValue[1]); // Remove "'" if there are any.

                // Handle split values.

                $splitValue[0] = @mysql_real_escape_string(trim($splitValue[0]));
                $splitValue[1] = @mysql_real_escape_string(trim($splitValue[1]));

                if (!$this->isFunction($splitValue[0]))
                    $splitValue[0] = "`{$splitValue[0]}`";

                // Reformat the function.

                $value = "FORMAT({$splitValue[0]}, '{$splitValue[1]}')";
            }
        }

        return $value;
    }

    // "Is" Methods.

    public function isFunction($value)
    {
        $isValue  = false;

        foreach ($this->expArray as $arrayKey => $arrayValue)
        {
            if ($isValue) // Break the loop if it's a function.
                break;

            $isValue = preg_match($arrayValue, $value);	
        }

        return $isValue;
    }
}

?>