<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: messages_processor.php                        *|
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
    // "Core" Variables.
    
    private $varRecieversID = null;
    private $varSendersID   = null;
    
    // "Constructor/s".
    
    public function __construct()
    {
        parent::__construct(Locales::getLink("messages"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if (Session::isActive())
        {
            if ($this->isPostEmpty())
            {
                if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")])) // Check If Option Variables Are Set.
                {
                    // Filter Message ID.

                    $messageID = Filter::forNumeric($_GET[Locales::getVariable("id")]);

                    // Fetch ID.

                    $usersID = IDFetch::byUsername(Session::getUsername());
                    
                    // Option: View Message.
                    
                    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-message"))
                    {
                        $data = EasyGet::execute
                        (
                            "TS: messages",
                            "CS: COUNT(`id`)",
                            "ARGS: id = $messageID AND receiver_id = $usersID"
                        );

                        if ($data[0][0] == 0)
                            exit(header("location: " . $this->getCoreLink()));
                    }
                    
                    // Option: View Sent Message.
                    
                    if ($_GET["option"] == Locales::getLink("view-sent-message"))
                    {
                        $data = EasyGet::execute
                        (
                            "TS: messages",
                            "CS: COUNT(`id`)",
                            "ARGS: id = $messageID AND sender_id = $usersID"
                        );

                        if ($data[0][0] == 0)
                            exit(header("location: " . $this->getCoreLink()));
                    }
                    
                    // Perform Certain Actions.

                    if ($_GET[Locales::getVariable("option")] == Locales::getLink("delete-message")) // Delete Message.
                    {
                        Messages::changeStatus($messageID, Messages::STS_DELETED, $usersID);

                        exit(header("location: " . $this->getCoreLink() . "&option=" . Locales::getLink("inbox")));
                    }
                    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("archive-message")) // Archive Message.
                    {
                        Messages::changeStatus($messageID, Messages::STS_ARCHIVED, $usersID);

                        exit(header("location: " . $this->getCoreLink() . "&option=" . Locales::getLink("inbox")));
                    }
                    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("restore-message")) // Archive Message.
                    {
                        Messages::changeStatus($messageID, Messages::STS_NORMAL, $usersID);

                        exit(header("location: " . $this->getCoreLink() . "&option=" . Locales::getLink("inbox")));
                    }
                }
            }
            else
            {
                $this->checkInput();
                
                $this->varSendersID = IDFetch::byUsername(Session::getUsername());
                
                if (Account::isDeactivated($this->varRecieversID))
                    exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("deactivated-user")));
                else
                {
                    Messages::sendMessage($_POST["req_title"], $_POST["req_content"], $this->varSendersID, $this->varRecieversID);

                    exit(header("location:" . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("success")));
                }
            }
        }
        else
            exit(header("location: " . CMS_ROOT));
    }
    
    // "Check" Methods.
    
    private function checkInput()
    {   
        $this->checkCaptcha();
        $this->checkToField();
        $this->checkUserExists();
        $this->checkTitleField();
        $this->checkContentField();
    }
    
    // Specific "Check" Methods.
    
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
    
    private function checkToField()
    {
        // Check "To" Variable.
        
        if (empty($_POST["req_to"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("to-empty")));
        else if (!StringCheck::between($_POST["req_to"], 5, 20))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("to-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.
        
        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("to-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_to"]);
        
        // Get Value.

        $iv->getValue();
    }
    
    private function checkUserExists()
    {
        // Check If User Exists.
        
        $this->varRecieversID = IDFetch::byUsername($_POST["req_to"]);

        if (empty($this->varRecieversID))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("invalid-user")));
    }
    
    private function checkTitleField()
    {
        // Check "Title" Variable.
        
        if (empty($_POST["req_title"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("title-empty")));
        else if (!StringCheck::between($_POST["req_title"], 5, 100))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("title-length")));
    }
    
    private function checkContentField()
    {
        // Check "Content" Variable.
        
        if (empty($_POST["req_content"]))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("content-empty")));
        else if (!StringCheck::between($_POST["req_content"], 2, 1000))
            exit(header("location: " . $this->getErrorLocationPrefix() . Locales::getErrorLink("content-length")));
    }
}

?>
