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

$varComment      = Comments::fetchComment($_GET[Locales::getVariable("id")]);
$varPage         = PageInfo::getTitle($varComment[0]["page_id"]);
$varPoster       = InfoFetch::fetchUsername($varComment[0]["sender_id"]);

// Create "Core" Elements.

$hdComment       = new FHeader();
$tblCommentInfo  = new FTable();

// Create "Row" Elements.

$rowPage         = new FTableRow();
$rowPoster       = new FTableRow();
$rowTimestamp    = new FTableRow();
$rowContentTitle = new FTableRow();
$rowContent      = new FTableRow();

// "Comment" Variable Settings.

$varComment[0]["content"] = str_replace("\r\n", " ", $varComment[0]["content"]);

$varComment[0]["timestamp"] = str_replace("-", ".", $varComment[0]["timestamp"]);
$varComment[0]["timestamp"] = str_replace(" ", ". - ", $varComment[0]["timestamp"]);

// "Header Comment" Element Settings.

$hdComment->setLevel(2);
$hdComment->setContent(Locales::getTitle("view-comment"));

// "Info Table" Element Settings.

$tblCommentInfo->setID("view-message-table");
$tblCommentInfo->setClass("default-table");
$tblCommentInfo->setAlignment(FTable::ALN_CENTER);

$tblCommentInfo->addRow($rowPage);
$tblCommentInfo->addRow($rowPoster);
$tblCommentInfo->addRow($rowTimestamp);
$tblCommentInfo->addRow($rowContentTitle);
$tblCommentInfo->addRow($rowContent);

// "Row Page" Element Settings.

$rowPage->addCell(new FTableCell(null, "row-page", "<strong>" . Locales::getCore("page") . ":</strong>"));
$rowPage->addCell(new FTableCell(null, null, $varPage));

// "Row Poster" Element Settings.

$rowPoster->addCell(new FTableCell(null, "row-poster", "<strong>" . Locales::getCore("poster") . ":</strong>"));
$rowPoster->addCell(new FTableCell(null, null, $varPoster));

// "Row Timestamp" Element Settings.

$rowTimestamp->addCell(new FTableCell(null, "row-timestamp", "<strong>" . Locales::getCore("timestamp") . ":</strong>"));
$rowTimestamp->addCell(new FTableCell(null, null, $varComment[0]["timestamp"]));

// "Row Content Title" Element Settings.

$rowContentTitle->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("content") . "</strong>", 2));

// "Row Content" Element Settings.

$rowContent->addCell(new FTableCell(null, null, $varComment[0]["content"], 2));

// Append Elements To "Workplace".

$divWorkplace->addElement($hdComment);
$divWorkplace->addElement($tblCommentInfo);

?>