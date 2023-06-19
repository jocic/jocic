<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: sa_processor.php                              *|
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

class Processor extends PageProcessor
{
    // "Constructor/s".
    
    public function __construct()
    {
        parent::__construct(Locales::getLink("site-administration"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        // Check If Page Is Selected.
        
        if ($this->isPageSelected())
        {
            // Check If User Is Logged In.
            
            if (Session::isActive())
            {
                // Fetch User Status.
                
                $userID = IDFetch::byUsername(Session::getUsername());
                
                $userStatus = InfoFetch::fetchStatus($userID);
                
                // Check If User Is Administrator.
                
                if ($userStatus == Account::STS_ADMIN || $userStatus == Account::STS_SUPER_ADMIN)
                {
                    // Check If Workplace Is Selected.
                    
                    if ($this->isWorkplaceSelected())
                    {
                        // Create Script Root Location.
                        
                        $srl = DOC_ROOT .
                               DIRECTORY_SEPARATOR .
                               "system" .
                               DIRECTORY_SEPARATOR .
                               "processors" .
                               DIRECTORY_SEPARATOR .
                               "processor_scripts" .
                               DIRECTORY_SEPARATOR;
                        
                        // Check If "User Managment" Workplace Is Selcted.
                        
                        if ($this->isUserManagmentWorkplace())
                            require_once $srl . "user_managment.php";
                        else if ($this->isMessagesWorkplace())
                            require_once $srl . "messages.php";
                        else if ($this->isAssetsWorkplace())
                            require_once $srl . "assets.php";
                        else if ($this->isPagesWorkplace())
                            require_once $srl . "pages.php";
                        else if ($this->isCommentsWorkplace())
                            require_once $srl . "comments.php";
                        else if ($this->isShoutsWorkplace())
                            require_once $srl . "shouts.php";
                        else if ($this->isLinksWorkplace())
                            require_once $srl . "links.php";
                        else if ($this->isThemesWorkplace())
                            require_once $srl . "themes.php";
                        else if ($this->isModulesWorkplace())
                            require_once $srl . "modules.php";
                        else if ($this->isEarningsWorkplace())
                            require_once $srl . "earnings.php";
                        else if ($this->isSecurityWorkplace())
                            require_once $srl . "security.php";
                        else if ($this->isSettingsWorkplace())
                            require_once $srl . "settings.php";
                    }
                }
            }
            else
                exit(header("location: " . CMS_ROOT));
        }
    }
    
    // "Is" Methods.
    
    private function isWorkplaceSelected()
    {
        return !empty($_GET[Locales::getVariable("workplace")]);
    }
    
    private function isUserManagmentWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("user-managment");
    }
    
    private function isMessagesWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("messages");
    }
    
    private function isAssetsWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("assets");
    }
    
    private function isPagesWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("pages");
    }
    
    private function isCommentsWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("comments");
    }
    
    private function isShoutsWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("shouts");
    }
    
    private function isLinksWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("links");
    }
    
    private function isThemesWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("themes");
    }
    
    private function isModulesWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("modules");
    }
    
    private function isEarningsWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("earnings");
    }
    
    private function isSecurityWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("security");
    }
    
    private function isSettingsWorkplace()
    {
        return $_GET[Locales::getVariable("workplace")] == Locales::getLink("settings");
    }
}

?>