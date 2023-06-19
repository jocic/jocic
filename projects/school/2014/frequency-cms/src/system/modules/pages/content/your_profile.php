<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: your_profile.php                              *|
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

// Create "Core" Variables.

$varScriptRoot = DOC_ROOT .
                 DIRECTORY_SEPARATOR .
                 "system" .
                 DIRECTORY_SEPARATOR .
                 "modules" .
                 DIRECTORY_SEPARATOR .
                 "pages" .
                 DIRECTORY_SEPARATOR .
                 "content" .
                 DIRECTORY_SEPARATOR .
                 "your_profile_sections" .
                 DIRECTORY_SEPARATOR;

// Include Pages.

if (empty($_GET[Locales::getVariable("option")]))
    require_once($varScriptRoot . "default_section.php");
else
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-profile"))
        require_once($varScriptRoot . "edit_profile.php");
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("change-password"))
        require_once($varScriptRoot . "change_password.php");
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("deactivate-account"))
        require_once($varScriptRoot . "deactivate_account.php");
    else
        require_once($varScriptRoot . "unknown_page.php");
}

?>