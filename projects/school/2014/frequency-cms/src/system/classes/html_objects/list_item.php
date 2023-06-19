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

class FListItem
{
    // "Main" Variables.
    
    private $id      = null;
    private $class   = null;
    private $content = null;
    
    // "Constructor/s."
    
    public function __construct($itemID = null, $itemClass = null, $itemContent = null)
    {
        $this->id      = $itemID;
        $this->class   = $itemClass;
        $this->content = $itemContent;
    }
    
    // "Set" Methods.

    public function setID($itemID)
    {
        $this->id = $itemID;
    }
    
    public function setClass($itemClass)
    {
        $this->class = $itemClass;
    }
    
    public function setContent($itemContent)
    {
        $this->content = $itemContent;
    }
    
    // "Get" Methods.
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function getContent()
    {
        return $this->content;
    }
}

?>