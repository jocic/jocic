<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: account_recovery.php                          *|
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

$hdAccountRecovery  = new FHeader();
$tblNotice          = new FTable();
$rwNoticeOne        = new FTableRow();
$rwNoticeTwo        = new FTableRow();
$clNoticeTitle      = new FTableCell();
$clNoticeContent    = new FTableCell();
$fmAccountRecovery  = new FForm();
$tblAccountRecovery = new FTable();
$parNotice          = new FParagraph();

// Create "Row" Elements.

$rowEmailAddress    = new FTableRow();
$rowCaptcha         = new FTableRow();
$rowSubmit          = new FTableRow();

// Create "Input" Elements.

$inpEmailAddress    = new FInput();
$inpCaptcha         = new FInput();
$btnReset           = new FButton();
$btnSubmit          = new FButton();

// "Header Account Recovery" Element Settings.

$hdAccountRecovery->setLevel(1);
$hdAccountRecovery->setContent(Locales::getTitle("account-recovery"));

// "Table Notice" Element Settings.

$tblNotice->setID("notice-table");
$tblNotice->setClass("info-table");
$tblNotice->addRow($rwNoticeOne);
$tblNotice->addRow($rwNoticeTwo);

// "Collumn Notice Title" Element Settings.

$clNoticeTitle->setID("notice-title");
$clNoticeTitle->setClass("info-title");
$clNoticeTitle->setContent(Locales::getNoticeTitle("acc-info"));

$rwNoticeOne->addCell($clNoticeTitle);

// "Collumn Notice Content" Element Settings.

$clNoticeContent->setID("notice-content");
$clNoticeContent->setClass("info-content");
$clNoticeContent->setContent(Locales::getNoticeContent("acc-info"));

$rwNoticeTwo->addCell($clNoticeContent);

// "Form Account Recovery" Element Settings.

$fmAccountRecovery->setID("account-recovery-form");
$fmAccountRecovery->setClass("default-form");
$fmAccountRecovery->setMethod(FForm::MTD_POST);
$fmAccountRecovery->setAction("./?$pnv=" . Locales::getLink("account-recovery"));

$fmAccountRecovery->addItem($tblAccountRecovery);

// "Table Account Recovery" Element Settings.

$tblAccountRecovery->setID("account-recovery-table");
$tblAccountRecovery->setClass("default-table");

$tblAccountRecovery->addRow($rowEmailAddress);

if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
    $tblAccountRecovery->addRow($rowCaptcha);

$tblAccountRecovery->addRow($rowSubmit);

// "Row Email Address" Element Settings.

$rowEmailAddress->addCell(new FTableCell(null, null, new FLabel("email-address", Locales::getCore("email-address"))));
$rowEmailAddress->addCell(new FTableCell(null, null, $inpEmailAddress));

// "Row CAPTCHA" Element Settings.

$rowCaptcha->addCell(new FTableCell(null, "captcha-left", new FLabel("login-captcha", Captcha::getChallenge()), null, null, FTableCell::ALN_RIGHT));
$rowCaptcha->addCell(new FTableCell(null, "captcha-right", $inpCaptcha));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, 0, FTableCell::ALN_RIGHT));

// "Input Email Address" Element Settings.

$inpEmailAddress->setID("email-address-input");
$inpEmailAddress->setClass("form-input");
$inpEmailAddress->setMaxLength(150);
$inpEmailAddress->setType(FInput::TP_TEXT);
$inpEmailAddress->setName("req_email");

// "Input CAPTCHA" Element Settings.

$inpCaptcha->setID("captcha-input");
$inpCaptcha->setClass("form-input");
$inpCaptcha->setMaxLength(2);
$inpCaptcha->setType(FInput::TP_TEXT);
$inpCaptcha->setName("req_captcha");

// "Button Reset" Element Settings.

$btnReset->setID("account-recovery-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("account-recovery-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("resend"));

// "Paragraph Notice" Element Settings.

$parNotice->setAlignment(FParagraph::ALN_CENTER);
$parNotice->setContent(Locales::getParagraph("go-home"));
$parNotice->setLink("/");
$parNotice->setLinkTitle(Locales::getTitle("homepage"));

// Build Elements.

Build::element($hdAccountRecovery);
Build::element($tblNotice);
Build::element($fmAccountRecovery);
Build::element($parNotice);

?>