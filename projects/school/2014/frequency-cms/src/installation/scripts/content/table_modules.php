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

// Row "Head Information".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("head", "1", "head_information", "1"))
);

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("head", "2", "custom_css_styles", "1"))
);

// Row "Navigation Bar".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("navigation", "1", "navigation_bar", "1"))
);

// Row "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("side-1", "1", "side_navigation_bar", "1"))
);

// Row "Pages".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("main", "1", "pages", "1"))
);

// Row "Login Module".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("side-2", "1", "login_module", "1"))
);

// Row "Shoutbox".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("side-2", "2", "shoutbox", "1"))
);

// Row "Language".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("side-2", "3", "language", "1"))
);

// Row "Footer".

EasyInsert::execute
(
    new TableSelection("modules"),
    new ColumnSelection("block", "position", "name", "status"),
    new ValueSelection(array("footer", "1", "footer", "1"))
);

?>