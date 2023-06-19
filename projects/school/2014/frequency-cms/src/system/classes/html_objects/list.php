<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: list.php                                      *|
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

// Class Starts.

class FList extends FHTMLObject
{
    // "Type" Constants.
    
    const TP_UL = "ul";
    const TP_OL = "ol";
    
    // "Main" Variables.
    
    private $type  = null;
    private $items = null;
    
    // "Constructor/s."
    
    public function __construct($listType = null, $listID = null, $listClass = null)
    {
        $this->type = $listType;

        $this->setID($listID);
        $this->setClass($listClass);
    }
    
    // "Set" Methods.
    
    public function setType($listType)
    {
        $this->type = $listType;
    }
    
    public function setItems($varListItems)
    {
        $this->items = $varListItems;
    }

    public function setItemAt($listItem, $position)
    {
        $this->items[$position] = $listItem;
    }
    
    // "Get" Methods.
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getItemAt($position)
    {
        return $this->items[$position];
    }
    
    public function getItems()
    {
        return $this->items;
    }
    
    // "Add" Methods.
    
    public function addItem($item)
    {
        $this->items[] = $item;
    }
    
    // "Other" Methods.
    
    public function countItems()
    {
        return count($this->items);
    }
}

?>