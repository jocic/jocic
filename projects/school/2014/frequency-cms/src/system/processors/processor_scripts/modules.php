<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: modules.php                                   *|
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

if (!empty($_GET[Locales::getVariable("option")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("activate-module")) // Activate Module.
    {
        if (empty($_GET[Locales::getVariable("value")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        else
        {
            // Create "Core" Variables.

            $varModuleName  = Filter::forTableNames($_GET[Locales::getVariable("value")]);
            $varModuleRoot  = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $varModuleName .  DIRECTORY_SEPARATOR;
            
            // Check If Module Exists.

            if (file_exists($varModuleRoot . "index.php") &&
                file_exists($varModuleRoot . "module.xml"))
            {
                // Tie Module

                EasyUpdate::execute
                (
                    "TS: modules",
                    "CS: status",
                    "VLS: 1",
                    "ARGS: name = $varModuleName AND name <> pages"
                );

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("deactivate-module")) // Deactivate Module.
    {
        if (empty($_GET[Locales::getVariable("value")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        else
        {
            // Create "Core" Variables.

            $varModuleName  = Filter::forTableNames($_GET[Locales::getVariable("value")]);
            $varModuleRoot  = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $varModuleName .  DIRECTORY_SEPARATOR;
            
            // Check If Module Exists.

            if (file_exists($varModuleRoot . "index.php") &&
                file_exists($varModuleRoot . "module.xml"))
            {
                // Tie Module

                EasyUpdate::execute
                (
                    "TS: modules",
                    "CS: status",
                    "VLS: 0",
                    "ARGS: name = $varModuleName AND name <> pages"
                );

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("tie-module") && !$this->isPostEmpty()) // Tie Module.
    {
        if (empty($_GET[Locales::getVariable("value")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        else
        {
            // Create "Core" Variables.

            $varModuleName  = Filter::forTableNames($_GET[Locales::getVariable("value")]);
            $varModuleRoot  = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $varModuleName .  DIRECTORY_SEPARATOR;
            $varBlockName   = null;
            $varModulePos   = null;
            
            // "Block Name" Variable Settings.
            
            if (isset($_POST["req_block"]) && is_numeric($_POST["req_block"]))
            {
                $varBlockName = $_POST["req_block"] - 1;
                
                if ($varBlockName == 0)
                    $varBlockName = Block::HEAD;
                else if ($varBlockName == 1)
                    $varBlockName = Block::TOP;
                else if ($varBlockName == 2)
                    $varBlockName = Block::NAVIGATION;
                else if ($varBlockName == 3)
                    $varBlockName = Block::SIDE_1;
                else if ($varBlockName == 4)
                    $varBlockName = Block::SIDE_2;
                else if ($varBlockName == 5)
                    $varBlockName = Block::SIDE_3;
                else if ($varBlockName == 6)
                    $varBlockName = Block::MAIN;
                else if ($varBlockName == 7)
                    $varBlockName = Block::FRONT_PAGE;
                else if ($varBlockName == 8)
                    $varBlockName = Block::CUSTOM_1;
                else if ($varBlockName == 9)
                    $varBlockName = Block::CUSTOM_2;
                else if ($varBlockName == 10)
                    $varBlockName = Block::CUSTOM_3;
                else if ($varBlockName == 11)
                    $varBlockName = Block::FOOTER;
                else
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            
            // "Moudule Position" Variable Settings.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varModulePos = EasyGet::execute
            (
                "TS: modules",
                "CS: COUNT(`id`)",
                "ARGS: block = $varBlockName"
            );

            $varModulePos = $varModulePos[0][0] + 1;
            
            // Check If Module Exists.

            if (file_exists($varModuleRoot . "index.php") &&
                file_exists($varModuleRoot . "module.xml"))
            {
                // Tie Module

                EasyInsert::execute
                (
                    "TS: modules",
                    "CS: block, position, name, status",
                    "VLS: $varBlockName, $varModulePos, $varModuleName, 1"
                );

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        }
    }
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-module") && !$this->isPostEmpty()) // Edit Module
    {
        if (empty($_GET[Locales::getVariable("value")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        else
        {
            // Create "Core" Variables.

            $varModuleName  = Filter::forTableNames($_GET[Locales::getVariable("value")]);
            $varModuleRoot  = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $varModuleName .  DIRECTORY_SEPARATOR;
            $varBlockName   = null;
            $varOldBlock    = null;
            $varModulePos   = null;
            
            // "Block Name" Variable Settings.
            
            if (isset($_POST["req_block"]) && is_numeric($_POST["req_block"]))
            {
                $varBlockName = $_POST["req_block"];
                
                if ($varBlockName == 0)
                    $varBlockName = Block::HEAD;
                else if ($varBlockName == 1)
                    $varBlockName = Block::TOP;
                else if ($varBlockName == 2)
                    $varBlockName = Block::NAVIGATION;
                else if ($varBlockName == 3)
                    $varBlockName = Block::SIDE_1;
                else if ($varBlockName == 4)
                    $varBlockName = Block::SIDE_2;
                else if ($varBlockName == 5)
                    $varBlockName = Block::SIDE_3;
                else if ($varBlockName == 6)
                    $varBlockName = Block::MAIN;
                else if ($varBlockName == 7)
                    $varBlockName = Block::FRONT_PAGE;
                else if ($varBlockName == 8)
                    $varBlockName = Block::CUSTOM_1;
                else if ($varBlockName == 9)
                    $varBlockName = Block::CUSTOM_2;
                else if ($varBlockName == 10)
                    $varBlockName = Block::CUSTOM_3;
                else if ($varBlockName == 11)
                    $varBlockName = Block::FOOTER;
                else
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            
            // "Old Block" Variable Settings.
            
             EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varOldBlock = EasyGet::execute
            (
                "TS: modules",
                "CS: block",
                "ARGS: name = $varModuleName"
            );
            
            $varOldBlock = $varOldBlock[0][0];
            
            // "Moudule Position" Variable Settings.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
            
            $varModulePos = EasyGet::execute
            (
                "TS: modules",
                "CS: COUNT(`id`)",
                "ARGS: block = $varBlockName"
            );

            $varModulePos = $varModulePos[0][0] + 1;
            
            // Check If Module Exists.

            if (file_exists($varModuleRoot . "index.php") &&
                file_exists($varModuleRoot . "module.xml"))
            {
                // Edit Module

                EasyUpdate::execute
                (
                    "TS: modules",
                    "CS: block, position",
                    "VLS: $varBlockName, $varModulePos",
                    "ARGS: name = $varModuleName"
                );
                
                // Reset Module Position In The Old Block.
                
                EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
                
                EasyGet::setOrderBy("position", EasyGet::OB_ASC);
                
                $tempData =  EasyGet::execute
                (
                    "TS: modules",
                    "CS: id, position",
                    "ARGS: block = $varOldBlock"
                );
                
                for ($i = 0; $i < count($tempData); $i ++)
                {
                    EasyUpdate::execute
                    (
                        "TS: modules",
                        "CS: position",
                        "VLS: " . ($i + 1),
                        "ARGS: id = " . $tempData[$i]["id"]
                    );
                }

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("release-module")) // Release Module.
    {
        if (empty($_GET[Locales::getVariable("value")]))
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        else
        {
            // Create "Core" Variables.

            $varModuleName  = Filter::forTableNames($_GET[Locales::getVariable("value")]);
            $varModuleRoot  = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $varModuleName .  DIRECTORY_SEPARATOR;
            $varBlockName   = null;
            $varModuleTied  = null;
            
            // "Block Name" Variable Settings.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varBlockName = EasyGet::execute
            (
                "TS: modules",
                "CS: block",
                "ARGS: name = " . $_GET[Locales::getVariable("value")]
            );
            
            $varBlockName = $varBlockName[0][0];
            
            // "Module Tied" Variable Settings.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varModuleTied = EasyGet::execute
            (
                "TS: modules",
                "CS: COUNT(`id`)",
                "ARGS: name = " . $_GET[Locales::getVariable("value")]
            );
            
            $varModuleTied = $varModuleTied[0][0] == 1;
            
            // Check If Module Exists.

            if (file_exists($varModuleRoot . "index.php") &&
                file_exists($varModuleRoot . "module.xml"))
            {
                // Check If Module Is Tied.

                if ($varModuleTied == 1)
                {
                    // Release The MOdule.
                    
                    EasyDelete::execute
                    (
                        "TS: modules",
                        "ARGS: name = $varModuleName AND name <> pages"
                    );
                    
                    // Reset Module Position In The Block.

                    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

                    EasyGet::setOrderBy("position", EasyGet::OB_ASC);

                    $tempData =  EasyGet::execute
                    (
                        "TS: modules",
                        "CS: id, position",
                        "ARGS: block = $varBlockName"
                    );

                    for ($i = 0; $i < count($tempData); $i ++)
                    {
                        EasyUpdate::execute
                        (
                            "TS: modules",
                            "CS: position",
                            "VLS: " . ($i + 1),
                            "ARGS: id = " . $tempData[$i]["id"]
                        );
                    }
                }

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("move-up")) // Move The Module Up.
    {
        if (!empty($_GET[Locales::getVariable("value")]))
        {
            $varModuleBlock = Modules::getModuleBlockName($_GET[Locales::getVariable("value")]);
            
            Modules::moveModuleUp($_GET[Locales::getVariable("value")]);
            
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-modules") . "&" . Locales::getVariable("module-block") . "=" . $varModuleBlock));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("move-down")) // Move The Module Down.
    {
        if (!empty($_GET[Locales::getVariable("value")]))
        {
            $varModuleBlock = Modules::getModuleBlockName($_GET[Locales::getVariable("value")]);
            
            Modules::moveModuleDown($_GET[Locales::getVariable("value")]);
            
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-modules") . "&" . Locales::getVariable("module-block") . "=" . $varModuleBlock));
        }
    }
}

?>