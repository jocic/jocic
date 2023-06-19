<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: structure_query_builder.php                   *|
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

class StructureQueryBuilder
{
    // "Class" Constants.

    const TP_CREATE       = "TP_CREATE";
    const TP_ALTER_ADD    = "TP_ALTER_ADD";
    const TP_ALTER_CHANGE = "TP_ALTER_CHANGE";
    const TP_ALTER_DROP   = "TP_ALTER_DROP";
    const TP_DROP         = "TP_DROP";
    const TP_TRUNCATE     = "TP_TRUNCATE";

    // "Build" Methods. 

    private function buildColumns($columnData)
    {
        $cols = null;
        $tmp  = null; // Temp variable.

        if ($columnData != null) // Check if there is column data.
        {
            // Check if paramater is an array.

            if (!is_array($columnData))
                $columnData = array($columnData);

            for ($i = 0; $i < count($columnData); $i ++) // Loop for column creation.
            {
                if ($i > 0)
                    $cols .= ", ";

                $tmpColumn = $columnData[$i];

                // Append column name value.

                $tmpObject = $tmpColumn->getColumnNameObject();

                $line  = "`" . $tmpObject->getValue() . "` ";

                // Append column type and its length/value if it exists.

                $tmpObject = $tmpColumn->getColumnTypeObject();

                $line .= $tmpObject->getTextualTypeIdentificator();

                if (($tmp = $tmpObject->getLengthValue()) != null)
                {
                    if ($tmpObject->getTextualTypeIdentificator() == "ENUM" ||
                        $tmpObject->getTextualTypeIdentificator() == "SET") // Specific logic for "ENUM" and "SET" type.
                    {
                        $tmpArray = explode(",", $tmp);
                        $value    = "";

                        for ($j = 0; $j < count($tmpArray); $j ++)
                        {
                            if ($j > 0)
                                $value .= ", ";

                            $value .= "'" . trim(@mysql_real_escape_string($tmpArray[$j])) . "'";
                        }

                        $tmp = $value;
                    }
                    else // For everything else.
                        $tmp = @mysql_real_escape_string($tmp);

                    $line .= "(" . $tmp .")";
                }

                // Append column "null allowed" value.

                $tmpObject = $tmpColumn->getColumnNullPremittedObject();

                if ($tmpObject != null)
                {
                    if ($tmpObject->getValue() == ColumnNull::CT_ALLOWED)
                        $line .= " NULL";
                    else
                        $line .= " NOT NULL";
                }

                // Append column "default" value.

                $tmpObject = $tmpColumn->getColumnValueObject();

                if ($tmpObject != null)
                {
                    if ($tmpObject->getValue() == ColumnValue::VL_AUTO_INCREMENT)
                        $line .= " " . $tmpObject->getValue();
                    else if ($tmpObject->getValue() == ColumnValue::VL_CURRENT_TIMESTAMP)
                        $line .= " DEFAULT " . $tmpObject->getValue();
                    else if ($tmpObject->getValue() != null)
                        $line .= " DEFAULT '" . $tmpObject->getValue() . "'";
                    else
                        $line .= " DEFAULT NULL";
                }

                // Finallize.

                $cols .= $line;

                $line  = null;
            }
        }

        return $cols;
    }

    private function buildIndex($object)
    {
        $index = null;

        if ($object != null)
        {
            if ($object->getUniqueValue())
                $index .= "UNIQUE ";

            $index .= "INDEX `" . $object->getName() . "` (`" . $object->getColumnName() . "`)";
        }

        return $index;
    }

    private function buildPrimaryKey($object)
    {
        $pk = null;

        if ($object != null)
            $pk .= "PRIMARY KEY(`" . $object->getValue() . "`)";

        return $pk;
    }

    private function buildForeignKey($object)
    {
        $fk = null;

        if ($object != null)
        {
            if ($object->getName() != null)
                $fk = "CONSTRAINT `" . $object->getName() . "` ";

            $fk .= "FOREIGN KEY (`" . $object->getForeignKeyColumn() . "`) " . 
                   "REFERENCES " . $object->getReferenceTable() .
                   " (" . $object->getReferenceColumn() . ") " .
                   "ON DELETE " . $object->getOnDeleteValue() .
                   " ON UPDATE " . $object->getOnUpdateValue();
        }

        return $fk;
    }

    public function buildCreationQuery($strObj)
    {
        $query = "";

        if ($strObj instanceof EasySchema)
        {
            $query = "CREATE SCHEMA `" . $strObj->getName() . "` COLLATE utf8_general_ci";
        }
        else if ($strObj instanceof EasyTable)
        {	
            $tn       = $strObj->getName();

            $columns  = $this->buildColumns($strObj->getColumns());
            $index    = $this->buildIndex($strObj->getIndex());
            $pk       = $this->buildPrimaryKey($strObj->getPrimaryKey());
            $fk       = $this->buildForeignKey($strObj->getForeignKey());

            $eng      = EasyCreate::getEngine();
            $cs       = EasyCreate::getDefaultCharacterSet();
            $cl       = EasyCreate::getDefaultCollation();

            $addComma = false; // Control variable.

            // Merge builds.

            $tmpArray = array($columns, $index, $pk, $fk);

            $structure = null;

            for ($i = 0; $i < 4; $i ++)
            {
                if ($i > 0 && $tmpArray[$i] != null)
                    $structure .= ", ";

                $structure .= $tmpArray[$i];
            }

            if ($structure == null) // If there is no structure, show error.
                new Error("StructureQueryBuilder", "You can't create a table without at least one column.");

            // Create the query.

            $query = "CREATE TABLE `" . EasyCore::getTablePrefix() . "$tn` ($structure) ENGINE = $eng CHARACTER SET $cs COLLATE $cl";
        }
        else if ($strObj instanceof EasyView)
        {
            $tn = $strObj->getName();

            $dqb = new DataQueryBuilder();

            $structure = $dqb->buildQuery
             (
                 DataQueryBuilder::SQL_SELECT,
                 $strObj->getColumnSelection(),
                 $strObj->getTableSelection(),
                 $strObj->getArgumentSelection()
             );

            // Create the query.

            $query = "CREATE VIEW `" . EasyCore::getViewPrefix() . "$tn` AS $structure";
        }
        else
            new Notice("StructureQueryBuilder", "You have used a wrong object in the method <i>buildCreationQuery</i>.");

        return $query;
    }

