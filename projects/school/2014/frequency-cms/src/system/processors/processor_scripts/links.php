<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: links.php                                     *|
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

if (!empty($_GET[Locales::getVariable("option")])) 
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("arrange-menu-items")) // If Arrange Menu Items Was Selected.
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            // Create "Core" Variables.

            $varMenuID     = Filter::forNumeric($_GET[Locales::getVariable("id")]);
            $varMenuExists = null;

            // "Menu Exists" Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varMenuExists = EasyGet::execute
            (
                "TS: menus",
                "CS: COUNT(`id`)",
                "ARGS: id = " . $varMenuID
            );

            $varMenuExists = $varMenuExists[0][0] == 1;

            // Check If Menu Exists.

            if (!$varMenuExists)
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
        }
        else
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else if (!empty($_GET[Locales::getVariable("option")]) && ($_GET[Locales::getVariable("option")] == Locales::getLink("move-up") || $_GET[Locales::getVariable("option")] == Locales::getLink("move-down"))) // If Move Item Up Or Move Item Down Was Selected.
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            // Create "Core" Variables.

            $varMenuItemID     = Filter::forNumeric($_GET[Locales::getVariable("id")]);
            $varMenuItemExists = null;
            $varMenuID         = null;

            // "Menu Item Exists, Menu ID" Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varMenuItemExists = EasyGet::execute
            (
                "TS: menu_items",
                "CS: COUNT(`id`), menu_id",
                "ARGS: id = " . $varMenuItemID
            );

            $varMenuID = $varMenuItemExists[0][1];

            $varMenuItemExists = $varMenuItemExists[0][0] == 1;

            // Check If Menu Item Exists.

            if ($varMenuItemExists)
            {
                if ($_GET[Locales::getVariable("option")] == Locales::getLink("move-up"))
                    Menus::moveItemUp($varMenuItemID);
                else
                    Menus::moveItemDown($varMenuItemID);

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-menu-items") . "&" . Locales::getVariable("id") . "=" . $varMenuID));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
        }
        else
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-menu")) // If Add Menu Was Selected.
    {
        if (!empty($_POST["req_name"]) && !empty($_POST["req_title"]))
        {
            // Create "Core" Variables.
            
            $varName  = new FilteredVariable();
            $varTitle = new FilteredVariable();
            
            // "Name" Variable Settings.
            
            $varName->setType(FilteredVariable::TP_CUSTOM);
            $varName->setRegularExpression("/[^a-z_]/");
            $varName->setValue($_POST["req_name"]);
            
            $varName = $varName->getValue();
            
            // "Title" Variable Settings.
            
            $varTitle->setType(FilteredVariable::TP_TEXT);

            $varTitle->setValue($_POST["req_title"]);
            
            $varTitle = $varTitle->getValue();
            
            // Perform Row Insertion.

            EasyInsert::execute
            (
                "TS: menus",
                "CS: name, title",
                "VLS: " . $varName . ", " . $varTitle
            );
        }
        else
            return;

        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("edit-menu")) // If Edit Menu Was Selected.
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            // Create "Core" Variables.
            
            $varName       = null;
            $varTitle      = null;
            $varMenuID     = Filter::forNumeric($_GET[Locales::getVariable("id")]);
            $varMenuExists = null;
            $varCoreMenu   = null;

            // "Menu Exists, Core Menu" Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varMenuExists = EasyGet::execute
            (
                "TS: menus",
                "CS: COUNT(`id`), core",
                "ARGS: id = $varMenuID"
            );
            
            $varCoreMenu = $varMenuExists[0][1] == 1;
            
            $varMenuExists = $varMenuExists[0][0] == 1;

            // Check If Menu Exists.

            if (!$varMenuExists)
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));

            if ($varCoreMenu)
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
            
            // Alter Menu.

            if (!$this->isPostEmpty())
            {
                if (!empty($_POST["req_name"]))
                    $varName = $_POST["req_name"];
                else
                    exit(header("location: " . $_SERVER["HTTP_REFERER"]));

                if (!empty($_POST["req_title"]))
                    $varTitle = $_POST["req_title"];
                else
                    exit(header("location: " . $_SERVER["HTTP_REFERER"]));

                $fv = new FilteredVariable();

                $fv->setType(FilteredVariable::TP_CUSTOM);
                $fv->setRegularExpression("/[^a-z_]/");

                $fv->setValue($varName);

                $varName = $fv->getValue();

                $fv->setType(FilteredVariable::TP_CUSTOM);
                $fv->setRegularExpression("/[^A-z_ ]/");

                $fv->setValue($varTitle);

                $varTitle = $fv->getValue();

                EasyUpdate::execute
                (
                    "TS: menus",
                    "CS: name, title",
                    "VLS: $varName, $varTitle",
                    "ARGS: id = $varMenuID"
                );

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
            }
        }
        else
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("delete-menu")) // If Delete Menu Was Selected.
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            // Create "Core" Variables.
            
            $varMenuID     = Filter::forNumeric($_GET[Locales::getVariable("id")]);
            $varMenuExists = null;
            $varCoreMenu   = null;
            
            // "Menu Exists, Core Menu" Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varMenuExists = EasyGet::execute
            (
                "TS: menus",
                "CS: COUNT(`id`), core",
                "ARGS: id = $varMenuID"
            );
            
            $varCoreMenu = $varMenuExists[0][1] == 1;
            
            $varMenuExists = $varMenuExists[0][0] == 1;

            // Check If Menu Exists.

            if (!$varMenuExists)
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));

            // Check If Menu Is Core.

            if ($varCoreMenu)
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));

            // Delete Menu.

            EasyDelete::execute
            (
                "TS: menus",
                "ARGS: id = $varMenuID"
            );
            
            // Delete Menu Items (Type: Menu) That Are Of That Menu.

            EasyDelete::execute
            (
                "TS: menu_items",
                "ARGS: value = $varMenuID and type = 2"
            );

            // Reddirect.

            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
        }
        else
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("add-menu-item")) // If Add Menu Item Was Selected.
    {
        if (!$this->isPostEmpty())
        {
            // Create "Core" Variables.

            $varType         = null;
            $varTitle        = null;
            $varParent       = null;
            $varMenu         = null;
            $varCorePage     = null;
            $varPage         = null;
            $varCustomItem   = null;
            $varItemPosition = null;

            // "Type" Variable Settings.

            if (isset($_POST["req_type"]))
            {
                $varType = $_POST["req_type"];

                $varType = Filter::forNumeric($varType);

                if ($varType < 0 || $varType > 5)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
            }

            // "Title" Variable Settings.

            if (!empty($_POST["req_title"]))
                $varTitle = $_POST["req_title"];

            // "Parent" Variable Settings.

            if (!empty($_POST["req_parent"]))
            {
                $varParent = $_POST["req_parent"];

                $varParent = Filter::forNumeric($varParent);
            }

            // "Menu" Variable Settings.

            if (!empty($_POST["req_menus"]))
            {
                $varMenu = $_POST["req_menus"];

                $varMenu = Filter::forNumeric($varMenu);
            }

            // "Core Page" Variable Settings.

            if (!empty($_POST["req_core_page"]))
                $varCorePage = $_POST["req_core_page"];

            // "Page" Variable Settings.

            if (!empty($_POST["req_page"]))
                $varPage = $_POST["req_page"];

            // "Custom Item" Variable Settings.

            if (!empty($_POST["req_custom"]))
                $varCustomItem = $_POST["req_custom"];

            // "Item Position" Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varItemPosition = EasyGet::execute
            (
                "TS: menu_items",
                "CS: COUNT(`id`)",
                "ARGS: menu_id = " . $varParent
            );

            $varItemPosition = $varItemPosition[0][0] + 1;

            // Process The Rest Of Data.

            if ($varType == Menus::MI_TITLE) // If Menu Item - Title.
            {
                if (!empty($varTitle) && !empty($varParent))
                {
                    // Create "Temp" Variables.

                    $tempSelection = new ValueSelection();

                    // "Selection" Variable Settings.

                    $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                    $tempSelection->addValues($varTitle, "header", Menus::MI_TITLE, $varItemPosition, $varParent);

                    // Perform Insertion.

                    EasyInsert::execute
                    (
                        "TS: menu_items",
                        "CS: title, value, type, position, menu_id",
                        $tempSelection
                    );
                }
            }
            else if ($varType == Menus::MI_SEPARATOR) // If Menu Item - Separator.
            {
                if (!empty($varTitle) && !empty($varParent))
                {
                    // Create "Temp" Variables.

                    $tempSelection = new ValueSelection();

                    // "Selection" Variable Settings.

                    $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                    $tempSelection->addValues($varTitle, "separator", Menus::MI_SEPARATOR, $varItemPosition, $varParent);

                    // Perform Insertion.

                    EasyInsert::execute
                    (
                        "TS: menu_items",
                        "CS: title, value, type, position, menu_id",
                        $tempSelection
                    );
                }
            }
            else if ($varType == Menus::MI_SUBMENU) // If Menu Item - Menu.
            {
                if (!empty($varTitle) && !empty($varParent) && !empty($varMenu))
                {
                    // Create "Temp" Variables.

                    $tempSelection = new ValueSelection();

                    // "Selection" Variable Settings.

                    $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                    $tempSelection->addValues($varTitle, $varMenu, Menus::MI_SUBMENU, $varItemPosition, $varParent);

                    // Perform Insertion.

                    EasyInsert::execute
                    (
                        "TS: menu_items",
                        "CS: title, value, type, position, menu_id",
                        $tempSelection
                    );
                }
            }
            else if ($varType == Menus::MI_CORE_PAGE) // If Menu Item - Core Item.
            {
                if (!empty($varTitle) && !empty($varParent) && !empty($varCorePage))
                {
                    // Create "Temp" Variables.

                    $tempSelection = new ValueSelection();

                    // "Selection" Variable Settings.

                    $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                    $tempSelection->addValues($varTitle, $varCorePage, Menus::MI_CORE_PAGE, $varItemPosition, $varParent);

                    // Perform Insertion.

                    EasyInsert::execute
                    (
                        "TS: menu_items",
                        "CS: title, value, type, position, menu_id",
                        $tempSelection
                    );
                }
            }
            else if ($varType == Menus::MI_PAGE) // If Menu Item - Core Item.
            {
                if (!empty($varTitle) && !empty($varParent) && !empty($varPage))
                {
                    // Create "Temp" Variables.

                    $tempSelection = new ValueSelection();

                    // "Selection" Variable Settings.

                    $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                    $tempSelection->addValues($varTitle, $varPage, Menus::MI_PAGE, $varItemPosition, $varParent);

                    // Perform Insertion.

                    EasyInsert::execute
                    (
                        "TS: menu_items",
                        "CS: title, value, type, position, menu_id",
                        $tempSelection
                    );
                }
            }
            else if ($varType == Menus::MI_CUSTOM_LINK) // If Menu Item - Custom Item.
            {
                if (!empty($varTitle) && !empty($varParent) && !empty($varCustomItem))
                {
                    // Create "Temp" Variables.

                    $tempSelection = new ValueSelection();

                    // "Selection" Variable Settings.

                    $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                    $tempSelection->addValues($varTitle, $varCustomItem, Menus::MI_CUSTOM_LINK, $varItemPosition, $varParent);

                    // Perform Insertion.

                    EasyInsert::execute
                    (
                        "TS: menu_items",
                        "CS: title, value, type, position, menu_id",
                        $tempSelection
                    );
                }
            }

            // Reddirect.

            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
        }
    }
    else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("edit-menu-item")) // If Edit Menu Item Was Selected.
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            if (!$this->isPostEmpty())
            {
                // Create "Core" Variables.

                $varItemID       = null;
                $varType         = null;
                $varTitle        = null;
                $varParent       = null;
                $varMenu         = null;
                $varCorePage     = null;
                $varPage         = null;
                $varCustomItem   = null;
                $varItemPosition = null;

                // "Item ID" Variable Settings.

                $varItemID = $_GET[Locales::getVariable("id")];

                // "Type" Variable Settings.

                if (isset($_POST["req_type"]))
                {
                    $varType = $_POST["req_type"];

                    $varType = Filter::forNumeric($varType);

                    if ($varType < 0 || $varType > 5)
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
                }

                // "Title" Variable Settings.

                if (!empty($_POST["req_title"]))
                    $varTitle = $_POST["req_title"];

                // "Parent" Variable Settings.

                if (!empty($_POST["req_parent"]))
                {
                    $varParent = $_POST["req_parent"];

                    $varParent = Filter::forNumeric($varParent);
                }

                // "Menu" Variable Settings.

                if (!empty($_POST["req_menus"]))
                {
                    $varMenu = $_POST["req_menus"];

                    $varMenu = Filter::forNumeric($varMenu);
                }

                // "Core Page" Variable Settings.

                if (!empty($_POST["req_core_page"]))
                    $varCorePage = $_POST["req_core_page"];

                // "Page" Variable Settings.

                if (!empty($_POST["req_page"]))
                    $varPage = $_POST["req_page"];

                // "Custom Item" Variable Settings.

                if (!empty($_POST["req_custom"]))
                    $varCustomItem = $_POST["req_custom"];

                // Process The Rest Of Data.

                if ($varType == Menus::MI_TITLE) // If Menu Item - Title.
                {
                    if (!empty($varTitle) && !empty($varParent))
                    {
                        // Create "Temp" Variables.

                        $tempSelection = new ValueSelection();

                        // "Selection" Variable Settings.

                        $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                        $tempSelection->addValues($varTitle, "header", Menus::MI_TITLE, $varParent);

                        // Perform Update.

                        EasyUpdate::execute
                        (
                            "TS: menu_items",
                            "CS: title, value, type, menu_id",
                            $tempSelection,
                            "ARGS: id = " . $varItemID
                        );
                    }
                }
                else if ($varType == Menus::MI_SEPARATOR) // If Menu Item - Separator.
                {
                    if (!empty($varTitle) && !empty($varParent))
                    {
                        // Create "Temp" Variables.

                        $tempSelection = new ValueSelection();

                        // "Selection" Variable Settings.

                        $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                        $tempSelection->addValues($varTitle, "separator", Menus::MI_SEPARATOR, $varParent);

                        // Perform Insertion.

                        EasyUpdate::execute
                        (
                            "TS: menu_items",
                            "CS: title, value, type, menu_id",
                            $tempSelection,
                            "ARGS: id = " . $varItemID
                        );
                    }
                }
                else if ($varType == Menus::MI_SUBMENU) // If Menu Item - Menu.
                {
                    if (!empty($varTitle) && !empty($varParent) && !empty($varMenu))
                    {
                        // Create "Temp" Variables.

                        $tempSelection = new ValueSelection();

                        // "Selection" Variable Settings.

                        $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                        $tempSelection->addValues($varTitle, $varMenu, Menus::MI_SUBMENU, $varParent);

                        // Perform Insertion.

                        EasyUpdate::execute
                        (
                            "TS: menu_items",
                            "CS: title, value, type, menu_id",
                            $tempSelection,
                            "ARGS: id = " . $varItemID
                        );
                    }
                }
                else if ($varType == Menus::MI_CORE_PAGE) // If Menu Item - Core Item.
                {
                    if (!empty($varTitle) && !empty($varParent) && !empty($varCorePage))
                    {
                        // Create "Temp" Variables.

                        $tempSelection = new ValueSelection();

                        // "Selection" Variable Settings.

                        $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                        $tempSelection->addValues($varTitle, $varCorePage, Menus::MI_CORE_PAGE, $varParent);

                        // Perform Insertion.

                        EasyUpdate::execute
                        (
                            "TS: menu_items",
                            "CS: title, value, type, menu_id",
                            $tempSelection,
                            "ARGS: id = " . $varItemID
                        );
                    }
                }
                else if ($varType == Menus::MI_PAGE) // If Menu Item - Core Item.
                {
                    if (!empty($varTitle) && !empty($varParent) && !empty($varPage))
                    {
                        // Create "Temp" Variables.

                        $tempSelection = new ValueSelection();

                        // "Selection" Variable Settings.

                        $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                        $tempSelection->addValues($varTitle, $varPage, Menus::MI_PAGE, $varParent);

                        // Perform Insertion.

                        EasyUpdate::execute
                        (
                            "TS: menu_items",
                            "CS: title, value, type, menu_id",
                            $tempSelection,
                            "ARGS: id = " . $varItemID
                        );
                    }
                }
                else if ($varType == Menus::MI_CUSTOM_LINK) // If Menu Item - Custom Item.
                {
                    if (!empty($varTitle) && !empty($varParent) && !empty($varCustomItem))
                    {
                        // Create "Temp" Variables.

                        $tempSelection = new ValueSelection();

                        // "Selection" Variable Settings.

                        $tempSelection->setOption(ValueSelection::OPT_ENCODE);

                        $tempSelection->addValues($varTitle, $varCustomItem, Menus::MI_CUSTOM_LINK, $varParent);

                        // Perform Insertion.

                        EasyUpdate::execute
                        (
                            "TS: menu_items",
                            "CS: title, value, type, menu_id",
                            $tempSelection,
                            "ARGS: id = " . $varItemID
                        );
                    }
                }

                    // Fetch New Menu ID.

                EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

                $varNewMenuID = EasyGet::execute
                (
                    "TS: menu_items",
                    "CS: menu_id",
                    "ARGS: id = " . $varItemID
                );  

                // Reset Menu Item Positions.

                if ($varOldMenuID[0][0] != $varNewMenuID[0][0])
                {
                        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

                        EasyGet::setOrderBy("position", EasyGet::OB_ASC);

                        $varMenuItems = EasyGet::execute
                        (
                            "TS: menu_items",
                            "CS: id",
                            "ARGS: menu_id = " . $varOldMenuID[0][0]
                        );            

                        for ($i = 0; $i < count($varMenuItems); $i ++)
                        {
                            EasyUpdate::execute
                            (
                                "TS: menu_items",
                                "CS: position",
                                "VLS: " . ($i + 1),
                                "ARGS: id = " . $varMenuItems[$i][0]
                            );
                        }
                }

                // Reddirect.

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-menu-items") . "&" . Locales::getVariable("id") . "=" . $varNewMenuID[0][0]));
            }
        }
        else
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("delete-menu-item")) // If Delete Menu Item Was Selected.
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            // Create "Core" Variables.
            
            $varItemID     = Filter::forNumeric($_GET[Locales::getVariable("id")]);
            $varItemExists = null;
            
            // "Menu Exists, Core Menu" Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varItemExists = EasyGet::execute
            (
                "TS: menu_items",
                "CS: COUNT(`id`)",
                "ARGS: id = $varItemID"
            );
            
            $varItemExists = $varItemExists[0][0] == 1;

            // Check If Menu Exists.

            if (!$varItemExists)
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
            
            // Fetch Menu ID.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
            
            $varMenuID = EasyGet::execute
            (
                "TS: menu_items",
                "CS: menu_id",
                "ARGS: id = " . $varItemID
            );
            
            $varMenuID = $varMenuID[0][0];
            
            // Delete Menu Item.

            EasyDelete::execute
            (
                "TS: menu_items",
                "ARGS: id = $varItemID"
            );
            
            // Reset Menu Item Positions.
                    
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
            
            EasyGet::setOrderBy("position", EasyGet::OB_ASC);
            
            $varMenuItems = EasyGet::execute
            (
                "TS: menu_items",
                "CS: id",
                "ARGS: menu_id = " . $varMenuID
            );            
            
            for ($i = 0; $i < count($varMenuItems); $i ++)
            {
                EasyUpdate::execute
                (
                    "TS: menu_items",
                    "CS: position",
                    "VLS: " . ($i + 1),
                    "ARGS: id = " . $varMenuItems[$i][0]
                );
            }

            // Reddirect.

            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
        }
        else
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
    }
    else
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("links")));
}

?>
