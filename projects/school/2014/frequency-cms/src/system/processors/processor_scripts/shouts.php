<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: shouts.php                                    *|
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

// Check If Option And ID Selected.

if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")])) 
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-shout"))
    {
        // Check If Comment Exists.
        
        if (!Shoutbox::isShoutPosted($_GET[Locales::getVariable("id")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("shouts")));
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-profile"))
    {
        // Check If User Exists.
        
        if (!Account::isCreated($_GET[Locales::getVariable("id")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("shouts")));
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("delete-shout"))
    {
        // Check If Comment Exists.
        
        if (Shoutbox::isShoutPosted($_GET[Locales::getVariable("id")]))
        {
            // Delete Comment.
            
            Shoutbox::deletePost($_GET[Locales::getVariable("id")]);
        }
        
        // Reddirect.
        
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("shouts")));
    }
}

?>