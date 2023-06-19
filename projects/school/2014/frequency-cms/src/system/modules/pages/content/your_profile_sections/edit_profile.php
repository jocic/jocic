<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: edit_profile.php                              *|
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

$varUsersID           = IDFetch::byUsername(Session::getUsername());
$varProfileStatus     = InfoFetch::fetchProfileStatus($varUsersID);
$varAvatar            = InfoFetch::fetchAvatar($varUsersID);
$varUsername          = InfoFetch::fetchUsername($varUsersID);
$varStatus            = InfoFetch::fetchStatus($varUsersID);
$varFirstName         = InfoFetch::fetchFirstName($varUsersID);
$varMiddleName        = InfoFetch::fetchMiddleName($varUsersID);
$varLastName          = InfoFetch::fetchLastName($varUsersID);
$varGender            = InfoFetch::fetchGender($varUsersID);
$varBirthday          = null;
$varEmailAddress      = InfoFetch::fetchEmailAddress($varUsersID);
$varBiography         = InfoFetch::fetchBio($varUsersID);

// Create "Core" Elements.

$hdEditProfile        = new FHeader();
$fmEditProfile        = new FForm();
$divProfileStatus     = new FDiv();
$divMainInfo          = new FDiv();
$divMainInfoLeftSide  = new FDiv();
$divMainInfoRightSide = new FDiv();
$divAvatarHolder      = new FDiv();
$divAvatar            = new FDiv();
$tblUserInfo          = new FTable();
$divEmailAddress      = new FDiv();
$tblEmailAddress      = new FTable();
$divBiography         = new FDiv();
$tblBiography         = new FTable();
$divFormOptions       = new FDiv();
$divProfileOptions    = new FDiv();

// Create "Row" Elements.

$rowUsername          = new FTableRow();
$rowStatus            = new FTableRow();
$rowFirstName         = new FTableRow();
$rowMiddleName        = new FTableRow();
$rowLastName          = new FTableRow();
$rowGender            = new FTableRow();
$rowBirthday          = new FTableRow();

// Create "Input" Elements.

$inpProfileStatus     = new FInput();
$inpAvatar            = new FInput();
$inpFirstName         = new FInput();
$inpMiddleName        = new FInput();
$inpLastName          = new FInput();
$selGender            = new FSelect();
$selDay               = new FSelect();
$selMonth             = new FSelect();
$selYear              = new FSelect();
$inpEmailAddress      = new FInput();
$inpBiography         = new FTextArea();
$btnReset             = new FButton();
$btnSubmit            = new FButton();

// Create "Link" Elements.

$lnkEditProfile       = new FAnchor();
$lnkChangePassword    = new FAnchor();
$lnkDeactivateAccount = new FAnchor();

// "Status" Variable Settings.

if ($varStatus == Account::STS_SUPER_ADMIN)
    $varStatus = Locales::getCore("super-administrator");
else if ($varStatus == Account::STS_ADMIN)
    $varStatus = Locales::getCore("administrator");
else if ($varStatus == Account::STS_REGULAR)
    $varStatus = Locales::getCore("regular");
else if ($varStatus == Account::STS_BANNED)
    $varStatus = Locales::getCore("banned");
else if ($varStatus == Account::STS_DEACTIVATED)
    $varStatus = Locales::getCore("deactivated");
else if ($varStatus == Account::STS_PENDING_VERIFICATION)
    $varStatus = Locales::getCore("pending-verification");
else
    exit();

// "Birthday" Variable Settings.

$varBirthday = new Date();

$varBirthday->setSQLDate(InfoFetch::fetchBirthday($varUsersID));

// "Header Edit Profile" Element Settings.

$hdEditProfile->setLevel(1);
$hdEditProfile->setContent(Locales::getTitle("edit-profile"));

// "Form Edit Form" Element Settings.

$fmEditProfile->setID("deactivate-account-form");
$fmEditProfile->setClass("default-form");

$fmEditProfile->setType("multipart/form-data");
$fmEditProfile->setMethod(FForm::MTD_POST);
$fmEditProfile->setAction("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-profile"));

$fmEditProfile->addItem($divProfileStatus);
$fmEditProfile->addItem($divMainInfo);
$fmEditProfile->addItem($divEmailAddress);
$fmEditProfile->addItem($divBiography);
$fmEditProfile->addItem($divFormOptions);

// "Div Profile Status" Element Settings.

$divProfileStatus->setID("profile-status");

$divProfileStatus->addElement($inpProfileStatus);

// "Div Main Info" Element Settings.

$divMainInfo->setID("main-info-content");

