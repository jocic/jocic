<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: your_profile_processor.php                    *|
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
        parent::__construct(Locales::getLink("your-profile"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if (!empty($_SESSION["password-changed"]) && $_SESSION["password-changed"])
        {
            $_SESSION["password-changed"] = false;
            
            return;
        }
        else if (!empty($_SESSION["account-deactivated"]) && $_SESSION["account-deactivated"])
        {
            $_SESSION["account-deactivated"] = false;
            
            return;
        }
        else if (!Session::isActive())
            exit(header("location: " . CMS_ROOT));
        
        if (!empty($_GET[Locales::getVariable("option")]))
        {
            if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-profile"))
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("post-size")));
                
                // Check If File Exists.
                
                if (!empty($_FILES["req_avatar"]))
                {
                    // Create "Core" Variables.

                    $varFile           = $_FILES["req_avatar"];
                    $varError          = $_FILES["req_avatar"]["error"];
                    $varFilename       = basename($_FILES["req_avatar"]["name"]);
                    $varExtension      = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAvatarFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_avatar"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if (($varExtension == "jpg") ||
                                ($varExtension == "jpeg") ||
                                ($varExtension == "gif") ||
                                ($varExtension == "png"))
                            {

                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "avatars" .
                                               DIRECTORY_SEPARATOR .
                                               $varAvatarFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_avatar"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        $varUsersID = IDFetch::byUsername(Session::getUsername());
                                        
                                        InfoAlter::alterAvatar($varAvatarFilename, $varUsersID);
                                    }
                                }

                                // Reddirect.
                    
                                exit(header("location: " . $this->getCoreLink()));
                            }
                            else
                                exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("file-upload")));
                }
                
                if (!$this->isPostEmpty())
                {
                     // Create "Core" Variables.
                    
                    $varUsersID = IDFetch::byUsername(Session::getUsername());
                    
                    // Perform "Core" Checks.
                    
                    $this->checkProfileStatus();
                    $this->checkFirstName();
                    $this->checkMiddleName();
                    $this->checkLastName();
                    $this->checkGender();
                    $this->checkBirthday();
                    $this->checkEmailAddress();
                    $this->checkBiography();
                    
                    // Check If The Email Is Taken.

                    if (InfoFetch::fetchEmailAddress($varUsersID) != $_POST["req_email"] && !AccountCheck::isEmailAvailable($_POST["req_email"]))
                        exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-taken")));
                    
                    // Perform Altering.
                    
                    if (!empty($_POST["req_status"]))
                        InfoAlter::alterProfileStatus($_POST["req_status"], $varUsersID);
                    
                    if (!empty($_POST["req_first_name"]))
                        InfoAlter::alterFirstName($_POST["req_first_name"], $varUsersID);
                    
                    if (!empty($_POST["req_middle_name"]))
                        InfoAlter::alterMiddleName($_POST["req_middle_name"], $varUsersID);
                    
                    if (!empty($_POST["req_last_name"]))
                        InfoAlter::alterLastName($_POST["req_last_name"], $varUsersID);

                    if (!empty($_POST["req_gender"]))   
                        InfoAlter::alterGender(($_POST["req_gender"] - 1), $varUsersID);
                    
                    if (!empty($_POST["req_day"]) || !empty($_POST["req_month"]) || !empty($_POST["req_year"]))
                    {
                        $varDate = new Date();
                        
                        $varDate->setDay($_POST["req_day"]);
                        $varDate->setMonth($_POST["req_month"]);
                        $varDate->setYear($_POST["req_year"]);
                        
                        InfoAlter::alterBirthday($varDate->getSQLDate(), $varUsersID);
                    }
                    
                    InfoAlter::alterEmailAddress($_POST["req_email"], $varUsersID);
                    
                    if (!empty($_POST["req_biography"]))
                        InfoAlter::alterBio($_POST["req_biography"], $varUsersID);
                    
                    // Reddirect.
                    
                    exit(header("location: " . $this->getCoreLink()));
                }
            }
            else if ($_GET[Locales::getVariable("option")] == Locales::getLink("change-password"))
            {
                if (!$this->isPostEmpty())
                {
                    // Create "Core" Variables.
                    
                    $varUsersID = IDFetch::byUsername(Session::getUsername());
                    
                    // Perform "Core" Checks.
                    
                    $this->checkCurrentPassword($varUsersID);
                    $this->checkNewPassword();
                    $this->checkRetypedPassword();
                    
                    InfoAlter::alterPassword(sha1($_POST["req_new"] . " - " . Core::get(Core::PASSWORD_SALT)), $varUsersID);
                    
                    // Stop Session.
                    
                    Session::stop();
                    
                    // Set Password Change Variable.
                    
                    $_SESSION["password-changed"] = true;
                    
                    // Reddirect.
                    
                    exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("password-changed")));
                }
            }
            else if ($_GET[Locales::getVariable("option")] == Locales::getLink("deactivate-account"))
            {
                if (!$this->isPostEmpty())
                {
                    // Create "Core" Variables.
                    
                    $varUsersID = IDFetch::byUsername(Session::getUsername());
                    
                    // Perform "Core" Checks.
                    
                    $this->checkCurrentPassword($varUsersID);
                    
                    if (Account::isSuperAdmin($varUsersID) || Account::isAdmin($varUsersID))
                        exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("deactivation-failed")));
                    else
                    {
                        // Alter Account Status.
                        
                        InfoAlter::alterStatus(Account::STS_DEACTIVATED, $varUsersID);

                        // Stop Session.

                        Session::stop();
                        
                        // Set Account Deactivated Variable.
                    
                        $_SESSION["account-deactivated"] = true;
                        
                        // Reddirect.

                        exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("account-deactivated")));
                    }
                }
            }
        }
    }
    
    // "Default" Check Methods.
    
    private function checkCurrentPassword($varUsersID)
    {
        $varCurrent = null;
        
        if (!empty($_POST["req_current"]))
            $varCurrent = $_POST["req_current"];
        
        $varCurrent = sha1($varCurrent . " - " . Core::get(Core::PASSWORD_SALT));
        $varUsers   = InfoFetch::fetchPassword($varUsersID);
        
        if ($varCurrent != $varUsers)
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("current-password")));
    }
    
    private function checkNewPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_new"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-empty")));
        else if (!StringCheck::between($_POST["req_new"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_new"]);
        
        // Get Value.

        $this->psw = $iv->getValue();
    }
    
    private function checkRetypedPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_retype"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-empty")));
        else if (!StringCheck::between($_POST["req_retype"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_retype"]);
        
        $iv->getValue(); // It Needs To Be Called In Order To Trigger Check.
        
        // Check Password Match.
        
        if ($_POST["req_new"] != $_POST["req_retype"])
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("passwords-not-equal")));
    }
    
    // "Your Profile" Check Methods.
    
    private function checkProfileStatus()
    {
        if (!StringCheck::between($_POST["req_status"], 0, 150))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("status-length")));
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

        $iv->getValue(); // Function must be called in order for check to be performed.
        
        // Check If The Username Is Taken.
        
        if (Session::getUsername() != $_POST["req_username"] && AccountCheck::isUsernameTaken($_POST["req_username"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("username-taken")));
    }
    
    private function checkFirstName()
    {
        if (!empty($_POST["req_first_name"]))
        {
            // Check "Name" Variable.

            if (!StringCheck::between($_POST["req_first_name"], 2, 50))
                exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("name-length")));

            // Check Integrity.

            $iv = new IntegrityVariable();

            // Perform Initial Settings.

            $iv->setType(IntegrityVariable::TP_CUSTOM);
            $iv->setRegularExpression("/^[A-z]+$/");
            $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("name-content"));

            // Assign Values.

            $iv->setValue($_POST["req_first_name"]);

            // Get Value.

            $iv->getValue(); // Function must be called in order for check to be performed.
        }
    }
    
    private function checkMiddleName()
    {
        if (!empty($_POST["req_middle_name"]))
        {
            // Check "Middle Name" Variable.

            if (!StringCheck::between($_POST["req_middle_name"], 2, 50))
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

            $iv->getValue(); // Function must be called in order for check to be performed.
        }
    }
    
    private function checkLastName()
    {
        if (!empty($_POST["req_last_name"]))
        {
            // Check "Surname" Variable.

            if (!StringCheck::between($_POST["req_last_name"], 2, 50))
                exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("surname-length")));

            // Check Integrity.

            $iv = new IntegrityVariable();

            // Perform Initial Settings.

            $iv->setType(IntegrityVariable::TP_CUSTOM);
            $iv->setRegularExpression("/^[A-z]+$/");
            $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("surname-content"));

            // Assign Values.

            $iv->setValue($_POST["req_last_name"]);

            // Get Value.

            $iv->getValue(); // Function must be called in order for check to be performed.
        }
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
        if (!empty($_POST["req_day"]) || !empty($_POST["req_month"]) || !empty($_POST["req_year"]))
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
    }
    
    private function checkEmailAddress()
    {
        // Check "Email" Variable.
        
        if (empty($_POST["req_email"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-empty")));
        else if (!StringCheck::between($_POST["req_email"], 5, 150))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("email-length")));
        else if (!StringCheck::isEmailAddress($_POST["req_email"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-email-address")));
    }
    
    private function checkBiography()
    {
        if (!StringCheck::between($_POST["req_biography"], 0, 2000))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("biography-length")));
    }
}

?>