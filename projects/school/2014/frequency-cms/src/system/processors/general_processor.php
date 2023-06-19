<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: general_processor.php                         *|
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

class GeneralProcessor extends PageProcessor
{   
    // "Constructor/s".
    
    public function __construct()
    {
        $id = null;
        
        if (!empty($_GET[Locales::getVariable("page")]))
            $id = $_GET[Locales::getVariable("page")];
        
        parent::__construct($id);
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if (Session::isActive()) // Active Session Processes.
        {
            if ($this->isPostEmpty())
            {
                // FUTURE STUFF WILL GO HERE.
            }
            else
            {
                // Shoutbox.
                
                if (isset($_POST["req_shout"]))
                {
                    // Create "Core" Variables.
                    
                    $varUsersID = null;
                    $varPrev    = null;
                    
                    // "Users ID" Variable Settings.
                    
                    $varUsersID = IDFetch::byUsername(Session::getUsername());
                    
                    // "Prev" Variable Settings.
                    
                    if (empty($_GET[Locales::getVariable("page")]))
                        $varPrev = CMS_ROOT;
                    else
                        $varPrev = CMS_ROOT . "?" . Locales::getVariable("page") . "=" . $_GET[Locales::getVariable("page")];
                    
                    // Add Shout.
                    
                    Shoutbox::addPost($varUsersID, $_POST["req_shout"]);
                    
                    // Reddirect.
                    
                    exit(header("location: " . $varPrev));
                }
                
                // Comment.
                
                if (isset($_POST["req_comment"]))
                {
                    // Dynamic Page.

                    $this->checkDynamicPageInput();

                    // Check Page.

                    $pageID = $_GET[$this->getPageVariableName()];

                    if (!is_numeric($pageID))
                        $pageID = PageInfo::convertCustomID($pageID);

                    if (PageInfo::isCreated($pageID) && PageInfo::isPublished($pageID) && PageInfo::isCommentingEnabled($pageID))
                    {
                        // Fetch Users ID.

                        $userID = IDFetch::byUsername(Session::getUsername());

                        // Process Comment Content.

                        $usersComment = str_replace("\r\n", " ", $_POST["req_comment"]);

                        // Add Comment.

                        Comments::addComment($pageID, $usersComment, $userID);

                        // Reddirect.

                        exit(header("location: " . $_SERVER["HTTP_REFERER"]));
                    }
                    else
                        exit(header("location: " . CMS_ROOT));
                }
            }
        }
        else // Inactive Session Processes.
        {
            if ($this->isPostEmpty())
            {
                // FUTURE STUFF WILL GO HERE.
            }
            else
            {
                // Dynamic Page.

                if (!empty($_GET[$this->getOptionVariableName()]) && $_GET[$this->getOptionVariableName()] == Locales::getLink("comment"))
                    exit(header("location: " . CMS_ROOT));
            }
        }
    }
    
    // "Check" Methods.
    
    private function checkDynamicPageInput()
    {   
        // Check Captcha.

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
        
        // Check Input.
                    
        if (empty($_POST["req_comment"]))
            exit(header("location: " . $_SERVER["HTTP_REFERER"]));
    }
}

?>