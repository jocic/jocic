<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: edit_advert.php                               *|
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

$varCoreLink      = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("earnings");
$varID            = null;
$varAdvert        = null;
$varAdvertName    = null;
$varAdvertContent = null;
$varAdvertID      = null;
$varAdvertClass   = null;
$varAdvertSection = null;

// Create "Core" Elements.

$hdEditAdvert     = new FHeader();
$fmEditAdvert     = new FForm();
$tblEditAdvert    = new FTable();

// Create "Row" Elements.

$rowName          = new FTableRow();
$rowContent       = new FTableRow();
$rowID            = new FTableRow();
$rowClass         = new FTableRow();
$rowSection       = new FTableRow();
$rowSubmit        = new FTableRow();

// Create "Input" Element.

$inpName          = new FInput();
$inpContent       = new FTextArea();
$inpID            = new FInput();
$inpClass         = new FInput();
$selSection       = new FSelect();
$btnReset         = new FButton();
$btnSubmit        = new FButton();

// "Advert ID" Variable Settings.

if (!empty($_GET[Locales::getVariable("id")]))
    $varID = $_GET[Locales::getVariable("id")];

// "Advert" Variable Settings.

$varAdvert = Adverts::getAdvert($varID);

// "Advert Name" Variable Settings.

if (empty($_POST["req_name"]))
    $varAdvertName = $varAdvert["name"];
else
    $varAdvertName = $_POST["req_name"];

// "Advert Content" Variable Settings.

if (empty($_POST["req_content"]))
    $varAdvertContent = $varAdvert["content"];
else
    $varAdvertContent = $_POST["req_content"];

// "Advert ID" Variable Settings.

if (empty($_POST["req_id"]))
    $varAdvertID = $varAdvert["css_id"];
else
    $varAdvertID = $_POST["req_id"];

// "Advert Class" Variable Settings.

if (empty($_POST["req_class"]))
    $varAdvertClass = $varAdvert["css_class"];
else
    $varAdvertClass = $_POST["req_class"];

// "Advert Section" Variable Settings.

if (empty($_POST["req_section"]))
    $varAdvertSection = $varAdvert["section"];
else
    $varAdvertSection = $_POST["req_section"];

// "Header Edit Advert" Element Settings.

$hdEditAdvert->setLevel(2);
$hdEditAdvert->setContent(Locales::getTitle("edit-advert"));

// "Form Edit Advert" Element Settings.

$fmEditAdvert->setID("edit-advert-form");
$fmEditAdvert->setClass("default-form");
$fmEditAdvert->setMethod(FForm::MTD_POST);
$fmEditAdvert->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-advert") . "&" . Locales::getVariable("id") . "=" . $varID);

$fmEditAdvert->addItem($tblEditAdvert);

// "Table Edit Advert" Element Settings.

$tblEditAdvert->setID("site-advert-table");
$tblEditAdvert->setClass("default-admin-table");

$tblEditAdvert->addRow($rowName);
$tblEditAdvert->addRow($rowContent);
$tblEditAdvert->addRow($rowID);
$tblEditAdvert->addRow($rowClass);
$tblEditAdvert->addRow($rowSection);
$tblEditAdvert->addRow($rowSubmit);

// "Row Name" Element Settings.

$rowName->setID("advert-name");

$rowName->addCell(new FTableCell(null, null, new FLabel("name", Locales::getCore("name"))));
$rowName->addCell(new FTableCell(null, null, $inpName));

// "Row Content" Element Settings.

$rowContent->setID("advert-content");

$rowContent->addCell(new FTableCell("advert-content-title", null, new FLabel("content", Locales::getCore("content"))));
$rowContent->addCell(new FTableCell("advert-content-editor", null, $inpContent));

// "Row ID" Element Settings.

$rowID->setID("advert-css-id");

$rowID->addCell(new FTableCell(null, null, new FLabel("css-id", Locales::getCore("css-id"))));
$rowID->addCell(new FTableCell(null, null, $inpID));

// "Row Class" Element Settings.

$rowClass->setID("advert-css-class");

$rowClass->addCell(new FTableCell(null, null, new FLabel("css-class", Locales::getCore("css-class"))));
$rowClass->addCell(new FTableCell(null, null, $inpClass));

// "Row Section" Element Settings.

$rowSection->setID("advert-section");

$rowSection->addCell(new FTableCell(null, null, new FLabel("section", Locales::getCore("section"))));
$rowSection->addCell(new FTableCell(null, null, $selSection));

// "Row Section" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));

// "Input Name" Element Settings.

$inpName->setID("name-input");
$inpName->setClass("form-input");
$inpName->setType(FInput::TP_TEXT);
$inpName->setMaxLength(100);
$inpName->setContent($varAdvertName);
$inpName->setName("req_name");

// "Input Content" Element Settings.

$inpContent->setID("content-input");
$inpContent->setClass("form-input");
$inpContent->setContent($varAdvertContent);
$inpContent->setName("req_content");

// "Input CSS ID" Element Settings.

$inpID->setID("css-id-input");
$inpID->setClass("form-input");
$inpID->setType(FInput::TP_TEXT);
$inpID->setMaxLength(50);
$inpID->setContent($varAdvertID);
$inpID->setName("req_id");

// "Input CSS Class" Element Settings.

$inpClass->setID("css-class-input");
$inpClass->setClass("form-input");
$inpClass->setType(FInput::TP_TEXT);
$inpClass->setMaxLength(50);
$inpClass->setContent($varAdvertClass);
$inpClass->setName("req_class");

// "Select Section" Element Settings.

$selSection->setClass("form-select");

if ($varAdvertSection == 0)
    $selSection->addOption(new FSelectOption(0, Locales::getCore("advert-section-1"), true));
else
    $selSection->addOption(new FSelectOption(0, Locales::getCore("advert-section-1"), false));

if ($varAdvertSection == 1)
    $selSection->addOption(new FSelectOption(1, Locales::getCore("advert-section-2"), true));
else
    $selSection->addOption(new FSelectOption(1, Locales::getCore("advert-section-2"), false));

if ($varAdvertSection == 2)
    $selSection->addOption(new FSelectOption(2, Locales::getCore("advert-section-3"), true));
else
    $selSection->addOption(new FSelectOption(2, Locales::getCore("advert-section-3"), false));

if ($varAdvertSection == 3)
    $selSection->addOption(new FSelectOption(3, Locales::getCore("advert-section-4"), true));
else
    $selSection->addOption(new FSelectOption(3, Locales::getCore("advert-section-4"), false));

if ($varAdvertSection == 4)
    $selSection->addOption(new FSelectOption(4, Locales::getCore("advert-section-5"), true));
else
    $selSection->addOption(new FSelectOption(4, Locales::getCore("advert-section-5"), false));

$selSection->setName("req_section");

// "Button Reset" Element Settings.

$btnReset->setID("edit-advert-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("edit-advert-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("edit"));

// Append Elements To "Workplace".

$divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ace/ace.js\" type=\"text/javascript\"></script>");
$divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ace/ace_implement_advert.js\" type=\"text/javascript\"></script>");

$divWorkplace->addElement($hdEditAdvert);
$divWorkplace->addElement($fmEditAdvert);

?>
