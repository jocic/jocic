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

class FParagraph extends FHTMLObject
{
    // "Main" Variables.
    
    private $link      = null;
    private $linkTitle = null;
    
    // "Constructor/s."
    
    public function __construct($content = null, $alignment = null, $paragraphLink = null, $paragraphLinkTitle = null)
    {
        $this->setContent($content);
        $this->setAlignment($alignment);
        
        $this->link      = $paragraphLink;
        $this->linkTitle = $paragraphLinkTitle;
    }
    
    // "Set" Methods.
    
    public function setLink($paragraphLink)
    {
        $this->link = $paragraphLink;
    }
    
    public function setLinkTitle($paragraphLinkTitle)
    {
        $this->linkTitle = $paragraphLinkTitle;
    }
    
    // "Get" Methods.
    
    public function getLink()
    {
        return $this->link;
    }
    
    public function getLinkTitle()
    {
        return $this->linkTitle;
    }
}

?>
