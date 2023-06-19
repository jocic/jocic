<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: form.php                                      *|
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

class FAnchor extends FHTMLObject
{
    // "Main" Variables.
    
    private $l   = null;
    private $lt  = null;
    private $onw = false;
    
    // "Constructor/s".
    
    public function __construct($id = null, $class = null, $link = null, $linkTitle = null, $content = null, $openNewWindow = false)
    {
        $this->setID($id);
        $this->setClass($class);
        $this->setLink($link);
        $this->setLinkTitle($linkTitle);
        $this->setContent($content);
        $this->setOpenNewWindow($openNewWindow);
    }
    
    // "Set" Methods.
    
    public function setLink($link)
    {
        $this->l = $link;
    }
    
    public function setLinkTitle($linkTitle)
    {
        $this->lt = $linkTitle;
    }
    
    public function setOpenNewWindow($varOpenNewWindow)
    {
        $this->onw = $varOpenNewWindow;
    }
    
    // "Get" Methods.
    
    public function getLink()
    {
        return $this->l;
    }
    
    public function getLinkTitle()
    {
        return $this->lt;
    }
    
    public function getOpenNewWindow()
    {
        return $this->onw;
    }
}

?>
