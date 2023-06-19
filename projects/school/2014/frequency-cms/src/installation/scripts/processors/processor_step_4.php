<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: processor_step_4.php                          *|
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

// Create "Core" Variables.

$varChars = array
(
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
    'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
    'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z',
    'x', 'c', 'v', 'b', 'n', 'm'
);

$varUsername       = "RootUser";
$varPassword       = null;
$varPasswordSalt   = null;
$varVerifSalt      = null;
$varTokenSalt      = null;
$varSaltedPassword = null;
$varJunkLatinPart  = null;
$varJunkLatinFull  = null;

// "Password" Variable Settings.

if (empty($_SESSION["cms_password"]))
{
    for ($i = 0; $i < 8; $i ++)
        $varPassword .= $varChars[rand(0, (count($varChars) - 1))];
    
    $_SESSION["cms_password"] = $varPassword;
}
else
    $varPassword = $_SESSION["cms_password"];

// "Password Salt" Variable Settings.

if (empty($_SESSION["cms_password_salt"]))
{
    for ($i = 0; $i < rand(50, 200); $i ++)
        $varPasswordSalt .= $varChars[rand(0, (count($varChars) - 1))];

    $varPasswordSalt = sha1($varPasswordSalt);
    
    $_SESSION["cms_password_salt"] = $varPasswordSalt;
}
else
    $varPasswordSalt = $_SESSION["cms_password_salt"];

// "Verification Salt" Variable Settings.

if (empty($_SESSION["cms_verification_salt"]))
{
    for ($i = 0; $i < rand(50, 200); $i ++)
        $varVerifSalt .= $varChars[rand(0, (count($varChars) - 1))];

    $varVerifSalt = sha1($varVerifSalt);
    
    $_SESSION["cms_verification_salt"] = $varVerifSalt;
}
else
    $varVerifSalt = $_SESSION["cms_verification_salt"];

// "Token Salt" Variable Settings.

if (empty($_SESSION["cms_token_salt"]))
{
    for ($i = 0; $i < rand(50, 200); $i ++)
        $varTokenSalt .= $varChars[rand(0, (count($varChars) - 1))];

    $varTokenSalt = sha1($varTokenSalt);
    
    $_SESSION["cms_token_salt"] = $varTokenSalt;
}
else
    $varTokenSalt = $_SESSION["cms_token_salt"];

// If Tables Were Not Created And Filled, Do That.

if (empty($_SESSION["cms_created"]))
{
    // "Altered Password" Variable Settings.

    $varSaltedPassword = sha1($varPassword . " - " . $varPasswordSalt);

    // "Junk Latin Part" Variable Settings.

    $varJunkLatinPart = file_get_contents("./assets/text/junk_latin_part.txt");

    // "Junk Latin Full" Variable Settings.

    $varJunkLatinFull = file_get_contents("./assets/text/junk_latin_full.txt");
    
    // "Custom CSS" Variable Settings.
    
    $varCustomCSS     = file_get_contents("./assets/text/custom_css.txt");

    // Include "EasySQL Framework" Core Files.

    require_once("./../system/easysql_framework/easysql_core_files.php");

    // Recreate The Database Schema If It Exists.

    EasyConnection::start();

    $dbSchema = new EasySchema();

    $dbSchema->setName(EasyCore::getSchemaName());

    if ($dbSchema->exists())
    {
        EasyDrop::execute($dbSchema);

        EasyCreate::execute($dbSchema);

        EasyConnection::stop();

        EasyConnection::start();
    }

    // Generate Tables.

    require_once("./scripts/tables/table_users.php");
    require_once("./scripts/tables/table_user_info.php");
    require_once("./scripts/tables/table_user_personals.php");

    require_once("./scripts/tables/table_ads.php");
    require_once("./scripts/tables/table_assets.php");
    require_once("./scripts/tables/table_blogs.php");
    require_once("./scripts/tables/table_core.php");
    require_once("./scripts/tables/table_core_pages.php");
    require_once("./scripts/tables/table_logs.php");
    require_once("./scripts/tables/table_menus.php");
    require_once("./scripts/tables/table_menu_items.php");
    require_once("./scripts/tables/table_messages.php");
    require_once("./scripts/tables/table_modules.php");
    require_once("./scripts/tables/table_pages.php");
    require_once("./scripts/tables/table_page_comments.php");
    require_once("./scripts/tables/table_sessions.php");
    require_once("./scripts/tables/table_shoutbox.php");
    require_once("./scripts/tables/table_statistics.php");
    require_once("./scripts/tables/table_styles.php");

    // Fill Up The Tables.

    require_once("./scripts/content/user_related_tables.php");

    require_once("./scripts/content/table_ads.php");
    require_once("./scripts/content/table_assets.php");
    require_once("./scripts/content/table_core.php");
    require_once("./scripts/content/table_core_pages.php");
    require_once("./scripts/content/table_menus.php");
    require_once("./scripts/content/table_menu_items.php");
    require_once("./scripts/content/table_modules.php");
    require_once("./scripts/content/table_pages.php");
    require_once("./scripts/content/table_statistics.php");
    require_once("./scripts/content/table_styles.php");
    
    // Set The Session Variable.
    
    $_SESSION["cms_created"] = true;
}

?>