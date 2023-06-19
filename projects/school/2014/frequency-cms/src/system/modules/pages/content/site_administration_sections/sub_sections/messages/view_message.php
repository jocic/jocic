<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: view_message.php                              *|
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

$varMessage      = Messages::fetchMessageByID($_GET[Locales::getVariable("id")]);
$varFrom         = InfoFetch::fetchUsername($varMessage[0]["sender_id"]);
$varTo           = InfoFetch::fetchUsername($varMessage[0]["receiver_id"]);
$varStatus       = null;

// Create "Core" Elements.

$hdMessage       = new FHeader();
$tblMessageInfo  = new FTable();

// Create "Row" Elements.

$rowFrom         = new FTableRow();
$rowTo           = new FTableRow();
$rowTitle        = new FTableRow();
$rowContentTitle = new FTableRow();
$rowContent      = new FTableRow();
$rowStatus       = new FTableRow();

// "Messages" Variable Settings.

$varMessage[0]["content"] = str_replace("\r\n", " ", $varMessage[0]["content"]);

if ($varMessage[0]["read_status"] == 0)
    $varMessage[0]["read_status"] = Locales::getCore("unread");
else
    $varMessage[0]["read_status"] = Locales::getCore("read");

if ($varMessage[0]["status"] == 0)
    $varMessage[0]["status"] = Locales::getCore("normal");
else if ($varMessage[0]["status"] == 1)
    $varMessage[0]["status"] = Locales::getCore("archived");
else
    $varMessage[0]["status"] = Locales::getCore("deleted");

// "Status" Variable Settings.

$varStatus = $varMessage[0]["read_status"] . ", " . $varMessage[0]["status"];

// "View Message" Element Settings.

$hdMessage->setLevel(2);
$hdMessage->setContent(Locales::getTitle("view-message"));

// "Info Table" Element Settings.

$tblMessageInfo->setID("view-message-table");
$tblMessageInfo->setClass("default-table");
$tblMessageInfo->setAlignment(FTable::ALN_CENTER);

$tblMessageInfo->addRow($rowFrom);
$tblMessageInfo->addRow($rowTo);
$tblMessageInfo->addRow($rowTitle);
$tblMessageInfo->addRow($rowContentTitle);
$tblMessageInfo->addRow($rowContent);
$tblMessageInfo->addRow($rowStatus);

// "Row From" Element Settings.

$rowFrom->addCell(new FTableCell(null, "row-title", "<strong>" . Locales::getCore("from") . ":</strong>"));
$rowFrom->addCell(new FTableCell(null, null, $varFrom));

// "Row To" Element Settings.

$rowTo->addCell(new FTableCell(null, "row-title", "<strong>" . Locales::getCore("to") . ":</strong>"));
$rowTo->addCell(new FTableCell(null, null, $varTo));

// "Row Title" Element Settings.

$rowTitle->addCell(new FTableCell(null, "row-title", "<strong>" . Locales::getCore("title") . ":</strong>"));
$rowTitle->addCell(new FTableCell(null, null, $varMessage[0]["title"]));

// "Row Content Title" Element Settings.

$rowContentTitle->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("content") . "</strong>", 2));

// "Row Content" Element Settings.

$rowContent->addCell(new FTableCell(null, null, $varMessage[0]["content"], 2));

// "Row Status" Element Settings.

$rowStatus->addCell(new FTableCell(null, "row-title", "<strong>" . Locales::getCore("status") . ":</strong>"));
$rowStatus->addCell(new FTableCell(null, null, $varStatus));

// Append Elements To "Workplace".

$divWorkplace->addElement($hdMessage);
$divWorkplace->addElement($tblMessageInfo);

?>