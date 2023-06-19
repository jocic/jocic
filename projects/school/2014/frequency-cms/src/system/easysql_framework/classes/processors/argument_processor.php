<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: argument_processor.php                        *|
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

class ArgumentProcessor
{
    // "Is" Methods.

    public function isArgumentSelection($value)
    {
        return (strlen($value) > 5) && (strtolower(substr($value, 0, 5)) == "args:");
    }

    // "Main" Methods.

    public function processVariable($params = null)
    {
        if (!is_array($params))
            $params = func_get_args();

        $count  = count($params);

        if ($params[0] instanceof ArgumentSelection) // If it's CS, return that object
        {
            return $params[0];
        }
        else if ($count == 1 && $params[0] instanceof Argument) // If there is only one param. and that param is string.
        {
            $cs = new ArgumentSelection($params[0]);

            return $cs;
        }
        else if ($count == 1 && is_string($params[0]))
        {
            if ($this->isArgumentSelection($params[0]))
            {
                $params[0] = explode(" ", trim(substr($params[0], 5)));

                for ($i = 0; $i < count($params[0]); $i ++)
                        $params[0][$i] = trim($params[0][$i]);

                $cnt = count($params[0]);

                if ($cnt == 3)
                {
                    $params[0] = new Argument($params[0][0], $params[0][1], $params[0][2]);
                }
                if ($cnt > 3)
                {
                    $tmpArray = null;

                    while (count($params[0]) > 0)
                    {
                        if (isset($params[0][0]) &&
                            isset($params[0][1]) &&
                            isset($params[0][2]))
                        {
                            $tmpArray[] = new Argument($params[0][0], $params[0][1], $params[0][2]);

                            unset($params[0][0]);
                            unset($params[0][1]);
                            unset($params[0][2]);

                            if (isset($params[0][3]))
                            {
                                $tmpArray[] = $params[0][3];

                                unset($params[0][3]);
                            }

                            $params[0] = array_values($params[0]);
                        }
                        else
                            new Error("ArgumentProcessor", "Check your argument parameters.");
                    }

                    $params = $tmpArray;
                }
            }
            else
                $params = ":D";

            $cs = new ArgumentSelection($params);

            return $cs;
        }
        else if ($count > 1) // If user used an array.
        {
            if ($count == 3)
            {
                $params = new Argument($params[0], $params[1], $params[2]);
            }
            else if ($count > 3)
            {
                $tmpArray = null;

                while (count($params) > 0)
                {
                    if (is_string($params[0]) &&
                        is_string($params[1]) &&
                        is_string($params[2]))
                    {
                        $tmpArray[] = new Argument($params[0], $params[1], $params[2]);

                        unset($params[0]);
                        unset($params[1]);
                        unset($params[2]);

                        if (isset($params[3]))
                        {
                            $tmpArray[] = $params[3];

                            unset($params[3]);
                        }
                    }
                    else if ($params[0] instanceof Argument)
                    {
                        $tmpArray[] = $params[0];

                        unset($params[0]);

                        if (isset($params[1]))
                        {
                            $tmpArray[] = $params[1];

                            unset($params[1]);
                        }
                    }
                    else
                        new Error("ArgumentProcessor", "Check your argument parameters.");

                    $params = array_values($params);
                }

                $params = $tmpArray;
            }
            else
                new Error("ArgumentProcessor", "You need to use minimum three parameters for an Argument.");

            $cs = new ArgumentSelection($params);

            return $cs;
        }
    }
}

?>