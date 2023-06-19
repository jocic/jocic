<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: activate_account_processor.php                *|
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
        parent::__construct(Locales::getLink("activate-account"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if ($this->isPageSelected())
        {
            if (!$this->isErrorShown() && !$this->isNoticeShown())
            {
                // Check If User Is Logged In.

                if (Session::isActive() && $_GET[$this->getNoticeVariableName()] != Locales::getNoticeLink("logged-in"))
                    exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("logged-in")));

                // Check Variables.

                $this->checkInput();

                // Get Users ID.

                $usersID = $_GET["id"];

                // Perform Few Checks.

                if (Account::isCreated($usersID))
                {
                    if (Account::isPendingVerification($usersID))
                    {
                        $saltedVerification = InfoFetch::fetchVerification($usersID);

                        if ($saltedVerification == sha1($_GET["verification"] . " - " . Core::get(Core::VERIFICATION_SALT)))
                        {
                            InfoAlter::alterStatus(Account::STS_REGULAR, $usersID);

                            InfoAlter::alterVerification(null, $usersID);
                        }

                        if (!Account::isPendingVerification($usersID))
                            exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
                        else
                            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("activation-failed")));
                     }
                     else
                         exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("already-activated")));
                }
                else
                    exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-account")));
            }
        }
    }
    
    // "Check" Methods.
    
    private function checkInput()
    {
        // Check Parameters.
        
        if (empty($_GET["id"]) || empty($_GET["verification"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("key-params-missing")));
        else if (!is_numeric($_GET["id"]) || strlen($_GET["verification"]) != 40)
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("params-not-correct")));
    }
}

?>