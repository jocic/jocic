<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: log_in_processor.php                          *|
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
    // "Main" Variables.
    
    private $username = null;
    private $password = null;
    
    // "Constructor/s".
    
    public function __construct()
    {
        parent::__construct(Locales::getLink("log-in"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if ($this->isPageSelected())
        {
            if (!$this->isErrorShown() && !$this->isNoticeShown())
            {
                if (Session::isActive())
                    exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("already-logged-in")));
                else if (!$this->isPostEmpty())
                {
                    // Check Variables.

                    $this->checkInput();

                    // Fetch Users ID.

                    $usersID = IDFetch::byUsername($this->username);

                    // If Info Is Correct, Set Session.

                    if (!empty($usersID))
                    {
                        if (Account::isPendingVerification($usersID))
                            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("account-pending-verification")));
                        if (Account::isBanned($usersID))
                            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("account-banned")));

                        if (AccountCheck::isPasswordValid($this->password, $usersID)) // Check The "Password".
                        {
                            if (Account::isDeactivated($usersID))
                                InfoAlter::alterStatus(Account::STS_REGULAR, $usersID);

                            InfoAlter::alterVerification(null, $usersID);
                            InfoAlter::alterLastIP($_SERVER["REMOTE_ADDR"], $usersID);

                            Session::start($this->username, $this->password);
                            
                            Logs::insertLog(Logs::LC_LOGGED_IN, $this->username);

                            exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
                        }
                        else
                            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("incorrect-password")));
                    }
                    else
                        exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("incorrect-username")));
                }
            }
        }
    }
    
    // "Check" Methods.
    
    private function checkInput()
    {
        $this->checkCaptcha();
        $this->checkUsername();
        $this->checkPassword();
    }
    
    // Specific Check Methods.
    
    private function checkUsername()
    {
        // Check "Username" Variable.
        
        if (empty($_POST["req_username"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("username-empty")));
        else if (!StringCheck::between($_POST["req_username"], 5, 20))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("username-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("username-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_username"]);
        
        // Get Value.

        $this->username = $iv->getValue();
    }
    
    private function checkPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-empty")));
        else if (!StringCheck::between($_POST["req_password"], 5, 50))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_password"]);
        
        // Get Value.

        $this->password = $iv->getValue();
    }
    
    private function checkCaptcha()
    {
        if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
        {
            if (empty($_POST["req_captcha"]))
            {
                Logs::insertLog(2, "/");
                
                exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("captcha-error")));
            }
            else if (!Captcha::respondToChallenge($_POST["req_captcha"]))
            {
                Logs::insertLog(3, "/");
                
                exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("captcha-error")));
            }
        }
    }
}

?>
