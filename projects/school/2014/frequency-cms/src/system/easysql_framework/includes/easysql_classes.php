<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easysql_classes.php                           *|
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

// "Core Class" Includes.

require_once SQL_ROOT . "/classes/easy_config.php";

// "Default Class" Includes.

require_once SQL_ROOT . "/classes/default/anti_hack_system.php";
require_once SQL_ROOT . "/classes/default/integrity_variable.php";
require_once SQL_ROOT . "/classes/default/filtered_variable.php";

// "Builders Class" Includes.

require_once SQL_ROOT . "/classes/builders/structure_query_builder.php";
require_once SQL_ROOT . "/classes/builders/data_query_builder.php";

// "Processors Class" Includes.

require_once SQL_ROOT . "/classes/processors/column_processor.php";
require_once SQL_ROOT . "/classes/processors/table_processor.php";
require_once SQL_ROOT . "/classes/processors/value_processor.php";
require_once SQL_ROOT . "/classes/processors/argument_processor.php";

// "Handlers Class" Includes.

require_once SQL_ROOT . "/classes/handlers/ip_handler.php";
require_once SQL_ROOT . "/classes/handlers/function_handler.php";
require_once SQL_ROOT . "/classes/handlers/value_handler.php";

// "Informers Class" Includes.

require_once SQL_ROOT . "/classes/informers/notice.php";
require_once SQL_ROOT . "/classes/informers/error.php";
require_once SQL_ROOT . "/classes/informers/debug_info.php";

?>