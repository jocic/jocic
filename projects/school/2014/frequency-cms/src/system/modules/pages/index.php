<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: index.php                                     *|
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

// Module Starts.

$pnv = Locales::getVariable("page"); // Fetch "Page Name Variable".

$directorArray = array
(
    Locales::getLink("homepage")                => "homepage.php",
    Locales::getLink("view-profile")            => "view_profile.php",
    Locales::getLink("terms-of-service")        => "terms_of_service.php",
    Locales::getLink("privacy-policy")          => "privacy_policy.php",
    Locales::getLink("registration")            => "registration.php",
    Locales::getLink("log-in")                  => "log_in.php",
    Locales::getLink("privacy-policy")          => "privacy_policy.php",
    Locales::getLink("log-out")                 => "log_out.php",
    Locales::getLink("activate-account")        => "activate_account.php",
    Locales::getLink("resend-activation-email") => "resend_activation_email.php",
    Locales::getLink("account-recovery")        => "account_recovery.php",
    Locales::getLink("password-reset")          => "password_reset.php",
    Locales::getLink("set-language")            => "set_language.php",
    Locales::getLink("site-administration")     => "site_administration.php",
    Locales::getLink("your-profile")            => "your_profile.php",
    Locales::getLink("messages")                => "messages.php"
);

$bp = $this->getBlankPrefix(); // Set Blank Prefix.

if (!empty($_GET[Locales::getVariable($pnv)])) // Check Page.
{
    $page = strtolower($_GET[Locales::getVariable($pnv)]);
    
    // Check If Page Is Numeric (Dynamic)
    
    if (is_numeric($page))
    {
        if (PageInfo::isCreated($page) && PageInfo::isPublished($page))
            require_once($this->getLocation() . "/directors/dynamic_page.php");
        else
            require_once($this->getLocation() . "/directors/unknown.php");
    }
    else
    {
        $pageFound = false;
        
        // Check Core Pages.
        
        foreach ($directorArray as $key => $value) // Loop Through Director Array.
        {
            if ($page == $key) // Include The Page.
            {
                if (file_exists($this->getLocation() . "/directors/" . $value))
                    require_once($this->getLocation() . "/directors/" . $value);

                $pageFound = true;
            }
        }
        
        if (!$pageFound)
        {            
            $page = PageInfo::convertCustomID($page);
            
            if (PageInfo::isCreated($page) && PageInfo::isPublished($page))
            {
                require_once($this->getLocation() . "/directors/dynamic_page.php");

                $pageFound = true;
            }
        }

        // Include The Unknown Page If Requirements Are Met.

        if (!$pageFound)
            require_once($this->getLocation() . "/directors/unknown.php");
    }
}
else if ($_SERVER["REQUEST_URI"] == CMS_ROOT)
    require_once($this->getLocation() . "/directors/homepage.php");
else
    require_once($this->getLocation() . "/directors/unknown.php");

?>