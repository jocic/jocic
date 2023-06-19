<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: settings.php                                  *|
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

if (!$this->isPostEmpty())
{
    if (!empty($_POST["req_title"]))
        Core::set(Core::WEBSITE_TITLE, $_POST["req_title"]);
    
    if (!empty($_POST["req_title_sufix"]))
        Core::set(Core::WEBSITE_TITLE_SUFIX, $_POST["req_title_sufix"]); // » Free And Open Source CMS « frequency-cms.com

    if (!empty($_POST["req_base"]))
        Core::set(Core::WEBSITE_BASE, $_POST["req_base"]);
    
    if (!empty($_POST["req_charset"]))
        Core::set(Core::WEBSITE_CHARSET, $_POST["req_charset"]);
    
    if (!empty($_POST["req_keywords"]))
        Core::set(Core::WEBSITE_KEYWORDS, $_POST["req_keywords"]);
    
    if (!empty($_POST["req_description"]))
        Core::set(Core::WEBSITE_DESCRIPTION, $_POST["req_description"]);
    
    if (!empty($_POST["req_email"]))
        Core::set(Core::WEBSITE_MAIL, $_POST["req_email"]);
    
    if (!empty($_POST["req_mode"]))
        Core::set(Core::REGISTRAION_MODE, $_POST["req_mode"]);
    
    if (!empty($_POST["req_social"]))
        Core::set(Core::SOCIAL_INTEGRATION, $_POST["req_social"]);
    
    if (!empty($_POST["req_latest_pages"]))
        Core::set(Core::SHOW_LATEST_PAGES, $_POST["req_latest_pages"]);
    
    // Reddirect.
                            
    exit(header("location: " . $_SERVER["HTTP_REFERER"]));
}

?>