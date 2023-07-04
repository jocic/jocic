<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_alter.php                                *|
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

class EasyAlter
{
    // "Core" Variables.

    private static $STR_OBJECT = null;

    // "Core" Methods.

    public static function setStructure($obj)
    {
        if ($obj != null)
        {
            if ($obj instanceof EasySchema ||
                $obj instanceof EasyTable ||
                $obj instanceof EasyView)
            {
                self::$STR_OBJECT = $obj;
            }
            else
                new Error("EasyAlter", "You have used a wrong object in the method <i>setStructure</i>.");
        }
    }
	
    public static function getStructure()
    {
        return self::$STR_OBJECT;
    }
	
    public static function unsetStructure()
    {
        self::$STR_OBJECT = null;;
    }

    public static function rename($newName)
    {
        if (self::$STR_OBJECT instanceof EasySchema)
        {
            $newSchema = new EasySchema($newName); // Because it checks the name.

            $oldName = self::$STR_OBJECT->getName();
            $newName = $newSchema->getName(); // Get filtered name.

            // Make a temp. copy of the settings.

            $tmpMode = EasyCreate::getMode();

            // Step #1 - Create new schema.

            EasyCreate::setMode(EasyCreate::ECM_DO_NOTHING_IF_EXISTS);
            EasyCreate::execute(new EasySchema($newName));

            // Step #2 - Fetch all table names.

            $data = EasyGet::execute
            (
                new ColumnSelection("TABLE_NAME"),
                new TableSelection("information_schema.TABLES"),
                new ArgumentSelection(new Argument("TABLE_SCHEMA", "=", self::$STR_OBJECT->getName()))
            );

            // Step #3 - Rename all the tables.

            if ($data != null)
            {
                foreach ($data as $value)
                {
                    $query = "RENAME TABLE `$oldName`.`" . $value[0] . "` TO `$newName`." . $value[0];

                    new DebugInfo("EasyAlter", $query); // Print debug info.

                    $result = @mysql_query($query); // Rename the table.

                    if (!$result)
                            new Error("EasyAlter", "The query could not be run.");
                }
            }

            // Step #4 - Drop the old schema.

            EasyDrop::execute(self::$STR_OBJECT);

            // Step #5 - Set the new schema.

            EasyAlter::setStructure($newSchema);

            // Restore the old settings.

            EasyCreate::setMode($tmpMode);
        }
        else if (self::$STR_OBJECT instanceof EasyTable)
        {
            $newTable = new EasyTable($newName); // Because it checks the name.

            $oldName = EasyCore::getTablePrefix() . self::$STR_OBJECT->getName();
            $newName = EasyCore::getTablePrefix() . $newTable->getName(); // Get filtered name.
            $sm      = EasyCore::getSchemaName();

            // Step #1 - Perform renaming.

            $query = "RENAME TABLE `$sm`.`$oldName` TO `$sm`.`$newName`";

            new DebugInfo("EasyAlter", $query); // Print debug info.

            $result = @mysql_query($query); // Rename the table.

            if (!$result)
                new Error("EasyAlter", "The query could not be run.");

            // Step #2 - Set the new schema.

            EasyAlter::setStructure($newTable);
        }
        else if (self::$STR_OBJECT instanceof EasyView)
        {
            $newView = new EasyView($newName); // Because it checks the name.

            $oldName = EasyCore::getViewPrefix() . self::$STR_OBJECT->getName();
            $newName = EasyCore::getViewPrefix() . $newView->getName(); // Get filtered name.
            $sm      = EasyCore::getSchemaName();

            // Step #1 - Perform renaming.

            $query = "RENAME TABLE `$sm`.`$oldName` TO `$sm`.`$newName`";

            new DebugInfo("EasyAlter", $query); // Print debug info.

            $result = @mysql_query($query); // Rename the table.

            if (!$result)
                new Error("EasyAlter", "The query could not be run.");

            // Step #2 - Set the new schema.

            EasyAlter::setStructure($newView);
        }
    }
	
    // Specific "Rename" Methods.

    public static function renameSchema($oldName, $newName)
    {
        // Make a temp. copy of the parameters.

        $tmpStrObj = self::getStructure();

        // Perform renaming.

        self::setStructure(new EasySchema($oldName));

        EasyAlter::rename($newName);

        // Restor the old parameters.

        self::setStructure($tmpStrObj);
    }
	
    public static function renameTable($oldName, $newName)
    {
        // Make a temp. copy of the paramters.

        $tmpStrObj = self::getStructure();

        // Perform renaming.

        self::setStructure(new EasyTable($oldName));

        EasyAlter::rename($newName);

        // Restor the old parameters.

        self::setStructure($tmpStrObj);
    }
	
    public static function renameView($oldName, $newName)
    {
        // Make a temp. copy of the paramters.

        $tmpStrObj = self::getStructure();

        // Perform renaming.

        self::setStructure(new EasyView($oldName));

        EasyAlter::rename($newName);

        // Restor the old parameters.

        self::setStructure($tmpStrObj);
    }
	
