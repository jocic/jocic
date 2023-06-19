<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: string_check.php                              *|
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

class StringCheck
{
    // "Is" Methods.
    
    public static function isEmailAddress($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }
    
    // "Main" Methods.
    
    public static function containsNeedle($haystack, $needle)
    {
        for ($i = 0; $i < strlen($haystack); $i ++)
        {
            if ($haystack[$i] == $needle)
                return true;
        }
        
        return false;
    }
    
    public static function constainsAll($value, $character)
    {
        for ($i = 0; $i < strlen($value); $i ++)
        {
            if ($value[$i] != " ")
                return false;
        }
        
        return true;
    }
    
    public static function stripFirstChars($string, $characterNumber)
    {
        $newString = "";
        
        for ($i = $characterNumber; $i < strlen($string); $i ++)
        {
            $newString .= $string[$i];
        }
        
        return $newString;
    }
    
    public static function stripLastChars($string, $characterNumber)
    {
        $newString = "";
        
        for ($i = strlen($string), $j = 0; $i > $characterNumber; $i --)
        {
            $newString .= $string[$j];
            
            $j ++;
        }
        
        return $newString;
    }
    
    public static function between($string, $num_1, $num_2)
    {
        $len = strlen($string);
        
        return ($len >= $num_1) && ($len <= $num_2);
    }
}

?>