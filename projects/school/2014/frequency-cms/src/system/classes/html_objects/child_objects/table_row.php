<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_row.php                                 *|
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

class FTableRow extends FHTMLObject
{
    // "Main" Variables.
    
    private $cells = null;
    
    // "Constructor/s"
    
    public function __construct($id = null, $class = null, $cellData = null)
    {
        $this->setID($id);
        $this->setClass($class);
        
        if ($cellData != null)
        {
            if (is_array($cellData))
                $this->setCells($cellData);
            else if ($cellData instanceof FTableCell)
                $this->addCell($cellData);
            else
                $this->addCell(new FTableCell(null, null, $cellData));
        }
    }
    
    // "Set" Methods.
    
    public function setCells($cellRows)
    {
        $this->cells = $cellRows;
    }
    
    public function setCellAt($cellObject, $position)
    {
        if ($cellObject instanceof FTableCell)
            $this->cells[$position] = $cell;
    }
    
    // "Get" Methods.
    
    public function getCells()
    {
        return $this->cells;
    }
    
    public function getCellAt($position)
    {
        return $this->cells[$position];
    }
    
    // "Add" Methods.
    
    public function addCell($cellObject)
    {
        if ($cellObject instanceof FTableCell)
            $this->cells[] = $cellObject;
    }
}

?>
