<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: messages.php                                  *|
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

$varCoreLink = CMS_ROOT .
               "?" .
               Locales::getVariable("page") .
               "=" .
               Locales::getLink("site-administration") .
               "&" .
               Locales::getVariable("workplace") .
               "=" .
               Locales::getLink("messages");

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "messages" .
                    DIRECTORY_SEPARATOR;

$varMessages = Messages::fetchAllMessages();

// Create "Core" Elements.

$hdMessages  = new FHeader();
$parInfo     = new FParagraph();
$tblMessages = new FTable();
$rowInfoRow  = new FTableRow();

// "Header Messages" Element Settings.

$hdMessages->setLevel(2);
$hdMessages->setContent(Locales::getTitle("all-messages-sent"));

// "Paragraph Info" Element Settings.

$parInfo->setClass("info-paragraph");
$parInfo->setAlignment(FParagraph::ALN_CENTER);
$parInfo->setContent(Locales::getParagraph("no-messages-sent"));

// "Table Messages" Element Settings.

$tblMessages->setID("user-messages-table");
$tblMessages->setClass("default-admin-table");
$tblMessages->setAlignment(FTable::ALN_CENTER);

$tblMessages->addRow($rowInfoRow);

// Loop Through All Messages.

if ($varMessages != null)
{
    foreach($varMessages as $varMessage)
    {
        // Process "Sender Username".

        $varMessage["sender_id"] = InfoFetch::fetchUsername($varMessage["sender_id"]);

        // Process "Receiver Username".

        $varMessage["receiver_id"] = InfoFetch::fetchUsername($varMessage["receiver_id"]);

        // Process "Read Status".

        if ($varMessage["read_status"] == 0)
            $varMessage["read_status"] = Locales::getCore("unread");
        else
            $varMessage["read_status"] = Locales::getCore("read");

        // Process "Status".

        if ($varMessage["status"] == 0)
            $varMessage["status"] = Locales::getCore("normal");
        else if ($varMessage["status"] == 1)
            $varMessage["status"] = Locales::getCore("archived");
        else
            $varMessage["status"] = Locales::getCore("deleted");

        // Create Link.

        $varViewMessagePrefix = "<a id=\"search-icon\" class=\"options-icon\" title=\"" . Locales::getCore("view-message") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-message") . "&" . Locales::getVariable("id") . "=";
        $varViewMessageSufix  = "\">" . Locales::getCore("view-message") . "</a>";
        
        // Create A Temp Row.

        $tempRow = new FTableRow();

        $tempRow->addCell(new FTableCell(null, null, $varMessage["id"]));
        $tempRow->addCell(new FTableCell(null, null, $varMessage["sender_id"]));
        $tempRow->addCell(new FTableCell(null, null, $varMessage["receiver_id"]));
        $tempRow->addCell(new FTableCell(null, null, $varMessage["date_sent"]));
        $tempRow->addCell(new FTableCell(null, null, $varMessage["title"]));
        $tempRow->addCell(new FTableCell(null, null, $varMessage["read_status"]));
        $tempRow->addCell(new FTableCell(null, null, $varMessage["status"]));
        $tempRow->addCell(new FTableCell(null, null, $varViewMessagePrefix . $varMessage["id"] . $varViewMessageSufix));

        // Add A Temp Row.

        $tblMessages->addRow($tempRow);
    }
}

// "Row Info Row" Element Settings.

$rowInfoRow->setID("messages-info-row");
$rowInfoRow->setClass("info-row");

$rowInfoRow->addCell(new FTableCell(null, "table-cell-1", "#"));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-2", Locales::getCore("from")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-3", Locales::getCore("to")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-4", Locales::getCore("date-sent")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-5", Locales::getCore("title")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-6", Locales::getCore("read")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-7", Locales::getCore("status")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-8", Locales::getCore("options")));

// SPECIFIC PAGE ACTION STARTS HERE.

if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-message")) // Show Profile Information (If Selected).
        require_once $varSubScriptRoot .  "view_message.php";
}

// SPECIFIC PAGE ACTION ENDS HERE.

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdMessages);

if ($varMessages == null)
    $divWorkplace->addElement($parInfo);
else
    $divWorkplace->addElement($tblMessages);

?>