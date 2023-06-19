<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_column.php                               *|
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

class EasyColumn
{
    // "Core" Variables.

    private $columnName    = null;
    private $columnOldName = null;
    private $columnType    = null;
    private $columnNull    = null;
    private $columnDefault = null;
	
    // Constructor/s.

    public function __construct($value = null)
    {
        $args = func_get_args($value);

        foreach ($args as $value)
        {
            if (is_string($value))
                $this->setColumnName($value);
            else if ($value instanceof ColumnName)
                $this->setColumnNameObject($value);
            else if ($value instanceof ColumnType)
                $this->setColumnTypeObject($value);
            else if ($value instanceof ColumnNull)
                $this->setColumnNullPremittedObject($value);
            else if ($value instanceof ColumnValue)
                $this->setColumnValueObject($value);
            else
                new Error("EasyColumn", "You have used a wrong type of object in the constructor.");
        }
    }
	
    // Normal "Set" Functions.

    public function setColumnName($value)
    {
        if ($value instanceof ColumnName)
            $this->setColumnNameObject($value);
        else
        {
            if (is_string($value))
                $this->setColumnNameObject(ColumnName::useValue($value));
            else
                new Error("EasyColumn", "Name of the column must be a string.");
        }
    }
	
    public function setColumnNameObject($value)
    {
        if ($value instanceof ColumnName)
            $this->columnName = $value;
        else
            new Error("EasyColumn", "You have used a wrong object in <i>setColumnName</i> method.");
    }
	
    public function setColumnOldName($value)
    {
        if ($value instanceof ColumnName)
            $this->setColumnNameObject($value);
        else
        {
            if (is_string($value))
                $this->setColumnOldNameObject(ColumnName::useValue($value));
            else
                new Error("EasyColumn", "Name of the column must be a string.");
        }
    }
	
    public function setColumnOldNameObject($obj)
    {
        if ($obj instanceof ColumnName)
            $this->columnOldName = $obj;
        else
            new Error("EasyColumn", "You have used a wrong object in <i>setColumnNewNameObject</i> method.");
    }
	
    public function setColumnType($value)
    {
        if ($value instanceof ColumnType)
            $this->setColumnTypeObject($value);
        else
        {
            if (is_string($value))
            {
                $tmpArray = explode("->", $value);

                if (count($tmpArray) == 2)
                {
                    $ct = new ColumnType();

                    $ct->setTextualTypeIdentificator($tmpArray[0]);
                    $ct->setLengthValue($tmpArray[1]);

                    $this->setColumnTypeObject($ct);
                }
                else
                    new Error("EasyColumn", "You have used <i>setColumnType</i> method in a wrong way.");
            }
            else
                new Error("EasyColumn", "Type of the column must be a string.");
        }
    }
	
    public function setColumnTypeObject($value)
    {	
        if ($value instanceof ColumnType)
            $this->columnType = $value;
        else
            new Error("EasyColumn", "You have used a wrong object in <i>setColumnType</i> method.");
    }
	
    public function setColumnNullPremitted($value)
    {
        if ($value instanceof ColumnNull)
            $this->setColumnNullPremittedObject($value);
        else
        {
            if (is_bool($value))
            {
                $cn = new ColumnNull();

                $cn->setValue($value);

                $this->setColumnNullPremittedObject($cn);
            }
            else
                new Error("EasyColumn", "Null value can either be set to true or false.");
        }
    }
	
    public function setColumnNullPremittedObject($value)
    {
        if ($value instanceof ColumnNull)
            $this->columnNull = $value;
        else
            new Error("EasyColumn", "You have used a wrong object in <i>setColumnNullValue</i> method.");
    }
	
    public function setColumnValue($value)
    {
        if ($value instanceof ColumnValue)
            $this->setColumnValueObject($value);
        else
        {
            $cv = new ColumnValue();

            $cv->setValue($value);

            $this->setColumnValueObject($cv);
        }
    }
	
    public function setColumnValueObject($value)
    {
        if ($value instanceof ColumnValue)
            $this->columnDefault = $value;
        else
            new Error("EasyColumn", "You have used a wrong object in <i>setColumnDefaultValue</i> method.");
    }
	
    // Short "Set" Methods.

    public function setName($value)
    {
        $this->setColumnName($value);
    }
	
    public function setNameObject($object)
    {
        $this->setColumnNameObject($object);
    }
	
    public function setOldName($value)
    {
        $this->setColumnOldName($value);
    }
	
    public function setOldNameObject($object)
    {
        $this->setColumnOldNameObject($object);
    }

    public function setType($value)
    {
        $this->setColumnType($value);
    }
	
    public function setTypeObject($object)
    {
        $this->setColumnTypeObject($object);
    }

    public function setNullPremitted($value)
    {
        $this->setColumnNullPremitted($value);
    }

    public function setNullPremittedObject($object)
    {
        $this->setColumnNullPremittedObject($object);
    }

    public function setValue($value)
    {
        $this->setColumnValue($value);
    }

    public function setValueObject($object)
    {
        $this->setColumnValueObject($object);
    }
	
    // Normal "Get" Methods.

    public function getColumnName()
    {
        return $this->columnName->getName();
    }

    public function getColumnNameObject()
    {
        return $this->columnName;
    }

    public function getColumnOldName()
    {
        return $this->columnOldName->getName();
    }

    public function getColumnOldNameObject()
    {
        if ($this->columnOldName == null)
            return $this->columnName;
        else
            return $this->columnOldName;
    }
	
    public function getColumnType()
    {
        return $this->columnType->getTextualTypeIdentificator();
    }

    public function getColumnTypeObject()
    {
        return $this->columnType;
    }

    public function getColumnNullPremitted()
    {
        return $this->columnNull->getValue();
    }

    public function getColumnNullPremittedObject()
    {
        return $this->columnNull;
    }

    public function getColumnValue()
    {
        return $this->columnDefault->getValue();
    }

    public function getColumnValueObject()
    {
        return $this->columnDefault;
    }
	
    // Short "Get" Methods.

    public function getName()
    {
        return $this->getColumnName();
    }

    public function getNameObject()
    {
        return $this->getColumnNameObject();
    }

    public function getOldName()
    {
        return $this->getColumnOldName();
    }

    public function getOldNameObject()
    {
        return $this->getColumnOldNameObject();
    }

    public function getType()
    {
        return $this->getColumnType();
    }
	
    public function getTypeObject()
    {
        return $this->getColumnTypeObject();
    }

    public function getNullPremitted()
    {
        return $this->getColumnNullPremitted();
    }

    public function getNullPremittedObject()
    {
        return $this->getColumnNullPremittedObject();
    }

    public function getValue()
    {
        return $this->getColumnValue();
    }

    public function getValueObject()
    {
        return getColumnValueObject();
    }
	
    // "Other" Methods.

    public function prepareForRenaming()
    {
        $this->setColumnOldName($this->getColumnName());
    }
}

?>