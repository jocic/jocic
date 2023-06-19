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

class Module
{
    // "Status" Constants.
    
    const STS_DEACTIVATED = 0;
    const STS_ACTIVATED   = 1;
    
    // "Type" Constants.
    
    const TP_STANDALONE    = "standalone";
    const TP_FUNCTIONALITY = "functionality";
    const TP_CONTENT       = "content";
    
    // "Show Title" Constants.
    
    const ST_NO            = 0;
    const ST_YES           = 1;
    
    // "Main" Variables.
    
    private $status      = null;
    
    // "Settings" Variables.
    
    private $number      = null;
    private $name        = null;
    private $description = null;
    private $version     = null;
    private $type        = null;
    private $author      = null;
    private $contact     = null;
    private $website     = null;
    private $location    = null;
    
    // "Other" Variables.
    
    private $bp          = null;
    private $block       = null;
    
    // "Set" Methods.
    
    public function setStatus($moduleStatus)
    {
        $this->status = $moduleStatus;
    }
    
    public function setNumber($moduleNumber)
    {
        $this->number = $moduleNumber;
    }
    
    public function setName($moduleName)
    {
        $this->name = $moduleName;
    }
    
    public function setDescription($moduleDescription)
    {
        $this->description = $moduleDescription;
    }
    
    public function setVersion($moduleVersion)
    {
        $this->version = $moduleVersion;
    }
    
    public function setType($moduleType)
    {
        $this->type = $moduleType;
    }
    
    public function setAuthor($moduleAuthor)
    {
        $this->author = $moduleAuthor;
    }
    
    public function setContact($moduleContact)
    {
        $this->contact = $moduleContact;
    }
    
    public function setWebsite($moduleWebiste)
    {
        $this->website = $moduleWebiste;
    }
    
    public function setLocation($moduleLocation)
    {
        $this->location = $moduleLocation;
    }
    
    public function setBlankPrefix($moduleBlankPrefix)
    {
        $this->bp = $moduleBlankPrefix;
    }
    
    public function setBlockName($moduleBlockName)
    {
        $this->block = $moduleBlockName;
    }
    
    // "Get" Methods.
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function getNumber()
    {
        return $this->number;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getAuthor()
    {
        return $this->author;
    }
    
    public function getContact()
    {
        return $this->contact;
    }
    
    public function getWebsite()
    {
        return $this->website;
    }
    
    public function getLocation()
    {
        return $this->location;
    }
    
    public function getBlankPrefix()
    {
        return $this->bp;
    }
    
    public function getBlockName()
    {
        return $this->block;
    }
    
    // "Main" Methods.
    
    public function includeSettings()
    {
        // Create Default Variables.
        
        $name        = "Module name was not given.";
        $description = "Module description was not given.";
        $version     = "1.0 (Not given, assumed)";
        $type        = "Standalone";
        $author      = "Author Unknown";
        $contact     = "Contact Unknown";
        $website     = "Website Unknown";
        
        // Include Module Variables (They override the default ones).
        
        if (file_exists($this->getLocation() . "/module.xml"))
        {
            $tempXMLData = simplexml_load_file($this->getLocation() . "/module.xml");
            
            $name        = htmlentities($tempXMLData->name);
            $description = htmlentities($tempXMLData->description);
            $version     = htmlentities($tempXMLData->version);
            $type        = htmlentities($tempXMLData->type);
            $author      = htmlentities($tempXMLData->author);
            $contact     = htmlentities($tempXMLData->contact);
            $website     = htmlentities($tempXMLData->website);
        }
        
        // Initialize the module variables.
        
        $this->setName($name);
        $this->setDescription($description);
        $this->setVersion($version);
        $this->setType($type);
        $this->setAuthor($author);
        $this->setContact($contact);
        $this->setWebsite($website);
    }
    
    public function includeModule()
    {
        // Include module settings.
        
        $this->includeSettings();
        
        // Create "Core" Variables.
        
        $moduleID          = $this->getBlockName() . "-module-" . $this->getNumber();
        $moduleName        = $this->getName();
        $moduleDescription = $this->getDescription();
        $moduleVersion     = $this->getVersion();
        $moduleType        = strtolower($this->getType());
        
        if (file_exists($this->getLocation() . "/index.php"))
        {
            if ($this->getStatus() == self::STS_ACTIVATED) // Include it if it's activated.
            {
                if ($moduleType == "standalone")
                {
                    include $this->getLocation() . "/index.php";
                }
                else if ($moduleType == "functionality" || $moduleType == "content")
                {
                    echo $this->getBlankPrefix() . "<div id=\"$moduleID\" class=\"module\">\n";

                    $this->setBlankPrefix($this->getBlankPrefix() . "    ");
                    
                    include $this->getLocation() . "/index.php";

                    $this->setBlankPrefix(StringCheck::stripFirstChars($this->getBlankPrefix(), 4));

                    echo $this->getBlankPrefix() . "</div>\n";
                }
            }
        }
    }
}

?>