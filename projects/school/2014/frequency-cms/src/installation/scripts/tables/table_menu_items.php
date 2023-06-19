<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_menu_items.php                          *|
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

$tblMenuItems = new EasyTable();
$fkMenuItems  = new EasyForeignKey();

// "Table Menu Items" Variable Settings.

$tblMenuItems->setName("menu_items");

$tblMenuItems->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblMenuItems->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("title"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblMenuItems->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("value"),
        ColumnType::useVarChar(125),
        ColumnNull::notAllowed()
    )
);

$tblMenuItems->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("type"),
        ColumnType::useEnum("0, 1, 2, 3, 4, 5"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblMenuItems->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("position"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblMenuItems->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("menu_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblMenuItems->addPrimaryKey(new EasyPrimaryKey("id"));
$tblMenuItems->addForeignKey($fkMenuItems);

// "Foreign Key Menu Items" Variable Settings.

$fkMenuItems->setName("menu_items_fk");
$fkMenuItems->setForeignKeyColumn("menu_id");
$fkMenuItems->setReferenceTable("menus");
$fkMenuItems->setReferenceColumn("id");
$fkMenuItems->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkMenuItems->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblMenuItems);

?>