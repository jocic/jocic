<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: themes.php                                    *|
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

if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("activate-theme"))
{
    if (!empty($_GET[Locales::getVariable("value")]))
    {
        // Create "Core" Variables

        $varThemeRoot = DOC_ROOT . DIRECTORY_SEPARATOR . "themes" . DIRECTORY_SEPARATOR . $_GET[Locales::getVariable("value")] . DIRECTORY_SEPARATOR;

        // Check Theme Files.

        if (file_exists($varThemeRoot . "info.xml") &&
            file_exists($varThemeRoot . "thumb.png") &&
            file_exists($varThemeRoot . "pages" . DIRECTORY_SEPARATOR . "default_page.html"))
        {
            Core::set(Core::SELECTED_THEME, $_GET[Locales::getVariable("value")]);
        }

        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes")));
    }
    else
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes")));
}

if (!empty($_GET[Locales::getVariable("option")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-style"))
    {
        if (!$this->isPostEmpty())
        {
            // Create "Core" Variables.

            $varName    = "/";
            $varContent = null;

            // "Name" Variable Settings.

            if (!empty($_POST["req_name"]))
                $varName = $_POST["req_name"];

            // "Content" Variable Settings.

            if (!empty($_POST["req_content"]))
                $varContent = $_POST["req_content"];

            // Add Style.

            Styles::addStyle($varName, $varContent);

            // Reddirect.

            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-style") && !empty($_GET[Locales::getVariable("id")]))
    {
        if (!$this->isPostEmpty())
        {
            // Create "Core" Variables.

            $varID = $_GET[Locales::getVariable("id")];

            // Check And Alter Style.

            if (Styles::isStyleCreated($varID))
            {
                // Create "Core" Variables.

                $varName    = "/";
                $varContent = null;

                // "Name" Variable Settings.

                if (!empty($_POST["req_name"]))
                    $varName = $_POST["req_name"];

                // "Content" Variable Settings.

                if (!empty($_POST["req_content"]))
                    $varContent = $_POST["req_content"];

                // Add Style.

                Styles::alterStyle($varName, $varContent, $varID);
            }

            // Reddirect.

            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("delete-style") && !empty($_GET[Locales::getVariable("id")]))
    {
        // Create "Core" Variables.

        $varID = $_GET[Locales::getVariable("id")];

        // Check And Delete Style.

        if (Styles::isStyleCreated($varID))
            Styles::removeStyle($varID);

        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes")));
    }
    else
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes")));
}

?>