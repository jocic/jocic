<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: finish.php                                    *|
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

// Define "Core" Constants.

define("IND_ACCESS", true);

// Create "Core" Variables.

$varFilesAndFolders = array
(
    "./assets/images/index.php",
    "./assets/images/fatcow.png",
    "./assets/images/lol.png",
    "./assets/images/flags/index.php",
    "./assets/images/flags/de.png",
    "./assets/images/flags/de_hov.png",
    "./assets/images/flags/en.png",
    "./assets/images/flags/en_hov.png",
    "./assets/images/flags/gr.png",
    "./assets/images/flags/gr_hov.png",
    "./assets/images/flags/it.png",
    "./assets/images/flags/it_hov.png",
    "./assets/images/flags/rs.png",
    "./assets/images/flags/rs_hov.png",
    "./assets/images/flags/ru.png",
    "./assets/images/flags/ru_hov.png",
    "./assets/text/index.php",
    "./assets/text/custom_css.txt",
    "./assets/text/easy_config.txt",
    "./assets/text/junk_latin_full.txt",
    "./assets/text/junk_latin_part.txt",
    "./assets/index.php",
    "./assets/theme.css",
    "./locales/index.php",
    "./locales/en_locales.php",
    "./locales/rs_locales.php",
    "./locales/de_locales.php",
    "./locales/it_locales.php",
    "./locales/ru_locales.php",
    "./locales/gr_locales.php",
    "./scripts/content/index.php",
    "./scripts/content/table_ads.php",
    "./scripts/content/table_assets.php",
    "./scripts/content/table_core.php",
    "./scripts/content/table_core_pages.php",
    "./scripts/content/table_menu_items.php",
    "./scripts/content/table_menus.php",
    "./scripts/content/table_modules.php",
    "./scripts/content/table_pages.php",
    "./scripts/content/table_statistics.php",
    "./scripts/content/table_styles.php",
    "./scripts/content/user_related_tables.php",
    "./scripts/processors/index.php",
    "./scripts/processors/processor_step_3.php",
    "./scripts/processors/processor_step_4.php",
    "./scripts/tables/index.php",
    "./scripts/tables/table_ads.php",
    "./scripts/tables/table_assets.php",
    "./scripts/tables/table_blogs.php",
    "./scripts/tables/table_core.php",
    "./scripts/tables/table_core_pages.php",
    "./scripts/tables/table_logs.php",
    "./scripts/tables/table_menu_items.php",
    "./scripts/tables/table_menus.php",
    "./scripts/tables/table_messages.php",
    "./scripts/tables/table_modules.php",
    "./scripts/tables/table_page_comments.php",
    "./scripts/tables/table_pages.php",
    "./scripts/tables/table_sessions.php",
    "./scripts/tables/table_shoutbox.php",
    "./scripts/tables/table_statistics.php",
    "./scripts/tables/table_styles.php",
    "./scripts/tables/table_user_info.php",
    "./scripts/tables/table_user_personals.php",
    "./scripts/tables/table_users.php",
    "./scripts/index.php",
    "./index.php",
    "./step-2.php",
    "./step-3.php",
    "./step-4.php",
    "./assets/images/flags/",
    "./assets/images/",
    "./assets/text/",
    "./assets/",
    "./locales/",
    "./scripts/content/",
    "./scripts/processors/",
    "./scripts/tables/",
    "./scripts/",
    "./finish.php",
    "./"
);

$varRoot = str_replace("installation/finish.php", "", $_SERVER["PHP_SELF"]);

// Delete Files And Folders.

foreach($varFilesAndFolders as $location)
{
    if (is_file($location) && is_writable($location))
        unlink($location);
    else if (is_dir($location) && is_writable($location))
        rmdir($location);
}

// Reset Session Variable "Step".

$_SESSION["step"] = 1;

// Reset Session "CMS Variables".

$_SESSION["cms_password"]          = 0;
$_SESSION["cms_password_salt"]     = 0;
$_SESSION["cms_verification_salt"] = 0;
$_SESSION["cms_created"]           = 0;

// Reddirect To "Home Page".

exit(header("location: " . $varRoot));

?>