<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: password_reset.php                            *|
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

// Set Blank Prefix.

Build::setBlankPrefix($this->getBlankPrefix());

// Create "Main" Elements.

$hdPasswordReset    = new FHeader();
$tblNotice          = new FTable();
$rwNoticeOne        = new FTableRow();
$rwNoticeTwo        = new FTableRow();
$clNoticeTitle      = new FTableCell();
$clNoticeContent    = new FTableCell();
$fmPasswordReset    = new FForm();
$tblPasswordReset   = new FTable();
$parLinks           = new FParagraph();

// Create "Row" Elements.

$rowPassword        = new FTableRow();
$rowPasswordRe      = new FTableRow();
$rowSubmit          = new FTableRow();

// Create "Input" Elements.

$inpPassword        = new FInput();
$inpPasswordRe      = new FInput();
$btnReset           = new FButton();
$btnSubmit          = new FButton();

// "Header Password Reset" Element Settings.

$hdPasswordReset->setLevel(1);
$hdPasswordReset->setContent(Locales::getTitle("password-reset"));

// "Table Notice" Element Settings.

$tblNotice->setID("notice-table");
$tblNotice->setClass("info-table");
$tblNotice->addRow($rwNoticeOne);
$tblNotice->addRow($rwNoticeTwo);

// "Collumn Notice Title" Element Settings.

$clNoticeTitle->setID("notice-title");
$clNoticeTitle->setClass("info-title");
$clNoticeTitle->setContent(Locales::getNoticeTitle("one-step-away"));

$rwNoticeOne->addCell($clNoticeTitle);

// "Collumn Notice Content" Element Settings.

$clNoticeContent->setID("notice-content");
$clNoticeContent->setClass("info-content");
$clNoticeContent->setContent(Locales::getNoticeContent("one-step-away"));

$rwNoticeTwo->addCell($clNoticeContent);

// "Form Password Reset" Element Settings.

$fmPasswordReset->setID("password-reset-form");
$fmPasswordReset->setClass("default-form");
$fmPasswordReset->setMethod(FForm::MTD_POST);
$fmPasswordReset->setAction("./?$pnv=" . Locales::getLink("password-reset") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]);

$fmPasswordReset->addItem($tblPasswordReset);

// "Table Password Reset" Element Settings.

$tblPasswordReset->setID("password-reset-table");
$tblPasswordReset->setClass("default-table");

$tblPasswordReset->addRow($rowPassword);
$tblPasswordReset->addRow($rowPasswordRe);
$tblPasswordReset->addRow($rowSubmit);

// "Row Passowrd" Element Settings.

$rowPassword->addCell(new FTableCell(null, null, new FLabel("password", Locales::getCore("password"))));
$rowPassword->addCell(new FTableCell(null, null, $inpPassword));

// "Row Password Re" Element Settings.

$rowPasswordRe->addCell(new FTableCell(null, null, new FLabel("password-re", Locales::getCore("confirmation-password"))));
$rowPasswordRe->addCell(new FTableCell(null, null, $inpPasswordRe));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, 2, 0, FTableCell::ALN_RIGHT));

// "Input Password" Element Settings.

$inpPassword->setID("password-input");
$inpPassword->setClass("form-input");
$inpPassword->setMaxLength(50);
$inpPassword->setType(FInput::TP_PASSWORD);
$inpPassword->setName("req_password");

// "Input Password Re" Element Settings.

$inpPasswordRe->setID("password-re-input");
$inpPasswordRe->setClass("form-input");
$inpPasswordRe->setMaxLength(50);
$inpPasswordRe->setType(FInput::TP_PASSWORD);
$inpPasswordRe->setName("req_password_re");

// "Input Submit" Element Settings.

$btnSubmit->setID("password-reset-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("submit"));

// "Paragraph Links" Element Settings.

$parLinks->setAlignment(FHTMLObject::ALN_CENTER);
$parLinks->setContent
(
    " <a href=\"" . "./?" .
    Locales::getVariable("page") .
    "=" .
    Locales::getLink("terms-of-service") .
    "\">" . Locales::getCore("terms-of-service") .
    "</a> | " .
    " <a href=\"" . "./?" .
    Locales::getVariable("page") .
    "=" .
    Locales::getLink("privacy-policy") .
    "\">" . Locales::getCore("privacy-policy") .
    "</a>"
);

// Build Elements.

if (empty($_GET[Locales::getVariable("error")]))
    Build::element($hdPasswordReset);

Build::element($tblNotice);
Build::element($fmPasswordReset);
Build::element($parLinks);

?>
