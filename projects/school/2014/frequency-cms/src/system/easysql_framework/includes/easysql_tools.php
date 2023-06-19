<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easysql_tools.php                             *|
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

// "Core Tools" Includes.

require_once SQL_ROOT . "/tools/default/easy_connection.php";
require_once SQL_ROOT . "/tools/default/easy_core.php";
require_once SQL_ROOT . "/tools/default/easy_query.php";

// "Structure Tools" Includes.

require_once SQL_ROOT . "/tools/structure/easy_create.php";
require_once SQL_ROOT . "/tools/structure/easy_alter.php";
require_once SQL_ROOT . "/tools/structure/easy_drop.php";
require_once SQL_ROOT . "/tools/structure/easy_truncate.php";

// "Data Tools" Includes.

require_once SQL_ROOT . "/tools/data/easy_get.php";
require_once SQL_ROOT . "/tools/data/easy_insert.php";
require_once SQL_ROOT . "/tools/data/easy_update.php";
require_once SQL_ROOT . "/tools/data/easy_delete.php";

// "Privilege Tools" Includes.

require_once SQL_ROOT . "/tools/privilege/easy_user.php";
require_once SQL_ROOT . "/tools/privilege/easy_grant.php";
require_once SQL_ROOT . "/tools/privilege/easy_revoke.php";

?>