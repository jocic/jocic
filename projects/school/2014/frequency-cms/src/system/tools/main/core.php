<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: core.php                                      *|
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

class Core
{
    // Class Constants.
    
    const SYSTEM_VERSION      = "system_version";
    const WEBSITE_BASE        = "base";
    const WEBSITE_MAIL        = "email";
    const WEBSITE_CHARSET     = "charset";
    const WEBSITE_KEYWORDS    = "keywords";
    const WEBSITE_DESCRIPTION = "description";
    const WEBSITE_TITLE       = "title";
    const WEBSITE_TITLE_SUFIX = "title_sufix";
    const SELECTED_THEME      = "selected_theme";
    const PASSWORD_SALT       = "password_salt";
    const VERIFICATION_SALT   = "verification_salt";
    const TOKEN_SALT          = "token_salt";
    const REGISTRAION_MODE    = "registration_mode";
    const SECURITY_LOGGING    = "security_logging";
    const DEPLOY_CAPTCHA      = "deploy_captcha";
    const SHOW_LATEST_PAGES   = "show_latest_pages";
    const SOCIAL_INTEGRATION  = "social_integration";
    
    // "Get" Methods.
    
    public static function get($identifier)
    {
        $identifier = Filter::forTableNames($identifier);
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: core",
            "CS: content",
            "ARGS: name = $identifier"
        );
        
        return html_entity_decode($data[0][0]);
    }
    
    // "Set" Methods.
    
    public static function set($identifier, $newValue)
    {
        $identifier = Filter::forTableNames($identifier);
        
        $vs = new ValueSelection();
        
        $vs->setOption(ValueSelection::OPT_ENCODE);
        
        $vs->addValue($newValue);
        
        EasyUpdate::execute
        (
            "TS: core",
            "CS: content",
            "VLS: $newValue",
            "ARGS: name = $identifier"
        );
    }
}

?>