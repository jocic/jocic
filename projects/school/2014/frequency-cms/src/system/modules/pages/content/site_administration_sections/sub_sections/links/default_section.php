<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_section.php                           *|
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

$varMenus                = null;
$varMenuItems            = null;

// Create "Link Prefix And Sufix" Variables.

$varEditMenuPrefix       = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-menu") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu") . "&" . Locales::getVariable("id") . "=";
$varEditMenuSufix        = "\">" . Locales::getCore("edit-menu") . "</a>";
$varDeleteMenuPrefix     = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-menu") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-menu") . "&" . Locales::getVariable("id") . "=";
$varDeleteMenuSufix      = "\">" . Locales::getCore("delete-menu") . "</a>";
$varArrangeItemsPrefix   = "<a id=\"arrange-icon\" class=\"options-icon\" title=\"" . Locales::getCore("arrange-menu-items") . "\"  href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-menu-items") . "&" . Locales::getVariable("id") . "=";
$varArrangeItemsSufix    = "\">" . Locales::getCore("arrange-menu-items") . "</a>";
$varEditMenuItemPrefix   = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item") . "&" . Locales::getVariable("id") . "=";
$varEditMenuItemSufix    = "\">" . Locales::getCore("edit-menu-item") . "</a>";
$varDeleteMenuItemPrefix = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-menu-item") . "&" . Locales::getVariable("id") . "=";
$varDeleteMenuItemSufix  = "\">" . Locales::getCore("delete-menu-item") . "</a>";

// Create "Core" Elements.

$hdMenus                 = new FHeader();
$parMenusInfo            = new FParagraph();
$tblMenus                = new FTable();
$divOptionLinks          = new FDiv();

// Create "Row" Elements.

$rowMenusInfo            = new FTableRow();

// "Menus" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

$varMenus = EasyGet::execute
(
    "TS: menus",
    "CS: *"
);

// "Header Menus" Element Settings.

$hdMenus->setLevel(2);
$hdMenus->setContent(Locales::getTitle("all-menus"));

// "Paragraph Menus Info" Element Settings.

$parMenusInfo->setID("menus-info");
$parMenusInfo->setClass("info-paragraph");
$parMenusInfo->setAlignment(FParagraph::ALN_CENTER);
$parMenusInfo->setContent(Locales::getParagraph("no-menus"));

// "Table Menus" Element Settings.

$tblMenus->setID("menus-table");
$tblMenus->setClass("default-admin-table");
$tblMenus->setAlignment(FTable::ALN_CENTER);

$tblMenus->addRow($rowMenusInfo);

if ($varMenus != null)
{
    foreach ($varMenus as $varMenu)
    {
        // Create "Temp" Variables.

        $varTempOptions = null;

        // Create "Temp" Elements.

        $varTempRow     = new FTableRow();

        // "Temp Options" Variable Settings.

        if ($varMenu["core"] == 1)
            $varTempOptions = $varArrangeItemsPrefix . $varMenu["id"] . $varArrangeItemsSufix;
        else
            $varTempOptions = $varArrangeItemsPrefix . $varMenu["id"] . $varArrangeItemsSufix . " " . $varEditMenuPrefix . $varMenu["id"] . $varEditMenuSufix . " " . $varDeleteMenuPrefix . $varMenu["id"] . $varDeleteMenuSufix;

        // "Temp Row" Element Settings.

        $varTempRow->addCell(new FTableCell(null, "table-cell-id", $varMenu["id"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-name", $varMenu["name"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-title", $varMenu["title"]));
        $varTempRow->addCell(new FTableCell(null, "table-cell-options", $varTempOptions));

        // Append Elements To "Table Menus" Element.

        $tblMenus->addRow($varTempRow);
    }
}

// "Div Option Links" Element Settings.

$divOptionLinks->setClass("option-links");

$divOptionLinks->addElement("<strong>" . Locales::getCore("options") . ":</strong>");
$divOptionLinks->addElement(new FAnchor(null, null, $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu"), null, Locales::getCore("add-menu")));
$divOptionLinks->addElement(" | ");
$divOptionLinks->addElement(new FAnchor(null, null, $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu-item"), null, Locales::getCore("add-menu-item")));

// "Row Menus Info" Element Settings.

$rowMenusInfo->setID("menu-info-row");
$rowMenusInfo->setClass("info-row");

$rowMenusInfo->addCell(new FTableCell(null, "table-cell-id", "#"));
$rowMenusInfo->addCell(new FTableCell(null, "table-cell-name", Locales::getCore("name")));
$rowMenusInfo->addCell(new FTableCell(null, "table-cell-title", Locales::getCore("title")));
$rowMenusInfo->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdMenus);

if ($varMenus == null)
    $divWorkplace->addElement($parMenusInfo);
else
    $divWorkplace->addElement($tblMenus);

$divWorkplace->addElement($divOptionLinks);

?>