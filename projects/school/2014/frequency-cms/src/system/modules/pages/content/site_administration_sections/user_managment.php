<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: user_managmet.php                             *|
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

$varCoreLink = CMS_ROOT .
               "?" .
               Locales::getVariable("page") .
               "=" .
               Locales::getLink("site-administration") .
               "&" .
               Locales::getVariable("workplace") .
               "=" .
               Locales::getLink("user-managment");

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "user_managment" .
                    DIRECTORY_SEPARATOR;

$varCharacters = array
(
    '0', '1', '2', '3', '4', '5', '6',
    '7', '8', '9', 'A', 'B', 'C', 'D',
    'E', 'F', 'G', 'H', 'I', 'J', 'K',
    'L', 'M', 'N', 'O', 'P', 'Q', 'R',
    'S', 'T', 'U', 'V', 'W', 'X', 'Y',
    'Z'
);

// Create "Prefix And Sufix Stuff For Links" Variables.

$varViewProfilePrefix = "<a id=\"profile-icon\" class=\"options-icon\" title=\"" . Locales::getCore("view-profile") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-profile") . "&" . Locales::getVariable("id") . "=";
$varPromoteUserPrefix = "<a id=\"promote-icon\" class=\"options-icon\" title=\"" . Locales::getCore("promote-user") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("promote-user") . "&" . Locales::getVariable("id") . "=";
$varDemoteUserPrefix  = "<a id=\"demote-icon\" class=\"options-icon\" title=\"" . Locales::getCore("demote-user") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("demote-user") . "&" . Locales::getVariable("id") . "=";
$varBanUserPrefix     = "<a id=\"ban-icon\" class=\"options-icon\" title=\"" . Locales::getCore("ban-user") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("ban-user") . "&" . Locales::getVariable("id") . "=";
$varUnbanUserPrefix   = "<a id=\"unban-icon\" class=\"options-icon\" title=\"" . Locales::getCore("unban-user") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("unban-user") . "&" . Locales::getVariable("id") . "=";

$varViewProfileSufix  = "\" />" . Locales::getCore("view-profile") . "</a>";
$varPromoteUserSufix  = "\" />" . Locales::getCore("promote-user") . "</a>";
$varDemoteUserSufix   = "\" />" . Locales::getCore("demote-user") . "</a>";
$varBanUserSufix      = "\" />" . Locales::getCore("ban-user") . "</a>";
$varUnbanUserSufix    = "\" />" . Locales::getCore("unban-user") . "</a>";

// SPECIFIC PAGE ACTION STARTS HERE.

if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-profile")) // Show Profile Information (If Selected).
        require_once $varSubScriptRoot . "view_profile.php";
}

// SPECIFIC PAGE ACTION ENDS HERE.

// Create Default Column Row.

$rowInfoRow = new FTableRow(null, "info-row");

$rowInfoRow->addCell(new FTableCell(null, "table-cell-id", "#"));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-username", Locales::getCore("username")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-status", Locales::getCore("status")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-ip", Locales::getCore("first-ip")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-ip", Locales::getCore("last-ip")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

foreach ($varCharacters as $character) // Fetch Users By Letter And Display Info.
{
    // Set Fetch Mode.

    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

    EasyGet::setOrderBy("id", EasyGet::OB_ASC);
    
    $varUserData = EasyGet::execute // Fetch Username And Statuses.
    (
        "TS: users",
        "CS: id, username, status",
        "ARGS: username LIKE $character%"
    );

    if ($varUserData != null) // Print Information - Tabelar.
    {   
        $tblUserInfo = new FTable("users-table", "default-admin-table", "center");

        $tblUserInfo->addRow($rowInfoRow);

        for ($i = 0; $i < count($varUserData); $i ++) // Add User Info.
        {
            // Fetch IPs.

            $varUserInfo = EasyGet::execute
            (
                "TS: user_info",
                "CS: first_ip, last_ip",
                "ARGS: id = " . $varUserData[$i]["id"]
            );

            // Status.

            if ($varUserData[$i]["status"] == 0)
                $varUserData[$i]["status"] = Locales::getCore("super-administrator");
            else if ($varUserData[$i]["status"] == 1)
                $varUserData[$i]["status"] = Locales::getCore("administrator");
            else if ($varUserData[$i]["status"] == 2)
                $varUserData[$i]["status"] = Locales::getCore("regular");
            else if ($varUserData[$i]["status"] == 3)
                $varUserData[$i]["status"] = Locales::getCore("banned");
            else if ($varUserData[$i]["status"] == 4)
                $varUserData[$i]["status"] = Locales::getCore("deactivated");
            else if ($varUserData[$i]["status"] == 5)
                $varUserData[$i]["status"] = Locales::getCore("pending-verification");
            else
                $varUserData[$i]["status"] = "/";

            // Options.

            $userOpt = $varViewProfilePrefix . $varUserData[$i]["id"] . $varViewProfileSufix . " " . // View Profile.
                       $varPromoteUserPrefix . $varUserData[$i]["id"] . $varPromoteUserSufix . " " . // Promote.
                       $varDemoteUserPrefix . $varUserData[$i]["id"] . $varDemoteUserSufix . " " .   // Demote.
                       $varBanUserPrefix . $varUserData[$i]["id"] . $varBanUserSufix . " " .         // Ban.
                       $varUnbanUserPrefix . $varUserData[$i]["id"] . $varUnbanUserSufix;            // Unban.
            
            // Create And Add User Info Row.
            
            $rowUserInfo = new FTableRow();

            $rowUserInfo->addCell(new FTableCell(null, "table-cell-id", ($i + 1)));
            $rowUserInfo->addCell(new FTableCell(null, "table-cell-username", "<a href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-profile") . "&" . Locales::getVariable("id") . "=" . $varUserData[$i]["id"] . "\" />" . $varUserData[$i]["username"] . "</a>"));
            $rowUserInfo->addCell(new FTableCell(null, "table-cell-status", $varUserData[$i]["status"]));
            $rowUserInfo->addCell(new FTableCell(null, "table-cell-ip", $varUserInfo[0]["first_ip"]));
            $rowUserInfo->addCell(new FTableCell(null, "table-cell-ip", $varUserInfo[0]["last_ip"]));
            $rowUserInfo->addCell(new FTableCell(null, "table-cell-options", $userOpt));
            
            $tblUserInfo->addRow($rowUserInfo);
        }
        
        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement(new FHeader(2, $character));
        $divWorkplace->addElement($tblUserInfo);
    }
}

?>