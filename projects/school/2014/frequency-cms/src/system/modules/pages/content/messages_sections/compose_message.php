<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: compose_message.php                           *|
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

// Create "Core" Elements.

$hdOption   = new FHeader();
$fmCompose  = new FForm();
$tblCompose = new FTable();

// Create "Row" Elements.

$rowTo      = new FTableRow();
$rowTitle   = new FTableRow();
$rowContent = new FTableRow();
$rowCaptcha = new FTableRow();
$rowSubmit  = new FTableRow();

// Create "Input" Elements.

$inpTo      = new FInput();
$inpTitle   = new FInput();
$txtContent = new FTextArea();
$inpCaptcha = new FInput();
$btnReset   = new FButton();
$btnSubmit  = new FButton();

// "Header Option" Element Settings.

$hdOption->setLevel(2);
$hdOption->setContent(Locales::getTitle("compose"));

// "Form Compose" Element Settings.

$fmCompose->setID("compose-form");
$fmCompose->setClass("default-form");
$fmCompose->setMethod(FForm::MTD_POST);
$fmCompose->setAction($varLinkPreifx . Locales::getLink("compose"));

$fmCompose->addItem($tblCompose);

// "Table Compose" Element Settings.

$tblCompose->setID("compose-table");
$tblCompose->setClass("default-table");

$tblCompose->addRow($rowTo);
$tblCompose->addRow($rowTitle);
$tblCompose->addRow($rowContent);
$tblCompose->addRow($rowCaptcha);
$tblCompose->addRow($rowSubmit);

// "Row To" Element Settings.

$rowTo->addCell(new FTableCell(null, null, new FLabel("to", Locales::getCore("to"))));
$rowTo->addCell(new FTableCell(null, null, $inpTo));

// "Row Title" Element Settings.

$rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
$rowTitle->addCell(new FTableCell(null, null, $inpTitle));

// "Row Content" Element Settings.

$rowContent->addCell(new FTableCell(null, null, new FLabel("content", Locales::getCore("content"))));
$rowContent->addCell(new FTableCell(null, null, $txtContent));

// "Row Captcha" Element Settings.

$rowCaptcha->addCell(new FTableCell(null, null, new FLabel("comment-captcha", Captcha::getChallenge())));
$rowCaptcha->addCell(new FTableCell(null, null, $inpCaptcha));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, 0, FTableCell::ALN_RIGHT));

// "Input To" Element Settings.

$inpTo->setID("to-input");
$inpTo->setClass("form-input");
$inpTo->setType("text");
$inpTo->setMaxLength(20);
$inpTo->setName("req_to");

// "Input Title" Element Settings.

$inpTitle->setID("title-input");
$inpTitle->setClass("form-input");
$inpTitle->setType("text");
$inpTitle->setMaxLength(100);
$inpTitle->setName("req_title");

// "Textarea Content" Element Settings.

$txtContent->setID("content-input");
$txtContent->setClass("form-textarea");
$txtContent->setMaxLength(1000);
$txtContent->setName("req_content");

// "Input Captcha" Element Settings.

$inpCaptcha->setID("captcha-input");
$inpCaptcha->setMaxLength(2);
$inpCaptcha->setType(FInput::TP_TEXT);
$inpCaptcha->setName("req_captcha");

// "Button Reset" Element Settings.

$btnReset->setID("compose-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("compose-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("send"));

// Append Elements.

$divContent->addElement($hdOption);
$divContent->addElement($fmCompose);

?>