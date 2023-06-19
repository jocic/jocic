<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: statistics.php                                *|
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

class Statistics
{
    // "Get" Methods.
    
    private static function countIDS($tableName, $argument = null)
    {
        if ($argument != null)
            $argument = "ARGS: " . $argument;
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: $tableName",
            "CS: COUNT(`id`)",
            $argument
        );

        return $data[0]["COUNT(`id`)"];
    }
    
    private static function get($name)
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: statistics",
            "CS: count",
            "ARGS: name = $name"
        );

        return $data[0]["count"];
    }
    
    public static function getTotalHits()
    {
        $hits = self::get("total_hits");
        
        if ($hits == null)
            return 0;
        else
            return $hits;
    }
    
    public static function getPageHits()
    {
        $hits = self::get("page_hits");
        
        if ($hits == null)
            return 0;
        else
            return self::get("page_hits");
    }
    
    public static function getUserCount()
    {
        return self::countIDS("users");
    }
    
    public static function getMaleUserCount()
    {
        return self::countIDS("user_info", "gender = 0");
    }
    
    public static function getFemaleUserCount()
    {
        return self::countIDS("user_info", "gender = 1");
    }
    
    public static function getOtherUserCount()
    {
        return self::countIDS("user_info", "gender = 2");
    }
    
    public static function getMessagesCount()
    {
        return self::countIDS("messages");
    }
    
    public static function getCommentCount()
    {
        return self::countIDS("page_comments");
    }
    
    public static function getPagesCount()
    {
        return self::countIDS("pages");
    }
    
    // "Print" Methods.
    
    public static function printVisits($parContainer, $parMaxHeight)
    {
        // Create "Core" Variables.
        
        $varTotalHits  = self::getTotalHits();
        $varPageHits   = self::getPageHits();
        $varSizeOne    = $parMaxHeight;
        $varSizeTwo    = ($parMaxHeight * $varPageHits) / $varTotalHits;
        
        // Create "Core" Elements.
        
        $divBarCont    = new FDiv();
        $divBarInfo    = new FDiv();
        $divBarOne     = new FDiv();
        $divBarTwo     = new FDiv();
        $divBarInfoOne = new FDiv();
        $divBarInfoTwo = new FDiv();
        
        // "Core" Variable Settings.
        
        $varSizeTwo = intval($varSizeTwo);
        
        // "Div Bar Cont" Element Settings.
        
        $divBarCont->setClass("bar-container");
        
        $divBarCont->addElement(new FDiv(null, "bar-holder", array($divBarOne, new FDiv(null, "bar-count", $varTotalHits))));
        $divBarCont->addElement(new FDiv(null, "bar-holder", array($divBarTwo, new FDiv(null, "bar-count", $varPageHits))));
        
        // "Div Bar Info" Element Settings.
        
        $divBarInfo->setClass("bar-information");
        
        $divBarInfo->addElement($divBarInfoOne);
        $divBarInfo->addElement($divBarInfoTwo);
        
        // "Div Bar One" Element Settings.
        
        $divBarOne->setClass("bar-1");
        $divBarOne->setStyle("height: " . $varSizeOne . "px;");
        $divBarOne->setContent("Bar 1");
        
        // "Div Bar Two" Element Settings.
        
        $divBarTwo->setClass("bar-2");
        $divBarTwo->setStyle("height: " . $varSizeTwo . "px; margin-top: " . ($parMaxHeight - $varSizeTwo) . "px;");
        $divBarTwo->setContent("Bar 2");
        
        // "Div Bar Info One" Element Settings.
        
        $divBarInfoOne->setClass("bar-info-line");
        
        $divBarInfoOne->addElement(new FDiv(null, "bar-color-1", "Bar Info 1"));
        $divBarInfoOne->addElement(new FDiv(null, "bar-description", Locales::getCore("total-hits")));
        $divBarInfoOne->addElement(new FDiv(null, "clr"));
        
        // "Div Bar Info Two" Element Settings.
        
        $divBarInfoTwo->setClass("bar-info-line");
        
        $divBarInfoTwo->addElement(new FDiv(null, "bar-color-2", "Bar Info 2"));
        $divBarInfoTwo->addElement(new FDiv(null, "bar-description", Locales::getCore("page-hits")));
        $divBarInfoTwo->addElement(new FDiv(null, "clr"));
        
        // Append Elements To "Workplace".

        $parContainer->addElement($divBarCont);
        $parContainer->addElement($divBarInfo);
        $parContainer->addElement(new FDiv(null, "clr"));
    }
    
    public static function printUsers($parContainer, $parMaxHeight)
    {
        // Create "Core" Variables.
        
        $varUserCount    = self::getUserCount();
        $varMaleUsers    = self::getMaleUserCount();
        $varFemaleUsers  = self::getFemaleUserCount();
        $varOtherUsers   = self::getOtherUserCount();
        $varSizeOne      = $parMaxHeight;
        $varSizeTwo      = ($parMaxHeight * $varMaleUsers) / $varUserCount;
        $varSizeThree    = ($parMaxHeight * $varFemaleUsers) / $varUserCount;
        $varSizeFour     = ($parMaxHeight * $varOtherUsers) / $varUserCount;
        
        // Create "Core" Elements.
        
        $divBarCont      = new FDiv();
        $divBarInfo      = new FDiv();
        $divBarOne       = new FDiv();
        $divBarTwo       = new FDiv();
        $divBarThree     = new FDiv();
        $divBarFour      = new FDiv();
        $divBarInfoOne   = new FDiv();
        $divBarInfoTwo   = new FDiv();
        $divBarInfoThree = new FDiv();
        $divBarInfoFour  = new FDiv();
        
        // "Core" Variable Settings.
        
        $varSizeTwo   = intval($varSizeTwo);
        $varSizeThree = intval($varSizeThree);
        $varSizeFour  = intval($varSizeFour);
        
        // "Div Bar Cont" Element Settings.
        
        $divBarCont->setClass("bar-container");
        
        $divBarCont->addElement(new FDiv(null, "bar-holder", array($divBarOne, new FDiv(null, "bar-count", $varUserCount))));
        $divBarCont->addElement(new FDiv(null, "bar-holder", array($divBarTwo, new FDiv(null, "bar-count", $varMaleUsers))));
        $divBarCont->addElement(new FDiv(null, "bar-holder", array($divBarThree, new FDiv(null, "bar-count", $varFemaleUsers))));
        $divBarCont->addElement(new FDiv(null, "bar-holder", array($divBarFour, new FDiv(null, "bar-count", $varOtherUsers))));
        
        // "Div Bar Info" Element Settings.
        
        $divBarInfo->setClass("bar-information");
        
        $divBarInfo->addElement($divBarInfoOne);
        $divBarInfo->addElement($divBarInfoTwo);
        $divBarInfo->addElement($divBarInfoThree);
        $divBarInfo->addElement($divBarInfoFour);
        
        // "Div Bar One" Element Settings.
        
        $divBarOne->setClass("bar-1");
        $divBarOne->setStyle("height: " . $varSizeOne . "px;");
        $divBarOne->setContent("Bar 1");
        
        // "Div Bar Two" Element Settings.
        
        $divBarTwo->setClass("bar-2");
        $divBarTwo->setStyle("height: " . $varSizeTwo . "px; margin-top: " . ($parMaxHeight - $varSizeTwo) . "px;");
        $divBarTwo->setContent("Bar 2");
        
        // "Div Bar Three" Element Settings.
        
        $divBarThree->setClass("bar-3");
        $divBarThree->setStyle("height: " . $varSizeThree . "px; margin-top: " . ($parMaxHeight - $varSizeThree) . "px;");
        $divBarThree->setContent("Bar 3");
        
        // "Div Bar Four" Element Settings.
        
        $divBarFour->setClass("bar-4");
        $divBarFour->setStyle("height: " . $varSizeFour . "px; margin-top: " . ($parMaxHeight - $varSizeFour) . "px;");
        $divBarFour->setContent("Bar 4");
        
        // "Div Bar Info One" Element Settings.
        
        $divBarInfoOne->setClass("bar-info-line");
        
        $divBarInfoOne->addElement(new FDiv(null, "bar-color-1", "Bar Info 1"));
        $divBarInfoOne->addElement(new FDiv(null, "bar-description", Locales::getCore("users-registered")));
        $divBarInfoOne->addElement(new FDiv(null, "clr"));
        
        // "Div Bar Info Two" Element Settings.
        
        $divBarInfoTwo->setClass("bar-info-line");
        
        $divBarInfoTwo->addElement(new FDiv(null, "bar-color-2", "Bar Info 2"));
        $divBarInfoTwo->addElement(new FDiv(null, "bar-description", Locales::getCore("males-registered")));
        $divBarInfoTwo->addElement(new FDiv(null, "clr"));
        
        // "Div Bar Info Three" Element Settings.
        
        $divBarInfoThree->setClass("bar-info-line");
        
        $divBarInfoThree->addElement(new FDiv(null, "bar-color-3", "Bar Info 3"));
        $divBarInfoThree->addElement(new FDiv(null, "bar-description", Locales::getCore("females-registered")));
        $divBarInfoThree->addElement(new FDiv(null, "clr"));
        
        // "Div Bar Info Four" Element Settings.
        
        $divBarInfoFour->setClass("bar-info-line");
        
        $divBarInfoFour->addElement(new FDiv(null, "bar-color-4", "Bar Info 4"));
        $divBarInfoFour->addElement(new FDiv(null, "bar-description", Locales::getCore("others-registered")));
        $divBarInfoFour->addElement(new FDiv(null, "clr"));
        
        // Append Elements To "Workplace".

        $parContainer->addElement($divBarCont);
        $parContainer->addElement($divBarInfo);
        $parContainer->addElement(new FDiv(null, "clr"));
    }
    
    // "Increment" Methods.
    
    public static function increment($nameValue)
    {
        EasyUpdate::execute
        (
            "TS: statistics",
            "CS: count",
            "VLS: increment",
            "ARGS: name = $nameValue"
        );
    }
    
    public static function incrementTotalHits()
    {
        self::increment("total_hits");
    }
    
    public static function incrementPageHits()
    {
        self::increment("page_hits");
    }
}

?>
