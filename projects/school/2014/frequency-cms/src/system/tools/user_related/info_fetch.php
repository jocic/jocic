<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: info_fetch.php                                *|
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

class InfoFetch
{
    // "Core" Variables.
    
    private static $FLAG_DO_EXECUTE = false;
    
    // "Core" Methods.
    
    public static function fetchUsername($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "users", "username");
    }
    
    public static function fetchPassword($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "users", "password");
    }
    
    public static function fetchStatus($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "users", "status");
    }
    
    public static function fetchVerification($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "users", "verification");
    }
    
    public static function fetchFirstName($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "name");
    }
    
    public static function fetchMiddleName($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "middle_name");
    }
    
    public static function fetchLastName($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "surname");
    }
    
    public static function fetchGender($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "gender");
    }
    
    public static function fetchBirthday($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "birthday");
    }
    
    public static function fetchEmailAddress($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "email");
    }
    
    public static function fetchFirstIP($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "first_ip");
    }
    
    public static function fetchLastIP($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_info", "last_ip");
    }
    
    public static function fetchPreferedLanguage($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_personals", "prefered_language");
    }
    
    public static function fetchProfileStatus($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_personals", "profile_status");
    }
    
    public static function fetchBio($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_personals", "bio");
    }
    
    public static function fetchAvatar($id)
    {
        self::$FLAG_DO_EXECUTE = true;
        
        return self::genericFetch($id, "user_personals", "avatar");
    }
    
    // "Main" Methods.
    
    private static function genericFetch($id, $table, $column)
    {
        if (self::$FLAG_DO_EXECUTE)
        {
            // Filter ID.

            $filteredID = new FilteredVariable();

            $filteredID->setType(FilteredVariable::TP_NUMBERS);
            $filteredID->setValue($id);

            $filteredID = $filteredID->getValue();

            // Perform Fetching.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $data = EasyGet::execute
            (
                "TS: $table",
                "CS: $column",
                "ARGS: id = $filteredID"
            );

            // Return The Data.

            return $data[0][0];
        }
        else
            return null;
    }
}

?>
