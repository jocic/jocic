<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_page.php                              *|
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

// Set Blank Prefix.

Build::setBlankPrefix($this->getBlankPrefix());

// Create "Core" Variables.

$varAdminOptions      = null;
$varScriptRoot        = null;
$varTitleSufix        = null;

// Create "Core" Elements;

$hdSiteAdministration = new FHeader();
$divOptions           = new FDiv();
$divWorkplace         = new FDiv();

// "Admin Options" Variable Settings.

$varAdminOptions = array
(
    "user-managment",
    "messages",
    "assets",
    "pages",
    "comments",
    "shouts",
    "links",
    "themes",
    "modules",
    "statistics",
    "earnings",
    "security",
    "settings"
);

// "Script Root" Variable Settings.

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
                 "site_administration_sections" .
                 DIRECTORY_SEPARATOR;

// "Title Sufix" Variable Settings.

if (empty($_GET[Locales::getVariable("workplace")]))
    $varTitleSufix = Locales::getCore("welcome");
else
{
    $varTitleSufix = Locales::getTitle($_GET[Locales::getVariable("workplace")]);
    
    if ($varTitleSufix == "?")
        $varTitleSufix = Locales::getTitle("unknown-page");
}

// "Header Site Administration" Element Settings.

$hdSiteAdministration->setLevel(1);
$hdSiteAdministration->setContent(Locales::getTitle("site-administration") . " - " . $varTitleSufix);

// "Options" Element Settings.

$divOptions->setID("administration-options");
$divOptions->setClass("administration-div");

foreach ($varAdminOptions as $value)
{
    // Create "Temp" Variables.
    
    $tempID    = $value . "-icon";
    $tempClass = "administration-icon";
    $tempLink  = CMS_ROOT .
                 "?" .
                 Locales::getVariable("page") .
                 "=" .
                 Locales::getLink("site-administration") .
                 "&" .
                 Locales::getVariable("workplace") .
                 "=" .
                 Locales::getLink($value);
    $varTitle  = Locales::getTitle($value);
    
    // Add Dynamic Element.
    
    $divOptions->addElement(new FAnchor($tempID, $tempClass, $tempLink, $varTitle, $varTitle));
    
    // Unset "Temp" Variables.
    
    unset($tempID);
    unset($tempClass);
    unset($tempLink);
    unset($varTitle);
}

// "Workplace" Element Settings.

$divWorkplace->setID("administration-workplace");
$divWorkplace->setClass("administration-div");

if (empty($_GET[Locales::getVariable("workplace")]))
    require_once($varScriptRoot . "default_section.php");
else
{
    if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("user-managment"))
        require_once($varScriptRoot . "user_managment.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("messages"))
        require_once($varScriptRoot . "messages.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("assets"))
        require_once($varScriptRoot . "assets.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("pages"))
        require_once($varScriptRoot . "pages.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("comments"))
        require_once($varScriptRoot . "comments.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("shouts"))
        require_once($varScriptRoot . "shouts.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("links"))
        require_once($varScriptRoot . "links.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("themes"))
        require_once($varScriptRoot . "themes.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("modules"))
        require_once($varScriptRoot . "modules.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("statistics"))
        require_once($varScriptRoot . "statistics.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("earnings"))
        require_once($varScriptRoot . "earnings.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("security"))
        require_once($varScriptRoot . "security.php");
    else if ($_GET[Locales::getVariable("workplace")] == Locales::getLink("settings"))
        require_once($varScriptRoot . "settings.php");
    else
        require_once($varScriptRoot . "unknown_page.php");
}

// Build Elements.

Build::element($hdSiteAdministration);
Build::element($divOptions);
Build::element($divWorkplace);
Build::element(new FDiv(null, "clr"));

?>