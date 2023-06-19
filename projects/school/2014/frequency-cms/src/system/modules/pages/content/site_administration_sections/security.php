<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: security.php                                  *|
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

$varCoreLink         = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("security");
$varLogsPagePrefix   = $varCoreLink . "&" . Locales::getVariable("logs-page") . "=";
$varLogCount         = Logs::getLogCount();
$varPageNumber       = 0;

// Create "Core" Elements.

$hdSecSettings       = new FHeader();
$fmSecSettings       = new FForm();
$tblSecSettings      = new FTable();
$hdSecurityLogs      = new FHeader();
$tblSecurityLogs     = new FTable();
$divLogsNumbers      = new FDiv();
$parNoSecurityLogs   = new FParagraph();

// Create "Row" Elements.

$rowSecurityLogging  = new FTableRow();
$rowDeployCaptcha    = new FTableRow();
$rowSubmit           = new FTableRow();
$rowSecurityLogsInfo = new FTableRow();

// Create "Input" Elements.

$selSecurityLogging  = new FSelect();
$selDeployCaptcha    = new FSelect();
$btnReset            = new FButton();
$btnSubmit           = new FButton();

// "Page Number" Variable Settings.

if (!empty($_GET[Locales::getVariable("logs-page")]))
    $varPageNumber = Filter::forNumeric($_GET[Locales::getVariable("logs-page")] - 1);

// "Header Sec Settings" Element Settings.

$hdSecSettings->setLevel(2);
$hdSecSettings->setContent(Locales::getTitle("security-settings"));

// "Form Sec Settings" Element Settings.

$fmSecSettings->setID("security-settings-form");
$fmSecSettings->setClass("default-form");
$fmSecSettings->setMethod(FForm::MTD_POST);
$fmSecSettings->setAction($varCoreLink);

$fmSecSettings->addItem($tblSecSettings);

// "Table Core Settings" Element Settings.

$tblSecSettings->setID("security-settings-table");
$tblSecSettings->setClass("default-admin-table");

$tblSecSettings->addRow($rowSecurityLogging);
$tblSecSettings->addRow($rowDeployCaptcha);
$tblSecSettings->addRow($rowSubmit);

// "Header Security Logs" Element Settings.

$hdSecurityLogs->setLevel(2);
$hdSecurityLogs->setContent(Locales::getTitle("security-logs"));

// "Table Security Logs" Element Settings.

$tblSecurityLogs->setID("security-logs-table");
$tblSecurityLogs->setClass("default-admin-table");
$tblSecurityLogs->setAlignment(FTable::ALN_CENTER);

$tblSecurityLogs->addRow($rowSecurityLogsInfo);

