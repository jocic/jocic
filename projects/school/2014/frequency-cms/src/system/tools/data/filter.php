<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: filter.php                                    *|
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

class Filter
{
    // "Main" Methods.
    
    public static function forNumeric($unfilteredValue)
    {
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_NUMBERS);
        $filteredValue->setValue($unfilteredValue);

        $filteredValue = $filteredValue->getValue();
        
        return $filteredValue;
    }
    
    public static function forAlphaNumeric($unfilteredValue)
    {
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z]/i");
        $filteredValue->setValue($unfilteredValue);

        $filteredValue = $filteredValue->getValue();
        
        return $filteredValue;
    }
    
    public static function forAlphaNumericWithSpace($unfilteredValue)
    {
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z ]/i");
        $filteredValue->setValue($unfilteredValue);

        $filteredValue = $filteredValue->getValue();
        
        return $filteredValue;
    }
    
    public static function forAlphaNumericWithDash($unfilteredValue)
    {
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z-]/i");
        $filteredValue->setValue($unfilteredValue);

        $filteredValue = $filteredValue->getValue();
        
        $filteredValue = str_replace("--", "", $filteredValue);
        
        return $filteredValue;
    }
    
    public static function forText($unfilteredValue)
    {
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z_.-\s\/]/i");
        $filteredValue->setValue($unfilteredValue);

        $filteredValue = $filteredValue->getValue();
        
        return $filteredValue;
    }
    
    public static function forTableNames($unfilteredValue)
    {
        $filteredValue = new FilteredVariable();

        $filteredValue->setType(FilteredVariable::TP_CUSTOM);
        $filteredValue->setRegularExpression("/[^\da-z_]/i");
        $filteredValue->setValue($unfilteredValue);

        $filteredValue = $filteredValue->getValue();
        
        return $filteredValue;
    }
}

?>