    // "Add" Methods.

    public static function add($obj)
    {
        if (self::getStructure() instanceof EasyTable)
        {
            if ($obj instanceof EasyColumn ||
                $obj instanceof EasyIndex ||
                $obj instanceof EasyPrimaryKey ||
                $obj instanceof EasyForeignKey)
            {
                $queryBuilder = new StructureQueryBuilder();

                $query = $queryBuilder->getQuery(self::$STR_OBJECT, $obj, StructureQueryBuilder::TP_ALTER_ADD);

                new DebugInfo("EasyAlter", $query); // Print debug info.

                $result = @mysql_query($query); // Drop the table if exists.

                if (!$result)
                    new Error("EasyAlter", "The query could not be run.");
            }
        }
        else
            new Notice("EasyAlter", "You can only use the method <i>add()</i> for EasyTable.");
    }
	
    public static function addColumn($obj)
    {
        if ($obj instanceof EasyColumn)
            self::add($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>addColumn</i>.");
    }

    public static function addIndex($obj)
    {
        if ($obj instanceof EasyIndex)
            self::add($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>addIndex</i>.");
    }

    public static function addPrimaryKey($obj)
    {
        if ($obj instanceof EasyPrimaryKey)
            self::add($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>addPrimaryKey</i>.");
    }

    public static function addForeignKey($obj)
    {
        if ($obj instanceof EasyForeignKey)
            self::add($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>addForeignKey</i>.");
    }
    
    // "Change" Methods.

    public static function change($obj)
    {
        if ($obj instanceof EasyColumn ||
            $obj instanceof EasyIndex ||
            $obj instanceof EasyPrimaryKey ||
            $obj instanceof EasyForeignKey)
        {
            $queryBuilder = new StructureQueryBuilder();

            $query = $queryBuilder->getQuery(self::$STR_OBJECT, $obj, StructureQueryBuilder::TP_ALTER_CHANGE);

            new DebugInfo("EasyAlter", $query); // Print debug info.

            $result = @mysql_query($query); // Drop the table if exists.

            if (!$result)
                new Error("EasyAlter", "The query could not be run.");
        }
    }
	
    public static function changeColumn($obj)
    {
        if ($obj instanceof EasyColumn)
            self::change($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>changeColumn</i>.");
    }

    public static function changeIndex($obj)
    {
        if ($obj instanceof EasyIndex)
            self::change($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>changeColumn</i>.");
    }
	
    public static function changePrimaryKey($obj)
    {
        if ($obj instanceof EasyPrimaryKey)
            self::change($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>changePrimaryKey</i>.");
    }
	
    public static function changeForeignKey($obj)
    {
        if ($obj instanceof EasyForeignKey)
            self::change($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>changePrimaryKey</i>.");
    }
	
    // Specific "Change" Methods.

    public static function changeView($obj)
    {
        if ($obj instanceof EasyView)
        {
            $queryBuilder = new StructureQueryBuilder();

            $query = $queryBuilder->getQuery($obj, StructureQueryBuilder::TP_ALTER_CHANGE);

            new DebugInfo("EasyAlter", $query); // Print debug info.

            $result = @mysql_query($query); // Drop the table if exists.

            if (!$result)
                new Error("EasyAlter", "The query could not be run.");
        }
        else
            new Notice("EasyAlter", "You didn't use a correct object in the method <i>changeView</i>");
    }
	
    // "Remove" Methods.

    public static function remove($obj)
    {
        if ($obj instanceof EasyColumn ||
            $obj instanceof EasyIndex ||
            $obj instanceof EasyPrimaryKey ||
            $obj instanceof EasyForeignKey)
        {
            $queryBuilder = new StructureQueryBuilder();

            $query = $queryBuilder->getQuery(self::$STR_OBJECT, $obj, StructureQueryBuilder::TP_ALTER_DROP);

            new DebugInfo("EasyAlter", $query); // Print debug info.

            $result = @mysql_query($query); // Drop the table if exists.

            if (!$result)
                    new Error("EasyAlter", "The query could not be run.");
        }
    }
	
    public static function removeColumn($obj)
    {
        if ($obj instanceof EasyColumn)
            self::remove($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>removeColumn</i>.");
    }
	
    public static function removeIndex($obj)
    {
        if ($obj instanceof EasyIndex)
            self::remove($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>removeIndex</i>.");
    }
	
    public static function removePrimaryKey($obj = null)
    {
        self::remove(new EasyPrimaryKey());
    }
	
    public static function removeForeignKey($obj)
    {
        if ($obj instanceof EasyForeignKey)
            self::remove($obj);
        else
            new Error("EasyAlter", "You have used a wrong object in the method <i>removeForeignKey</i>.");
    }
}

?>