<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: string.php                                    *|
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

class Block
{
    // "Class" Constants.
    
    const HEAD       = "head";
    const TOP        = "top";
    const NAVIGATION = "navigation";
    const SIDE_1     = "side-1";
    const SIDE_2     = "side-2";
    const SIDE_3     = "side-3";
    const MAIN       = "main";
    const FRONT_PAGE = "front-page";
    const CUSTOM_1   = "custom-1";
    const CUSTOM_2   = "custom-2";
    const CUSTOM_3   = "custom-3";
    const FOOTER     = "footer";
    
    // "Main" Variables.
    
    private $blankPrefix = null;
    private $blockName   = null;
    
    // "Constructor/s".
    
    public function __construct($value = null)
    {
        $this->setBlockName($value);
    }
    
    // "Set" Methods.
    
    public function setBlankPrefix($value)
    {
        $this->blankPrefix = $value;
    }
    
    public function setBlockName($value)
    {
        $this->blockName = strtolower($value);
    }
    
    // "Get" Methods.
    
    public function getBlankPrefix()
    {
        return $this->blankPrefix;
    }
    
    public function getBlockName()
    {
        return $this->blockName;
    }
    
    public function getValidBlockNames()
    {
        return array
        (
            self::HEAD,
            self::TOP,
            self::SIDE_1,
            self::SIDE_2,
            self::MAIN,
            self::FRONT_PAGE,
            self::CUSTOM_1,
            self::CUSTOM_2,
            self::CUSTOM_3,
            self::FOOTER
        );
    }
    
    // "Is" Methods.
    
    public function isBlockNameValid()
    {
        $validBlockNames = $this->getValidBlockNames();
        
        for ($i = 0; $i < count($validBlockNames); $i ++)
        {
            if ($this->blockName == $validBlockNames[$i])
                return true;
        }
        
        return true;
    }
    
    // "Main" Methods.
    
    public function includeModules()
    {
        if ($this->isBlockNameValid())
        {   
            // Fetch data of all the modules tied with the block.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
            
            EasyGet::setOrderBy("position", EasyGet::OB_ASC);
            
            $data = EasyGet::execute
            (        
                "TS: modules",
                "CS: *",
                "ARGS: block = " . $this->getBlockName()
            );
            
            // Include modules.
            
            if ($data != null)
            {
                $moduleNumber = 1;
                
                foreach ($data as $row)
                {
                    if (file_exists(DOC_ROOT . "/system/modules/" . $row["name"]))
                        $varLocation = DOC_ROOT . "/system/modules/" . $row["name"];
                    else if (file_exists(DOC_ROOT . "/modules/" . $row["name"]))
                        $varLocation = DOC_ROOT . "/modules/" . $row["name"];
                    
                    if (!empty($varLocation))
                    {
                        // Create a module object.

                        $module = new Module();

                        // Initialize its values.

                        $module->setStatus($row["status"]);
                        $module->setNumber($moduleNumber);


                        $module->setLocation($varLocation);


                        $module->setBlankPrefix($this->blankPrefix);
                        $module->setBlockName($this->blockName);

                        // Perform inclusion.

                        $module->includeModule();

                        // Increase module number.

                        $moduleNumber ++;
                    }
                }
            }
        }
    }
}

?>