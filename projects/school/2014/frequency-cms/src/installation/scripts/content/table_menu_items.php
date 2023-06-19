<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_menu_items.php                          *|
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

// Row "Homepage" For "Main Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Home Page", "homepage", "3", "1", "1"))
);

// Row "Demo Page 1" For "Main Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Demp Page 1", "1", "4", "2", "1"))
);

// Row "Demo Page 2" For "Main Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Demp Page 2", "2", "4", "3", "1"))
);

// Row "Demo Page 3" For "Main Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Demp Page 3", "3", "4", "4", "1"))
);

// Row "Dropdown Menu" For "Main Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Dropdown Menu", "1", "2", "5", "1"))
);

// Row "Test Title 1" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Test Title 1", "header", "0", "1", "2"))
);

// Row "Homepage" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Home Page", "homepage", "3", "2", "2"))
);

// Row "Demo Page 1" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Demp Page 1", "1", "4", "3", "2"))
);

// Row "Demo Page 2" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Demp Page 2", "2", "4", "4", "2"))
);

// Row "Demo Page 3" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Demp Page 3", "3", "4", "5", "2"))
);

// Row "Separator 1" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Separator 1", "separator", "1", "6", "2"))
);

// Row "Registration" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Registration", "registration", "3", "7", "2"))
);

// Row "Log In" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Log In", "log-in", "3", "8", "2"))
);

// Row "Test Title 2" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Test Title 2", "header", "0", "9", "2"))
);

// Row "Terms Of Service" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Terms Of Service", "terms-of-service", "3", "10", "2"))
);

// Row "Privacy Policy" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Privacy Policy", "privacy-policy", "3", "11", "2"))
);

// Row "Separator 2" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Separator 2", "separator", "1", "12", "2"))
);

// Row "Custom Item 1" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Google", "http://www.google.com/", "4", "13", "2"))
);

// Row "Custom Item 2" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("YouTube", "http://www.youtube.com/", "4", "14", "2"))
);

// Row "Separator 3" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Separator 3", "separator", "1", "15", "2"))
);

// Row "Dropdown Menu" For "Side Navigation Bar".

EasyInsert::execute
(
    new TableSelection("menu_items"),
    new ColumnSelection("title", "value", "type", "position", "menu_id"),
    new ValueSelection(array("Dropdown Menu", "1", "2", "16", "2"))
);

?>