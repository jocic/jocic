<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: resend_activation_email_processor.php         *|
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
        parent::__construct(Locales::getLink("resend-activation-email"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if ($this->isPageSelected())
        {
            // Check If User Is Logged In.
            
            if (Session::isActive() && $_GET[$this->getNoticeVariableName()] != Locales::getNoticeLink("already-activated"))
                exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("already-activated")));
            
            if (!$this->isErrorShown() && !$this->isNoticeShown() && !$this->isPostEmpty())
            {
                // Check Variables.

                $this->checkInput();
                
                // Fetch User ID.
                
                $userID = IDFetch::byEmailAddress($_POST["req_email"]);
                
                if ($userID == null)
                    exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-does-not-exist")));
                else
                {
                    if (Account::isPendingVerification($userID))
                    {
                        Account::sendActivationEmail($userID);

                        exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
                    }
                    else
                        exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("already-activated")));
                } 
            }
        }
    }
    
    // "Check" Methods.
    
    private function checkInput()
    {
        // Check "Email" Variable.
        
        if (empty($_POST["req_email"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-empty")));
        else if (!StringCheck::between($_POST["req_email"], 5, 150))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-length")));
        else if (!StringCheck::isEmailAddress($_POST["req_email"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-email-address")));
    }
}

?>