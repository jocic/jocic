<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_core_pages.php                          *|
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

// Row "Homepage".

EasyInsert::execute
(
    new TableSelection("core_pages"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("homepage", $varJunkLatinFull))
);

// Row "Terms Of Service".

EasyInsert::execute
(
    new TableSelection("core_pages"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("terms-of-service", $varJunkLatinFull))
);

// Row "Privacy Policy".

EasyInsert::execute
(
    new TableSelection("core_pages"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("privacy-policy", $varJunkLatinFull))
);

?>