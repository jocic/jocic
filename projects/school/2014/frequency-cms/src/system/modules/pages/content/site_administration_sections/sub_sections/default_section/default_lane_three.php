<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_lane_three.php                        *|
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

$varLatestLogs   = Logs::getLatestLogs(7);

// Create "Core" Elements.

$divSystemUpdate = new FDiv();
$parInfo         = new FParagraph();
$divIconHolder   = new FDiv();
$divIcon         = new FDiv();
$parVersion      = new FParagraph();
$divLatestLogs   = new FDiv();

// "Div System Update" Element Settings.

if (empty($varSystemVersion))
    $divSystemUpdate->setID("system-info-unavailable");
else
    $divSystemUpdate->setID("system-info-available");

$divSystemUpdate->setClass("lane-item");

$divSystemUpdate->addElement($parInfo);
$divSystemUpdate->addElement($divIconHolder);
$divSystemUpdate->addElement($parVersion);

// "Paragraph Info" Element Settings.

$parInfo->setID("update-info");

if (empty($varSystemVersion))
{
    $parInfo->setClass("unavailable-info");
    $parInfo->setContent(Locales::getParagraph("info-not-available"));
}
else
{
    $parInfo->setClass("available-info");
    
    if ($varSystemVersion == Core::get(Core::SYSTEM_VERSION))
        $parInfo->setContent(Locales::getParagraph("system-updated"));
    else
        $parInfo->setContent(Locales::getParagraph("update-available"));
}

// "Div Icon Holder" Element Settings.

if (empty($varSystemVersion))
    $divIconHolder->setID("info-unavailable-icon");
else
    $divIconHolder->setID("info-available-icon");

$divIconHolder->setClass("update-info-icon");

$divIconHolder->addElement($divIcon);

// "Div Icon" Element Settings.

$divIcon->setClass("protector");
$divIcon->setContent(Locales::getCore("update"));

// "Paragraph Version" Element Settings.

$parVersion->setID("version-info");

if (empty($varSystemVersion))
{
    $parVersion->setClass("unavailable-info");
    $parVersion->setContent(Locales::getCore("version") . ": <strong>" . Core::get(Core::SYSTEM_VERSION) . "</strong>");
}
else
{
    $parVersion->setClass("available-info");
    
    if ($varSystemVersion == Core::get(Core::SYSTEM_VERSION))
        $parVersion->setContent(Locales::getCore("system-version") . ": <strong>" . $varSystemVersion . "</strong>");
    else
        $parVersion->setContent(Locales::getCore("available-version") . ": <strong>" . $varSystemVersion . "</strong>");
}

// "Div Latest Logs" Element Settings.

$divLatestLogs->setID("latest-logs");
$divLatestLogs->setClass("lane-item");

$divLatestLogs->addElement(new FDiv("title", null, Locales::getTitle("latest-logs")));

if (empty($varLatestLogs))
    $divLatestLogs->addElement(new FParagraph(Locales::getParagraph("no-security-logs")));
else
{
    foreach ($varLatestLogs as $varLog)
    {
        // Create "Temp" Variables.
        
        $varLogID        = $varLog["id"];
        $varLogCode      = $varLog["code"];
        $varLogInfo      = Locales::getParagraph("log-info-code-" . $varLog["code"]);
        $varLogTimestamp = explode(" ", $varLog["timestamp"]);
        
        // Create "Temp" Elements.
        
        $tempLog         = new FDiv();
        $tempLogInfo     = new FDiv();
        
        // "Temp Log Timestamp" Variable Settings.
        
        $varLogTimestamp = $varLogTimestamp[1];
        
        // "Temp Log" Element Settings.
        
        $tempLog->setClass("latest-log");

        $tempLog->addElement($tempLogInfo);
        $tempLog->addElement(new FDiv(null, "log-content", $varLogInfo));
        
        // "Temp Log Info" Element Settings.
        
        $tempLogInfo->setClass("log-info");
        
        $tempLogInfo->addElement(new FDiv(null, "log-code", "<strong>" . Locales::getCore("code") . ":</strong> " . $varLogCode));
        $tempLogInfo->addElement(new FDiv(null, "log-timestamp", $varLogTimestamp));
        $tempLogInfo->addElement(new FDiv(null, "clr"));
        
        // Add Child Element To Parent Element.
        
        $divLatestLogs->addElement($tempLog);
    }
}

// Append Elements To "Lane Three" Element.

$divLaneThree->addElement($divSystemUpdate);
$divLaneThree->addElement($divLatestLogs);

?>