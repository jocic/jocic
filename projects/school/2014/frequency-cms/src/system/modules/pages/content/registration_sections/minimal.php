<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: minimal.php                                   *|
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

// Create "Core" Elements.

$hdRegistration  = new FHeader();
$tblFeatures     = new FTable();
$lstFeatures     = new FList();
$fmRegistration  = new FForm();
$tblRegistration = new FTable();
$parLinks        = new FParagraph();

// Create "Row" Elements.

$rowFeatureTitle = new FTableRow();
$rowFeatureList  = new FTableRow();
$rowUsername     = new FTableRow();
$rowPassword     = new FTableRow();
$rowEmail        = new FTableRow();
$rowCaptcha      = new FTableRow();
$rowTos          = new FTableRow();
$rowSubmit       = new FTableRow();

// Create "Input" Elements.

$inpUsername     = new FInput();
$inpPassword     = new FInput();
$inpEmail        = new FInput();
$inpCaptcha      = new FInput();
$inpTos          = new FInput();
$btnSubmit       = new FButton();

// "Header Registration" Element Setings.

$hdRegistration->setLevel(1);
$hdRegistration->setContent(Locales::getTitle("registration") . " - " . Locales::getSubtitle("new-account"));

// "Table Features" Element Settings.

$tblFeatures->setID("notice-table");
$tblFeatures->setClass("info-table");
$tblFeatures->addRow($rowFeatureTitle);
$tblFeatures->addRow($rowFeatureList);

// "Row Feature Title" Element Settings.

$rowFeatureTitle->addCell(new FTableCell("notice-title", "info-title", Locales::getCore("what-you-get")));

// "Row Feature List" Element Settings.

$rowFeatureList->addCell(new FTableCell("notice-content", "info-content", $lstFeatures));

// "List Features" Element Settings.

$lstFeatures->setType(FList::TP_UL);
$lstFeatures->setID("registration-list");

$lstFeatures->addItem(new FListItem(null, null, "<div class=\"protector\">" . Locales::getCore("wyg-1") . "</div>"));
$lstFeatures->addItem(new FListItem(null, null, "<div class=\"protector\">" . Locales::getCore("wyg-2") . "</div>"));
$lstFeatures->addItem(new FListItem(null, null, "<div class=\"protector\">" . Locales::getCore("wyg-3") . "</div>"));
$lstFeatures->addItem(new FListItem(null, null, "<div class=\"protector\">" . Locales::getCore("wyg-4") . "</div>"));

// "Form Registration" Element Settings.

$fmRegistration->setID("registration-form");
$fmRegistration->setClass("default-form");
$fmRegistration->setMethod(FForm::MTD_POST);
$fmRegistration->setAction("./?$pnv=" . Locales::getLink("registration"));

$fmRegistration->addItem($tblRegistration);

// "Table Registration" Element Settings.

$tblRegistration->setID("registration-table");
$tblRegistration->setClass("default-table");

$tblRegistration->addRow($rowUsername);
$tblRegistration->addRow($rowPassword);
$tblRegistration->addRow($rowEmail);
$tblRegistration->addRow($rowTos);

if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
    $tblRegistration->addRow($rowCaptcha);

$tblRegistration->addRow($rowSubmit);

// "Row Username" Element Settings.

$rowUsername->addCell(new FTableCell(null, null, new FLabel("username", Locales::getCore("username"))));
$rowUsername->addCell(new FTableCell(null, null, $inpUsername));

// "Row Password" Element Settings.

$rowPassword->addCell(new FTableCell(null, null, new FLabel("password", Locales::getCore("password"))));
$rowPassword->addCell(new FTableCell(null, null, $inpPassword));

// "Row Email" Element Settings.

$rowEmail->addCell(new FTableCell(null, null, new FLabel("email-address", Locales::getCore("email-address"))));
$rowEmail->addCell(new FTableCell(null, null, $inpEmail));

// "Row CAPTCHA" Element Settings.

$rowCaptcha->addCell(new FTableCell(null, "captcha-left", new FLabel("login-captcha", Captcha::getChallenge()), null, null, FTableCell::ALN_RIGHT));
$rowCaptcha->addCell(new FTableCell(null, "captcha-right", $inpCaptcha));

// "Row ToS" Element Settings.

$rowTos->addCell(new FTableCell(null, null, $inpTos, null, null, FTableCell::ALN_RIGHT));
$rowTos->addCell(new FTableCell(null, null, new FLabel("terms-of-service", Locales::getParagraph("registration-agreement"))));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, 2, 0, FTableCell::ALN_RIGHT));

// "Input Username" Element Settings.

$inpUsername->setID("username-input");
$inpUsername->setClass("form-input");
$inpUsername->setMaxLength(20);
$inpUsername->setType(FInput::TP_TEXT);
$inpUsername->setName("req_username");

// "Input Password" Element Settings.

$inpPassword->setID("password-input");
$inpPassword->setClass("form-input");
$inpPassword->setMaxLength(50);
$inpPassword->setType(FInput::TP_PASSWORD);
$inpPassword->setName("req_password");

// "Input Email" Element Settings.

$inpEmail->setID("email-address");
$inpEmail->setClass("form-input");
$inpEmail->setMaxLength(150);
$inpEmail->setType(FInput::TP_TEXT);
$inpEmail->setName("req_email");

// "Input CAPTCHA" Element Settings.

$inpCaptcha->setID("captcha-input");
$inpCaptcha->setClass("form-input");
$inpCaptcha->setMaxLength(2);
$inpCaptcha->setType(FInput::TP_TEXT);
$inpCaptcha->setName("req_captcha");

// "Input ToS" Element Settings.

$inpTos->setID("terms-of-service");
$inpTos->setClass("form-checkbox");
$inpTos->setType(FInput::TP_CHECKBOX);
$inpTos->setName("req_tos");

// "Input Submit" Element Settings.

$btnSubmit->setID("registration-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("register"));

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

Build::element($hdRegistration);
Build::element($tblFeatures);
Build::element($fmRegistration);
Build::element($parLinks);

?>