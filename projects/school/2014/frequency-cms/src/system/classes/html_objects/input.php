<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: input.php                                     *|
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

class FInput extends FHTMLObject
{
    // "Type" Constants.
    
    const TP_TEXT     = "text";
    const TP_PASSWORD = "password";
    const TP_CHECKBOX = "checkbox";
    const TP_HIDDEN   = "hidden";
    const TP_SUBMIT   = "submit";
    
    // "Main" Variables.
    
    private $ml       = null;
    private $tp       = null;
    private $nm       = null;
    private $vl       = null;
    
    // "Constructor/s."
    
    public function __construct($inputID = null, $inputClass = null, $inputType = null, $inputName = null, $inputContent = null)
    {
        $this->setID($inputID);
        $this->setClass($inputClass);
        $this->setType($inputType);
        $this->setName($inputName);
        $this->setContent($inputContent);
    }
    
    // "Set" Methods.
    
    public function setMaxLength($maxLength)
    {
        $this->ml = $maxLength;
    }
    
    public function setType($type)
    {
        $this->tp = $type;
    }
    
    public function setName($name)
    {
        $this->nm = $name;
    }
    
    public function setValue($value)
    {
        $this->vl = $value;
    }

    // "Get" Methods.
    
    public function getMaxLength()
    {
        return $this->ml;
    }
    
    public function getType()
    {
        return $this->tp;
    }
    
    public function getName()
    {
        return $this->nm;
    }
    
    public function getValue()
    {
        return $this->vl;
    }
}

?>
