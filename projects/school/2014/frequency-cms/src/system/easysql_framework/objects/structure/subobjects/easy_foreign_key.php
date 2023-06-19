<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_foreign_key.php                          *|
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

class EasyForeignKey
{
    // "Class" Constants.

    const OPT_CASCADE   = 0; // Default Mode.
    const OPT_SET_NULL  = 1;
    const OPT_NO_ACTION = 2;
    const OPT_RESTRICT  = 3;

    // "Core" Variables.

    private $fkName	= null;
    private $fkOldName  = null;
    private $fkColumn   = null;
    private $refTable   = null;
    private $refColumn  = null;
    private $onDelValue = null;
    private $onUpdValue = null;
	
    // "Set" Methods.

    public function setName($value)
    {
        $this->fkName = @mysql_real_escape_string($value);
    }

    public function setOldName($value)
    {
        $this->fkOldName = @mysql_real_escape_string($value);
    }

    public function setForeignKeyColumn($value)
    {
        $this->fkColumn = @mysql_real_escape_string($value);
    }
	
    public function setReferenceTable($value)
    {
        if (preg_match("/\./i", $value)) // If it contains a ".", don't use "`".
        {
            $tmpArray = explode(".", $value);

            $value    = null;

            for($i = 0; $i < 2; $i ++)
            {
                if ($i > 0)
                    $value .= ".";

                $value .= "`" . @mysql_real_escape_string($tmpArray[$i]) . "`";
            }
        }
        else
            $value = "`" . EasyCore::getTablePrefix() . @mysql_real_escape_string($value) . "`";

        $this->refTable = $value;
    }
	
    public function setReferenceColumn($value)
    {
        $this->refColumn = "`" . @mysql_real_escape_string($value) . "`";
    }
	
    public function setOnDeleteValue($value)
    {
        $this->onDelValue = $this->setChangable($value);
    }

    public function setOnUpdateValue($value)
    {
        $this->onUpdValue = $this->setChangable($value);
    }
	
    private function setChangable($value)
    {
        if ($value == self::OPT_CASCADE)
            return "CASCADE";
        else if ($value == self::OPT_SET_NULL)
            return "SET NULL";
        else if ($value == self::OPT_NO_ACTION)
            return "NO ACTION";
        else if ($value == self::OPT_RESTRICT)
            return "RESTRICT";
        else
            new Error("EasyForeignKey", "You have used a wrong value in the method <i>setChangable</i>.");
    }

    // "Get" Methods.

    public function getName() { return $this->fkName; }

    public function getOldName()
    {
        if ($this->fkOldName == null)
            return $this->fkName;
        else
            return $this->fkOldName;
    }
	
    public function getForeignKeyColumn() { return $this->fkColumn; }

    public function getReferenceTable() { return $this->refTable; }

    public function getReferenceColumn() { return $this->refColumn; }

    public function getOnDeleteValue() { return $this->onDelValue; }

    public function getOnUpdateValue() { return $this->onUpdValue; }
}

?>