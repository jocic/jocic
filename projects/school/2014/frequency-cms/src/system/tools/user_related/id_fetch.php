<?php

/***********************************************************\
|* Magnum CMS v1.0.0                                       *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: id_fetch.php                                  *|
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

class IDFetch
{
    // "Main" Methods.
    
    public static function byUsername($usernameValue)
    {
        // Filter Username.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z]/i");
        $filteredValue->setValue($usernameValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Fetching.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $data = EasyGet::execute
        (
            "TS: users",
            "CS: id",
            "ARGS: username = $filteredValue"
        );
        
        // Process The Data.
        
        $data = $data[0][0];
        
        if ($data == null)
            $data = 0;
        
        // Return The Data.
        
        return $data;
    }
    
    public static function byEmailAddress($emailAddressValue)
    {
        if (StringCheck::isEmailAddress($emailAddressValue))
        {
            // Perform Fetching.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $data = EasyGet::execute
            (
                "TS: user_info",
                "CS: id",
                "ARGS: email = $emailAddressValue"
            );

            // Return The Data.

            return $data[0][0];
        }
        else
            return 0;
    }
}

?>