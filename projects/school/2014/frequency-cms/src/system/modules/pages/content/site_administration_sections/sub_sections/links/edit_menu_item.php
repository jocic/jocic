<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: edit_menu_item.php                            *|
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

$varCorePages        = array("homepage", "registration", "log-in", "messages", "your-profile", "site-administration", "account-recovery", "resend-activation-email", "terms-of-service", "privacy-policy");
$varItemID           = null;
$varMenuItem         = null;
$varTitle            = null;
$varValue            = null;
$varType             = null;
$varParent           = null;
$varCoreLink         = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item");
$varSuboptionLink    = $varCoreLink . "&" . Locales::getVariable("suboption") . "=";
$varMenuItemSelected = null;
$varMenus            = null;
$varLinks            = null;

// Create "Core" Elements.

$hdEditMenuItem      = new FHeader();
$divSelectItemHolder = new FDiv();
$olMenuItems         = new FList();
$divEditMenuItem     = new FDiv();
$fmEditMenuItem      = new FForm();
$tblEditMenuItem     = new FTable();

// Create "Row" Elements.

$rowTitle            = new FTableRow();
$rowParent           = new FTableRow();
$rowChildMenu        = new FTableRow();
$rowCorePages        = new FTableRow();
$rowPages            = new FTableRow();
$rowCustomLink       = new FTableRow();
$rowSubmit           = new FTableRow();

// Create "Input" Elements.

$inpType             = new FInput();
$inpTitle            = new FInput();
$selParent           = new FSelect();
$selMenus            = new FSelect();
$selCorePages        = new FSelect();
$selPages            = new FSelect();
$inpCustomLink       = new FInput();
$btnReset            = new FButton();
$btnSubmit           = new FButton();

// "Item ID" Variable Settings.

$varItemID = $_GET[Locales::getVariable("id")];

// "Menu Item" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

$varMenuItem = EasyGet::execute
(
    "TS: menu_items",
    "CS: title, value, type, menu_id",
    "ARGS: id = " . $varItemID
);

$varMenuItem = $varMenuItem[0];

// "Menu Title" Variable Settings.

$varTitle = $varMenuItem["title"];

// "Menu Value" Variable Settings.

$varValue = $varMenuItem["value"];

// "Menu Type" Variable Settings.

$varType = $varMenuItem["type"];

// "Menu Parent" Variable Settings.

$varParent = $varMenuItem["menu_id"];

// "Variable Menu Item Selected" Element Settings.

if ($varMenuItem["type"] == Menus::MI_TITLE)
    $varMenuItemSelected = Locales::getLink("title");
else if ($varMenuItem["type"] == Menus::MI_SEPARATOR)
    $varMenuItemSelected = Locales::getLink("separator");
else if ($varMenuItem["type"] == Menus::MI_SUBMENU)
    $varMenuItemSelected = Locales::getLink("submenu");
else if ($varMenuItem["type"] == Menus::MI_CORE_PAGE)
    $varMenuItemSelected = Locales::getLink("core-page");
else if ($varMenuItem["type"] == Menus::MI_PAGE)
    $varMenuItemSelected = Locales::getLink("page");
else if ($varMenuItem["type"] == Menus::MI_CUSTOM_LINK)
    $varMenuItemSelected = Locales::getLink("custom-link");

if (!empty($_GET[Locales::getVariable("suboption")]))
    $varMenuItemSelected = $_GET[Locales::getVariable("suboption")];

// "Menus" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

$varMenus = EasyGet::execute
(
    "TS: menus",
    "CS: id, title"
);

// "Links" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

$varLinks = EasyGet::execute
(
    "TS: pages",
    "CS: id, title"
);

// "Header Edit Menu Item" Element Settings.

$hdEditMenuItem->setLevel(2);
$hdEditMenuItem->setContent(Locales::getCore("edit-menu-item"));

// "Div Select Item Type" Element Settings.

$divSelectItemHolder->setID("select-item-holder");

$divSelectItemHolder->addElement($olMenuItems);

// "List Menu Items" Element Settings.

$olMenuItems->setType(FList::TP_OL);

