<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_modules.php                             *|
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

// Create "Core" Variables.

$tblModules = new EasyTable();

// "Table Modules" Variable Settings.

$tblModules->setName("modules");

$tblModules->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblModules->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("block"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblModules->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("position"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblModules->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("name"),
        ColumnType::useVarChar(100),
        ColumnNull::notAllowed()
    )
);

$tblModules->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("status"),
        ColumnType::useEnum("0, 1"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblModules->addPrimaryKey(new EasyPrimaryKey("id"));
$tblModules->addIndex(new EasyIndex("name", "name", true));

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblModules);

?>