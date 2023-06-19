<?php

/***********************************************************\
|* Magnum CMS v1.0.0                                       *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: user.php                                      *|
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

class RandomStringGenerator
{
    // "Class" Constants.
    
    const OPT_NUMERIC            = 0;
    const OPT_ALPHA_NUMERIC      = 1;
    const OPT_ALPHA_NUMERIC_CAPT = 2;
    const OPT_ALPHA_NUMERIC_RAND = 3;
    
    // "Main" Variables.
    
    private $numberSeed    = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    
    private $characterSeed = array
    (
        'a', 'b', 'c', 'd', 'e', 'f', 'g',
        'h', 'i', 'j', 'k', 'l', 'm', 'n',
        'o', 'p', 'q', 'r', 's', 't', 'u',
        'v', 'w', 'x', 'y', 'z'
    );
    
    // "Other" Variables.
    
    private $option = null;
    private $size   = null;
    private $rs     = null; // Random String.
    
    // "Constructor/s".
    
    public function __construct()
    {
        $this->option = self::OPT_NUMERIC; // Default Option.
        
        $this->size   = 10; // Default Size.
    }
    
    // "Set" Methods.
    
    public function setOption($value)
    {
        $this->option = $value;
    }
    
    public function setSize($stringSize)
    {
        $this->size = $stringSize;
    }
    
    // "Get" Methods.
    
    public function getOption()
    {
        return $this->option;
    }
    
    public function getSize()
    {
        return $this->size;
    }
    
    public function getRandomString()
    {
        return $this->rs;
    }
    
    // "Main" Methods.
    
    public function generateString()
    {
        $tempArray = array();
        
        if ($this->option == self::OPT_NUMERIC)
            $tempArray = $this->numberSeed;
        else
            $tempArray = array_merge($this->numberSeed, $this->characterSeed);
        
        $count = count($tempArray) - 1;
        
        for ($i = 0; $i < $this->size; $i ++)
        {
            $char = $tempArray[rand(0, $count)];
            
            if ($this->option == self::OPT_ALPHA_NUMERIC_CAPT)
                $char = strtoupper($char);
            else if ($this->option == self::OPT_ALPHA_NUMERIC_RAND)
            {
                if (rand(0, 1) == 1)
                    $char = strtoupper($char);
            }
            
            $this->rs .= $char;
        }
    }
}

?>