    public function buildAlterationQuery($strObj, $strCnt, $type)
    {
        $query = "";

        // Step #1.

        if ($strObj instanceof EasySchema)
            new Notice("SructureQueryBuilder", "Schema altering is not supported.");
        else if ($strObj instanceof EasyTable)
            $query = "ALTER TABLE `" . EasyCore::getTablePrefix() . $strObj->getName() . "`";
        else if ($strObj instanceof EasyView)
        {
            $dqb = new DataQueryBuilder();

            $structure = $dqb->buildQuery
            (
                DataQueryBuilder::SQL_SELECT,
                $strObj->getColumnSelection(),
                $strObj->getTableSelection(),
                $strObj->getArgumentSelection()
            );

            $query = "ALTER VIEW `" . EasyCore::getViewPrefix() . $strObj->getName() . "` AS $structure";
        }

        // Step #2.

        if ($type == self::TP_ALTER_ADD)
        {
            $query .= " ADD ";

            if ($strCnt instanceof EasyColumn)
                $query .= "COLUMN " . self::buildColumns($strCnt);
            else if ($strCnt instanceof EasyIndex)
                $query .= self::buildIndex($strCnt);
            else if ($strCnt instanceof EasyPrimaryKey)
                $query .= self::buildPrimaryKey($strCnt);
            else if ($strCnt instanceof EasyForeignKey)
                $query .= self::buildForeignKey($strCnt);
        }
        else if ($type == self::TP_ALTER_CHANGE)
        {
            if ($strCnt instanceof EasyColumn)
                $query .= " CHANGE COLUMN `" . $strCnt->getColumnOldNameObject()->getValue() . "` " . self::buildColumns($strCnt);
            else if ($strCnt instanceof EasyIndex)
                $query .= " DROP INDEX `" . $strCnt->getOldName() . "`, ADD " . self::buildIndex($strCnt);
            else if ($strCnt instanceof EasyPrimaryKey)
                $query .= " DROP PRIMARY KEY, ADD " . self::buildPrimaryKey($strCnt);
            else if ($strCnt instanceof EasyForeignKey)
                $query .= " DROP FOREIGN KEY `" . $strCnt->getOldName() . "`, ADD " . self::buildForeignKey($strCnt);
        }
        else if ($type == self::TP_ALTER_DROP)
        {
            $query .= " DROP ";

            if ($strCnt instanceof EasyColumn)
                $query .= " COLUMN `" . $strCnt->getColumnNameObject()->getValue() . "`";
            else if ($strCnt instanceof EasyIndex)
                $query .= " INDEX `" . $strCnt->getName() . "`";
            else if ($strCnt instanceof EasyPrimaryKey)
                $query .= " PRIMARY KEY";
            else if ($strCnt instanceof EasyForeignKey)
                $query .= " FOREIGN KEY `" . $strCnt->getName() . "`";
        }

        return $query;
    }

    public function buildDropQuery($strObj)
    {
        $query = "";

        if ($strObj instanceof EasySchema)
            $query = "DROP SCHEMA IF EXISTS `" . $strObj->getName() . "`";
        else if ($strObj instanceof EasyTable)
            $query = "DROP TABLE IF EXISTS `" . EasyCore::getTablePrefix() . $strObj->getName() . "`";
        else if ($strObj instanceof EasyView)
            $query = "DROP VIEW IF EXISTS `" . EasyCore::getViewPrefix() . $strObj->getName() . "`";
        else
            new Error("StructureQueryBuilder", "You have used a wrong object in the method <i>buildDropQuery</i>.");

        return $query;
    }
    
    public function buildTruncateQuery($strObj)
    {
        return "TRUNCATE TABLE `" . EasyCore::getTablePrefix() . $strObj->getName() . "`";
    }

    public function getQuery($params = null)
    {
        $params = func_get_args(); // Get parameters as an array.

        $strObj = null;
        $strCnt = null;
        $type   = null;

        foreach ($params as $obj) // Go throough each param.
        {
            if ($obj instanceof EasySchema || $obj instanceof EasyTable || $obj instanceof EasyView)
                $strObj = $obj;
            else if ($obj instanceof EasyColumn ||
                     $obj instanceof EasyIndex ||
                     $obj instanceof EasyPrimaryKey ||
                     $obj instanceof EasyForeignKey)
                    $strCnt = $obj;
            else if (is_string($obj))
                $type = $obj;
        }

        if ($type == self::TP_CREATE)
            return self::buildCreationQuery($strObj);
        else if ($type == self::TP_ALTER_ADD ||
                 $type == self::TP_ALTER_DROP ||
                 $type == self::TP_ALTER_CHANGE)
            return self::buildAlterationQuery($strObj, $strCnt, $type);
        else if ($type == self::TP_DROP)
            return self::buildDropQuery($strObj);
        else if ($type == self::TP_TRUNCATE)
            return self::buildTruncateQuery($strObj);
        else
            new Error("StructureQueryBuilder", "You have used a wrong option in the method <i>getQuery</i>.");
    }
}

?>