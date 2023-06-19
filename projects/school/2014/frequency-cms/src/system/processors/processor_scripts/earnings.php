<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: earnings.php                                  *|
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

// Check If Option And ID Selected.

if (!empty($_GET[Locales::getVariable("option")])) 
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-advert"))
    {
        // Create "Core" Variables.

        $varAdvertName    = null;
        $varAdvertContent = null;
        $varAdvertID      = null;
        $varAdvertClass   = null;
        $varAdvertSection = null;
        
        // Check Post Variable.
        
        if (!$this->isPostEmpty())
        {
            // "Advert Name" Variable Settings.
            
            if (empty($_POST["req_name"]))
                return;
            else
                $varAdvertName = $_POST["req_name"];
            
            // "Advert Content" Variable Settings.
            
            if (empty($_POST["req_content"]))
                return;
            else
                $varAdvertContent = $_POST["req_content"];
            
            // "Advert ID" Variable Settings.
            
            if (!empty($_POST["req_id"]))
                $varAdvertID = $_POST["req_id"];
            
            // "Advert Class" Variable Settings.
            
            if (!empty($_POST["req_class"]))
                $varAdvertClass = $_POST["req_class"];
            
            // "Advert Section" Variable Settings.
            
            if (isset($_POST["req_section"]))
            {
                if ($_POST["req_section"] >= 0 || $_POST["req_section"] <= 4)
                    $varAdvertSection = $_POST["req_section"];
                else
                    return;
            }
            else
                return;
            
            // Edit Advert.
            
            Adverts::addAdvert($varAdvertName, $varAdvertContent, $varAdvertID, $varAdvertClass, $varAdvertSection);
            
            // Reddirect.
            
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("earnings")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-advert") && !empty($_GET[Locales::getVariable("id")]))
    {
        // Create "Core" Variables.

        $varID            = Filter::forNumeric($_GET[Locales::getVariable("id")]);
        $varAdvertExists  = Adverts::isAdvertCreated($varID);
        $varAdvertName    = null;
        $varAdvertContent = null;
        $varAdvertID      = null;
        $varAdvertClass   = null;
        $varAdvertSection = null;
        
        // If Advert Does Not Exist, Reddirect.

        if (!$varAdvertExists)
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("earnings")));
        
        // Check Post Variable.
        
        if (!$this->isPostEmpty())
        {
            // "Advert Name" Variable Settings.
            
            if (empty($_POST["req_name"]))
                return;
            else
                $varAdvertName = $_POST["req_name"];
            
            // "Advert Content" Variable Settings.
            
            if (empty($_POST["req_content"]))
                return;
            else
                $varAdvertContent = $_POST["req_content"];
            
            // "Advert ID" Variable Settings.
            
            if (!empty($_POST["req_id"]))
                $varAdvertID = $_POST["req_id"];
            
            // "Advert Class" Variable Settings.
            
            if (!empty($_POST["req_class"]))
                $varAdvertClass = $_POST["req_class"];
            
            // "Advert Section" Variable Settings.
            
            if (isset($_POST["req_section"]))
            {
                if ($_POST["req_section"] >= 0 || $_POST["req_section"] <= 4)
                    $varAdvertSection = $_POST["req_section"];
                else
                    return;
            }
            else
                return;
            
            // Edit Advert.
            
            Adverts::alterAdvert($varAdvertName, $varAdvertContent, $varAdvertID, $varAdvertClass, $varAdvertSection, $varID);
            
            // Reddirect.
            
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("earnings")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("delete-advert") && !empty($_GET[Locales::getVariable("id")]))
    {
        // Create "Core" Variables.

        $varID            = Filter::forNumeric($_GET[Locales::getVariable("id")]);
        $varAdvertExists  = Adverts::isAdvertCreated($varID);
        
        if ($varAdvertExists)
            Adverts::removeAdvert($varID);
            
        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("earnings")));
        
    }
}

?>