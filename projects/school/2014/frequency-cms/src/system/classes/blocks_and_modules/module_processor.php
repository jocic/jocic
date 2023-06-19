<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: module_processor.php                          *|
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

// Processor Starts.

class ModuleProcessor
{
    // "Main" Variables.
    
    private $name = null;
    
    // "Set" Methods.
    
    public function setName($moduleName)
    {
        $this->name = $moduleName;
    }
    
    // "Get" Methods.
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getLocation()
    {
        if (file_exists(DOC_ROOT . "/system/modules/" . $this->name))
            $varLocation = DOC_ROOT . "/system/modules/" . $this->name;
        else if (file_exists(DOC_ROOT . "/modules/" . $this->name))
            $varLocation = DOC_ROOT . "/modules/" . $this->name;
        
        return $varLocation;
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        $processorLocation = $this->getLocation() . "/processor.php";
        
        if (file_exists($processorLocation))
            require_once $processorLocation;
    }
}

?>