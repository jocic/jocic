<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: core.php                                      *|
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

class Captcha
{
    // "Get" Methods.
    
    public static function getFirstNumber()
    {
        return $_SESSION["cfn"];
    }
    
    public static function getSecondNumber()
    {
        return $_SESSION["csn"];
    }
    
    public static function getChallenge()
    {
        return self::getFirstNumber() . " + " . self::getSecondNumber() . " =";
    }
    
    // "Main" Methods.
    
    public static function generateChallenge()
    {
        $_SESSION["cfn"] = rand(1, 9);
        $_SESSION["csn"] = rand(1, 9);
    }
    
    public static function resetChallenge()
    {
        $_SESSION["cfn"] = null;
        $_SESSION["csn"] = null;
    }
    
    public static function respondToChallenge($answer)
    {
        $sum = self::getFirstNumber() + self::getSecondNumber();

        $result = ($sum == $answer);
        
        self::resetChallenge();
        
        return $result;
    }
}

?>