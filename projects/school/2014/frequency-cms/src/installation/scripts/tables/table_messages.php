<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_messages.php                            *|
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

$tblMessages   = new EasyTable();
$fkMessagesOne = new EasyForeignKey();
$fkMessagesTwo = new EasyForeignKey();

// "Table Messages" Variable Settings.

$tblMessages->setName("messages");

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("date_sent"),
        ColumnType::useDate(),
        ColumnNull::notAllowed()
    )
);


$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("title"),
        ColumnType::useVarChar(100),
        ColumnNull::notAllowed()
    )
);

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("content"),
        ColumnType::useText(),
        ColumnNull::notAllowed()
    )
);

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("read_status"),
        ColumnType::useEnum("0, 1"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("status"),
        ColumnType::useEnum("0, 1, 2"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("sender_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblMessages->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("receiver_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblMessages->addPrimaryKey(new EasyPrimaryKey("id"));
$tblMessages->addForeignKey($fkMessagesOne);

// "Foreign Key Messages One" Variable Settings.

$fkMessagesOne->setName("messages_fk_one");
$fkMessagesOne->setForeignKeyColumn("sender_id");
$fkMessagesOne->setReferenceTable("users");
$fkMessagesOne->setReferenceColumn("id");
$fkMessagesOne->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkMessagesOne->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// "Foreign Key Messages One" Variable Settings.

$fkMessagesTwo->setName("messages_fk_two");
$fkMessagesTwo->setForeignKeyColumn("receiver_id");
$fkMessagesTwo->setReferenceTable("users");
$fkMessagesTwo->setReferenceColumn("id");
$fkMessagesTwo->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkMessagesTwo->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblMessages);

// Append One More Constraint.

EasyAlter::setStructure($tblMessages);

EasyAlter::addForeignKey($fkMessagesTwo);

EasyAlter::unsetStructure();

?>