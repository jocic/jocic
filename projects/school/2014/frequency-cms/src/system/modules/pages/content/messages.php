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

// Set Blank Prefix.

Build::setBlankPrefix($this->getBlankPrefix());

// Create "Core" Variables.

$varLinkPreifx = null;
$varScriptRoot = null;

// Create "Core" Elements.

$hdMessages    = new FHeader();
$lstOptions    = new FList();
$divContainer  = new FDiv();
$divContent    = new FDiv();
$tblMessages   = new FTable();

// "Link Prefix" Variable Settings.

$varLinkPreifx = "./?" .
                 Locales::getVariable("page") .
                 "=" .
                 Locales::getLink("messages") .
                 "&" .
                 Locales::getVariable("option") .
                 "=";

// "Script Root" Variable Settings.

$varScriptRoot = DOC_ROOT .
                 DIRECTORY_SEPARATOR .
                 "system" .
                 DIRECTORY_SEPARATOR .
                 "modules" .
                 DIRECTORY_SEPARATOR .
                 "pages" .
                 DIRECTORY_SEPARATOR .
                 "content" .
                 DIRECTORY_SEPARATOR .
                 "messages_sections" .
                 DIRECTORY_SEPARATOR;

// "Header Messages" Element Settings.

$hdMessages->setLevel(1);
$hdMessages->setContent(Locales::getTitle("messages"));

// "List Options" Element Settings.

$lstOptions->setID("communication-options");
$lstOptions->setType(FList::TP_UL);
$lstOptions->setAlignment(FList::ALN_CENTER);

$lstOptions->addItem(new FListItem(null, null, new FAnchor("compose-icon", null, $varLinkPreifx . Locales::getLink("compose"), null, Locales::getCore("compose"))));
$lstOptions->addItem(new FListItem(null, null, new FAnchor("inbox-icon", null, $varLinkPreifx . Locales::getLink("inbox"), null, Locales::getCore("inbox"))));
$lstOptions->addItem(new FListItem(null, null, new FAnchor("sent-icon", null, $varLinkPreifx . Locales::getLink("sent"), null, Locales::getCore("sent"))));
$lstOptions->addItem(new FListItem(null, null, new FAnchor("archive-icon", null, $varLinkPreifx . Locales::getLink("archive"), null, Locales::getCore("archive"))));
$lstOptions->addItem(new FListItem(null, null, new FAnchor("thrash-icon", null, $varLinkPreifx . Locales::getLink("deleted"), null, Locales::getCore("deleted"))));

// "Div Container" Element Settings.

$divContainer->setID("communication-container");

$divContainer->addElement($divContent);

// "Div Content" Element Settings.

$divContent->setID("communication-content");

if (empty($_GET[Locales::getVariable("option")])) // No Option Was Selected.
    require_once($varScriptRoot . "default_section.php");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("compose")) // Compose Selected.
    require_once($varScriptRoot . "compose_message.php");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("inbox")) // Inbox Selected.
    require_once($varScriptRoot . "inbox_messages.php");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("sent")) // Sent Selected.
    require_once($varScriptRoot . "sent_messages.php");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("archive")) // Archive Selected.
    require_once($varScriptRoot . "archive_messages.php");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("deleted")) // Deleted Selected.
    require_once($varScriptRoot . "deleted_messages.php");
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-message") ||
         $_GET[Locales::getVariable("option")] == Locales::getLink("view-sent-message") ||
         $_GET[Locales::getVariable("option")] == Locales::getLink("view-archived-message") ||
         $_GET[Locales::getVariable("option")] == Locales::getLink("view-deleted-message")) // View Selected.
    require_once($varScriptRoot . "view_message.php");
    
// "Table Messages" Element Settings.

$tblMessages->setID("message-table");
$tblMessages->setAlignment(FTable::ALN_CENTER);

// Build Elements.

Build::element($hdMessages);
Build::element($lstOptions);
Build::element($divContainer);
Build::element(new FDiv(null, "clr", null));

?>