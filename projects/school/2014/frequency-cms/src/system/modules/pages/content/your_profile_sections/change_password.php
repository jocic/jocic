<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: change_password.php                           *|
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

$hdChangePassword     = new FHeader();
$divMainInfo          = new FDiv();
$fmChangePassword     = new FForm();
$tblChangePassword    = new FTable();
$divProfileOptions    = new FDiv();

// Create "Row" Elements.

$rowCurrentPassword   = new FTableRow();
$rowNewPassword       = new FTableRow();
$rowRetypePassword    = new FTableRow();
$rowSubmit            = new FTableRow();

// Create "Input" Elements.

$inpCurrentPassword   = new FInput();
$inpNewPassword       = new FInput();
$inpRetypePassword    = new FInput();
$btnReset             = new FButton();
$btnSubmit            = new FButton();

// Create "Link" Elements.

$lnkEditProfile       = new FAnchor();
$lnkChangePassword    = new FAnchor();
$lnkDeactivateAccount = new FAnchor();

// "Header Change Password" Element Settings.

$hdChangePassword->setLevel(1);
$hdChangePassword->setContent(Locales::getTitle("change-password"));

// "Div Main Info" Element Settings.

$divMainInfo->setID("profile-status");

$divMainInfo->addElement(Locales::getParagraph("you-will-be-logged-out"));

// "Form Change Password" Element Settings.

$fmChangePassword->setID("change-password-form");
$fmChangePassword->setClass("default-form");

$fmChangePassword->setMethod(FForm::MTD_POST);
$fmChangePassword->setAction("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("change-password"));

$fmChangePassword->addItem($tblChangePassword);

// "Table Change Password" Element Settings.

$tblChangePassword->setID("change-password-table");
$tblChangePassword->setClass("default-table");

$tblChangePassword->addRow($rowCurrentPassword);
$tblChangePassword->addRow($rowNewPassword);
$tblChangePassword->addRow($rowRetypePassword);
$tblChangePassword->addRow($rowSubmit);

// "Div Profile Options" Element Settings.

$divProfileOptions->setID("users-profile-options");

$divProfileOptions->addElement(array($lnkEditProfile, " | ", $lnkChangePassword, " | ", $lnkDeactivateAccount));

// "Row Current Password" Element Settings.

$rowCurrentPassword->addCell(new FTableCell(null, null, new FLabel("current-password", Locales::getCore("current-password"))));
$rowCurrentPassword->addCell(new FTableCell(null, null, $inpCurrentPassword));

// "Row New Password" Element Settings.

$rowNewPassword->addCell(new FTableCell(null, null, new FLabel("new-password", Locales::getCore("new-password"))));
$rowNewPassword->addCell(new FTableCell(null, null, $inpNewPassword));

// "Row Retype Password" Element Settings.

$rowRetypePassword->addCell(new FTableCell(null, null,new FLabel("retype-password", Locales::getCore("retype-password"))));
$rowRetypePassword->addCell(new FTableCell(null, null, $inpRetypePassword));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableRow::ALN_RIGHT));

// "Input Current Password" Element Settings.

$inpCurrentPassword->setID("current-password-input");
$inpCurrentPassword->setClass("form-input");
$inpCurrentPassword->setMaxLength(50);
$inpCurrentPassword->setType(FInput::TP_PASSWORD);
$inpCurrentPassword->setName("req_current");

// "Input New Password" Element Settings.

$inpNewPassword->setID("new-password-input");
$inpNewPassword->setClass("form-input");
$inpNewPassword->setMaxLength(50);
$inpNewPassword->setType(FInput::TP_PASSWORD);
$inpNewPassword->setName("req_new");

// "Input Retype Password" Element Settings.

$inpRetypePassword->setID("retype-password-input");
$inpRetypePassword->setClass("form-input");
$inpRetypePassword->setMaxLength(50);
$inpRetypePassword->setType(FInput::TP_PASSWORD);
$inpRetypePassword->setName("req_retype");

// "Button Reset" Element Settings.

$btnReset->setID("change-password-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("change-password-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("change"));

// "Link Edit Profile" Element Settings.

$lnkEditProfile->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-profile"));
$lnkEditProfile->setLinkTitle(Locales::getCore("edit-profile"));
$lnkEditProfile->setContent(Locales::getCore("edit-profile"));

// "Link Change Password" Element Settings.

$lnkChangePassword->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("change-password"));
$lnkChangePassword->setLinkTitle(Locales::getCore("change-password"));
$lnkChangePassword->setContent(Locales::getCore("change-password"));

// "Link Deactivate Account" Element Settings.

$lnkDeactivateAccount->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("deactivate-account"));
$lnkDeactivateAccount->setLinkTitle(Locales::getCore("deactivate-account"));
$lnkDeactivateAccount->setContent(Locales::getCore("deactivate-account"));

// Build Elements.

Build::element($hdChangePassword);
Build::element($divMainInfo);
Build::element($fmChangePassword);
Build::element($divProfileOptions);

?>