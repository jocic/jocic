<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: processor_step_3.php                          *|
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

$varPassed = true;

if (!empty($_POST))
{
    // Create "Core" Variables.

    $varRootFile    = "./../system/easysql_framework/classes/easy_config.php";
    $varTempFile    = "./assets/text/easy_config.txt";
    $varData        = null;
    $varHostname    = null;
    $varUsername    = null;
    $varPassword    = null;
    $varName        = null;
    $varTablePrefix = null;
    $varViewPrefix  = null;
    
    // "Hostname" Variable Settings.

    if (isset($_POST["req_hostname"]))
        $varHostname = trim($_POST["req_hostname"]);
    
    // "Username" Variable Settings.
    
    if (isset($_POST["req_username"]))
        $varUsername = trim($_POST["req_username"]);
    
    // "Password" Variable Settings.
    
    if (isset($_POST["req_password"]))
        $varPassword = trim($_POST["req_password"]);
    
    // "Name" Variable Settings.
    
    if (isset($_POST["req_name"]))
        $varName = trim($_POST["req_name"]);
    
    // "Table Prefix" Variable Settings.
    
    if (isset($_POST["req_table_prefix"]))
        $varTablePrefix = trim($_POST["req_table_prefix"]);
    
    // "View Prefix" Variable Settings.
    
    if (isset($_POST["req_view_prefix"]))
        $varTablePrefix = trim($_POST["req_view_prefix"]);
    
    // Include "EasySQL Framework" Core Files.
    
    require_once("./../system/easysql_framework/easysql_core_files.php");

    // Custom DBConfig.

    $dbConfig = new DBConfig();

    $dbConfig->setHostname($varHostname);
    $dbConfig->setUsername($varUsername);
    $dbConfig->setPassword($varPassword);
    $dbConfig->setSchemaName($varName);
    $dbConfig->setTablePrefix($varTablePrefix);
    $dbConfig->setViewPrefix($varViewPrefix);
    
    // Check The Connection.

    EasyConnection::start($dbConfig);
    
    if (EasyConnection::active())
    {
        EasyConnection::stop();
        
        // Perform The File Setup.
        
        if (file_exists($varRootFile) && is_writable($varRootFile)) // Check The File.
        {
            if ($varData = file_get_contents($varTempFile))
            {   
                $varData = str_replace("{hostname}", "private \$host       = \"$varHostname\";", $varData);
                $varData = str_replace("{username}", "private \$username   = \"$varUsername\";", $varData);
                $varData = str_replace("{password}", "private \$password   = \"$varPassword\";", $varData);
                $varData = str_replace("{table_schema}", "private \$dbSchema   = \"$varName\";", $varData);
                $varData = str_replace("{table_prefix}", "private \$tblPrefix  = \"$varTablePrefix\";", $varData);
                $varData = str_replace("{view_prefix}", "private \$viewPrefix = \"$varViewPrefix\";", $varData);

                if (file_put_contents("./../system/easysql_framework/classes/easy_config.php", $varData))
                    exit(header("location: step-4.php"));
                else
                    $varPassed = false;
            }
            else
                $varPassed = false;
        }
        else
            $varPassed = false;
    }
    else
        $varPassed = false;
}

?>