if ($varMenuItemSelected == Locales::getLink("title"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("title") . "&" . Locales::getVariable("id") . "=" . $varItemID . "\" />" . Locales::getCore("title") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("title") . "&" . Locales::getVariable("id") . "=" . $varItemID . "\" />" . Locales::getCore("title") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("separator"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("separator") . "&" . Locales::getVariable("id") . "=" . $varItemID . "\" />" . Locales::getCore("separator") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("separator") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("separator") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("submenu"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("submenu") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("submenu") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("submenu") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("submenu") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("core-page"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("core-page") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("core-page") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("core-page") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("core-page") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("page"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("page") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("page") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("page") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("page") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("custom-link"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("custom-link") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("custom-link") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("custom-link") . "&" .  Locales::getVariable("id") . "=" . $varItemID .  "\" />" . Locales::getCore("custom-link") . "</a>"));

// "Div Edit Menu Item" Element Settings.

$divEditMenuItem->setID("edit-menu-item");

$divEditMenuItem->addElement($fmEditMenuItem);

// "Form Edit Menu Item" Element Settings.

$fmEditMenuItem->setID("edit-link-form");
$fmEditMenuItem->setClass("default-form");
$fmEditMenuItem->setMethod("post");
$fmEditMenuItem->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item") . "&" . Locales::getVariable("id") . "=" . $varItemID);

$fmEditMenuItem->addItem($inpType);
$fmEditMenuItem->addItem($tblEditMenuItem);

// "Table Add Menu Item" Element Settings.

$tblEditMenuItem->setID("edit-menu-item-table");
$tblEditMenuItem->setClass("default-admin-table");
$tblEditMenuItem->setAlignment(FTable::ALN_CENTER);

if ($varMenuItemSelected == Locales::getLink("title") ||
    $varMenuItemSelected == Locales::getLink("separator"))
{
    $tblEditMenuItem->addRow($rowTitle);
    $tblEditMenuItem->addRow($rowParent);
    $tblEditMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("submenu"))
{
    $tblEditMenuItem->addRow($rowTitle);
    $tblEditMenuItem->addRow($rowParent);
    $tblEditMenuItem->addRow($rowChildMenu);
    $tblEditMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("core-page"))
{
    $tblEditMenuItem->addRow($rowTitle);
    $tblEditMenuItem->addRow($rowParent);
    $tblEditMenuItem->addRow($rowCorePages);
    $tblEditMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("page"))
{
    $tblEditMenuItem->addRow($rowTitle);
    $tblEditMenuItem->addRow($rowParent);
    $tblEditMenuItem->addRow($rowPages);
    $tblEditMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("custom-link"))
{
    $tblEditMenuItem->addRow($rowTitle);
    $tblEditMenuItem->addRow($rowParent);
    $tblEditMenuItem->addRow($rowCustomLink);
    $tblEditMenuItem->addRow($rowSubmit);
}

// "Row Title" Element Settings.

$rowTitle->setID("menu-item-title");
$rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
$rowTitle->addCell(new FTableCell(null, null, $inpTitle));

// "Row Parent" Element Settings.

$rowParent->setID("menu-item-parent");
$rowParent->addCell(new FTableCell(null, null, new FLabel("parent", Locales::getCore("parent"))));
$rowParent->addCell(new FTableCell(null, null, $selParent));

// "Row Child Menu" Element Settings.

$rowChildMenu->setID("child-menu-selector");
$rowChildMenu->addCell(new FTableCell(null, null, new FLabel("child-menu", Locales::getCore("child-menu"))));
$rowChildMenu->addCell(new FTableCell(null, null, $selMenus));

// "Row Core Pages" Element Settings.

$rowCorePages->setID("core-pages-selector");
$rowCorePages->addCell(new FTableCell(null, null, new FLabel("child-item", Locales::getCore("child-item"))));
$rowCorePages->addCell(new FTableCell(null, null, $selCorePages));

// "Row Pages" Element Settings.

$rowPages->setID("pages-selector");
$rowPages->addCell(new FTableCell(null, null, new FLabel("child-item", Locales::getCore("child-item"))));
$rowPages->addCell(new FTableCell(null, null, $selPages));

// "Row Custom Link" Element Settings.

$rowCustomLink->setID("child-item-selector");
$rowCustomLink->addCell(new FTableCell(null, null, new FLabel("custom-child-item", Locales::getCore("custom-child-item"))));
$rowCustomLink->addCell(new FTableCell(null, null, $inpCustomLink));

// "Row Submit" Element Settings.

$rowSubmit->setID("edit-menu-item-row");
$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, 0, FTableCell::ALN_RIGHT));

// "Input Type" Element Settings.

$inpType->setType(FInput::TP_HIDDEN);

if ($varMenuItemSelected == Locales::getLink("title"))
    $inpType->setValue(Menus::MI_TITLE);
else if ($varMenuItemSelected == Locales::getLink("separator"))
    $inpType->setValue(Menus::MI_SEPARATOR);
else if ($varMenuItemSelected == Locales::getLink("submenu"))
    $inpType->setValue(Menus::MI_SUBMENU);
else if ($varMenuItemSelected == Locales::getLink("core-page"))
    $inpType->setValue(Menus::MI_CORE_PAGE);
else if ($varMenuItemSelected == Locales::getLink("page"))
    $inpType->setValue(Menus::MI_PAGE);
else if ($varMenuItemSelected == Locales::getLink("custom-link"))
    $inpType->setValue(Menus::MI_CUSTOM_LINK);

$inpType->setName("req_type");

// "Input Title" Element Settings.

$inpTitle->setID("menu-item-title-input");
$inpTitle->setClass("form-input");
$inpTitle->setType(FInput::TP_TEXT);
$inpTitle->setMaxLength(50);
$inpTitle->setContent($varTitle);
$inpTitle->setName("req_title");

// "Select Parent" Element Settings.

$selParent->setClass("form-select");

foreach ($varMenus as $varMenu)
{
    if ($varMenu["id"] == $varParent)
        $selParent->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], true));
    else
        $selParent->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));
}

