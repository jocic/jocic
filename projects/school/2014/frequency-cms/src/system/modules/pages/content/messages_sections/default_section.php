<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_section.php                           *|
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

$varUsersID = null;

// Create "Core" Elements.

$hdOption   = new FHeader();
$parNotice  = new FParagraph();

// "Users ID" Variable Settings.

$varUsersID = IDFetch::byUsername(Session::getUsername());

// "Header Option" Element Settings.

$hdOption->setLevel(2);
$hdOption->setContent(Locales::getTitle("welcome"));

// "Paragraph Notice" Element Settings.

$parNotice->setID("communication-notice");
$parNotice->setAlignment(FParagraph::ALN_CENTER);

if (Messages::newReceived($varUsersID))
    $parNotice->setContent(Locales::getParagraph("new-messages"));
else
    $parNotice->setContent(Locales::getParagraph("no-new-messages"));

// Append Elements.

$divContent->addElement($hdOption);
$divContent->addElement($parNotice);

?>