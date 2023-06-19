<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: add_menu_item.php                             *|
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

$varCoreLink         = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu-item");
$varSuboptionLink    = $varCoreLink . "&" . Locales::getVariable("suboption") . "=";
$varMenuItemSelected = null;
$varMenus            = null;
$varLinks            = null;

// Create "Core" Elements.

$hdAddMenuItem       = new FHeader();
$divSelectItemHolder = new FDiv();
$olMenuItems         = new FList();
$divAddMenuItem      = new FDiv();
$fmAddMenuItem       = new FForm();
$tblAddMenuItem      = new FTable();

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

// "Variable Menu Item Selected" Element Settings.

$varMenuItemSelected = (!empty($_GET[Locales::getVariable("suboption")]) ? $_GET[Locales::getVariable("suboption")] : null);

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

// "Header Add Menu Item" Element Settings.

$hdAddMenuItem->setLevel(2);
$hdAddMenuItem->setContent(Locales::getCore("add-menu-item"));

// "Div Select Item Type" Element Settings.

$divSelectItemHolder->setID("select-item-holder");

$divSelectItemHolder->addElement($olMenuItems);

// "List Menu Items" Element Settings.

$olMenuItems->setType(FList::TP_OL);

if ($varMenuItemSelected == Locales::getLink("title"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("title") . "\" />" . Locales::getCore("title") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("title") . "\" />" . Locales::getCore("title") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("separator"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("separator") . "\" />" . Locales::getCore("separator") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("separator") . "\" />" . Locales::getCore("separator") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("submenu"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("submenu") . "\" />" . Locales::getCore("submenu") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("submenu") . "\" />" . Locales::getCore("submenu") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("core-page"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("core-page") . "\" />" . Locales::getCore("core-page") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("core-page") . "\" />" . Locales::getCore("core-page") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("page"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("page") . "\" />" . Locales::getCore("page") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("page") . "\" />" . Locales::getCore("page") . "</a>"));

if ($varMenuItemSelected == Locales::getLink("custom-link"))
    $olMenuItems->addItem(new FListItem(null, "selected", "<a href=\"" . $varSuboptionLink . Locales::getLink("custom-link") . "\" />" . Locales::getCore("custom-link") . "</a>"));
else
    $olMenuItems->addItem(new FListItem(null, null, "<a href=\"" . $varSuboptionLink . Locales::getLink("custom-link") . "\" />" . Locales::getCore("custom-link") . "</a>"));

// "Div Add Menu Item" Element Settings.

$divAddMenuItem->setID("add-menu-item");

$divAddMenuItem->addElement($fmAddMenuItem);

// "Form Add Menu Item" Element Settings.

$fmAddMenuItem->setID("add-link-form");
$fmAddMenuItem->setClass("default-form");
$fmAddMenuItem->setMethod("post");
$fmAddMenuItem->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu-item"));

$fmAddMenuItem->addItem($inpType);
$fmAddMenuItem->addItem($tblAddMenuItem);

// "Table Add Menu Item" Element Settings.

$tblAddMenuItem->setID("add-menu-item-table");
$tblAddMenuItem->setClass("default-admin-table");
$tblAddMenuItem->setAlignment(FTable::ALN_CENTER);

if ($varMenuItemSelected == Locales::getLink("title") ||
    $varMenuItemSelected == Locales::getLink("separator"))
{
    $tblAddMenuItem->addRow($rowTitle);
    $tblAddMenuItem->addRow($rowParent);
    $tblAddMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("submenu"))
{
    $tblAddMenuItem->addRow($rowTitle);
    $tblAddMenuItem->addRow($rowParent);
    $tblAddMenuItem->addRow($rowChildMenu);
    $tblAddMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("core-page"))
{
    $tblAddMenuItem->addRow($rowTitle);
    $tblAddMenuItem->addRow($rowParent);
    $tblAddMenuItem->addRow($rowCorePages);
    $tblAddMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("page"))
{
    $tblAddMenuItem->addRow($rowTitle);
    $tblAddMenuItem->addRow($rowParent);
    $tblAddMenuItem->addRow($rowPages);
    $tblAddMenuItem->addRow($rowSubmit);
}
else if ($varMenuItemSelected == Locales::getLink("custom-link"))
{
    $tblAddMenuItem->addRow($rowTitle);
    $tblAddMenuItem->addRow($rowParent);
    $tblAddMenuItem->addRow($rowCustomLink);
    $tblAddMenuItem->addRow($rowSubmit);
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

$rowSubmit->setID("add-menu-item-row");
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
$inpTitle->setName("req_title");

// "Select Parent" Element Settings.

$selParent->setClass("form-select");

foreach ($varMenus as $varMenu)
    $selParent->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));

$selParent->setName("req_parent");

// "Select Menus" Element Settings.

$selMenus->setClass("form-select");

foreach ($varMenus as $varMenu)
    $selMenus->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));

$selMenus->setName("req_menus");

// "Select Core Pages" Element Settings.

$selCorePages->setClass("form-select");

$selCorePages->addOption(new FSelectOption("homepage", Locales::getTitle("homepage"), false));
$selCorePages->addOption(new FSelectOption("registration", Locales::getTitle("registration"), false));
$selCorePages->addOption(new FSelectOption("log-in", Locales::getTitle("log-in"), false));
$selCorePages->addOption(new FSelectOption("messages", Locales::getTitle("messages"), false));
$selCorePages->addOption(new FSelectOption("your-profile", Locales::getTitle("your-profile"), false));
$selCorePages->addOption(new FSelectOption("site-administration", Locales::getTitle("site-administration"), false));
$selCorePages->addOption(new FSelectOption("account-recovery", Locales::getTitle("account-recovery"), false));
$selCorePages->addOption(new FSelectOption("resend-activation-email", Locales::getTitle("resend-activation-email"), false));
$selCorePages->addOption(new FSelectOption("terms-of-service", Locales::getTitle("terms-of-service"), false));
$selCorePages->addOption(new FSelectOption("privacy-policy", Locales::getTitle("privacy-policy"), false));

$selCorePages->setName("req_core_page");

// "Select Pages" Element Settings.

$selPages->setClass("form-select");

foreach ($varLinks as $varLink)
    $selPages->addOption(new FSelectOption($varLink["id"], $varLink["title"], false));

$selPages->setName("req_page");

// "Input Custom" Element Settings.

$inpCustomLink->setID("custom-menu-item-input");
$inpCustomLink->setClass("form-input");
$inpCustomLink->setType(FInput::TP_TEXT);
$inpCustomLink->setMaxLength(125);
$inpCustomLink->setName("req_custom");

// "Button Reset" Element Settings.

$btnReset->setID("add-menu-item-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("add-menu-item-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("add"));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdAddMenuItem);
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
    $divWorkplace->addElement($divAddMenuItem);
}

?>