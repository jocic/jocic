<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: assets.php                                    *|
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

class Adverts
{
    // "Advert" Constats.
    
    const ADV_SECTION_1 = 0;
    const ADV_SECTION_2 = 1;
    const ADV_SECTION_3 = 2;
    const ADV_SECTION_4 = 3;
    const ADV_SECTION_5 = 4;
    
    // "Is" Methods.
    
    public static function isAdvertCreated($parAdvertID)
    {
        // Filter Advert ID.
        
        $parAdvertID = Filter::forNumeric($parAdvertID);
        
        // Fetch All Adverts.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $varData = EasyGet::execute
        (
            "TS: ads",
            "CS: COUNT(`id`)",
            "ARGS: id = $parAdvertID"
        );
        
        // Return The Data.
        
        return $varData[0][0] == 1;
    }
    
    // "Get" Methods.
    
    public static function getAll()
    {
        // Fetch All Adverts.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setOrderBy("section", EasyGet::OB_ASC);
        
        $varData = EasyGet::execute
        (
            "TS: ads",
            "CS: *"
        );
        
        // Return The Data.
        
        return $varData;
    }
    
    public static function getAdvert($parAdvertID)
    {
        // Filter Advert ID.
        
        $parAdvertID = Filter::forNumeric($parAdvertID);
        
        // Fetch All Adverts.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $varData = EasyGet::execute
        (
            "TS: ads",
            "CS: *",
            "ARGS: id = $parAdvertID"
        );
        
        // Return The Data.
        
        return $varData[0];
    }
            
    public static function getRandomAdvertString($parAdvertSection)
    {
        // Check Advert Section.
        
        if ($parAdvertSection == self::ADV_SECTION_1 ||
            $parAdvertSection == self::ADV_SECTION_2 ||
            $parAdvertSection == self::ADV_SECTION_3 ||
            $parAdvertSection == self::ADV_SECTION_4 ||
            $parAdvertSection == self::ADV_SECTION_5)
        {   
            // Fetch All Adverts.
            
            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
            
            $varAdverts = EasyGet::execute
            (
                "TS: ads",
                "CS: content, css_id, css_class",
                "ARGS: section = $parAdvertSection"
            );
            
            if ($varAdverts != null)
            {
                // Choose A Random Advert.

                $varRandomAdvert = $varAdverts[rand(0, (count($varAdverts) - 1))];

                // Convert Random Advert To Usable String.

                $varAdvertContent = "<div";

                if (!empty($varRandomAdvert["css_id"]))
                    $varAdvertContent .= " id=\"" . $varRandomAdvert["css_id"] . "\"";

                if (!empty($varRandomAdvert["css_class"]))
                    $varAdvertContent .= " class=\"" . $varRandomAdvert["css_class"] . "\"";

                $varAdvertContent .= ">" . html_entity_decode($varRandomAdvert["content"]) . "</div>\n";

                // Return The Advert.

                return $varAdvertContent;
            }
        }
        else
        {
            return;
        }
    }
    
    // "Add" Methods.
    
    public static function addAdvert($parName, $parContent, $parID, $parClass, $parSection)
    {
        // Create New Value Selection.
        
        $varVS = new ValueSelection();
        
        $varVS->setOption(ValueSelection::OPT_ENCODE);
        
        $varVS->addValues(array($parName, $parContent, $parID, $parClass, $parSection));
        
        // Update Values.
        
        EasyInsert::execute
        (
            "TS: ads",
            "CS: name, content, css_id, css_class, section",
            $varVS
        );
    }
    
    // "Alter" Methods.
    
    public static function alterAdvert($parName, $parContent, $parID, $parClass, $parSection, $parAdvertID)
    {
        // Filter Advert ID.
        
        $parAdvertID = Filter::forNumeric($parAdvertID);
        
        // Create New Value Selection.
        
        $varVS = new ValueSelection();
        
        $varVS->setOption(ValueSelection::OPT_ENCODE);
        
        $varVS->addValues(array($parName, $parContent, $parID, $parClass, $parSection));
        
        // Update Values.
        
        EasyUpdate::execute
        (
            "TS: ads",
            "CS: name, content, css_id, css_class, section",
            $varVS,
            "ARGS: id = $parAdvertID"
        );
    }
    
    // "Remove" Methods.
    
    public static function removeAdvert($parAdvertID)
    {
        // Filter Advert ID.
        
        $parAdvertID = Filter::forNumeric($parAdvertID);
        
        // Delete Row.
        
        EasyDelete::execute
        (
            "TS: ads",
            "ARGS: id = $parAdvertID"
        );
    }
}

?>