$selParent->setName("req_parent");

// "Select Menus" Element Settings.

$selMenus->setClass("form-select");

foreach ($varMenus as $varMenu)
{
    if ($varType == Menus::MI_SUBMENU && $varValue == $varMenu["id"])
        $selMenus->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], true));
    else
        $selMenus->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));
}

$selMenus->setName("req_menus");

// "Select Core Pages" Element Settings.

$selCorePages->setClass("form-select");

foreach ($varCorePages as $varCorePage)
{
    if ($varType == Menus::MI_CORE_PAGE && $varValue == $varCorePage)
        $selCorePages->addOption(new FSelectOption($varCorePage, Locales::getTitle($varCorePage), true));
    else
        $selCorePages->addOption(new FSelectOption($varCorePage, Locales::getTitle($varCorePage), false));
}

$selCorePages->setName("req_core_page");

// "Select Pages" Element Settings.

$selPages->setClass("form-select");

foreach ($varLinks as $varLink)
{
    if ($varType == Menus::MI_PAGE && $varValue == $varLink["id"])
        $selPages->addOption(new FSelectOption($varLink["id"], $varLink["title"], true));
    else
        $selPages->addOption(new FSelectOption($varLink["id"], $varLink["title"], false));
}

$selPages->setName("req_page");

// "Input Custom" Element Settings.

if ($varType == Menus::MI_CUSTOM_LINK)
    $inpCustomLink->setValue($varValue);

$inpCustomLink->setID("custom-menu-item-input");
$inpCustomLink->setClass("form-input");
$inpCustomLink->setType(FInput::TP_TEXT);
$inpCustomLink->setMaxLength(125);
$inpCustomLink->setName("req_custom");

// "Button Reset" Element Settings.

$btnReset->setID("edit-menu-item-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("edit-menu-item-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("edit"));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdEditMenuItem);
$divWorkplace->addElement(new FDiv("select-item-title", null, Locales::getCore("select-item-type") . ":"));
$divWorkplace->addElement($divSelectItemHolder);

if ($varMenuItemSelected == Locales::getLink("title") ||
    $varMenuItemSelected == Locales::getLink("separator") ||
    $varMenuItemSelected == Locales::getLink("submenu") ||
    $varMenuItemSelected == Locales::getLink("core-page") ||
    $varMenuItemSelected == Locales::getLink("page") ||
    $varMenuItemSelected == Locales::getLink("custom-link"))
{
    $divWorkplace->addElement(new FDiv("select-item-title", null, Locales::getCore("menu-item-settings") . ":"));
    $divWorkplace->addElement($divEditMenuItem);
}

?>