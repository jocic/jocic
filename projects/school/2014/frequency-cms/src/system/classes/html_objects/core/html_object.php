<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: paragraph.php                                 *|
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

class FHTMLObject
{
    // "Alignment" Constants.
    
    const ALN_LEFT   = "left";
    const ALN_RIGHT  = "right";
    const ALN_CENTER = "center";
    
    // "Main" Methods.
    
    private $name      = null; // DELETE.
    
    private $link      = null; // DELETE.
    
    private $id        = null;
    private $class     = null;
    private $align     = null;
    private $style     = null;
    
    private $content   = null; // DELETE.
    
    private $option    = null; // DELETE>
    
    // "Set" Methods.
    
    public function setName($objectName)
    {
        $this->name = $objectName;
    }
    
    public function setLink($objectLink)
    {
        $this->link = $objectLink;
    }
    
    public function setID($objectID)
    {
        $this->id = $objectID;
    }
    
    public function setClass($objectClass)
    {
        $this->class = $objectClass;
    }
    
    public function setAlignment($objectAlignment)
    {
        $this->align = $objectAlignment;
    }
    
    public function setStyle($objectStyle)
    {
        $this->style = $objectStyle;
    }
    
    public function setContent($objectContent)
    {
        $this->content = $objectContent;
    }
    
    public function setOption($objectOptions)
    {
        $this->option = $objectOptions;
    }
    
    // "Get" Methods.
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getLink()
    {
        return $this->link;
    }
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function getAlignment()
    {
        return $this->align;
    }
    
    public function getStyle()
    {
        return $this->style;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function getOption()
    {
        return $this->option;
    }
}

?>
