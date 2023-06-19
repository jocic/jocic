<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: unknown_page.php                              *|
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

Build::setBlankPrefix($this->getBlankPrefix()); // Set Blank Prefix.

// Create "Core" Elements.

$hdUnknownPage   = new FHeader();
$tblNotice       = new FTable();
$rwNoticeOne     = new FTableRow();
$rwNoticeTwo     = new FTableRow();
$clNoticeIcon    = new FTableCell();
$clNoticeTitle   = new FTableCell();
$clNoticeContent = new FTableCell();
$parNotice       = new FParagraph();

// "Header Unknown Page" Element Settings.

$hdUnknownPage->setLevel(1);
$hdUnknownPage->setContent(Locales::getNoticeTitle("unknown-page"));

// "Table Notice" Element Settings.

$tblNotice->setID("notice-table");
$tblNotice->setClass("info-table");
$tblNotice->addRow($rwNoticeOne);
$tblNotice->addRow($rwNoticeTwo);

// "Collumn Notice Icon" Element Settings.

$clNoticeIcon->setID("notice-icon");
$clNoticeIcon->setClass("info-icon");
$clNoticeIcon->setRowSpan(2);
$clNoticeIcon->setContent(new FDiv(null, "protector", "Notice Icon"));

$rwNoticeOne->addCell($clNoticeIcon);

// "Collumn Notice Title" Element Settings.

$clNoticeTitle->setID("notice-title");
$clNoticeTitle->setClass("info-title");
$clNoticeTitle->setContent(Locales::getNoticeTitle("oops"));

$rwNoticeOne->addCell($clNoticeTitle);

// "Collumn Notice Content" Element Settings.

$clNoticeContent->setID("notice-content");
$clNoticeContent->setClass("info-content");
$clNoticeContent->setContent(Locales::getNoticeContent("unknown-page"));

$rwNoticeTwo->addCell($clNoticeContent);

// "Paragraph Notice" Element Settings.

$parNotice->setAlignment(FParagraph::ALN_CENTER);
$parNotice->setContent(Locales::getParagraph("go-home"));
$parNotice->setLink("/");
$parNotice->setLinkTitle(Locales::getTitle("homepage"));
    
// Build Elements.

Build::element($hdUnknownPage);
Build::element($tblNotice);
Build::element($parNotice);

?>