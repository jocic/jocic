<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: info_alter.php                                *|
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

class InfoAlter
{
    // "Core" Variables.
    
    private static $FLAG_DO_EXECUTE = false;
    
    // "Core" Methods.
    
    public static function alterUsername($newValue, $id)
    {
        // Filter Username.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "users", "username");
    }
    
    public static function alterPassword($newValue, $id)
    {
        // Filter Password.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z!@#$%^&*()_+]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "users", "password");
    }
    
    public static function alterStatus($newValue, $id)
    {
        // Filter Status.
        
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_NUMBERS);
        $filteredValue->setValue($newValue);

        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "users", "status");
    }
    
    public static function alterVerification($newValue, $id)
    {
        // Filter Verification.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "users", "verification");
    }
    
    public static function alterFirstName($newValue, $id)
    {
        // Filter First Name.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_info", "name");
    }
    
    public static function alterMiddleName($newValue, $id)
    {
        // Filter Middle Name.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z.]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_info", "middle_name");
    }
    
    public static function alterLastName($newValue, $id)
    {
        // Filter Last Name.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_info", "surname");
    }
    
    public static function alterGender($newValue, $id)
    {
        // Filter Gender.
        
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_NUMBERS);
        $filteredValue->setValue($newValue);

        $filteredValue = $filteredValue->getValue();
        
        if ($filteredValue == null)
            $filteredValue = 0;
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_info", "gender");
    }
    
    public static function alterBirthday($newValue, $id)
    {
        // Filter Birthday.
        
        $date = new Date();
        
        $date->setSQLDate($newValue);
        
        // Perform Alteration.
        
        if ($date->isValid())
        {
            self::$FLAG_DO_EXECUTE = true;
            
            self::genericAlter($date->getSQLDate(), $id, "user_info", "birthday");
        }
    }
    
    public static function alterEmailAddress($newValue, $id)
    {
        // Perform Alteration.
        
        if (StringCheck::isEmailAddress($newValue))
        {
            self::$FLAG_DO_EXECUTE = true;
            
            self::genericAlter($newValue, $id, "user_info", "email");
        }
    }
    
    public static function alterFirstIP($newValue, $id)
    {
        // Filter First IP.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z.]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_info", "first_ip");
    }
    
    public static function alterLastIP($newValue, $id)
    {
        // Filter Last IP.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z.:]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_info", "last_ip");
    }
    
    public static function alterPreferedLanguage($newValue, $id)
    {
        // Filter Perefered Language Vale.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_TEXT_LOWR);
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_personals", "prefered_language");
    }
    
    public static function alterProfileStatus($newValue, $id)
    {
        // Filter Perefered Language Vale.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z\\s'\"!@#$%^&*()_+.]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_personals", "profile_status");
    }
    
    public static function alterBio($newValue, $id)
    {
        // Filter Perefered Language Vale.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z\\s\\n\\r'\"!@#$%^&*()_+.]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_personals", "bio");
    }
    
    public static function alterAvatar($newValue, $id)
    {
        // Filter Perefered Language Vale.
        
        $filteredValue = new FilteredVariable();
        
        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^a-zA-Z0-9.]/i");
        $filteredValue->setValue($newValue);
        
        $filteredValue = $filteredValue->getValue();
        
        // Perform Alteration.
        
        self::$FLAG_DO_EXECUTE = true;
        
        self::genericAlter($filteredValue, $id, "user_personals", "avatar");
    }
    
    // "Main" Methods.
    
    private static function genericAlter($newValue, $id, $table, $column)
    {
        if (self::$FLAG_DO_EXECUTE)
        {
            self::$FLAG_DO_EXECUTE = false;
            
            // Filter ID.

            $filteredID = new FilteredVariable();

            $filteredID->setType(FilteredVariable::TP_NUMBERS);
            $filteredID->setValue($id);

            $filteredID = $filteredID->getValue();
            
            // Encode Value Selection.
            
            $valueSelection = new ValueSelection();
            
            $valueSelection->setOption(ValueSelection::OPT_ENCODE);
            
            $valueSelection->addValue($newValue);

            // Perform Alteration.

            EasyUpdate::execute
            (
                "TS: $table",
                "CS: $column",
                $valueSelection,
                "ARGS: id = $filteredID"
            );
        }
    }
}

?>
