<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_user_personals.php                      *|
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

$tblUserPersonals = new EasyTable();
$fkUserPersonals  = new EasyForeignKey();

// "Table User Personals" Variable Settings.

$tblUserPersonals->setName("user_personals");

$tblUserPersonals->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblUserPersonals->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("prefered_language"),
        ColumnType::useVarChar(2),
        ColumnNull::notAllowed()
    )
);

$tblUserPersonals->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("profile_status"),
        ColumnType::useVarChar(150),
        ColumnNull::notAllowed()
    )
);

$tblUserPersonals->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("bio"),
        ColumnType::useText(),
        ColumnNull::notAllowed()
    )
);

$tblUserPersonals->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("avatar"),
        ColumnType::useVarChar(255),
        ColumnNull::notAllowed()
    )
);

$tblUserPersonals->addPrimaryKey(new EasyPrimaryKey("id"));
$tblUserPersonals->addForeignKey($fkUserPersonals);

// "Foreign Key User Personals" Variable Settings.

$fkUserPersonals->setName("user_personals_fk");
$fkUserPersonals->setForeignKeyColumn("id");
$fkUserPersonals->setReferenceTable("users");
$fkUserPersonals->setReferenceColumn("id");
$fkUserPersonals->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkUserPersonals->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblUserPersonals);

?>