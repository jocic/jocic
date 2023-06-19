<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: activate_account.php                          *|
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

/*****************\
| DIRECTOR STARTS |
\*****************/

$pnv = Locales::getVariable("page"); // Fetch "Page Name Variable".
$env = Locales::getVariable("error"); // Fetch "Error Name Variable".
$nnv = Locales::getVariable("notice"); // Fetch "Notice Name Variable".

// Check "Error" And "Notice" Variables.

$errorExist  = !empty($_GET[$env]);
$noticeExist = !empty($_GET[$nnv]);

if ($errorExist)
    require_once $this->getLocation() . "/core/errors.php";
else if ($noticeExist)
    require_once $this->getLocation() . "/core/notices.php";

?>