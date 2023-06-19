<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_assets.php                              *|
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

// Row "Leaderboard 728x90 One".

EasyInsert::execute
(
    new TableSelection("assets"),
    new ColumnSelection("type", "name", "filename"),
    new ValueSelection(array(0, "Leaderboard 728x90 One", "aff28e587ea3f3128b3bf73fcfa74b09fdb18905.png"))
);

// Row "Leaderboard 728x90 Two".

EasyInsert::execute
(
    new TableSelection("assets"),
    new ColumnSelection("type", "name", "filename"),
    new ValueSelection(array(0, "Leaderboard 728x90 Two", "4874a74d62be5fb4dcb5c2cee61c710b0016506e.png"))
);

// Row "Leaderboard 728x90 Three".

EasyInsert::execute
(
    new TableSelection("assets"),
    new ColumnSelection("type", "name", "filename"),
    new ValueSelection(array(0, "Leaderboard 728x90 Three", "be7dc2fd2b05418dbc660a9b267696e61c605459.png"))
);

// Row "Half Banner 234x60 One".

EasyInsert::execute
(
    new TableSelection("assets"),
    new ColumnSelection("type", "name", "filename"),
    new ValueSelection(array(0, "Half Banner 200x60 One", "f50ecf28c3b2a272534579ed5a49b9c10031941b.png"))
);

// Row "Half Banner 234x60 Two".

EasyInsert::execute
(
    new TableSelection("assets"),
    new ColumnSelection("type", "name", "filename"),
    new ValueSelection(array(0, "Half Banner 200x60 Two", "c21c62e3253c8a53710893bb92475bfb543ec639.png"))
);

// Row "Half Banner 234x60 Three".

EasyInsert::execute
(
    new TableSelection("assets"),
    new ColumnSelection("type", "name", "filename"),
    new ValueSelection(array(0, "Half Banner 200x60 Three", "2a52e95826e9f09d4dac931103814aaec5f92125.png"))
);

?>