<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: date.php                                      *|
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

class Date
{   
    // "Main" Variables.
    
    private $d = null;
    private $m = null;
    private $y = null;
    
    // "Is" Methods.
    
    public function isDayValid()
    {
        if ($this->isMonthValid() && $this->isYearValid())
        {
            $ndn = array // Normal Day Numbers.
            (
                31, // Jan
                28, // Feb
                31, // Mar
                30, // Apr
                31, // May
                30, // Jun
                31, // Jul
                31, // Aug
                30, // Sep
                31, // Oct
                30, // Nov
                31  // Dec
            );

            // Alter NDN If Year Is Leap.

            if ($this->isLeapYear())
                $ndn[1] = 29;
            
            return ($this->d != null) && is_numeric($this->d) && ($this->d > 0 && $this->d <= $ndn[$this->m - 1]);
        }
        else
            return false;
    }
    
    public function isMonthValid()
    {
        return ($this->m != null) && is_numeric($this->m) && ($this->m > 0 && $this->m <= 12);
    }
    
    public function isYearValid()
    {
        return ($this->y != null) && is_numeric($this->y) && ($this->y > 1904 && $this->y < 2904);
    }
    
    private function isLeapYear()
    {
        return ($this->y % 4 == 0) && (($this->y % 100 != 0) || ($this->y % 400 == 0));
    }
    
    public function isValid()
    {
        return $this->isDayValid() && $this->isMonthValid() && $this->isYearValid();
    }
    
    // "Set" Methods.
    
    public function setDay($day)
    {
        $this->d = $day;
    }
    
    public function setMonth($month)
    {
        $this->m = $month;
    }
    
    public function setYear($year)
    {
        $this->y = $year;
    }
    
    public function setSQLDate($sqlDate)
    {
        $eles = explode("-", $sqlDate);
        
        if (count($eles) == 3)
        {
            $this->setYear($eles[0]);
            $this->setMonth($eles[1]);
            $this->setDay($eles[2]);
        }
    }
    
    // "Get" Methods.
    
    public function getDay()
    {
        if ($this->isDayValid())
            return $this->d;
        else
            return null;
    }
    
    public function getMonth()
    {
        if ($this->isMonthValid())
            return $this->m;
        else
            return null;
    }
    
    public function getYear()
    {
        if ($this->isYearValid())
            return $this->y;
        else
            return;
    }
    
    public function getSQLDate()
    {
        if ($this->isValid())
        {
            return $this->getYear()  . "-" .
                   $this->getMonth() . "-" .
                   $this->getDay();
        }
        
        return null;
    }
    
    // "Other" Methods.
    
    public function convertSQLDate($sqlDate)
    {
        $this->setSQLDate($sqlDate);
        
        return $this->getDay() . "." . $this->getMonth() . "." . $this->getYear() . ".";
    }
}

?>