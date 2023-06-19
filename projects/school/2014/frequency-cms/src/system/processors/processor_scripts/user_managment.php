<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: user_managment.php                            *|
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

// Check If Option And ID Selected.

if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")])) 
{
    // Create "Core" Variables.
    
    $varUsersID     = Filter::forNumeric($_GET[Locales::getVariable("id")]);
    $varUsersStatus = null;

    // "Users Status" Variable Settings.

    EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

    $varUsersStatus = EasyGet::execute
    (
        "TS: users",
        "CS: status",
        "ARGS: id = $varUsersID"
    );
    
    if ($varUsersStatus == null) // User Does Not Exists If The Status Value Is Null.
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("user-managment")));
    else
        $varUsersStatus = $varUsersStatus[0][0];
    
    // Show Profile.

    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-profile"))
    {
        return;
    }
    
    // Promote User.
    
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("promote-user"))
    {
        // Check If User Is Regular (Regular Users Can Only Be Promoted).
        
        if ($varUsersStatus == Account::STS_REGULAR)
        {
            EasyUpdate::execute // Set Status.
            (
                "TS: users",
                "CS: status",
                "VLS: " . Account::STS_ADMIN,
                "ARGS: id = $varUsersID"
            );
        }
    }
    
    // Demote User.
    
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("demote-user"))
    {
        // Check If User Is Admin (Admins Can Only Be Demoted).
        
        if ($varUsersStatus == Account::STS_ADMIN)
        {
            EasyUpdate::execute // Set Status.
            (
                "TS: users",
                "CS: status",
                "VLS: " . Account::STS_REGULAR,
                "ARGS: id = $varUsersID"
            );
        }
    }
    
    // Ban User
    
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("ban-user"))
    {
        // Check If User Is Not Super Admin, Already Banned Or Pending.

        if ($varUsersStatus != Account::STS_SUPER_ADMIN &&
            $varUsersStatus != Account::STS_BANNED &&
            $varUsersStatus != Account::STS_DEACTIVATED &&
            $varUsersStatus != Account::STS_PENDING_VERIFICATION)
        {

            EasyUpdate::execute // Set Status.
            (
                "TS: users",
                "CS: status",
                "VLS: " . Account::STS_BANNED,
                "ARGS: id = $varUsersID"
            );
        }
    }
    
    // Unban User.
    
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("unban-user")) 
    {
        if ($varUsersStatus == Account::STS_BANNED)
        {
            EasyUpdate::execute // Set Status.
            (
                "TS: users",
                "CS: status",
                "VLS: " . Account::STS_REGULAR,
                "ARGS: id = $varUsersID"
            );
        }
    }

    // Reddirect.

    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("user-managment")));
}

?>