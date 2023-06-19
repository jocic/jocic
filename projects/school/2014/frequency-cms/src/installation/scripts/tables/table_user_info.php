<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_user_info.php                           *|
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

$tblUserProfile = new EasyTable();
$fkUserInfo  = new EasyForeignKey();

// "Table User Info" Variable Settings.

$tblUserProfile->setName("user_info");

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("name"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("middle_name"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("surname"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("gender"),
        ColumnType::useEnum("0, 1, 2"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("birthday"),
        ColumnType::useDate(),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("email"),
        ColumnType::useVarChar(150),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("first_ip"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("last_ip"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblUserProfile->addPrimaryKey(new EasyPrimaryKey("id"));
$tblUserProfile->addForeignKey($fkUserInfo);

// "Foreign Key User Info" Variable Settings.

$fkUserInfo->setName("user_info_fk");
$fkUserInfo->setForeignKeyColumn("id");
$fkUserInfo->setReferenceTable("users");
$fkUserInfo->setReferenceColumn("id");
$fkUserInfo->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkUserInfo->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblUserProfile);

?>