<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: frequency_tools.php                           *|
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

// "Data" Tool Includes.

require_once TOOLS_ROOT . "data" . DIRECTORY_SEPARATOR . "string_check.php";
require_once TOOLS_ROOT . "data" . DIRECTORY_SEPARATOR . "filter.php";

// "Main" Tool Includes.

require_once TOOLS_ROOT . "main" . DIRECTORY_SEPARATOR . "core.php";
require_once TOOLS_ROOT . "main" . DIRECTORY_SEPARATOR . "display.php";
require_once TOOLS_ROOT . "main" . DIRECTORY_SEPARATOR . "captcha.php";

// "Communication" Tool Includes.

require_once TOOLS_ROOT . "communication" . DIRECTORY_SEPARATOR . "messages.php";
require_once TOOLS_ROOT . "communication" . DIRECTORY_SEPARATOR . "shoutbox.php";

// "Content" Tool Includes.

require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "adverts.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "assets.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "core_page.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "page.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "comments.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "menus.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "modules.php";
require_once TOOLS_ROOT . "content" . DIRECTORY_SEPARATOR . "styles.php";

// "User Related" Tool Includes.

require_once TOOLS_ROOT . "user_related" . DIRECTORY_SEPARATOR . "id_fetch.php";
require_once TOOLS_ROOT . "user_related" . DIRECTORY_SEPARATOR . "account.php";
require_once TOOLS_ROOT . "user_related" . DIRECTORY_SEPARATOR . "account_check.php";
require_once TOOLS_ROOT . "user_related" . DIRECTORY_SEPARATOR . "info_fetch.php";
require_once TOOLS_ROOT . "user_related" . DIRECTORY_SEPARATOR . "info_alter.php";
require_once TOOLS_ROOT . "user_related" . DIRECTORY_SEPARATOR . "session.php";

// "Other" Tool Includes.

require_once TOOLS_ROOT . "other" . DIRECTORY_SEPARATOR . "locales.php";
require_once TOOLS_ROOT . "other" . DIRECTORY_SEPARATOR . "build.php";
require_once TOOLS_ROOT . "other" . DIRECTORY_SEPARATOR . "statistics.php";
require_once TOOLS_ROOT . "other" . DIRECTORY_SEPARATOR . "logs.php";

?>