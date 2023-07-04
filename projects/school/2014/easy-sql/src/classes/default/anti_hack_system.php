<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: anti_hack_system.php                          *|
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

class AntiHackSystem
{
    // "Core" Variables.

    private $illegalValues = array
    (
        "--",
        "#",
        "\/\*",
        "\*\/",
        "\({",
        ";",
        "SELECT",
        "INSERT",
        "UPDATE",
        "DELETE",
        "DROP",
        "TO",
        "UNION"
    );
							
    private $rl = null;

    // "Set" Methods.

    public function setRedirectLocation($param = null)
    {
            $this->rl = $param;
    }
	
    // "Get" Methods.

    public function getRedirectLocation()
    {
            return $this->rl;
    }
	
    // "Is" Methods.

    private function isAbnormal($param = null)
    {
        foreach ($this->illegalValues as $value)
        {
            if (preg_match("/$value/i", $param))
                return true;
        }

        return false;
    }

    // "Main" Methods.

    public function anlyzeVariable($param = null)
    {
        if ($param != null)
        {
            if ($this->isAbnormal($param))
            {
                $info = "Data: " . @mysql_real_escape_string($param);

                $this->logAttempt($info);

                if ($this->rl != null)
                    exit(header("location: " . $this->rl));
            }
        }
    }
	
    private function checkTables()
    {
        // Previous Settings.

        $prevMode      = EasyCreate::getMode();
        $prevEngine    = EasyCreate::getEngine();
        $prevCharSet   = EasyCreate::getDefaultCharacterSet();
        $prevCollation = EasyCreate::getDefaultCollation();

        // Table Settings.

        EasyCreate::setMode(EasyCreate::ECM_DO_NOTHING_IF_EXISTS);

        EasyCreate::setEngine("InnoDB");
        EasyCreate::setDefaultCharacterSet("utf8");
        EasyCreate::setDefaultCollation("utf8_general_ci");

        // Table Structure.

        $logTable = new EasyTable("sql_inj_logs");

        $column_1 = new EasyColumn
        (
            ColumnName::useName("id"),
            ColumnType::useInt(11),
            ColumnNull::notAllowed(),
            ColumnValue::useAutoIncrementValue()
        );

        $column_2 = new EasyColumn
        (
            ColumnName::useName("timestamp"),
            ColumnType::useTimestamp(),
            ColumnNull::notAllowed(),
            ColumnValue::useValue("CURRENT_TIMESTAMP")
        );

        $column_3 = new EasyColumn
        (
            ColumnName::useName("ip_address"),
            ColumnType::useVarChar(100),
            ColumnNull::notAllowed()
        );

        $column_4 = new EasyColumn
        (
            ColumnName::useName("info"),
            ColumnType::useText(),
            ColumnNull::notAllowed()
        );

        $logTable->addColumn($column_1);
        $logTable->addColumn($column_2);
        $logTable->addColumn($column_3);
        $logTable->addColumn($column_4);

        $logTable->addPrimaryKey(new EasyPrimaryKey("id"));

        // Create Table.

        EasyCreate::execute($logTable);

        // Revert Settings.

        EasyCreate::setMode($prevMode);
        EasyCreate::setEngine($prevEngine);
        EasyCreate::setDefaultCharacterSet($prevCharSet);
        EasyCreate::setDefaultCollation($prevCollation);
    }
	
    private function logAttempt($info)
    {
        if (EasyConnection::established())
        {
            $this->checkTables();

            EasyInsert::execute
            (
                new TableSelection("sql_inj_logs"),
                new ColumnSelection("ip_address", "info"),
                new ValueSelection($_SERVER["REMOTE_ADDR"], $info)
            );
        }
        else
            new Notice("AntiHackSystem", "You are not connected to the MySQL server. AHS couldn't perform a log.");
    }
}

?>