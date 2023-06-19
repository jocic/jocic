<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: locales.php                                   *|
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

class Locales
{
    // "Core" Variables.
    
    private static $CORE            = null;
    private static $VARIABLES       = null;
    private static $LINKS           = null;
    private static $TITLES          = null;
    private static $SUBTITLES       = null;
    private static $TEXT            = null;
    private static $PARAGRAPHS      = null;
    private static $NOTICE_LINKS    = null;
    private static $NOTICE_TITLES   = null;
    private static $NOTICE_CONTENT  = null;
    private static $ERROR_LINKS     = null;
    private static $ERROR_TITLES    = null;
    private static $ERROR_CONTENT   = null;
    
    // "Is" Methods.
    
    public static function isLocaleSet()
    {
        return !empty($_SESSION["var_language"]);
    }
    
    // "Set" Methods.
    
    public static function setLocale($languageCode)
    {
        if (self::coreFilesExist($languageCode))
            $_SESSION["var_language"] = $languageCode;
    }
    
    // "Get" Methods.
    
    public static function getLocale()
    {
        if (self::isLocaleSet())
            return $_SESSION["var_language"];
        else
            return "en";
    }
    
    public static function getVariable($codename)
    {
        if (empty(self::$VARIABLES[$codename]))
            return "?";
        else
            return self::$VARIABLES[$codename];
    }
    
    public static function getCore($codename)
    {
        if (empty(self::$CORE[$codename]))
            return "?";
        else
            return self::$CORE[$codename];
    }
    
    public static function getLink($codename)
    {
        if (empty(self::$LINKS[$codename]))
            return "?";
        else
            return self::$LINKS[$codename];
    }
    
    public static function getTitle($codename)
    {
        if (empty(self::$TITLES[$codename]))
            return "?";
        else
            return self::$TITLES[$codename];
    }
    
    public static function getSubtitle($codename)
    {
        if (empty(self::$SUBTITLES[$codename]))
            return "?";
        else
            return self::$SUBTITLES[$codename];
    }
    
    public static function getText($codename)
    {
        if (empty(self::$TEXT[$codename]))
            return "?";
        else
            return self::$TEXT[$codename];
    }
    
    public static function getParagraph($codename)
    {
        if (empty(self::$PARAGRAPHS[$codename]))
            return "?";
        else
            return self::$PARAGRAPHS[$codename];
    }
    
    public static function getNoticeLink($codename)
    {
        if (empty(self::$NOTICE_LINKS[$codename]))
            return "?";
        else
            return self::$NOTICE_LINKS[$codename];
    }
    
    public static function getNoticeTitle($codename)
    {
        if (empty(self::$NOTICE_TITLES[$codename]))
            return "?";
        else
            return self::$NOTICE_TITLES[$codename];
    }
    
    public static function getNoticeContent($codename)
    {
        if (empty(self::$NOTICE_CONTENT[$codename]))
            return "?";
        else
            return self::$NOTICE_CONTENT[$codename];
    }
    
    public static function getErrorLink($codename)
    {
        if (empty(self::$ERROR_LINKS[$codename]))
            return "?";
        else
            return self::$ERROR_LINKS[$codename];
    }
    
    public static function getErrorTitle($codename)
    {
        if (empty(self::$ERROR_TITLES[$codename]))
            return "?";
        else
            return self::$ERROR_TITLES[$codename];
    }
    
    public static function getErrorContent($codename)
    {
        if (empty(self::$ERROR_CONTENT[$codename]))
            return "?";
        else
            return self::$ERROR_CONTENT[$codename];
    }
    
    // "Other" Methods.
    
    public static function coreFilesExist($lc)
    {
        return file_exists(DOC_ROOT . "/system/locales/$lc/core_locales.php") &&
               file_exists(DOC_ROOT . "/system/locales/$lc/notice_locales.php") &&
               file_exists(DOC_ROOT . "/system/locales/$lc/error_locales.php");
    }
    
    public static function coreLocalesExist($lc)
    {
        return file_exists(DOC_ROOT . "/system/locales/$lc/core_locales.php");
    }
    
    public static function noticeLocalesExist($lc)
    {
        return file_exists(DOC_ROOT . "/system/locales/$lc/notice_locales.php");
    }
    
    public static function errorLocalesExist($lc)
    {
        return file_exists(DOC_ROOT . "/system/locales/$lc/error_locales.php");
    }
    
    // "Main" Methods.
    
    public static function loadFiles()
    {
        $lc = strtolower(self::getLocale());
        
        if ($lc == null)
            $lc = "en";
        
        // Include Core Files.
            
        if (self::coreLocalesExist($lc))
            require_once DOC_ROOT . "/system/locales/$lc/core_locales.php";
        
        if (self::noticeLocalesExist($lc))
            require_once DOC_ROOT . "/system/locales/$lc/notice_locales.php";
        
        if (self::errorLocalesExist($lc))
            require_once DOC_ROOT . "/system/locales/$lc/error_locales.php";
            
        // Initialize Core Variables.

        if (!empty($LCL_VARIABLES))
            self::$VARIABLES = $LCL_VARIABLES;

        if (!empty($LCL_CORE))
            self::$CORE  = $LCL_CORE;

        if (!empty($LCL_LINKS))
            self::$LINKS = $LCL_LINKS;

        if (!empty($LCL_TITLES))
            self::$TITLES = $LCL_TITLES;

        if (!empty($LCL_SUBTITLES))
            self::$SUBTITLES = $LCL_SUBTITLES;
        
        if (!empty($LCL_TEXT))
            self::$TEXT = $LCL_TEXT;

        if (!empty($LCL_PARAGRAPHS))
            self::$PARAGRAPHS = $LCL_PARAGRAPHS;

        // Initialize Notice Variables.

        if (!empty($LCL_NOTICE_LINKS))
            self::$NOTICE_LINKS = $LCL_NOTICE_LINKS;

        if (!empty($LCL_NOTICE_TITLES))
            self::$NOTICE_TITLES = $LCL_NOTICE_TITLES;

        if (!empty($LCL_NOTICE_CONTENT))
            self::$NOTICE_CONTENT = $LCL_NOTICE_CONTENT;

        // Initialize Error Variables.

        if (!empty($LCL_ERROR_LINKS))
            self::$ERROR_LINKS = $LCL_ERROR_LINKS;

        if (!empty($LCL_ERROR_TITLES))
            self::$ERROR_TITLES = $LCL_ERROR_TITLES;

        if (!empty($LCL_ERROR_CONTENT))
            self::$ERROR_CONTENT = $LCL_ERROR_CONTENT;
    }
}

?>