<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_shoutbox.php                            *|
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

$tblShoutbox = new EasyTable();
$fkShoutbox  = new EasyForeignKey();

// "Table Shoutbox" Variable Settings.

$tblShoutbox->setName("shoutbox");

$tblShoutbox->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblShoutbox->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("timestamp"),
        ColumnType::useTimeStamp(),
        ColumnNull::notAllowed(),
        ColumnValue::useCurrentTimeStampValue()
    )
);

$tblShoutbox->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("content"),
        ColumnType::useVarChar(255),
        ColumnNull::notAllowed()
    )
);

$tblShoutbox->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("poster_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblShoutbox->addPrimaryKey(new EasyPrimaryKey("id"));
$tblShoutbox->addForeignKey($fkShoutbox);

// "Foreign Key Shoutbox" Variable Settings.

$fkShoutbox->setName("shoutbox_fk");
$fkShoutbox->setForeignKeyColumn("poster_id");
$fkShoutbox->setReferenceTable("users");
$fkShoutbox->setReferenceColumn("id");
$fkShoutbox->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkShoutbox->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblShoutbox);

?>