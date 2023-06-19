<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: arrange_menu_items.php                        *|
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

// Create "Core" Variables.
        
$varMenuItems            = null;
$varMoveUpPrefix         = "<a id=\"move-up-icon\" class=\"options-icon\" title=\"" . Locales::getCore("move-up") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("move-up") . "&" . Locales::getVariable("id") . "=";
$varMoveUpSufix          = "\">" . Locales::getCore("move-up") . "</a>";
$varMoveDownPrefix       = "<a id=\"move-down-icon\" class=\"options-icon\" title=\"" . Locales::getCore("move-down") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("move-down") . "&" . Locales::getVariable("id") . "=";
$varMoveDownSufix        = "\">" . Locales::getCore("move-down") . "</a>";
$varEditMenuItemPrefix   = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item") . "&" . Locales::getVariable("id") . "=";
$varEditMenuItemSufix    = "\">" . Locales::getCore("edit-menu-item") . "</a>";
$varDeleteMenuItemPrefix = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-menu-item") . "&" . Locales::getVariable("id") . "=";
$varDeleteMenuItemSufix  = "\">" . Locales::getCore("delete-menu-item") . "</a>";

// Create "Core" Elements.

$hdArrangeMenuItems      = new FHeader();
$parMenuItemsInfo        = new FParagraph();
$tblArrangeMenuItems     = new FTable();

// Create "Row" Elements.

$rowMenuItemsInfo        = new FTableRow();

// "Menu Items" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

EasyGet::setOrderBy("position", EasyGet::OB_ASC);

$varMenuItems = EasyGet::execute
(
    "TS: menu_items",
    "CS: id, title, type, position",
    "ARGS: menu_id = " . $_GET[Locales::getVariable("id")]
);

// "Header Arrange Menu Items" Element Settings.

$hdArrangeMenuItems->setLevel(2);
$hdArrangeMenuItems->setContent(Locales::getCore("arrange-menu-items"));

// "Paragraph Menu Items Info" Element Settings.

$parMenuItemsInfo->setID("menu-items-info");
$parMenuItemsInfo->setClass("info-paragraph");
$parMenuItemsInfo->setAlignment(FParagraph::ALN_CENTER);
$parMenuItemsInfo->setContent(Locales::getParagraph("no-menu-items"));

// "Table Arrange Menu Items" Element Settings.

$tblArrangeMenuItems->setID("arrange-menu-items-table");
$tblArrangeMenuItems->setClass("default-admin-table");
$tblArrangeMenuItems->setAlignment(FTable::ALN_CENTER);

$tblArrangeMenuItems->addRow($rowMenuItemsInfo);

if ($varMenuItems != null)
{
    foreach ($varMenuItems as $varMenuItem)
    {
        // Create "Temp" Variables.

        $varTempOptions = null;

        // Create "Temp" Elements.

        $varTempRow     = new FTableRow();

        // "Temp Options" Variable Settings..

        $varTempOptions = $varMoveUpPrefix . $varMenuItem["id"] . $varMoveUpSufix . " " . $varMoveDownPrefix . $varMenuItem["id"] . $varMoveDownSufix . " " . $varEditMenuItemPrefix . $varMenuItem["id"] . $varEditMenuItemSufix . " " . $varDeleteMenuItemPrefix . $varMenuItem["id"] . $varDeleteMenuItemSufix;

        // Process "Type" Variable.

       if ($varMenuItem["type"] == Menus::MI_TITLE)
           $varMenuItem["type"] = Locales::getCore("title");
       else if ($varMenuItem["type"] == Menus::MI_SEPARATOR)
           $varMenuItem["type"] = Locales::getCore("separator");
       else if ($varMenuItem["type"] == Menus::MI_SUBMENU)
           $varMenuItem["type"] = Locales::getCore("menu");
       else if ($varMenuItem["type"] == Menus::MI_CORE_PAGE)
           $varMenuItem["type"] = Locales::getCore("core-page");
       else if ($varMenuItem["type"] == Menus::MI_PAGE)
           $varMenuItem["type"] = Locales::getCore("page");
       else if ($varMenuItem["type"] == Menus::MI_CUSTOM_LINK)
           $varMenuItem["type"] = Locales::getCore("custom-item");

        // "Temp Row" Element Settings.

        $varTempRow->addCell(new FTableCell(null, "table-cell-id", $varMenuItem["id"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-title", $varMenuItem["title"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-type", $varMenuItem["type"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-position", $varMenuItem["position"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-options", $varTempOptions));

        // Append Elements To "Table Arrange Menu Items" Element.

        $tblArrangeMenuItems->addRow($varTempRow);
    }
}

// "Row Menu Items Info" Element Settings.

$rowMenuItemsInfo->setID("menu-items-info-row");
$rowMenuItemsInfo->setClass("info-row");

$rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-id", "#"));
$rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-title", Locales::getCore("title")));
$rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-type", Locales::getCore("type")));
$rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-position", Locales::getCore("position")));
$rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdArrangeMenuItems);

if ($varMenuItems == null)
    $divWorkplace->addElement($parMenuItemsInfo);
else  
    $divWorkplace->addElement($tblArrangeMenuItems);

?>