<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_core.php                                 *|
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

class EasyCore
{
    // "Option" Variables.

    private static $DEBUG_MODE      = false;
    private static $SHOW_FM_NOTICES = false;
    private static $SHOW_FM_ERRORS  = false;
    private static $SHOW_SRV_ERRORS = false;

    // "Core" Variables.

    public static $DTB_SCHEMA       = null; // Database schema.
    public static $TBL_PREFIX       = null; // Table prefix.
    public static $VIE_PREFIX       = null; // View prefix.
    public static $BANNED_RED_LOC   = null; // Redirection location for banned users.
	
    // "Set" Methods.

    public static function setDebugMode($value)
    {
        if (!is_bool($value))
            new Notice("EasyConnect", "Method <i>setDebugMode</i> requires boolean for a parameter.");

        self::$DEBUG_MODE = $value;
    }
	
    public static function setShowFrameworkNotices($value)
    {
        if (!is_bool($value))
            new Notice("EasyConnect", "Method <i>setShowFrameworkNotices</i> requires boolean for a parameter.");

        self::$SHOW_FM_NOTICES = $value;
    }
	
    public static function setShowFrameworkErrors($value)
    {
        if (!is_bool($value))
            new Notice("EasyConnect", "Method <i>setShowFrameworkErrors</i> requires boolean for a parameter.");

        self::$SHOW_FM_ERRORS = $value;
    }
	
    public static function setShowServerErrors($value)
    {
        if (!is_bool($value))
            new Notice("EasyConnect", "Method <i>setShowServerErrors</i> requires boolean for a parameter.");

        self::$SHOW_SRV_ERRORS = $value;
    }
	
    public static function setSchemaName($param = null)
    {
        self::$DTB_SCHEMA = $param;
    }
	
    public static function setTablePrefix($param = null)
    {
        self::$TBL_PREFIX = $param;
    }
	
    public static function setViewPrefix($param = null)
    {
        self::$VIE_PREFIX = $param;
    }
	
    public static function setBannedRedirectLocation($value)
    {
        self::$BANNED_RED_LOC = $value;
    }
	
    // "Get" Methods.

    public static function getDebugMode() { return self::$DEBUG_MODE; }

    public static function getShowFrameworkNotices() { return self::$SHOW_FM_NOTICES; }

    public static function getShowFrameworkErrors() { return self::$SHOW_FM_ERRORS; }

    public static function getShowServerErrors() { return self::$SHOW_SRV_ERRORS; }

    public static function getSchemaName() { return self::$DTB_SCHEMA; }

    public static function getTablePrefix() { return self::$TBL_PREFIX; }

    public static function getViewPrefix() { return self::$VIE_PREFIX; }

    public static function getBannedRedirectLocation() { return self::$BANNED_RED_LOC; }
}

?>