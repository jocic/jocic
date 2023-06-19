<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: menus.php                                     *|
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

class Menus
{
    // "Item" Constants.
    
    const MI_TITLE       = 0;
    const MI_SEPARATOR   = 1;
    const MI_SUBMENU     = 2;
    const MI_CORE_PAGE   = 3;
    const MI_PAGE        = 4;
    const MI_CUSTOM_LINK = 5;
    
    // "Class" Constants.
    
    const MN_MAIN        = 1;
    const MN_SIDE        = 2;
    
    // "Main" Methods.
   
    public static function getMenuItems($varMenuID, $printSubmenus = true)
    {
        // Create "Core" Variables.
        
        $varMenuID         = Filter::forNumeric($varMenuID);
        $varMenuItems      = null;
        $varMenuItemNumber = 1;
        
        if (!empty($varMenuID))
        {
            // Fetch Menu Items.

            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

            EasyGet::setOrderBy("position", EasyGet::OB_ASC);

            $varMenuItems = EasyGet::execute
            (
                "TS: menu_items",
                "CS: title, value, type",
                "ARGS: menu_id = $varMenuID"
            );
            
            // Process Menu Items.
            
            for ($i = 0; $i < count($varMenuItems); $i ++)
            {
                $varTempItem = null;
                
                if ($varMenuItems[$i]["type"] == self::MI_TITLE) // "Title" Item.
                {
                    $varTempItem = new FHeader();
                    
                    $varTempItem->setLevel(1);
                    $varTempItem->setContent($varMenuItems[$i]["title"]);
                }
                else if ($varMenuItems[$i]["type"] == self::MI_SEPARATOR) // "Separator" Item.
                {
                    $varTempItem = new FDiv();
                    
                    $varTempItem->setClass("separator");
                    $varTempItem->setContent("-----------------");
                }
                else if ($varMenuItems[$i]["type"] == self::MI_SUBMENU) // "Menu" Item.
                {
                    if ($printSubmenus)
                    {
                        $varTempItem = new FList();

                        $varTempItem->setID("sub-menu");
                        $varTempItem->setType(FList::TP_UL);
                        $varTempItem->setName("<span>" . $varMenuItems[$i]["title"] . "</span>");

                        $varTempItem->setItems(self::getMenuItems($varMenuItems[$i]["value"], false));
                        
                        $varTempItem = new FListItem("menu-item-$varMenuItemNumber", null, $varTempItem);
                    }
                }
                else if ($varMenuItems[$i]["type"] == self::MI_CORE_PAGE ||
                         $varMenuItems[$i]["type"] == self::MI_PAGE) // "Core" Item.
                {
                    $varTempItem = new FListItem();
                    
                    $varTempItem->setID("menu-item-$varMenuItemNumber");
                    
                    if ($varMenuItems[$i]["value"] == Locales::getLink("homepage")) // Home Page.
                    {
                        $varTempItem->setContent(new FAnchor("link-item-$varMenuItemNumber", null, "./", null, $varMenuItems[$i]["title"]));
                    }
                    else
                    {
                        // Check For Custom ID.
                        
                        if (is_numeric($varMenuItems[$i]["value"]))
                        {
                            // Fetch Custom ID.

                            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

                            $varData = EasyGet::execute
                            (
                                "TS: pages",
                                "CS: custom_id",
                                "ARGS: id = " . $varMenuItems[$i]["value"]
                            );

                            // Process Value Variable.
                            
                            if ($varData != null)
                                $varMenuItems[$i]["value"] = $varData[0]["custom_id"];
                        }
                        
                        // Take In To The Account Translations.
                        
                        if (Locales::getLink($varMenuItems[$i]["value"]) != "?")
                            $varMenuItems[$i]["value"] = Locales::getLink($varMenuItems[$i]["value"]);
                        
                        // Create And Append Menu Item.
                        
                        $varTempItem->setContent(new FAnchor("link-item-$varMenuItemNumber", null, "./?" . Locales::getVariable("page") . "=" . $varMenuItems[$i]["value"], null, $varMenuItems[$i]["title"]));
                    }
                    
                    $varMenuItemNumber ++;
                }
                else if ($varMenuItems[$i]["type"] == self::MI_CUSTOM_LINK) // "Core" Item.
                {
                    $varTempItem = new FListItem();
                    
                    $varTempItem->setID("menu-item-$varMenuItemNumber");
                    
                    $varTempItem->setContent(new FAnchor("link-item-$varMenuItemNumber", null, $varMenuItems[$i]["value"], null, $varMenuItems[$i]["title"]));
                    
                    $varMenuItemNumber ++;
                }
                
                $varMenuItems[$i] = $varTempItem;
            }
        }
        
        // Return Menu Items.
        
        return $varMenuItems;
    }
    
    // "Main" Methods.
    
    public static function moveItemUp($itemID)
    {
        // Filter Item ID.
        
        $itemID = Filter::forNumeric($itemID);
        
        // Fetch Menu Items IDS.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: menu_items",
            "CS: menu_id",
            "ARGS: id = $itemID"
        );
        
        EasyGet::setOrderBy("position");
        
        $data = EasyGet::execute
        (
            "TS: menu_items",
            "CS: title, id, position",
            "ARGS: menu_id = " . $data[0]["menu_id"]
        );
        
        for ($i = 0; $i < count($data); $i ++)
        {
            if ($data[$i]["id"] == $itemID)
            {
                if (isset($data[$i - 1]))
                {
                    EasyUpdate::execute
                    (
                        "TS: menu_items",
                        "CS: position",
                        "VLS: " . $data[$i]["position"],
                        "ARGS: id = " . $data[$i - 1]["id"]
                    );

                    EasyUpdate::execute
                    (
                        "TS: menu_items",
                        "CS: position",
                        "VLS: " . $data[$i - 1]["position"],
                        "ARGS: id = " . $data[$i]["id"]
                    );
                }
            }
        }
    }
    
    public static function moveItemDown($itemID)
    {
        // Filter Item ID.
        
        $itemID = Filter::forNumeric($itemID);
        
        // Fetch Menu Items IDS.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: menu_items",
            "CS: menu_id",
            "ARGS: id = $itemID"
        );
        
        EasyGet::setOrderBy("position");
        
        $data = EasyGet::execute
        (
            "TS: menu_items",
            "CS: title, id, position",
            "ARGS: menu_id = " . $data[0]["menu_id"]
        );
        
        for ($i = 0; $i < count($data); $i ++)
        {
            if ($data[$i]["id"] == $itemID)
            {
                if (isset($data[$i + 1]))
                {
                    EasyUpdate::execute
                    (
                        "TS: menu_items",
                        "CS: position",
                        "VLS: " . $data[$i]["position"],
                        "ARGS: id = " . $data[$i + 1]["id"]
                    );

                    EasyUpdate::execute
                    (
                        "TS: menu_items",
                        "CS: position",
                        "VLS: " . $data[$i + 1]["position"],
                        "ARGS: id = " . $data[$i]["id"]
                    );
                }
            }
        }
    }
}

?>
