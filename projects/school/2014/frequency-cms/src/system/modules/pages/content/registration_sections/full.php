<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: full.php                                      *|
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
$rowFirstName    = new FTableRow();
$rowMiddleName   = new FTableRow();
$rowLastName     = new FTableRow();
$rowGender       = new FTableRow();
$rowBirthday     = new FTableRow();
$rowUsername     = new FTableRow();
$rowPassword     = new FTableRow();
$rowPasswordRe   = new FTableRow();
$rowEmail        = new FTableRow();
$rowCaptcha      = new FTableRow();
$rowTos          = new FTableRow();
$rowSubmit       = new FTableRow();

// Create "Input" Elements.

$inpFirstName    = new FInput();
$inpMiddleName   = new FInput();
$inpLastName     = new FInput();
$selGender       = new FSelect();
$selDay          = new FSelect();
$selMonth        = new FSelect();
$selYear         = new FSelect();
$inpUsername     = new FInput();
$inpPassword     = new FInput();
$inpPasswordRe   = new FInput();
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

$tblRegistration->addRow($rowFirstName);
$tblRegistration->addRow($rowMiddleName);
$tblRegistration->addRow($rowLastName);
$tblRegistration->addRow($rowGender);
$tblRegistration->addRow($rowBirthday);
$tblRegistration->addRow($rowUsername);
$tblRegistration->addRow($rowPassword);
$tblRegistration->addRow($rowPasswordRe);
$tblRegistration->addRow($rowEmail);
$tblRegistration->addRow($rowTos);

if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
    $tblRegistration->addRow($rowCaptcha);

$tblRegistration->addRow($rowSubmit);

// "Row First Name" Element Settings.

$rowFirstName->addCell(new FTableCell(null, null, new FLabel("first-name", Locales::getCore("first-name"))));
$rowFirstName->addCell(new FTableCell(null, null, $inpFirstName));

// "Row Middle Name" Element Settings.

$rowMiddleName->addCell(new FTableCell(null, null, new FLabel("middle-name", Locales::getCore("middle-name"))));
$rowMiddleName->addCell(new FTableCell(null, null, $inpMiddleName));

// "Row Last Name" Element Settings.

$rowLastName->addCell(new FTableCell(null, null, new FLabel("last-name", Locales::getCore("last-name"))));
$rowLastName->addCell(new FTableCell(null, null, $inpLastName));

// "Row Gender" Element Settings.

$rowGender->addCell(new FTableCell(null, null, new FLabel("gender", Locales::getCore("gender"))));
$rowGender->addCell(new FTableCell(null, null, $selGender));

// "Row Birthday" Element Settings.

$rowBirthday->addCell(new FTableCell(null, null, new FLabel("birthday", Locales::getCore("birthday"))));
$rowBirthday->addCell(new FTableCell(null, null, array($selDay, $selMonth, $selYear)));

// "Row Username" Element Settings.

$rowUsername->addCell(new FTableCell(null, null, new FLabel("username", Locales::getCore("username"))));
$rowUsername->addCell(new FTableCell(null, null, $inpUsername));

// "Row Password" Element Settings.

$rowPassword->addCell(new FTableCell(null, null, new FLabel("password", Locales::getCore("password"))));
$rowPassword->addCell(new FTableCell(null, null, $inpPassword));

// "Row Password Re" Element Settings.

$rowPasswordRe->addCell(new FTableCell(null, null, new FLabel("password-re", Locales::getCore("confirmation-password"))));
$rowPasswordRe->addCell(new FTableCell(null, null, $inpPasswordRe));

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

// "Input First Name" Element Settings.

$inpFirstName->setID("first-name-input");
$inpFirstName->setClass("form-input");
$inpFirstName->setMaxLength(50);
$inpFirstName->setType(FInput::TP_TEXT);
$inpFirstName->setName("req_name");

// "Input Middle Name" Element Settings.

$inpMiddleName->setID("middle-name-input");
$inpMiddleName->setClass("form-input");
$inpMiddleName->setMaxLength(50);
$inpMiddleName->setType(FInput::TP_TEXT);
$inpMiddleName->setName("req_middle_name");

// "Input Last Name" Element Settings.

$inpLastName->setID("last-name-input");
$inpLastName->setClass("form-input");
$inpLastName->setMaxLength(50);
$inpLastName->setType(FInput::TP_TEXT);
$inpLastName->setName("req_surname");

// "Select Gender" Element Settings.

$selGender->setClass("form-select");

$selGender->addOption(new FSelectOption(0, Locales::getCore("gender") . ":", true));
$selGender->addOption(new FSelectOption(1, Locales::getCore("male"), false));
$selGender->addOption(new FSelectOption(2, Locales::getCore("female"), false));
$selGender->addOption(new FSelectOption(3, Locales::getCore("other"), false));

$selGender->setName("req_gender");

// "Select Day" Element Settings.

$selDay->setClass("form-select");

$selDay->addOption(new FSelectOption(0, Locales::getCore("day") . ":", true));

for ($i = 1; $i <= 31; $i ++)
    $selDay->addOption(new FSelectOption($i, $i, false));

$selDay->setName("req_day");

// "Select Month" Element Settings.

$selMonth->setClass("form-select");

$selMonth->addOption(new FSelectOption(0, Locales::getCore("month") . ":", true));

for ($i = 1; $i <= 12; $i ++)
    $selMonth->addOption(new FSelectOption($i, $i, false));

$selMonth->setName("req_month");

// "Select Year" Element Settings.

$selYear->setClass("form-select");

$selYear->addOption(new FSelectOption(0, Locales::getCore("year") . ":", true));

 for($i = 2014; $i >= 1905; $i --)
    $selYear->addOption(new FSelectOption($i, $i, false));
 
 $selYear->setName("req_year");

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

// "Input Password Re" Element Settings.

$inpPasswordRe->setID("password-re-input");
$inpPasswordRe->setClass("form-input");
$inpPasswordRe->setMaxLength(50);
$inpPasswordRe->setType(FInput::TP_PASSWORD);
$inpPasswordRe->setName("req_password_re");

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