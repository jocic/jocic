<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: view_profile.php                              *|
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

// Create "Core" Variables.

$varUsersID           = $_GET[Locales::getVariable("id")];
$varProfileStatus     = InfoFetch::fetchProfileStatus($varUsersID);
$varAvatar            = InfoFetch::fetchAvatar($varUsersID);
$varUsername          = InfoFetch::fetchUsername($varUsersID);
$varStatus            = InfoFetch::fetchStatus($varUsersID);
$varFirstName         = InfoFetch::fetchFirstName($varUsersID);
$varMiddleName        = InfoFetch::fetchMiddleName($varUsersID);
$varLastName          = InfoFetch::fetchLastName($varUsersID);
$varGender            = InfoFetch::fetchGender($varUsersID);
$varBirthday          = null;
$varBiography         = InfoFetch::fetchBio($varUsersID);

// Create "Core" Elements.

$hdViewProfile        = new FHeader();
$divProfileStatus     = new FDiv();
$divMainInfo          = new FDiv();
$divMainInfoLeftSide  = new FDiv();
$divMainInfoRightSide = new FDiv();
$divAvatarHolder      = new FDiv();
$divAvatar            = new FDiv();
$tblUserInfo          = new FTable();
$divBiography         = new FDiv();
$tblBiography         = new FTable();

// Create "Row" Elements.

$rowUsername          = new FTableRow();
$rowStatus            = new FTableRow();
$rowFirstName         = new FTableRow();
$rowMiddleName        = new FTableRow();
$rowLastName          = new FTableRow();
$rowGender            = new FTableRow();
$rowBirthday          = new FTableRow();

// "Profile Status" Variable Settings.

if (empty($varProfileStatus))
    $varProfileStatus = Locales::getParagraph("status-not-set");

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

// "First Name" Variable Settings.

if ($varFirstName == null)
    $varFirstName = "/";

// "Middle Name" Variable Settings.

if ($varMiddleName == null)
    $varMiddleName = "/";

// "Last Name" Variable Settings.

if ($varLastName == null)
    $varLastName = "/";

// "Gender" Variable Settings.

if ($varGender == 0)
    $varGender = Locales::getCore("male");
else if ($varGender == 1)
    $varGender = Locales::getCore("female");
else if ($varGender == 2)
    $varGender = Locales::getCore("other");
else
    exit();

// "Birthday" Variable Settings.

$varBirthday = new Date();

$varBirthday =  $varBirthday->convertSQLDate(InfoFetch::fetchBirthday($varUsersID));

if ($varBirthday == "...")
    $varBirthday = "/";

// "Biography" Variable Settings.

if ($varBiography == null)
    $varBiography = Locales::getParagraph("bio-not-set");

// "Header View Profile" Element Settings.

$hdViewProfile->setLevel(1);
$hdViewProfile->setContent(Locales::getTitle("view-profile"));

// "Div Profile Status" Element Settings.

$divProfileStatus->setID("profile-status");

$divProfileStatus->addElement($varProfileStatus);

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

// "Div Biography" Element Settings.

$divBiography->setID("users-biography");

$divBiography->addElement($tblBiography);

// "Table Biography" Element Settings.

$tblBiography->setID("users-biography-table");

$tblBiography->addRow(new FTableRow(null, null, new FTableCell("biography-title", null, Locales::getCore("biography"))));
$tblBiography->addRow(new FTableRow(null, null, new FTableCell("biography-content", null, $varBiography)));

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
$rowFirstName->addCell(new FTableCell(null, null, $varFirstName));

// "Row Middle Name" Element Settings.

$rowMiddleName->setClass("user-info-row");

$rowMiddleName->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("middle-name") . ":</strong>"));
$rowMiddleName->addCell(new FTableCell(null, null, $varMiddleName));

// "Row Last Name" Element Settings.

$rowLastName->setClass("user-info-row");

$rowLastName->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("last-name") . ":</strong>"));
$rowLastName->addCell(new FTableCell(null, null, $varLastName));

// "Row Gender" Element Settings.

$rowGender->setClass("user-info-row");

$rowGender->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("gender") . ":</strong>"));
$rowGender->addCell(new FTableCell(null, null, $varGender));

// "Row Birthday" Element Settings.

$rowBirthday->setClass("user-info-row");

$rowBirthday->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("birthday") . ":</strong>"));
$rowBirthday->addCell(new FTableCell(null, null, $varBirthday));

// Build Elements.

Build::element($hdViewProfile);
Build::element($divProfileStatus);
Build::element($divMainInfo);
Build::element($divBiography);

?>