<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_index.php                                *|
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

class EasyIndex
{
    // "Core" Variables.

    private $indexName    = null;
    private $indexOldName = null;
    private $columnName   = null;
    private $uniqueValue  = false;

    // Constructor/s.

    public function __construct($params = null)
    {
        $params = func_get_args();

        if ($params != null)
        {
            if (count($params) == 3)
            {
                $this->setName($params[0]);

                if (count($params) > 1)
                    $this->setColumnName($params[1]);

                if (count($params) > 2)
                    $this->setUniqueValue($params[2]);
            }
            else
                new Notice("EasyIndex", "You need to pass three parameters in the constructor. Order is important.");
        }
    }

    // "Set" Methods.

    public function setName($value)
    {
        $this->indexName = @mysql_real_escape_string($value);
    }

    public function setOldName($value)
    {
        $this->indexOldName = @mysql_real_escape_string($value);
    }

    public function setColumnName($value)
    {
        $this->columnName = @mysql_real_escape_string($value);
    }

    public function setUniqueValue($value)
    {
        if (is_bool($value))
            $this->uniqueValue = $value;
        else
            new Notice("EasyIndex", "Value in the method <i>setUniqueValue</i> must be true or false. Default is false.");
    }

    // "Get" Methods.

    public function getName() { return $this->indexName; }

    public function getOldName()
    {
        if ($this->indexName == null)
            return $this->indexName;
        else
            return $this->indexOldName;
    }

    public function getColumnName() { return $this->columnName; }

    public function getUniqueValue() { return $this->uniqueValue; }
}

?>