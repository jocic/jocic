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

// Row "Demo Page 1".

EasyInsert::execute
(
    new TableSelection("pages"),
    new ColumnSelection("title", "description", "content", "custom_id", "tags", "published", "comments_enabled"),
    new ValueSelection(array("Demo Page 1", $varJunkLatinPart, $varJunkLatinFull, "demo-page-1", "default page, page 1", "1", "1"))
);

// Row "Demo Page 2".

EasyInsert::execute
(
    new TableSelection("pages"),
    new ColumnSelection("title", "description", "content", "custom_id", "tags", "published", "comments_enabled"),
    new ValueSelection(array("Demo Page 2", $varJunkLatinPart, $varJunkLatinFull, "demo-page-2", "default page, page 2", "1", "1"))
);

// Row "Demo Page 3".

EasyInsert::execute
(
    new TableSelection("pages"),
    new ColumnSelection("title", "description", "content", "custom_id", "tags", "published", "comments_enabled"),
    new ValueSelection(array("Demo Page 3", $varJunkLatinPart, $varJunkLatinFull, "demo-page-3", "default page, page 3", "1", "1"))
);

// Row "Demo Page 4".

EasyInsert::execute
(
    new TableSelection("pages"),
    new ColumnSelection("title", "description", "content", "custom_id", "tags", "published", "comments_enabled"),
    new ValueSelection(array("Demo Page 4", $varJunkLatinPart, $varJunkLatinFull, "demo-page-4", "default page, page 4", "1", "1"))
);

// Row "Demo Page 5".

EasyInsert::execute
(
    new TableSelection("pages"),
    new ColumnSelection("title", "description", "content", "custom_id", "tags", "published", "comments_enabled"),
    new ValueSelection(array("Demo Page 5", $varJunkLatinPart, $varJunkLatinFull, "demo-page-5", "default page, page 5", "1", "1"))
);

?>