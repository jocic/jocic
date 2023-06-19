<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: module.php                                    *|
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

class HTMLIncluder
{
    // "Main" Variables.
    
    private $location = null;
    private $prefix   = null;
    
    // "Constructor/s".
    
    public function __construct($htmlLocation = null, $blankPrefix = null)
    {
        $this->location = $htmlLocation;
        $this->prefix   = $blankPrefix;
    }
    
    // "Set" Methods.
    
    public function setLocation($htmlLocation)
    {
        $this->location = $htmlLocation;
    }
    
    public function setBlankPrefix($blankPrefix)
    {
        $this->prefix = $blankPrefix;
    }
    
    public function setPrintLineBreakOnFinish($printLineBreakOnFinish)
    {
        $this->plbote = $printLineBreakOnFinish;
    }
    
    // "Get" Methods.
    
    public function getLocation()
    {
        return $this->location;
    }
    
    public function getBlankPrefix()
    {
        return $this->prefix;
    }
    
    public function getPrintLineBreakOnFinish()
    {
        return $this->plbote;
    }
    
    // "Main" Methods.
    
    public function includeHTML()
    {
        if (file_exists($this->location))
        {
            $file = file($this->location);
            
            for ($i = 0; $i < count($file); $i ++) // Go trough "theme.html" file, line by line.
                echo $this->prefix . $file[$i];
            
            echo "\n";
        }
    }
    
    public function getHTML()
    {
        if (file_exists($this->location))
            return $file = file($this->location);
        else
            return null;
    }
}

?>