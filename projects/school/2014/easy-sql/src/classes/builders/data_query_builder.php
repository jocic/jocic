<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: data_query_builder.php                        *|
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

class DataQueryBuilder
{
    // Class "Constants".

    const SQL_SELECT = 0;
    const SQL_INSERT = 1;
    const SQL_UPDATE = 2;
    const SQL_DELETE = 3;
	
    // "Build" Methods.

    public function buildTableSelection($object)
    {
        $selection = "";

        if ($object instanceof TableSelection)
        {
            $count = $object->countTables();

            for ($i = 0; $i < $count; $i ++)
            {
                if ($i > 0) $selection .= ", ";

                $tblName = $object->getTableAt($i);

                if (preg_match("/\./i", $tblName)) // If it contains a ".", don't use "`".
                {
                    $tmpArray = explode(".", $tblName);

                    for($i = 0; $i < 2; $i ++)
                    {
                        if ($i > 0)
                            $selection .= ".";

                        if ($tmpArray[$i] == "*")
                            $selection .= $tmpArray[$i];
                        else
                            $selection .= "`{$tmpArray[$i]}`";
                    }
                }
                else
                    $selection .= "`" . EasyCore::getTablePrefix() . "$tblName`";
            }
        }

        return $selection;
    }

    public function buildColumnSelection($object)
    {
        $selection = "";

        if ($object instanceof ColumnSelection)
        {
            $funcHndlr = new FunctionHandler();

            $count = $object->countColumns();

            for ($i = 0; $i < $count; $i ++)
            {
                if ($i > 0) $selection .= ", ";

                $column = $object->getColumnAt($i); // Fetch column.

                if ($funcHndlr->isFunction($column))
                    $selection .= $funcHndlr->handleFunction($column);
                else
                    $selection .= "`" . $column . "`";
            }
        }

        return $selection;
    }

    public function buildValues($object)
    {
        $values = "";

        if ($object instanceof ValueSelection)
        {
            for ($i = 0; $i < $object->countValues(); $i ++)
            {
                if ($i > 0)
                    $values .= ', ';

                $values .= "'" . $object->getValueAt($i) . "'";
            }

            $values = "$values";
        }
        else new Error("DataQueryBuilder", "Wrong object was used in the method <i>buildValues</i>.");

        return $values;
    }

    public function buildArguments($object)
    {
        $argumentLine = "";

        if ($object instanceof ArgumentSelection)
        {
            $rawArguments = $object->getArguments();

            if ($rawArguments != null)
            {
                foreach ($rawArguments as $value)
                {
                    if ($value instanceof Argument)
                    {
                        $para = $value->getArgument();

                        $argumentLine .= "`{$para[0]}` {$para[1]} '{$para[2]}'";
                    }
                    else
                    {
                        $value = @mysql_real_escape_string($value); // Filter, just in case.

                        $argumentLine .= " $value ";
                    }
                }
            }
        }

        return $argumentLine;
    }

    public function buildQuery($params = null)
    {
        $params = func_get_args();

        $query = ""; // Query.

        $opt   = null; // Option.
        $ts    = null; // Table Selection.
        $cs    = null; // Column Selection.
        $vls   = null; // Values.
        $args  = null; // Arguments.

        $tmp_1 = null; // Temp. variable #1.
        $tmp_2 = null; // Temp. variable #2.

        foreach ($params as $value) // Fetch Information.
        {
            if (is_int($value))
            {
                $opt = $value;
            }
            else if ($value instanceof TableSelection)
            {
                $ts = $this->buildTableSelection($value);
            }
            else if ($value instanceof ColumnSelection)
            {
                $tmp_1 = $value;

                $cs = $this->buildColumnSelection($value);
            }
            else if ($value instanceof ValueSelection)
            {
                $tmp_2 = $value;

                $vls = $this->buildValues($value);
            }
            else if ($value instanceof ArgumentSelection)
            {
                $args = $this->buildArguments($value);
            }
        }

        // Build Query.

        $vh = new ValueHandler();

        if ($opt == self::SQL_INSERT)
        {
            $ts  = $vh->handleValue($ts);
            $cs  = $vh->handleValue($cs);

            $query = "INSERT INTO $ts ($cs) VALUES ($vls)";
        }
        else if ($opt == self::SQL_UPDATE)
        {
            $sel = ""; // Selection.

            $columnCount = $tmp_1->countColumns();

            if ($columnCount == $tmp_2->countValues())
            {
                for ($i = 0; $i < $columnCount; $i ++)
                {
                    if ($i > 0)
                        $sel .= ", ";

                    $col = $vh->handleValue($tmp_1->getColumnAt($i));

                    if (strtolower($tmp_2->getValueAt($i)) == "increment")
                        $sel .= "`$col` = `$col` + '1'";
                    else
                        $sel .= "`$col` = '" . $tmp_2->getValueAt($i) . "'";
                }
            }
            else new Notice("DataQueryBuilder", "Query for updating couldn't be built. Column and value count need to be equal.");

            $ts   = $vh->handleValue($ts);
            $args = $vh->handleValue($args);

            $query = "UPDATE $ts SET $sel WHERE $args";
        }
        else if ($opt == self::SQL_SELECT)
        {
            $ts   = $vh->handleValue($ts);
            $cs   = $vh->handleValue($cs);
            $args = $vh->handleValue($args);

            $query = "SELECT $cs FROM $ts";

            if ($args != "")
                $query .= " WHERE $args";
        }
        else if ($opt == self::SQL_DELETE)
        {
            $ts   = $vh->handleValue($ts);
            $args = $vh->handleValue($args);

            $query = "DELETE FROM $ts WHERE $args";
        }

        return $query;
    }
}

?>