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

class FForm extends FHTMLObject
{
    // "Method" Constants.
    
    const MTD_GET   = "get";
    const MTD_POST  = "post";
    
    // "Main" Variables.
    
    private $type   = null;
    private $method = null;
    private $action = null;
    private $items  = null;
    
    // "Constructor/s".
    
    public function __construct($id = null, $class = null, $method = null, $action = null)
    {
        $this->setID($id);
        $this->setClass($class);
        $this->setMethod($method);
        $this->setAction($action);
    }
    
    // "Set" Methods.
    
    public function setType($formType)
    {
        $this->type = $formType;
    }
    
    public function setMethod($formMethod)
    {
        $this->method = $formMethod;
    }
    
    public function setAction($formAction)
    {
        $this->action = $formAction;
    }
    
    public function setItemAt($item, $position)
    {
        $this->items[$position] = $item;
    }
    
    // "Get" Methods.
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function getAction()
    {
        return $this->action;
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
