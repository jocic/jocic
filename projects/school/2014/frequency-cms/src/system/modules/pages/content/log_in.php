<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: log_in.php                                    *|
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

$hdLogin          = new FHeader();
$tblFeatures      = new FTable();
$fmLogin          = new FForm();
$tblLogin         = new FTable();
$parTerms         = new FParagraph();
$parReset         = new FParagraph();

// Create "Row" Elements.

$rowFeaturesOne   = new FTableRow();
$rowFeaturesTwo   = new FTableRow();
$rowFeaturesThree = new FTableRow();
$rowUsername      = new FTableRow();
$rowPassword      = new FTableRow();
$rowCaptcha       = new FTableRow();
$rowSubmit        = new FTableRow();

// Create "Input" Elements.

$inpUsername      = new FInput();
$inpPassword      = new FInput();
$inpCaptcha       = new FInput();
$btnSubmit        = new FButton();

// Create "Other" Elements.

$lnkRegister      = new FAnchor();

// "Login Header" Element Settings.

$hdLogin->setLevel(1);
$hdLogin->setContent(Locales::getTitle("log-in"));

// "Table Features" Element Settings.

$tblFeatures->setID("feature-table");

$tblFeatures->addRow($rowFeaturesOne);
$tblFeatures->addRow($rowFeaturesTwo);
$tblFeatures->addRow($rowFeaturesThree);

// "Row Features One" Element Settings.

$rowFeaturesOne->setID("feature-table-row-1");
$rowFeaturesOne->setClass("default-table-row");

$rowFeaturesOne->addCell(new FTableCell("feature-icon-people", "feature-icon", new FDiv(null, "protector", Locales::getParagraph("meet-new-people"))));
$rowFeaturesOne->addCell(new FTableCell("feature-info-1", "feautre-info", array(new FLabel("important", Locales::getParagraph("uya-1")), Locales::getParagraph("uya-1a"))));

// "Row Features Two" Element Settings.

$rowFeaturesTwo->setID("feature-table-row-2");
$rowFeaturesTwo->setClass("default-table-row");

$rowFeaturesTwo->addCell(new FTableCell("feature-icon-blog", "feature-icon", new FDiv(null, "protector", Locales::getCore("blog"))));
$rowFeaturesTwo->addCell(new FTableCell("feature-info-2", "feautre-info", array(new FLabel("important", Locales::getParagraph("uya-2")), Locales::getParagraph("uya-2a"))));

// "Row Features Three" Element Settings.

$rowFeaturesThree->setID("feature-table-row-3");
$rowFeaturesThree->setClass("default-table-row");

$rowFeaturesThree->addCell(new FTableCell("feature-icon-chat", "feature-icon", new FDiv(null, "protector", Locales::getCore("chat"))));
$rowFeaturesThree->addCell(new FTableCell("feature-info-3", "feautre-info", array(new FLabel("important", Locales::getParagraph("uya-3")), Locales::getParagraph("uya-3a"))));

// "Login Form" Element Settings.

$fmLogin->setID("log-in-form");
$fmLogin->setClass("default-form");
$fmLogin->setMethod(FForm::MTD_POST);
$fmLogin->setAction("./?$pnv=" . Locales::getLink("log-in"));

$fmLogin->addItem($tblLogin);

// "Login Table" Element Settings.

$tblLogin->setID("log-in-table");
$tblLogin->setClass("default-table");

$tblLogin->addRow($rowUsername);
$tblLogin->addRow($rowPassword);

if (Core::get(Core::DEPLOY_CAPTCHA) == "yes") // Append "CAPTCHA Row".
    $tblLogin->addRow($rowCaptcha);

$tblLogin->addRow($rowSubmit);

// "Row Username" Settings.

$rowUsername->addCell(new FTableCell(null, null, new FLabel("username", Locales::getCore("username"))));
$rowUsername->addCell(new FTableCell(null, null, $inpUsername));

// "Row Password" Settings.

$rowPassword->addCell(new FTableCell(null, null, new FLabel("password", Locales::getCore("password"))));
$rowPassword->addCell(new FTableCell(null, null, $inpPassword));

// "CAPTCHA Row" Element Settings.

$rowCaptcha->addCell(new FTableCell(null, null, new FLabel("login-captcha", Captcha::getChallenge()), null, null, FTableCell::ALN_RIGHT));
$rowCaptcha->addCell(new FTableCell(null, null, $inpCaptcha));

// "Submit Row" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, $lnkRegister, null, null, FTableCell::ALN_LEFT));
$rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, null, null, FTableCell::ALN_RIGHT));

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

// "Input Captcha" Element Settings.

$inpCaptcha->setID("captcha-input");
$inpCaptcha->setClass("form-input");
$inpCaptcha->setMaxLength(2);
$inpCaptcha->setType(FInput::TP_TEXT);
$inpCaptcha->setName("req_captcha");

// "Link Register" Element Settings.

$lnkRegister->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("registration"));
$lnkRegister->setLinkTitle(Locales::getCore("register"));
$lnkRegister->setContent(Locales::getCore("register"));

// "Input Submit" Element Settings.

$btnSubmit->setID("login-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("log-in"));

// "Terms" Element Settings.

$parTerms->setAlignment(FParagraph::ALN_CENTER);
$parTerms->setContent
(
    Locales::getParagraph("by-clicking-log-in") .
    " <a href=\"" . "./?" .
    Locales::getVariable("page") .
    "=" .
    Locales::getLink("terms-of-service") .
    "\">" .
    Locales::getCore("terms-of-service") .
    "</a> " .
    Locales::getCore("and") .
    " <a href=\"" . "./?" .
    Locales::getVariable("page") .
    "=" .
    Locales::getLink("privacy-policy") .
    "\">" .
    Locales::getCore("privacy-policy") .
    "</a>."
);

// "Reset" Element Settings.

$parReset->setAlignment(FParagraph::ALN_CENTER);
$parReset->setContent
(
        Locales::getParagraph("caa-1") .
        " <a href=\"" . "./?" .
        Locales::getVariable("page") .
        "=" .
        Locales::getLink("account-recovery") .
        "\">" .
        Locales::getCore("here") .
        "</a>. " .
         Locales::getParagraph("caa-2") .
        " <a href=\"" . "./?" .
        Locales::getVariable("page") .
        "=" .
        Locales::getLink("resend-activation-email") .
        "\">" .
        Locales::getCore("here") .
        "</a>."
);

// Build Elements.

Build::element($hdLogin);
Build::element($tblFeatures);
Build::element($fmLogin);
Build::element($parTerms);
Build::element($parReset);

?>
