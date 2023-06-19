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

// Fetch Information.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

$varUserData = EasyGet::execute
(
    "TS: users",
    "CS: username, status",
    "ARGS: id = " . $_GET[Locales::getVariable("id")]
);

$varUserInfo = EasyGet::execute
(
    "TS: user_info",
    "CS: name, middle_name, surname, gender, birthday, email, first_ip, last_ip",
    "ARGS: id = " . $_GET[Locales::getVariable("id")]
);

// Process Data - First Name.

if ($varUserInfo[0]["name"] == null) 
    $varUserInfo[0]["name"] = "/";

// Process Data - Middle Name.

if ($varUserInfo[0]["middle_name"] == null)
    $varUserInfo[0]["middle_name"] = "/";

// Process Data - Last Name.

if ($varUserInfo[0]["surname"] == null)
    $varUserInfo[0]["surname"] = "/";

// Process Data - Gender.

if ($varUserInfo[0]["gender"] == 0)
    $varUserInfo[0]["gender"] = Locales::getCore("male");
else if ($varUserInfo[0]["gender"] == 1)
    $varUserInfo[0]["gender"] = Locales::getCore("female");
else if ($varUserInfo[0]["gender"] == 2)
    $varUserInfo[0]["gender"] = Locales::getCore("other");
else
    $varUserInfo[0]["gender"] = "/";

// Process Data - Birthday.

if ($varUserInfo[0]["birthday"] == "0000-00-00")
    $varUserInfo[0]["birthday"] = "/";

// Process Data - First IP.

if ($varUserInfo[0]["first_ip"] == null)
    $varUserInfo[0]["first_ip"] = "/";

// Process Data - Last IP.

if ($varUserInfo[0]["last_ip"] == null)
    $varUserInfo[0]["last_ip"] = "/";

// Process Data - Status.

if ($varUserData[0]["status"] == 0)
    $varUserData[0]["status"] = Locales::getCore("super-administrator");
else if ($varUserData[0]["status"] == 1)
    $varUserData[0]["status"] = Locales::getCore("administrator");
else if ($varUserData[0]["status"] == 2)
    $varUserData[0]["status"] = Locales::getCore("regular");
else if ($varUserData[0]["status"] == 3)
    $varUserData[0]["status"] = Locales::getCore("banned");
else if ($varUserData[0]["status"] == 4)
    $varUserData[0]["status"] = Locales::getCore("deactivated");
else if ($varUserData[0]["status"] == 5)
    $varUserData[0]["status"] = Locales::getCore("pending-verification");
else
    $varUserData[0]["status"] = "/";

// Create "Core" Elements.

$hdUserProfile   = new FHeader();
$tblUserProfile  = new FTable();
$parStatusInfo   = new FParagraph();

// Create Row Elements.

$rowInfoOne      = new FTableRow();
$rowInfoTwo      = new FTableRow();
$rowInfoThree    = new FTableRow();
$rowRegularOne   = new FTableRow();
$rowRegularTwo   = new FTableRow();
$rowRegularThree = new FTableRow();

// "Header User Profile" Element Settings.

$hdUserProfile->setLevel(2);
$hdUserProfile->setContent(Locales::getCore("profile") . " - " . $varUserData[0]["username"]);

// "Table User Profile" Element Settings.

$tblUserProfile->setID("user-profile-table");
$tblUserProfile->setClass("default-table");
$tblUserProfile->setAlignment(FTable::ALN_CENTER);

$tblUserProfile->addRow($rowInfoOne);
$tblUserProfile->addRow($rowRegularOne);
$tblUserProfile->addRow($rowInfoTwo);
$tblUserProfile->addRow($rowRegularTwo);
$tblUserProfile->addRow($rowInfoThree);
$tblUserProfile->addRow($rowRegularThree);

// "Row Info One" Element Settings.

$rowInfoOne->setID("info-row-1");
$rowInfoOne->setClass("info-row");

$rowInfoOne->addCell(new FTableCell(null, "user-info-cell-1", Locales::getCore("first-name")));
$rowInfoOne->addCell(new FTableCell(null, "user-info-cell-2", Locales::getCore("middle-name")));
$rowInfoOne->addCell(new FTableCell(null, "user-info-cell-3", Locales::getCore("last-name")));

// "Row Info Two" Element Settings.

$rowInfoTwo->setID("info-row-2");
$rowInfoTwo->setClass("info-row");

$rowInfoTwo->addCell(new FTableCell(null, "user-info-cell-1", Locales::getCore("gender")));
$rowInfoTwo->addCell(new FTableCell(null, "user-info-cell-2", Locales::getCore("birthday")));
$rowInfoTwo->addCell(new FTableCell(null, "user-info-cell-3", Locales::getCore("email-address")));

// "Row Info Three" Element Settings.

$rowInfoThree->setID("info-row-3");
$rowInfoThree->setClass("info-row");

$rowInfoThree->addCell(new FTableCell(null, "user-info-cell-1", Locales::getCore("username")));
$rowInfoThree->addCell(new FTableCell(null, "user-info-cell-2", Locales::getCore("first-ip")));
$rowInfoThree->addCell(new FTableCell(null, "user-info-cell-3", Locales::getCore("last-ip")));

// "Row Regular One" Element Settings.

$rowRegularOne->setID("regular-row-1");
$rowRegularOne->setClass("regular-row");

$rowRegularOne->addCell(new FTableCell(null, "user-info-cell-1", $varUserInfo[0]["name"]));
$rowRegularOne->addCell(new FTableCell(null, "user-info-cell-2", $varUserInfo[0]["middle_name"]));
$rowRegularOne->addCell(new FTableCell(null, "user-info-cell-3", $varUserInfo[0]["surname"]));

// "Row Regular Two" Element Settings.

$rowRegularTwo->setID("regular-row-2");
$rowRegularTwo->setClass("regular-row");

$rowRegularTwo->addCell(new FTableCell(null, "user-info-cell-1", $varUserInfo[0]["gender"]));
$rowRegularTwo->addCell(new FTableCell(null, "user-info-cell-2", $varUserInfo[0]["birthday"]));
$rowRegularTwo->addCell(new FTableCell(null, "user-info-cell-3", $varUserInfo[0]["email"]));

// "Row Regular Three" Element Settings.

$rowRegularThree->setID("regular-row-3");
$rowRegularThree->setClass("regular-row");

$rowRegularThree->addCell(new FTableCell(null, "user-info-cell-1", $varUserData[0]["username"]));
$rowRegularThree->addCell(new FTableCell(null, "user-info-cell-2", $varUserInfo[0]["first_ip"]));
$rowRegularThree->addCell(new FTableCell(null, "user-info-cell-3", $varUserInfo[0]["last_ip"]));

// "Paragraph Status Info" Element Settings.

$parStatusInfo->setClass("info-paragraph");
$parStatusInfo->setAlignment(FParagraph::ALN_CENTER);

$parStatusInfo->setContent("<strong>" . Locales::getCore("status") . ":</strong> " . $varUserData[0]["status"]);

// Append Elements To "Workplace".

$divWorkplace->addElement($hdUserProfile);
$divWorkplace->addElement($tblUserProfile);
$divWorkplace->addElement($parStatusInfo);

?>