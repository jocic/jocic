<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: add_menu.php                                  *|
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

$varName  = null;
$varTitle = null;

// Create "Core" Elements.

$hdAddMenu  = new FHeader();
$fmAddMenu  = new FForm();
$tblAddMenu = new FTable();

// Create "Row" Elements.

$rowName    = new FTableRow();
$rowTitle   = new FTableRow();
$rowSubmit  = new FTableRow();

// Create "Input" Elements.

$inpName    = new FInput();
$inpTitle   = new FInput();
$btnReset   = new FButton();
$btnSubmit  = new FButton();

// "Name" Variable Settings.

if (!empty($_POST["req_name"]))
    $varName = $_POST["req_name"];

// "Title" Variable Settings.

if (!empty($_POST["req_title"]))
    $varTitle = $_POST["req_title"];

// "Header Add Menu" Element Settings.

$hdAddMenu->setLevel(2);
$hdAddMenu->setContent(Locales::getCore("add-menu"));

// "Form Add Menu" Element Settings.

$fmAddMenu->setID("add-menu-form");
$fmAddMenu->setClass("default-form");
$fmAddMenu->setMethod(FForm::MTD_POST);
$fmAddMenu->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu"));

$fmAddMenu->addItem($tblAddMenu);

// "Table Add Menu" Element Settings.

$tblAddMenu->setID("add-menu-table");
$tblAddMenu->setClass("default-admin-table");
$tblAddMenu->setAlignment(FTable::ALN_CENTER);

$tblAddMenu->addRow($rowName);
$tblAddMenu->addRow($rowTitle);
$tblAddMenu->addRow($rowSubmit);

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
$inpName->setContent($varName);
$inpName->setName("req_name");

// "Input Title" Element Settings.

$inpTitle->setID("menu-title-input");
$inpTitle->setClass("form-input");
$inpTitle->setType(FInput::TP_TEXT);
$inpTitle->setMaxLength(50);
$inpTitle->setContent($varTitle);
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
$btnSubmit->setContent(Locales::getCore("add"));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdAddMenu);
$divWorkplace->addElement($fmAddMenu);
        
?>