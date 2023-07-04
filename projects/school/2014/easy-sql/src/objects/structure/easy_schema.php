<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_schema.php                               *|
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

class EasySchema
{
    // "Core" Variables.

    private $schemaName = null;

    // "Constructor/s".

    public function __construct($param = null)
    {
        if ($param != null)
            $this->setName($param);
    }

    // "Set" Methods.

    public function setName($param = null)
    {
        if (!is_string($param))
            new Error("EasyTable", "Database schema must be string.");
        else if (strlen($param) > 30)
            new Error("EasyTable", "Database schema must be between 1 and 30 characters.");
        else if (!preg_match("/^[a-z0-9_#$]+$/", $param))
            new Error("EasyTable", "Database schema name constains illegal characters. You can use A-Z, 0-9, _, $ and #.");

        $this->schemaName = @mysql_real_escape_string($param);
    }
	
    // "Get" Methods.

    public function getName() { return $this->schemaName; }
	
    // "Other" Methods.

    public function exists()
    {
        EasyGet::setParameters
        (
            new ColumnSelection("*"),
            new TableSelection("information_schema.SCHEMATA"),
            new ArgumentSelection(new Argument("SCHEMA_NAME", "=", $this->getName()))
        );

        return EasyGet::execute() != null;
    }
}

?>