<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_page_comments.php                       *|
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

$tblPageComments   = new EasyTable();
$fkPageCommentsOne = new EasyForeignKey();
$fkPageCommentsTwo = new EasyForeignKey();

// "Table Page Comments" Variable Settings.

$tblPageComments->setName("page_comments");

$tblPageComments ->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblPageComments->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("timestamp"),
        ColumnType::useTimeStamp(),
        ColumnNull::notAllowed(),
        ColumnValue::useCurrentTimeStampValue()
    )
);

$tblPageComments->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("content"),
        ColumnType::useVarChar(1000),
        ColumnNull::notAllowed()
    )
);

$tblPageComments ->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("page_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblPageComments ->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("sender_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblPageComments->addPrimaryKey(new EasyPrimaryKey("id"));
$tblPageComments->addForeignKey($fkPageCommentsOne);

// "Foreign Key Page Comments One" Variable Settings.

$fkPageCommentsOne->setName("page_comments_fk_one");
$fkPageCommentsOne->setForeignKeyColumn("page_id");
$fkPageCommentsOne->setReferenceTable("pages");
$fkPageCommentsOne->setReferenceColumn("id");
$fkPageCommentsOne->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkPageCommentsOne->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// "Foreign Key Page Comments Two" Variable Settings.

$fkPageCommentsTwo->setName("page_comments_fk_two");
$fkPageCommentsTwo->setForeignKeyColumn("sender_id");
$fkPageCommentsTwo->setReferenceTable("users");
$fkPageCommentsTwo->setReferenceColumn("id");
$fkPageCommentsTwo->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkPageCommentsTwo->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblPageComments);

// Append One More Constraint.

EasyAlter::setStructure($tblPageComments);

EasyAlter::addForeignKey($fkPageCommentsTwo);

EasyAlter::unsetStructure();

?>