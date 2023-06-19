<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_pages.php                               *|
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

$tblPages = new EasyTable();

// "Table Pages" Variable Settings.

$tblPages->setName("pages");

$tblPages ->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("title"),
        ColumnType::useVarChar(255),
        ColumnNull::notAllowed()
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("description"),
        ColumnType::useText(),
        ColumnNull::notAllowed()
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("content"),
        ColumnType::useText(),
        ColumnNull::notAllowed()
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("custom_id"),
        ColumnType::useVarChar(255),
        ColumnNull::notAllowed()
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("tags"),
        ColumnType::useVarChar(255),
        ColumnNull::notAllowed()
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("published"),
        ColumnType::useEnum("0, 1"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblPages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("comments_enabled"),
        ColumnType::useEnum("0, 1"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblPages->addPrimaryKey(new EasyPrimaryKey("id"));

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblPages);

?>