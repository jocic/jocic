<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table.php                                     *|
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

class FTable extends FHTMLObject
{
    // "Main" Variables.
    
    private $rows = null;
    
    // "Constructor/s"
    
    public function __construct($id = null, $class = null, $align = null)
    {
        $this->setID($id);
        $this->setClass($class);
        $this->setAlignment($align);
    }
    
    // "Set" Methods.
    
    public function setRows($rowArray)
    {
        $this->rows = $rowArray;
    }
    
    public function setRowAt($rowObject, $position)
    {
        if ($rowObject instanceof FTableRow)
            $this->rows[$position] = $rowObject;
    }
    
    // "Get" Methods.
    
    public function getRows()
    {
        return $this->rows;
    }
    
    public function getRowAt($position)
    {
        return $this->rows[$position];
    }
    
    // "Add" Methods.
    
    public function addRow($rowObject)
    {
        if ($rowObject instanceof FTableRow)
            $this->rows[] = $rowObject;
    }
    
    // "Other" Methods.
    
    public function countRows()
    {
        return count($rows);
    }
}

?>
