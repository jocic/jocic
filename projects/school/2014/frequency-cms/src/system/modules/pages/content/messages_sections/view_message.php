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

$varUsersID      = null;
$varMessageID    = null;
$varTitleSufix   = null;
$varMessage      = null;
$varDateSent     = null;
$varLinkArchive  = null;
$varLinkDelete   = null;
$varLinkRestore  = null;

// Create "Main" Variables.

$hdOption        = new FHeader();
$parTitle        = new FParagraph();
$parFrom         = new FParagraph();
$parDateSent     = new FParagraph();
$parContentTitle = new FParagraph();
$parContent      = new FParagraph();
$parLinks        = new FParagraph();

// "Users ID" Variable Settings.

$varUsersID = IDFetch::byUsername(Session::getUsername());

// "Message ID" Variable Settings.

$varMessageID = $_GET[Locales::getVariable("id")];

// "Title Sufix & Message" Variable Settings.

if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-message"))
{
    $varMessage    = Messages::fetchUsersInboxMessage($varMessageID, $varUsersID);
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-sent-message"))
{
    $varTitleSufix = " - " . Locales::getCore("sent");
    
    $varMessage    = Messages::fetchUsersSentMessage($varMessageID, $varUsersID);
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-archived-message"))
{
    $varTitleSufix = " - " . Locales::getCore("archived");
    
    $varMessage    = Messages::fetchUsersArchivedMessage($varMessageID, $varUsersID);
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-deleted-message"))
{
    $varTitleSufix = " - " . Locales::getCore("deleted");
    
    $varMessage    = Messages::fetchUsersDeletedMessage($varMessageID, $varUsersID);
}
else
{
    exit();
}

// "Date Sent" Variable Settings.

$varDateSent = new Date();

$varDateSent = $varDateSent->convertSQLDate($varMessage["date_sent"]);

// "Link Archive" Variable Settings.

$varLinkArchive = $varLinkPreifx . Locales::getLink("archive-message") . "&" . Locales::getVariable("id") . "=" . $varMessageID;

// "Link Delete" Variable Settings.

$varLinkDelete  = $varLinkPreifx . Locales::getLink("delete-message") . "&" . Locales::getVariable("id") . "=" . $varMessageID;

// "Link Restore" Variable Settings.

$varLinkRestore = $varLinkPreifx . Locales::getLink("restore-message") . "&" . Locales::getVariable("id") . "=" . $varMessageID;

// "Header Option" Element Settings.

$hdOption->setLevel(2);
$hdOption->setContent(Locales::getTitle("view-message") . $varTitleSufix);

// "Paragraph Title" Element Settings.

$parTitle->setClass("message-info");
$parTitle->setContent("<strong>" . Locales::getCore("title") . ":</strong> " . $varMessage["title"]);

// "Paragraph From" Element Settings.

$parFrom->setClass("message-info");
$parFrom->setContent("<strong>" . Locales::getCore("from") . ":</strong> " . InfoFetch::fetchUsername($varMessage["sender_id"]));

// "Paragraph Date Sent" Element Settings.

$parDateSent->setClass("message-info");
$parDateSent->setContent("<strong>" . Locales::getCore("date-sent") . ":</strong> " . $varDateSent);

// "Paragraph Content Title" Element Settings.

$parContentTitle->setClass("message-info");
$parContentTitle->setContent("<strong>" . Locales::getCore("content") . ":</strong>" );

// "Paragraph Content" Element Settings.

$parContent->setClass("message-info");
$parContent->setContent($varMessage["content"]);

// "Paragraph Links" Element Settings.

$parLinks->setClass("message-info");

if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-message"))
    $parLinks->setContent("<strong>" . Locales::getCore("options") . ":</strong> <a href=\"$varLinkArchive\">" . Locales::getCore("archive") . "</a> | <a href=\"$varLinkDelete\">" . Locales::getCore("delete") . "</a>");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-archived-message") || $_GET[Locales::getVariable("option")] == Locales::getLink("view-deleted-message"))
    $parLinks->setContent("<strong>" . Locales::getCore("options") . ":</strong> <a href=\"$varLinkRestore\">" . Locales::getCore("restore") . "</a>");

// Append Elements.

$divContent->addElement($hdOption);
$divContent->addElement($parTitle);
$divContent->addElement($parFrom);
$divContent->addElement($parDateSent);
$divContent->addElement($parContentTitle);
$divContent->addElement($parContent);

if ($parLinks->getContent() != null)
    $divContent->addElement($parLinks);
        
// Change Read Status.

Messages::changeReadStatus($varMessageID);

?>