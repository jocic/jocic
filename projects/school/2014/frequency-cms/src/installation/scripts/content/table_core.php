<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_core.php                                *|
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

// Row "System Version".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("system_version", "Beta Build 4"))
);

// Row "Base".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection("base", $_SERVER["HTTP_HOST"])
);

// Row "Charset".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection("charset", "utf-8")
);

// Row "Keywords".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("keywords", "frequency, free, open source, cms, dynamic portal, content management, digital publishing, open source, agpl, security, community"))
);

// Row "Description".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("description", "Frequency CMS is an open-source software solution for fast and easy dynamic web-site and portal developing."))
);

// Row "Title".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("title", "frequencyCMS"))
);

// Row "Title Sufix".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("title_sufix", ":: Free And Open Source CMS :: frequency-cms.com"))
);

// Row "Email".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("email", "/"))
);

// Row "Selected Theme".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("selected_theme", "blue_frequency"))
);

// Row "Security Logging".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("security_logging", "no"))
);

// Row "Deploy CAPTCHA".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("deploy_captcha", "yes"))
);

// Row "Registration Mode".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("registration_mode", "minimal"))
);

// Row "Registration Mode".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("social_integration", "no"))
);

// Row "Show Latest Pages".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("show_latest_pages", "yes"))
);

// Row "Password Salt".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("password_salt", $varPasswordSalt))
);

// Row "Verification Salt".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("verification_salt", $varVerifSalt))
);

// Row "Token Salt".

EasyInsert::execute
(
    new TableSelection("core"),
    new ColumnSelection("name", "content"),
    new ValueSelection(array("token_salt", $varTokenSalt))
);

?>