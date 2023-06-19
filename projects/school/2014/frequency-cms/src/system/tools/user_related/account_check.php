<?php

/***********************************************************\
|* Magnum CMS v1.0.0                                       *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: account_check.php                             *|
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

// Class Starts.

class AccountCheck
{
    // "Is" Methods.
    
    public static function isEmailAvailable($emailAddress)
    {
        if (StringCheck::isEmailAddress($emailAddress))
        {
            // Count Users.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $data = EasyGet::execute
            (
                "TS: user_info",
                "CS: COUNT(`id`)",
                "ARGS: email = $emailAddress"
            );

            return $data[0][0] == 0;
        }
        else
            return false;
    }
    
    public static function isUsernameTaken($username)
    {
        // Filter Username.
        
        $filteredUsername = new FilteredVariable();
        
        $filteredUsername->setType(FilteredVariable::TP_CUSTOM);
        $filteredUsername->setRegularExpression("/[^\da-z]/i");
        $filteredUsername->setValue($username);
        
        $filteredUsername = $filteredUsername->getValue();
        
        // Perform The Check.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $data = EasyGet::execute
        (
            "TS: users",
            "CS: COUNT(`id`)",
            "ARGS: username = $filteredUsername"
        );

        return $data[0][0] == 1;
    }
    
    public static function isPasswordValid($enteredPassword, $userID)
    {
        // Create Salted Password.
        
        $enteredPassword = sha1($enteredPassword . " - " . Core::get(Core::PASSWORD_SALT));

        // Fetch User Passowrd.
        
        $userPassword = InfoFetch::fetchPassword($userID);
        
        return $enteredPassword == $userPassword;
    }

}

?>
