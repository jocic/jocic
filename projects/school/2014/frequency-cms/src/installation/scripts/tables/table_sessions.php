<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_sessions.php                            *|
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

// Create "Sessions" Variables.

$tblSessions = new EasyTable();
$fkSessions  = new EasyForeignKey();

// "Table Sessions" Variable Settings.

$tblSessions->setName("sessions");

$tblSessions->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblSessions->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("token"),
        ColumnType::useVarChar(40),
        ColumnNull::notAllowed()
    )
);

$tblSessions->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("users_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblSessions->addPrimaryKey(new EasyPrimaryKey("id"));
$tblSessions->addIndex(new EasyIndex("sessions_fk", "users_id", true));
$tblSessions->addForeignKey($fkSessions);

// "Foreign Key Sessions" Variable Settings.

$fkSessions->setName("sessions_fk");
$fkSessions->setForeignKeyColumn("users_id");
$fkSessions->setReferenceTable("users");
$fkSessions->setReferenceColumn("id");
$fkSessions->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkSessions->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblSessions);

?>