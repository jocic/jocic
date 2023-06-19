<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_insert.php                               *|
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

class EasyInsert
{
    // "Core" Variables.

    private static $OBJ_TBL_SEL = null;
    private static $OBJ_COL_SEL = null;
    private static $OBJ_VALUES  = null;

    // "Set" Methods.

    public static function setTableSelection($params = null)
    {
        $params = func_get_args();

        $ts = new TableProcessor();

        self::$OBJ_TBL_SEL = $ts->processVariable($params);
    }
	
    public static function setColumnSelection($params = null)
    {
        $params = func_get_args();

        $cs = new ColumnProcessor();

        self::$OBJ_COL_SEL = $cs->processVariable($params);
    }
	
    public static function setValueSelection($params = null)
    {
        $params = func_get_args();

        $vs = new ValueProcessor();

        self::$OBJ_VALUES = $vs->processVariable($params);
    }
	
    public static function setParameters($params = null)
    {
        $queryBuilder = new DataQueryBuilder();

        // Processors.

        $tp = new TableProcessor();
        $cp = new ColumnProcessor();
        $vp = new ValueProcessor();

        if (!is_array($params))
            $params = func_get_args();

        foreach ($params as $value)
        {
            if (is_object($value))
            {
                if ($value instanceof TableSelection)
                    self::$OBJ_TBL_SEL = $value;

                else if ($value instanceof ColumnSelection)
                    self::$OBJ_COL_SEL = $value;

                else if ($value instanceof ValueSelection)
                    self::$OBJ_VALUES = $value;

                else new Error("EasyInsert", "You have used a wrong object in the method <i>setParameters</i>.");
            }
            else if (is_string($value))
            {
                if ($tp->isTableSelection($value))
                    self::$OBJ_TBL_SEL = $tp->processVariable($value);

                else if ($cp->isColumnSelection($value))
                    self::$OBJ_COL_SEL = $cp->processVariable($value);

                else if ($vp->isValueSelection($value))
                    self::$OBJ_VALUES = $vp->processVariable($value);
            }
            else
                new Error("EasyInsert", "Parameters in the method <i>setParameters</i> must be objects or strings.");
        }
    }
	
    // "Get" Methods.

    public static function getTableSelection()
    {
        return self::$OBJ_TBL_SEL;
    }
	
    public static function getColumnSelection()
    {
        return self::$OBJ_COL_SEL;
    }
	
    public static function getValueSelection()
    {
        return self::$OBJ_VALUES;
    }
	
    public static function getParameters()
    {
        return array(self::$OBJ_TBL_SEL, self::$OBJ_COL_SEL, self::$OBJ_VALUES);
    }
	
    // "Other" Methods.

    public static function execute($params = null)
    {
        if ($params != null)
        {
            $params = func_get_args();

            self::setParameters($params);
        }

        // Check Control Variables.

        if (self::$OBJ_TBL_SEL == null || self::$OBJ_COL_SEL == null || self::$OBJ_VALUES == null)
            new Error("EasyInsert", "Key parameters for query execution are missing.");

        // Build the final Query.

        $queryBuilder = new DataQueryBuilder();

        $query = $queryBuilder->buildQuery
        (
            DataQueryBuilder::SQL_INSERT,
            self::$OBJ_TBL_SEL,
            self::$OBJ_COL_SEL,
            self::$OBJ_VALUES
        );

        new DebugInfo("EasyInsert", $query); // Print debug info.

        // Perform the Query.

        $result = @mysql_query($query);

        if (!$result)
            new Error("EasyInsert", "The query could not be run.");

        // Reset Core Variables.

        self::$OBJ_TBL_SEL = null;
        self::$OBJ_COL_SEL = null;
        self::$OBJ_VALUES  = null;
    }
}

?>