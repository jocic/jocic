<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: links.php                                     *|
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

if (!defined("IND_ACCESS")) exit("Action not allowed.");

// Create "Core" Variable.

$varCoreLink = CMS_ROOT .
               "?" .
               Locales::getVariable("page") .
               "=" .
               Locales::getLink("site-administration") .
               "&" .
               Locales::getVariable("workplace") .
               "=" .
               Locales::getLink("links");

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "links" .
                    DIRECTORY_SEPARATOR;

if (!empty($_GET[Locales::getVariable("option")])) // If Option Selected.
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("arrange-menu-items")) // If "Arrange Menu Items" Selected.
        require_once $varSubScriptRoot .  "arrange_menu_items.php";
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-menu")) // If "Add Menu" Selected.
        require_once $varSubScriptRoot .  "add_menu.php";
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-menu")) // If "Edit Menu" Selected.
        require_once $varSubScriptRoot .  "edit_menu.php";
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-menu-item")) // If "Add Menu Item" Selected.
        require_once $varSubScriptRoot .  "add_menu_item.php";
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-menu-item")) // If "Edit Menu Item" Selected.
        require_once $varSubScriptRoot .  "edit_menu_item.php";
}
else
    require_once $varSubScriptRoot .  "default_section.php";

?>