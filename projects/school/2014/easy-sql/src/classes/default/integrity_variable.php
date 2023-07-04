<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: integrity_variable.php                        *|
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

if (!defined("CONST_EASY_SQL")) exit("Action not allowed.");

class IntegrityVariable
{
    // "Class" Constants.

    const TP_BOOLEAN = "BOOLEAN";
    const TP_NUMERIC = "NUMERIC";
    const TP_INTEGER = "INTEGER";
    const TP_DOUBLE  = "DOUBLE";
    const TP_LONG    = "LONG";
    const TP_REAL    = "REAL";
    const TP_STRING  = "STRING";
    const TP_CUSTOM  = "CUSTOM";

    // "Core" Variables.

    private $type    = null;
    private $rl      = null; // Redirect location.
    private $rlh     = null; // Redirect location for hack-attempts.
    private $re      = null; // Regular expression.
    private $value   = null;
	
    // "Control" Variables.

    private $checked = true;
    private $ahse    = false; // AHSE -> Anti-Hack system enabled.

    // "Constructor/s"

    public function __construct($param = null)
    {
        if ($param != null)
            $this->setValue($param);
    }
	
    // "Set" Methods.

    public function setType($param = null)
    {
        if ($param == null)
            new Notice("IntegrityVariable", "You haven't passed a value in the method <i>setType</i> or it is null.");
        else
            $this->type = $param;
    }
	
    public function setRegularExpression($param = null)
    {
        if ($param == null)
            new Notice("IntegrityVariable", "You haven't passed a value in the method <i>setRegularExpression</i> or it is null.");
        else
            $this->re = $param;
    }
	
    public function setRedirectLocation($param = null)
    {
        if ($param == null)
            new Notice("IntegrityVariable", "You haven't passed a value in the method <i>setRedirectLocation</i> or it is null.");
        else
            $this->rl = $param;
    }
	
    public function setRedirectHackLocation($param = null)
    {
        if ($param == null)
            new Notice("IntegrityVariable", "You haven't passed a value in the method <i>setRedirectHackLocation</i> or it is null.");
        else
            $this->rlh = $param;
    }

    public function setValue($param = null)
    {
        $this->checked = false;

        if ($param == null)
        {
            new Notice("IntegrityVariable", "You haven't passed a value in the method <i>setValue</i> or it is null.");
        }
        else if ($this->type == null)
        {
            new Notice("IntegrityVariable", "You haven't initialized the \"type\" value of your variable. Integrity check will have no effect.");

            $this->value = $param;
        }
        else
        {
            $this->value = $param;
        }
    }
	
    // "Get" Methods.

    public function getType()
    {
        return $this->type;
    }

    public function getRegularExpression()
    {
        return $this->re;
    }

    public function getRedirectLocation()
    {
        return $this->rl;
    }

    public function getRedirectHackLocation()
    {
        return $this->rlh;
    }
	
    public function getValue()
    {
        if ($this->type == null)
        {
            new Notice("IntegrityVariable", "You haven't initialized the \"type\" value of your variable. Integrity check won't take effect.");
        }
        else if (!$this->checked)
        {
            if ($this->ahse) // First check, AHS.
            {
                $ahs = new AntiHackSystem();

                $ahs->setRedirectLocation($this->rlh);

                $ahs->anlyzeVariable($this->value);
            }

            if (!$this->isVariableValid($this->value)) // Validity check, if passed the AHS check.
            {
                if ($this->rl != null)	
                    exit(header("location: " . $this->rl));
                else
                    return null;
            }

            $this->checked = true;
        }

        return $this->value;
    }

	
    // "Unset" Methods.

    public function unsetType()
    {
        $this->type = null;
    }

    public function unsetRegularExpression()
    {
        $this->re = null;
    }

    public function unsetRedirectLocation()
    {
        $this->rl = null;
    }

    public function unsetRedirectHackLocation()
    {
        $this->rlh = null;
    }

    public function unsetValue()
    {
        $this->value = null;
    }
	
    // "Other" Methods.

    private function isVariableValid($param = null)
    {
        if ($this->type == self::TP_BOOLEAN)
            return is_bool($param);
        else if ($this->type == self::TP_NUMERIC)
            return is_numeric($param);
        else if ($this->type == self::TP_INTEGER)
            return is_integer($param);
        else if ($this->type == self::TP_DOUBLE)
            return is_double($param);
        else if ($this->type == self::TP_LONG)
            return is_long($param);
        else if ($this->type == self::TP_REAL)
            return is_real($param);
        else if ($this->type == self::TP_STRING)
            return is_string($param);
        else if ($this->type == self::TP_CUSTOM)
        {
            if ($this->re == null)
            {
                new Notice("IntegrityVariable", "You haven't initialized the \"regular expression\" variable. Integrity check will have no effect.");

                $this->re = "//";
            }

            return preg_match($this->re, $param);
        }
        else
            new Notice("IntegrityVariable", "You didn't set a valid variable type.");
    }
	
    // "Anti-Hack System" Methods.

    public function setAntiHackSystemValue($param = null)
    {
        if (is_bool($param))
        {
            $this->ahse = $param;
        }
        else
            new Notice("IntegrityVariable", "You need to use variable of boolean type in <i>enableAntiHackSystem</i> method.");
    }
	
    public function getAntiHackSystemValue()
    {
        return $this->ahse;
    }
	
    public function enableAntiHackSystem($param = null)
    {
        $this->ahse = true;
    }

    public function disableAntiHackSystem($param = null)
    {
        $this->ahse = false;
    }
}

?>