if ($varLogCount != null)
{
    $varLogs = Logs::getLogs($varPageNumber * 20);
    
    if ($varLogs == null)
        $varLogCount = 0;
    else
    {
        foreach ($varLogs as $varLog)
        {
            // Create "Temp" Elements.

            $varTempRow = new FTableRow();

            // "Temp Row" Element Settings.

            $varTempRow->addCell(new FTableCell(null, "table-cell-code", $varLog["code"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-description", Locales::getParagraph("log-info-code-" . $varLog["code"])));
            $varTempRow->addCell(new FTableCell(null, "table-cell-info", $varLog["info"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-ip", $varLog["ip"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-timestamp", str_replace("-", ".", $varLog["timestamp"])));

            // Append Elements To "Table Menus" Element.

            $tblSecurityLogs->addRow($varTempRow);
        }
    }
}

// "Div Logs Numbers" Element Settings.

$divLogsNumbers->setID("security-logs-numbering");

// "Paragraph No Security Logs" Element Settings.

$parNoSecurityLogs->setClass("info-paragraph");
$parNoSecurityLogs->setAlignment(FParagraph::ALN_CENTER);
$parNoSecurityLogs->setContent(Locales::getParagraph("no-security-logs"));

// "Row Security Logging" Element Settings.

$rowSecurityLogging->setID("security-logging-row");

$rowSecurityLogging->addCell(new FTableCell(null, "table-cell-1", new FLabel("deploy-captcha", Locales::getCore("security-logging"))));
$rowSecurityLogging->addCell(new FTableCell(null, "table-cell-2", $selSecurityLogging));

// "Row Deploy Captcha" Element Settings.

$rowDeployCaptcha->setID("deploy-captcha-row");

$rowDeployCaptcha->addCell(new FTableCell(null, "table-cell-1", new FLabel("deploy-captcha", Locales::getCore("deploy-captcha"))));
$rowDeployCaptcha->addCell(new FTableCell(null, "table-cell-2", $selDeployCaptcha));

// "Row Submit" Element Settings.

$rowSubmit->setID("submit-row");

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));

// "Select Security Logging" Element Settings.

$selSecurityLogging->setClass("form-select");

$tempMode = Core::get(Core::SECURITY_LOGGING);

if ($tempMode == "yes")
    $selSecurityLogging->addOption(new FSelectOption("yes", Locales::getCore("yes"), true));
else
    $selSecurityLogging->addOption(new FSelectOption("yes", Locales::getCore("yes"), false));

if ($tempMode == "no")
    $selSecurityLogging->addOption(new FSelectOption("no", Locales::getCore("no"), true));
else
    $selSecurityLogging->addOption(new FSelectOption("no", Locales::getCore("no"), false));

unset($tempMode);

$selSecurityLogging->setName("req_sec_log");

// "Select Deploy Captcha" Element Settings.

$selDeployCaptcha->setClass("form-select");

$tempMode = Core::get(Core::DEPLOY_CAPTCHA);

if ($tempMode == "yes")
    $selDeployCaptcha->addOption(new FSelectOption("yes", Locales::getCore("yes"), true));
else
    $selDeployCaptcha->addOption(new FSelectOption("yes", Locales::getCore("yes"), false));

if ($tempMode == "no")
    $selDeployCaptcha->addOption(new FSelectOption("no", Locales::getCore("no"), true));
else
    $selDeployCaptcha->addOption(new FSelectOption("no", Locales::getCore("no"), false));

unset($tempMode);

$selDeployCaptcha->setName("req_captcha");

// "Button Reset" Element Settings.

$btnReset->setID("security-settings-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("security-settings-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("apply"));

// "Row Security Logs Info" Element Settings.

$rowSecurityLogsInfo->setID("security-logs-info-row");
$rowSecurityLogsInfo->setClass("info-row");

$rowSecurityLogsInfo->addCell(new FTableCell(null, "table-cell-code", Locales::getCore("code")));
$rowSecurityLogsInfo->addCell(new FTableCell(null, "table-cell-description", Locales::getCore("description")));
$rowSecurityLogsInfo->addCell(new FTableCell(null, "table-cell-info", Locales::getCore("info")));
$rowSecurityLogsInfo->addCell(new FTableCell(null, "table-cell-ip", Locales::getCore("ip-address")));
$rowSecurityLogsInfo->addCell(new FTableCell(null, "table-cell-timestamp", Locales::getCore("timestamp")));

// Append Elements To "Workplace".

$divWorkplace->addElement($hdSecSettings);
$divWorkplace->addElement($fmSecSettings);

if ($varLogCount != null)
{
    $divWorkplace->addElement($hdSecurityLogs);
    
    $divWorkplace->addElement($tblSecurityLogs);
    
    if ($varLogCount > 20)
    {
        $divWorkplace->addElement($divLogsNumbers);
        
        for ($i = 0; $i < ($varLogCount / 20); $i ++)
        {
            if ($i == $varPageNumber)
                $divLogsNumbers->addElement("<strong>" . ($i + 1) . "</strong>");
            else
                $divLogsNumbers->addElement("<a href=\"" . $varLogsPagePrefix . ($i + 1) . "\">" . ($i + 1) . "</a>");
        }
    }
}
else
{
    $divWorkplace->addElement($hdSecurityLogs);
    $divWorkplace->addElement($parNoSecurityLogs);
}

?>