<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: registration_processor.php                    *|
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
    
    private $nm  = null;
    private $mn  = null;
    private $ln  = null;
    private $usr = null;
    private $psw = null;
    
    // "Constructor/s".
    
    public function __construct()
    {
        parent::__construct(Locales::getLink("registration"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if ($this->isPageSelected())
        {
            if (!$this->isErrorShown() && !$this->isNoticeShown()) // Check "Error" And "Notice" Variables.
            {
                // Check If Use Is Logged In.
                
                if (Session::isActive())
                    exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("already-registered")));
                
                // Check "Post" Data.
                
                if (!$this->isPostEmpty())
                {
                    // Fetch Registration Mode.

                    $regMode = Core::get(Core::REGISTRAION_MODE);
                    
                    // Check Variables.

                    $this->checkInput($regMode);
                    
                    // Create Variables And Objects Needed For Registration.

                    $status       = 5;
                    $verification = "";
                    $usersGender  = 0;
                    $birthday     = "";
                    $email        = "";

                    // Create "RandomStringGenerator" Object.

                    $rsg = new RandomStringGenerator();

                    $rsg->setOption(RandomStringGenerator::OPT_ALPHA_NUMERIC);
                    $rsg->setSize(40);
                    $rsg->generateString();

                    // Create Verification Code.

                    $verification = $rsg->getRandomString();

                    // Process Gender And Birthday.

                    if ($regMode == "full")
                    {
                        $usersGender = $_POST["req_gender"] - 1;
                        
                        $birthday = $_POST["req_year"] . "-" . $_POST["req_month"] . "-" . $_POST["req_day"];
                    }

                    // Get Mail.

                    $email = $_POST["req_email"];
                    
                    // Perform Few Checks.

                    if (!AccountCheck::isEmailAvailable($email))
                        exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-taken")));
                    else if (AccountCheck::isUsernameTaken($this->usr))
                        exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("username-taken")));
                    else
                    {
                        // Create Info Array.

                        $infoArray = array
                        (
                            Account::COL_USERNAME     => $this->usr,
                            Account::COL_PASSWORD     => $this->psw,
                            Account::COL_STATUS       => 5,
                            Account::COL_VERIFICATION => $verification,
                            Account::COL_FIRST_NAME   => $this->nm,
                            Account::COL_MIDDLE_NAME  => $this->mn,
                            Account::COL_LAST_NAME    => $this->ln,
                            Account::COL_GENDER       => $usersGender,
                            Account::COL_BIRTHDAY     => $birthday,
                            Account::COL_EMAIL        => $email,
                            Account::COL_FIRST_IP     => null,
                            Account::COL_LAST_IP      => null
                        );

                        // Create Account.

                        Account::createNew($infoArray);

                        // Reddirect.

                        if (AccountCheck::isUsernameTaken($this->usr))
                            exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
                        else
                            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("registration-failed")));
                    }
                }
            }
        }
    }
    
    // "Check" Methods.
    
    private function checkInput($regMode)
    {
        $this->checkCaptcha();
        
        $this->checkTOS();
        
        if ($regMode == "minimal")
        {
            $this->checkUsername();
            $this->checkPassword();
            $this->checkEmail();
        }
        else if ($regMode == "normal")
        {
            $this->checkName();
            $this->checkSurname();
            $this->checkUsername();
            $this->checkPassword();
            $this->checkConfirmationPassword();
            $this->checkEmail();
        }
        else if ($regMode == "full")
        {
            $this->checkName();
            $this->checkMiddleName();
            $this->checkSurname();
            $this->checkGender();
            $this->checkBirthday();
            $this->checkUsername();
            $this->checkPassword();
            $this->checkConfirmationPassword();
            $this->checkEmail();
        }
    }
    
    private function checkCaptcha()
    {
        if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
        {
            if (empty($_POST["req_captcha"]))
            {
                Logs::insertLog(2, Session::getUsername());
                
                exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("captcha-error")));
            }
            else if (!Captcha::respondToChallenge($_POST["req_captcha"]))
            {
                Logs::insertLog(3, Session::getUsername());
                
                exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("captcha-error")));
            }
        }
    }
    
    private function checkTOS()
    {
        // Check "TOS" Variable.
        
        $link = "location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("terms-not-accepted");
        
        if (empty($_POST["req_tos"]))
            exit(header($link));
        else if ($_POST["req_tos"] != "on")
            exit(header($link));
    }
    
    private function checkName()
    {
        // Check "Name" Variable.
        
        if (empty($_POST["req_name"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("name-empty")));
        else if (!StringCheck::between($_POST["req_name"], 2, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("name-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.
        
        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("name-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_name"]);
        
        // Get Value.

        $this->nm = $iv->getValue();
    }
    
    private function checkMiddleName()
    {
        // Check "Middle Name" Variable.
        
        if (empty($_POST["req_middle_name"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("middle-name-empty")));
        else if (!StringCheck::between($_POST["req_middle_name"], 2, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("middle-name-length")));

        // Check Integrity.

        $iv = new IntegrityVariable();

        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z.]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("middle-name-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_middle_name"]);
        
        // Get Value.

        $this->mn = $iv->getValue();
    }
    
    private function checkSurname()
    {
        // Check "Surname" Variable.
        
        if (empty($_POST["req_surname"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("surname-empty")));
        else if (!StringCheck::between($_POST["req_surname"], 2, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("surname-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.
        
        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("surname-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_surname"]);
        
        // Get Value.

        $this->ln = $iv->getValue();
    }
    
    private function checkGender()
    {
        if (empty($_POST["req_gender"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("gender-empty")));
        else if (!is_numeric($_POST["req_gender"]) || $_POST["req_gender"] < 1 || $_POST["req_gender"] > 3)
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-gender-value")));
    }
    
    private function checkBirthday()
    {
        if (empty($_POST["req_day"]) || empty($_POST["req_month"]) || empty($_POST["req_year"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("birthday-empty")));
        else if (!is_numeric($_POST["req_day"]) || !is_numeric($_POST["req_month"]) || !is_numeric($_POST["req_year"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("birthday-content")));
        else
        {
            $date = new Date();

            $date->setDay($_POST["req_day"]);
            $date->setMonth($_POST["req_month"]);
            $date->setYear($_POST["req_year"]);
            
            if (!$date->isValid())
                exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-birthday-date")));
        }
    }
    
    private function checkUsername()
    {
        // Check "Username" Variable.
        
        if (empty($_POST["req_username"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("username-empty")));
        else if (!StringCheck::between($_POST["req_username"], 5, 20))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("username-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("username-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_username"]);
        
        // Get Value.

        $this->usr = $iv->getValue();
    }
    
    private function checkPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-empty")));
        else if (!StringCheck::between($_POST["req_password"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_password"]);
        
        // Get Value.

        $this->psw = $iv->getValue();
    }
    
    private function checkConfirmationPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password_re"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-empty")));
        else if (!StringCheck::between($_POST["req_password_re"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_password_re"]);
        
        $iv->getValue(); // It Needs To Be Called In Order To Trigger Check.
        
        // Check Password Match.
        
        if ($_POST["req_password"] != $_POST["req_password_re"])
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("passwords-not-equal")));
    }
    
    private function checkEmail()
    {
        // Check "Email" Variable.
        
        if (empty($_POST["req_email"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-empty")));
        else if (!StringCheck::between($_POST["req_email"], 5, 150))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-length")));
        else if (!StringCheck::isEmailAddress($_POST["req_email"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-email-address")));
    }
}

?>
