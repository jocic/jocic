<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: set_language_processor.php                    *|
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
        parent::__construct(Locales::getLink("set-language"));
    }
    
    // "Main" Methods.

    public function execute()
    {
        if (!$this->isErrorShown() && !$this->isNoticeShown())
        {
            // Check Input.
            
            $this->checkInput();

            Locales::setLocale($_GET[Locales::getVariable("language")]);
            
            // Changed Prefered Language If Session Is Active.
            
            if (Session::isActive())
            {
                $usersID = IDFetch::byUsername(Session::getUsername());
                
                InfoAlter::alterPreferedLanguage($_GET[Locales::getVariable("language")], $usersID);
            }
            
            // Show Success Notice.

            exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
        }
    }
    
    // "Check" Methods.
    
    private function checkInput()
    {
        if (empty($_GET[Locales::getVariable("language")]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("no-code")));
        else
        {
            if (strlen($_GET[Locales::getVariable("language")]) != 2 || !Locales::coreFilesExist($_GET[Locales::getVariable("language")]))
                exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-language-code")));
        }
    }
}

?>