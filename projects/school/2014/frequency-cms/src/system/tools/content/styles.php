<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: styles.php                                    *|
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

class Styles
{
    // "Is" Methods.
    
    public static function isStyleCreated($parStyleID)
    {
        // Filter Style ID.
        
        $parStyleID = Filter::forNumeric($parStyleID);
        
        // Fetch All Adverts.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $varData = EasyGet::execute
        (
            "TS: styles",
            "CS: COUNT(`id`)",
            "ARGS: id = $parStyleID"
        );
        
        // Return The Data.
        
        return $varData[0][0] == 1;
    }
    
    // "Get" Methods.
    
    public static function getAll()
    {
        // Fetch All Adverts.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $varData = EasyGet::execute
        (
            "TS: styles",
            "CS: *"
        );
        
        // Return The Data.
        
        return $varData;
    }
    
    public static function getStyle($parStyleID)
    {
        // Filter Style ID.
        
        $parStyleID = Filter::forNumeric($parStyleID);
        
        // Fetch All Adverts.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $varData = EasyGet::execute
        (
            "TS: styles",
            "CS: *",
            "ARGS: id = $parStyleID"
        );
        
        // Return The Data.
        
        return $varData[0];
    }
    
    // "Add" Methods.
    
    public static function addStyle($parName, $parContent)
    {
        // Create New Value Selection.
        
        $varVS = new ValueSelection();
        
        $varVS->setOption(ValueSelection::OPT_ENCODE);
        
        $varVS->addValues(array($parName, $parContent));
        
        // Update Values.
        
        EasyInsert::execute
        (
            "TS: styles",
            "CS: name, content",
            $varVS
        );
    }
    
    // "Alter" Methods.
    
    public static function alterStyle($parName, $parContent, $parStyleID)
    {
        // Filter Style ID.
        
        $parStyleID = Filter::forNumeric($parStyleID);
        
        // Create New Value Selection.
        
        $varVS = new ValueSelection();
        
        $varVS->setOption(ValueSelection::OPT_ENCODE);
        
        $varVS->addValues(array($parName, $parContent));
        
        // Update Values.
        
        EasyUpdate::execute
        (
            "TS: styles",
            "CS: name, content",
            $varVS,
            "ARGS: id = $parStyleID"
        );
    }
    
    // "Remove" Methods.
    
    public static function removeStyle($parStyleID)
    {
        // Filter Style ID.
        
        $parStyleID = Filter::forNumeric($parStyleID);
        
        // Delete Row.
        
        EasyDelete::execute
        (
            "TS: styles",
            "ARGS: id = $parStyleID"
        );
    }
}

?>