<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: edit_menu.php                                 *|
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
        
$varMenu     = null;

// Create "Core" Elements.

$hdEditMenu  = new FHeader();
$fmEditMenu  = new FForm();
$tblEditMenu = new FTable();

// Create "Row" Elements.

$rowName    = new FTableRow();
$rowTitle   = new FTableRow();
$rowSubmit  = new FTableRow();

// Create "Input" Elements.

$inpName    = new FInput();
$inpTitle   = new FInput();
$btnReset   = new FButton();
$btnSubmit  = new FButton();

// "Menu" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

$varMenu = EasyGet::execute
(
    "TS: menus",
    "CS: *",
    "ARGS: id = " . $_GET[Locales::getVariable("id")]
);

// "Header Edit Menu" Element Settings.

$hdEditMenu->setLevel(2);
$hdEditMenu->setContent(Locales::getCore("edit-menu"));

// "Form Edit Menu" Element Settings.

$fmEditMenu->setID("add-menu-form");
$fmEditMenu->setClass("default-form");
$fmEditMenu->setMethod(FForm::MTD_POST);
$fmEditMenu->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu") . "&" . Locales::getVariable("id") . "=" . $_GET[Locales::getVariable("id")]);

$fmEditMenu->addItem($tblEditMenu);

// "Table Edit Menu" Element Settings.

$tblEditMenu->setID("edit-menu-table");
$tblEditMenu->setClass("default-admin-table");
$tblEditMenu->setAlignment(FTable::ALN_CENTER);

$tblEditMenu->addRow($rowName);
$tblEditMenu->addRow($rowTitle);
$tblEditMenu->addRow($rowSubmit);

// "Row Name" Element Settings.

$rowName->addCell(new FTableCell(null, null, new FLabel("name", Locales::getCore("name"))));
$rowName->addCell(new FTableCell(null, null, $inpName));

// "Row Title" Element Settings.

$rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
$rowTitle->addCell(new FTableCell(null, null, $inpTitle));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));

// "Input Name" Element Settings.

$inpName->setID("menu-name-input");
$inpName->setClass("form-input");
$inpName->setType(FInput::TP_TEXT);
$inpName->setMaxLength(50);
$inpName->setContent($varMenu[0]["name"]);
$inpName->setName("req_name");

// "Input Title" Element Settings.

$inpTitle->setID("menu-title-input");
$inpTitle->setClass("form-input");
$inpTitle->setType(FInput::TP_TEXT);
$inpTitle->setMaxLength(50);
$inpTitle->setContent($varMenu[0]["title"]);
$inpTitle->setName("req_title");

// "Button Reset" Element Settings.

$btnReset->setID("pages-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("add-menu-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("edit"));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdEditMenu);
$divWorkplace->addElement($fmEditMenu);

?>