<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: index.php                                     *|
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

// Module Starts.

$bp = $this->getBlankPrefix();

echo $bp . "<base href=\"" . Core::get(Core::WEBSITE_BASE) . "\" />\n\n" .
     $bp . "<meta http-equiv=\"content-type\" content=\"text/html; charset=" . Core::get(Core::WEBSITE_CHARSET) . "\" />\n\n" .
     $bp . "<meta name=\"author\" content=\"Đorđe Jocić (Djordje Jocic)\" />\n\n" .
     $bp . "<meta name=\"keywords\" content=\"" . Core::get(Core::WEBSITE_KEYWORDS) . "\" />\n" .
     $bp . "<meta name=\"description\" content=\"" . Core::get(Core::WEBSITE_DESCRIPTION) . "\" />\n" .
     $bp . "<meta name=\"generator\" content=\"Frequency CMS - Open Source Content Management System\" />\n\n" .
     $bp . "<link rel=\"icon\" href=\"../../../../system/assets/images/favicon.ico\" type=\"image/x-icon\" />\n\n" .
     $bp . "<title>" . Core::get(Core::WEBSITE_TITLE) . " " . Core::get(Core::WEBSITE_TITLE_SUFIX) . "</title>\n\n" .
     $bp . "<script src=\"../../../../system/assets/scripts/jquery.js\" type=\"text/javascript\"></script>\n" .
     $bp . "<script src=\"../../../../system/assets/scripts/system_core.js\" type=\"text/javascript\"></script>\n";

?>