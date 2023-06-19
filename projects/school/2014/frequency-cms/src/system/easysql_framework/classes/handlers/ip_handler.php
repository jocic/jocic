<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: ip_handler.php                                *|
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

class IPHandler
{
    // "Main" Methods.

    public function checkIP()
    {
        $logTable = new EasyTable("sql_inj_logs");

        if ($logTable->exists())
        {
            $ip = $_SERVER["REMOTE_ADDR"];

            EasyGet::setParameters
            (
                new ColumnSelection("id"),
                new TableSelection($logTable->getName()),
                new ArgumentSelection(new Argument("ip_address", "=", $ip))
            );

            if (EasyGet::execute() != null) // If the attack was attempted.
            {
                if (EasyCore::getBannedRedirectLocation() != null)
                    exit(header("location: " . EasyCore::getBannedRedirectLocation()));
                else
                    exit("<p>Your IP Address was banned. Sorry.</p>");
            }
        }
}
}

?>