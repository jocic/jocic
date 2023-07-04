<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: filtered_variable.php                         *|
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

class FilteredVariable
{
    // "Class" Constants.

    const TP_TEXT          = "TEXT";
    const TP_TEXT_UPPR     = "TEXT_UPPERCASE";
    const TP_TEXT_LOWR     = "TEXT_LOWERCASE";
    const TP_NUMBERS       = "NUMBERS";
    const TP_ALPHA_NUMERIC = "ALPHA_NUMERIC";
    const TP_CUSTOM        = "CUSTOM";

    // "Core" Variables.

    private $type          = null;
    private $rlh           = null; // Redirect location for hack-attempts.
    private $re            = null; // Regular expression.
    private $value         = null;

    // "Control" Variables.

    private $checked 	   = true;
    private $ahse          = false; // AHSE -> Anti-Hack system enabled.

    // "Constructor/s."

    public function __construct($param = null)
    {
        if ($param != null)
            $this->setValue($param);
    }

    // "Set" Variables.

    public function setType($param = null)
    {
        if ($param == null)
            new Notice("FilteredVariable", "You haven't passed a value in the method <i>setType</i> or it is null.");
        else
            $this->type = $param;
    }

    public function setRedirectHackLocation($param = null)
    {
        if ($param == null)
            new Notice("IntegrityVariable", "You haven't passed a value in the method <i>setRedirectHackLocation</i> or it is null.");
        else
            $this->rlh = $param;
    }

    public function setRegularExpression($param = null)
    {
        if ($param == null)
            new Notice("FilteredVariable", "You haven't passed a value in the method <i>setRegularExpression</i> or it is null.");
        else
            $this->re = $param;
    }

    public function setValue($param = null)
    {
        $this->checked = false;

        if ($param == null)
        {
            new Notice("FilteredVariable", "You haven't passed a value in the method <i>setValue</i> or it is null.");
        }
        else
        {
            if ($this->type == null)
                new Notice("FilteredVariable", "You haven't initialized the \"type\" value of your variable. Variable filtration won't take effect.");

            $this->value = $param;
        }
    }

    // "Get" Variables.

    public function getType()
    {
        return $this->type;
    }

    public function getRedirectHackLocation()
    {
        return $this->rlh;
    }

    public function getRegularExpression()
    {
        return $this->re;
    }

    public function getValue()
    {
        if ($this->type == null)
        {
            new Notice("FilteredVariable", "You haven't initialized the \"type\" value of your variable. Variable filtration won't take effect.");
        }
        else if (!$this->checked)
        {
            if ($this->ahse)
            {
                $ahs = new AntiHackSystem();

                $ahs->setRedirectLocation($this->rlh);

                $ahs->anlyzeVariable($this->value);
            }

            if ($this->type == self::TP_TEXT)
                $this->value = preg_replace("/[^a-zA-Z ]/", "", $this->value);
            else if ($this->type == self::TP_TEXT_UPPR)
                $this->value = preg_replace("/[^A-Z ]/", "", $this->value);
            else if ($this->type == self::TP_TEXT_LOWR)
                $this->value = preg_replace("/[^a-z ]/", "", $this->value);
            else if ($this->type == self::TP_NUMBERS)
                $this->value = preg_replace("/[^0-9]/", "", $this->value);
            else if ($this->type == self::TP_ALPHA_NUMERIC)
                $this->value = preg_replace("/[^a-zA-Z0-9 ]/", "", $this->value);
            else if ($this->type == self::TP_CUSTOM)
            {
                if ($this->re == null)
                {
                    new Notice("IntegrityVariable", "You haven't initialized the \"regular expression\" variable. Integrity check will have no effect.");

                    $this->re = "//";
                }

                $this->value = preg_replace($this->re, "", $this->value);
            }
            else
                new Notice("FilteredVariable", "You didn't set a valid variable type.");

            $this->checked = true;
        }

        return $this->value;
    }

    // "Unset" Variables.

    public function unsetType()
    {
        $this->type = null;
    }

    public function unsetRedirectHackLocation()
    {
        $this->rlh = null;
    }

    public function unsetRegularExpression()
    {
        $this->re = null;
    }

    public function unsetValue()
    {
        $this->value = null;
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