$divMainInfo->addElement($divMainInfoLeftSide);
$divMainInfo->addElement($divMainInfoRightSide);
$divMainInfo->addElement(new FDiv(null, "clr", null));

// "Div Main Info Left Side" Element Settings.

$divMainInfoLeftSide->setID("main-info-content-left");

$divMainInfoLeftSide->addElement($divAvatarHolder);

// "Div Main Info Right Side" Element Settings.

$divMainInfoRightSide->setID("main-info-content-right");

$divMainInfoRightSide->addElement($tblUserInfo);

// "Div Avatar Holder" Element Settings.

$divAvatarHolder->setID("users-avatar-holder");

$divAvatarHolder->addElement($divAvatar);
$divAvatarHolder->addElement($inpAvatar);

// "Div Avatar" Element Settings.

$divAvatar->setID("users-avatar");

if ($varAvatar == null)
    $divAvatar->addElement("<div style=\"width: 150px; height: 150px; background: url(" . CMS_ROOT . "system/assets/images/other/no_avatar.png) no-repeat center center; background-size: auto 150px;\"><div class=\"protected\">$varUsername</div></div>");
else
    $divAvatar->addElement("<div style=\"width: 150px; height: 150px; background: url(" . CMS_ROOT . "assets/avatars/$varAvatar) no-repeat center center; background-size: auto 150px;\"><div class=\"protected\">$varUsername</div></div>");

// "Table User Info Left" Element Settings.

$tblUserInfo->setID("users-info-table");

$tblUserInfo->addRow($rowUsername);
$tblUserInfo->addRow($rowStatus);
$tblUserInfo->addRow($rowFirstName);
$tblUserInfo->addRow($rowMiddleName);
$tblUserInfo->addRow($rowLastName);
$tblUserInfo->addRow($rowGender);
$tblUserInfo->addRow($rowBirthday);

// "Div Email Address" Element Settings.

$divEmailAddress->setID("users-email-address");

$divEmailAddress->addElement($tblEmailAddress);

// "Table Email Address" Element Settings.

$tblEmailAddress->setID("email-address-table");

$tblEmailAddress->addRow(new FTableRow(null, null, new FTableCell("email-address-title", null, Locales::getCore("email-address"))));
$tblEmailAddress->addRow(new FTableRow(null, null, new FTableCell("email-address-content", null, $inpEmailAddress)));

// "Div Biography" Element Settings.

$divBiography->setID("users-biography");

$divBiography->addElement($tblBiography);

// "Table Biography" Element Settings.

$tblBiography->setID("users-biography-table");

$tblBiography->addRow(new FTableRow(null, null, new FTableCell("biography-title", null, Locales::getCore("biography"))));
$tblBiography->addRow(new FTableRow(null, null, new FTableCell("biography-content", null, $inpBiography)));

// "Div Form Options" Element Settings.

$divFormOptions->setID("form-options-table");

$divFormOptions->addElement(array($btnReset, $btnSubmit));

// "Div Profile Options" Element Settings.

$divProfileOptions->setID("users-profile-options");

$divProfileOptions->addElement(array($lnkEditProfile, " | ", $lnkChangePassword, " | ", $lnkDeactivateAccount));

// "Row Username" Element Settings.

$rowUsername->setClass("user-info-row");

$rowUsername->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("username") . ":</strong>"));
$rowUsername->addCell(new FTableCell(null, null, $varUsername));

// "Row Status" Element Settings.

$rowStatus->setClass("user-info-row");

$rowStatus->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("status") . ":</strong>"));
$rowStatus->addCell(new FTableCell(null, null, $varStatus));

// "Row First Name" Element Settings.

$rowFirstName->setClass("user-info-row");

$rowFirstName->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("first-name") . ":</strong>"));
$rowFirstName->addCell(new FTableCell(null, null, $inpFirstName));

// "Row Middle Name" Element Settings.

$rowMiddleName->setClass("user-info-row");

$rowMiddleName->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("middle-name") . ":</strong>"));
$rowMiddleName->addCell(new FTableCell(null, null, $inpMiddleName));

// "Row Last Name" Element Settings.

$rowLastName->setClass("user-info-row");

$rowLastName->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("last-name") . ":</strong>"));
$rowLastName->addCell(new FTableCell(null, null, $inpLastName));

// "Row Gender" Element Settings.

$rowGender->setClass("user-info-row");

$rowGender->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("gender") . ":</strong>"));
$rowGender->addCell(new FTableCell(null, null, $selGender));

// "Row Birthday" Element Settings.

$rowBirthday->setClass("user-info-row");

$rowBirthday->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("birthday") . ":</strong>"));
$rowBirthday->addCell(new FTableCell(null, null, array($selDay, $selMonth, $selYear)));

