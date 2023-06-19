<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: view_shout.php                                *|
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

$varShout        = Shoutbox::fetchPost($_GET[Locales::getVariable("id")]);
$varPoster       = InfoFetch::fetchUsername($varShout[0]["poster_id"]);

// Create "Core" Elements.

$hdShout       = new FHeader();
$tblShoutInfo  = new FTable();

// Create "Row" Elements.

$rowPoster       = new FTableRow();
$rowTimestamp    = new FTableRow();
$rowContent      = new FTableRow();

// "Shout" Variable Settings.

$varShout[0]["content"] = str_replace("\r\n", " ", $varShout[0]["content"]);

$varShout[0]["timestamp"] = str_replace("-", ".", $varShout[0]["timestamp"]);
$varShout[0]["timestamp"] = str_replace(" ", ". - ", $varShout[0]["timestamp"]);

// "Header Shout" Element Settings.

$hdShout->setLevel(2);
$hdShout->setContent(Locales::getTitle("view-shout"));

// "Info Table" Element Settings.

$tblShoutInfo->setID("view-shout-table");
$tblShoutInfo->setClass("default-table");
$tblShoutInfo->setAlignment(FTable::ALN_CENTER);

$tblShoutInfo->addRow($rowPoster);
$tblShoutInfo->addRow($rowTimestamp);
$tblShoutInfo->addRow($rowContent);

// "Row Poster" Element Settings.

$rowPoster->setID("row-poster");

$rowPoster->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("poster") . ":</strong>"));
$rowPoster->addCell(new FTableCell(null, null, $varPoster));

// "Row Timestamp" Element Settings.

$rowTimestamp->setID("row-timestamp");

$rowTimestamp->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("timestamp") . ":</strong>"));
$rowTimestamp->addCell(new FTableCell(null, null, $varShout[0]["timestamp"]));

// "Row Content" Element Settings.

$rowContent->setID("row-content");

$rowContent->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("content") . ":</strong>"));
$rowContent->addCell(new FTableCell(null, null, $varShout[0]["content"]));

// Append Elements To "Workplace".

$divWorkplace->addElement($hdShout);
$divWorkplace->addElement($tblShoutInfo);

?>