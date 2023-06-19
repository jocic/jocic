<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: password_reset_processor.php                  *|
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
        parent::__construct(Locales::getLink("password-reset"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if ($this->isPageSelected())
        {
            if (!$this->isErrorShown() && !$this->isNoticeShown())
            {
                // Check Variables.

                 $this->checkInput();
                 
                 // Get Users ID.
                 
                 $usersID = $_GET["id"];
                 
                 // Perform Few Checks.
                 
                 if (Account::isRegular($usersID) || Account::isAdmin($usersID) || Account::isSuperAdmin($usersID))
                 {
                     // Fetch Verification Values.
                     
                      $usersVerification    = InfoFetch::fetchVerification($usersID);
                      $providedVerification = sha1($_GET["verification"] . " - " . Core::get(Core::VERIFICATION_SALT));
                  
                      // Compare Verification Values.
                      
                      if ($usersVerification == $providedVerification)
                      {
                          if (!$this->isPostEmpty())
                          {
                              $this->checkPassword();
                              $this->checkConfirmationPassword();
                              
                              if ($_POST["req_password"] != $_POST["req_password_re"])
                                 exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("passwords-not-equal") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]));
                              
                              // Assign New Password.
                             
                              InfoAlter::alterPassword(sha1($_POST["req_password"] . " - " . Core::get(Core::PASSWORD_SALT)), $usersID);
                             
                              InfoAlter::alterVerification(null, $usersID);
                             
                              exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
                          }
                      }
                      else
                         exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-reset-failed")));
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
    
    // Specific "Check" Methods.
    
    private function checkPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-empty") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]));
        else if (!StringCheck::between($_POST["req_password"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-length") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("password-content") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]);
        
        // Assign Values.

        $iv->setValue($_POST["req_password"]);
        
        $iv->getValue(); // It Needs To Be Called In Order To Trigger Check.
    }
    
    private function checkConfirmationPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password_re"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-empty") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]));
        else if (!StringCheck::between($_POST["req_password_re"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-length") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-content") . "&id=" . $_GET["id"] . "&verification=" . $_GET["verification"]);
        
        // Assign Values.

        $iv->setValue($_POST["req_password_re"]);
        
        $iv->getValue(); // It Needs To Be Called In Order To Trigger Check.
    }
}

?>