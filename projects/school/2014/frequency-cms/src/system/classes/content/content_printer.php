<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: frequency_classes.php                         *|
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

class ContentPrinter
{
    // "Main" Variables.
    
    private $bp      = null;
    private $content = null;
    
    // "Set" Methods.
    
    public function setBlankPrefix($blankPrefix)
    {
        $this->bp = $blankPrefix;
    }
    
    public function setContent($printContent)
    {
        $this->content = $printContent;
    }
    
    // "Get" Methods.
    
    public function getBlankPrefix()
    {
        return $this->bp;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    // "Main" Methods.
    
    public function printContent()
    {
        $lines = explode("\n", $this->getContent());
        
        foreach ($lines as $value)
            echo $this->getBlankPrefix() . $value . "\n";
    }
}

?>