// "Input Profile Status" Element Settings.

$inpProfileStatus->setID("profile-status-input");
$inpProfileStatus->setClass("form-input");
$inpProfileStatus->setMaxLength(150);
$inpProfileStatus->setType(FInput::TP_TEXT);
$inpProfileStatus->setContent($varProfileStatus);
$inpProfileStatus->setName("req_status");

// "Input Avatar" Element Settings.

$inpAvatar->setID("avatar-input");
$inpAvatar->setClass("form-input");
$inpAvatar->setType("file");
$inpAvatar->setName("req_avatar");

// "Input First Name" Element Settings.

$inpFirstName->setID("first-name-input");
$inpFirstName->setClass("form-input");
$inpFirstName->setMaxLength(50);
$inpFirstName->setType(FInput::TP_TEXT);
$inpFirstName->setContent($varFirstName);
$inpFirstName->setName("req_first_name");

// "Input Middle Name" Element Settings.

$inpMiddleName->setID("middle-name-input");
$inpMiddleName->setClass("form-input");
$inpMiddleName->setMaxLength(50);
$inpMiddleName->setType(FInput::TP_TEXT);
$inpMiddleName->setContent($varMiddleName);
$inpMiddleName->setName("req_middle_name");

// "Input Last Name" Element Settings.

$inpLastName->setID("last-name-input");
$inpLastName->setClass("form-input");
$inpLastName->setMaxLength(50);
$inpLastName->setType(FInput::TP_TEXT);
$inpLastName->setContent($varLastName);
$inpLastName->setName("req_last_name");

// "Select Gender" Element Settings.

$selGender->setClass("form-select");

$selGender->addOption(new FSelectOption(0, Locales::getCore("gender") . ":", false));

if ($varGender == 0)
    $selGender->addOption(new FSelectOption(1, Locales::getCore("male"), true));
else
    $selGender->addOption(new FSelectOption(1, Locales::getCore("male"), false));

if ($varGender == 1)
    $selGender->addOption(new FSelectOption(2, Locales::getCore("female"), true));
else
    $selGender->addOption(new FSelectOption(2, Locales::getCore("female"), false));

if ($varGender == 2)
    $selGender->addOption(new FSelectOption(3, Locales::getCore("other"), true));
else
    $selGender->addOption(new FSelectOption(3, Locales::getCore("other"), false));

$selGender->setName("req_gender");

// "Select Day" Element Settings.

$selDay->setClass("form-select");

$selDay->addOption(new FSelectOption(0, Locales::getCore("day") . ":", true));

for ($i = 1; $i <= 31; $i ++)
{
    if ($varBirthday->getDay() == $i)
        $selDay->addOption(new FSelectOption($i, $i, true));
    else
        $selDay->addOption(new FSelectOption($i, $i, false));
}

$selDay->setName("req_day");

// "Select Month" Element Settings.

$selMonth->setClass("form-select");

$selMonth->addOption(new FSelectOption(0, Locales::getCore("month") . ":", true));

for ($i = 1; $i <= 12; $i ++)
{
    if ($varBirthday->getMonth() == $i)
        $selMonth->addOption(new FSelectOption($i, $i, true));
    else
        $selMonth->addOption(new FSelectOption($i, $i, false));
}

$selMonth->setName("req_month");

// "Select Year" Element Settings.

$selYear->setClass("form-select");

$selYear->addOption(new FSelectOption(0, Locales::getCore("year") . ":", true));

 for($i = 2014; $i >= 1905; $i --)
 {
    if ($varBirthday->getYear() == $i)
        $selYear->addOption(new FSelectOption($i, $i, true));
    else
        $selYear->addOption(new FSelectOption($i, $i, false));
 }
 
 $selYear->setName("req_year");
 
 // "Input Email Address" Element Settings.

$inpEmailAddress->setID("email-address-input");
$inpEmailAddress->setClass("form-input");
$inpEmailAddress->setMaxLength(150);
$inpEmailAddress->setType(FInput::TP_TEXT);
$inpEmailAddress->setContent($varEmailAddress);
$inpEmailAddress->setName("req_email");

// "Input Biography" Element Settings.

$inpBiography->setID("biography-input");
$inpBiography->setClass("form-input");
$inpBiography->setMaxLength(2000);
$inpBiography->setContent($varBiography);
$inpBiography->setName("req_biography");

 // "Button Reset" Element Settings.

$btnReset->setID("edit-account-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("edit-account-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("edit"));
 
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

Build::element($hdEditProfile);
Build::element($fmEditProfile);
Build::element($divProfileOptions);

?>