<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: deleted_messages.php                          *|
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

$varUsersID         = null;
$varDeletedMessages = null;

// Create "Core" Elements.

$hdOption           = new FHeader();
$parNotice          = new FParagraph();
$tblMessages        = new FTable();

// Create "Row" Elements.

$rowInfo            = new FTableRow();

// "Users ID" Variable Settings.

$varUsersID = IDFetch::byUsername(Session::getUsername());

// "Archived Messages" Variable Settings.

$varDeletedMessages = Messages::fetchUsersDeletedMessages($varUsersID);

// "Header Option" Element Settings.

$hdOption->setLevel(2);
$hdOption->setContent(Locales::getTitle("deleted"));

// "Paragraph Notice" Element Settings.

$parNotice->setID("communication-notice");
$parNotice->setAlignment(FParagraph::ALN_CENTER);
$parNotice->setContent(Locales::getParagraph("empty-deleted"));

// "Table Messages" Element Settings.

$tblMessages->setID("message-table");
$tblMessages->setClass("default-table");

$tblMessages->addRow($rowInfo);

if ($varDeletedMessages != null)
{
    for ($i = 0; $i < count($varDeletedMessages); $i ++)
    {
        if ($varDeletedMessages[$i]["read_status"] == 0)
            $varDeletedMessages[$i]["read_status"] = Locales::getCore("unread");
        else
            $varDeletedMessages[$i]["read_status"] = Locales::getCore("read");

        $tempRow = new FTableRow();

        $tempRow->addCell(new FTableCell(null, null, $i + 1));
        $tempRow->addCell(new FTableCell(null, null, $varDeletedMessages[$i]["date_sent"]));
        $tempRow->addCell(new FTableCell(null, null, new FAnchor(null, null, $varLinkPreifx . Locales::getLink("view-deleted-message") . "&" . Locales::getVariable("id") . "=" . $varDeletedMessages[$i]["id"], null, $varDeletedMessages[$i]["title"])));
        $tempRow->addCell(new FTableCell(null, null, $varDeletedMessages[$i]["read_status"]));

        $tblMessages->addRow($tempRow);
    }
}

// "Row Info" Element Settings.

$rowInfo->setClass("info-row");

$rowInfo->addCell(new FTableCell(null, null, "#"));
$rowInfo->addCell(new FTableCell(null, null, Locales::getCore("date-sent")));
$rowInfo->addCell(new FTableCell(null, null, Locales::getCore("title")));
$rowInfo->addCell(new FTableCell(null, null, Locales::getCore("status")));

// Append Elements.

$divContent->addElement($hdOption);

if ($varDeletedMessages == null)
    $divContent->addElement($parNotice);
else
    $divContent->addElement($tblMessages);

?>