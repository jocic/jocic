<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_table.php                                *|
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

class EasyTable
{
    // "Core" Variables.

    private $schema    = null;
    private $tableName = null;
    private $columns   = null;
    private $primKey   = null;
    private $index     = null;
    private $forKey    = null;

    // Constructor/s.

    public function __construct($name = null)
    {
        if ($name != null)
            $this->setName($name);
    }
	
    // "Add" Methods.

    public function addColumn($columnObject)
    {
        if ($columnObject instanceof EasyColumn)
            $this->columns[] = $columnObject;
        else
            new Notice("EasyTable", "You have used a wrong object in the method <i>addColumn</i>.");
    }
	
    public function addColumns($objectArray)
    {
        foreach ($objectArray as $object)
            $this->addColumn($object);
    }
	
    public function addPrimaryKey($pkObject)
    {
        if ($pkObject instanceof EasyPrimaryKey)
            $this->primKey = $pkObject;
        else
            new Error("EasyTable", "You must use a correct object in the method <i>addPrimaryKey/setPrimaryKey</i>.");
    }
	
    public function addIndex($indexObject)
    {
        if ($indexObject instanceof EasyIndex)
            $this->index = $indexObject;
        else
            new Error("EasyTable", "You must use a correct object in the method <i>addIndex</i>.");
    }
	
    public function addForeignKey($fkObject)
    {
        if ($fkObject instanceof EasyForeignKey)
            $this->forKey = $fkObject;
        else
            new Error("EasyTable", "You must use a correct object in the method <i>addForeignKey</i>.");
    }

    // "Remove" Methods.

    public function removeColumnAt($position)
    {
        unset($this->columns[$position]); // Remove a column.

        $this->columns = array_values($this->columns); // Reset array ident. values.
    }
	
    public function removeAllColumns()
    {
        $this->columns = null;
    }
	
    public function removePrimaryKey()
    {
        $this->primKey = null;
    }
	
    public function removeIndex()
    {
        $this->index = null;
    }
	
    public function removeForeignKey()
    {
        $this->forKey = null;
    }
	
    // "Set" Methods.

    public function setSchemaName($value)
    {
        if (!is_string($value))
                new Error("EasyTable", "Table name must be string.");
        else if (strlen($value) > 30)
                new Error("EasyTable", "Table name must be between 1 and 30 characters.");
        else if (!preg_match("/^[a-z0-9_#$]+$/", $value))
                new Error("EasyTable", "Table name constains illegal characters. You can use A-Z, 0-9, _, $ and #.");

        $this->schema = @mysql_real_escape_string($value);
    }
	
    public function setName($value)
    {
        if (!is_string($value))
                new Error("EasyTable", "Table name must be string.");
        else if (strlen($value) > 30)
                new Error("EasyTable", "Table name must be between 1 and 30 characters.");
        else if (!preg_match("/^[a-z0-9_#$]+$/", $value))
                new Error("EasyTable", "Table name constains illegal characters. You can use A-Z, 0-9, _, $ and #.");

        $this->tableName = @mysql_real_escape_string($value);
    }
	
    public function setColumnAt($params = null)
    {
        $params = func_get_args($params);

        if ($params == null)
            new Notice("EasyTable", "You didn't pass any values in the <i>setColumnAt</i> method.");
        else
        {
            if (count($params) == 2)
            {
                if ($params[0] instanceof EasyColumn)
                {
                    if (is_numeric($params[1]))
                        $this->columns[$params[1]] = $params[0];
                    else
                        new Notice("EasyTable", "Wrong set of params in <i>setColumnAt</i> method.");
                }
                else if ($params[1] instanceof EasyColumn)
                {
                    if (is_numeric($params[0]))
                        $this->columns[$params[0]] = $params[1];
                    else
                        new Notice("EasyTable", "Wrong set of params in <i>setColumnAt</i> method.");
                }
                else
                    new Notice("EasyTable", "You have used <i>setColumnAt</i> methods in a wrong way.");
            }
            else
                new Notice("EasyTable", "You have used <i>setColumnAt</i> methods in a wrong way.");
        }
    }
	
    public function setPrimaryKey($pkObject)
    {
        $this->addPrimaryKey($pkObject);
    }
	
    public function setIndex($indexObject)
    {
        $this->addIndex($indexObject);
    }
	
    public function setForeignKey($fkObject)
    {
        $this->addForeignKey($fkObject);
    }
	
    // "Get" Methods.

    public function getSchemaName()
    {
        if ($this->schema == null)
            return EasyCore::getSchemaName();
        else
            return $this->schema;
    }
	
    public function getName() { return $this->tableName; }

    public function getColumns() { return $this->columns; }

    public function getColumnAt($position) { return $this->columns[$position]; }

    public function getPrimaryKey() { return $this->primKey; }

    public function getIndex() { return $this->index; }

    public function getForeignKey() { return $this->forKey; }
	
    // "Other" Methods.

    public function exists()
    {
        $arg_1 = new Argument("table_schema", "=", EasyCore::getSchemaName());
        $arg_2 = new Argument("table_name", "=", EasyCore::getTablePrefix() . $this->getName());

        EasyGet::setParameters
        (
            new ColumnSelection("*"),
            new TableSelection("information_schema.TABLES"),
            new ArgumentSelection($arg_1, Argument::AO_AND, $arg_2)
        );

        return (EasyGet::execute() != null);
    }
	
    public function countColumns() { return count($this->columns); }
}

?>