<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: set_language.php                              *|
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

$varLanguageCode = Locales::getLocale();
$varLanguageName = Locales::getCore($varLanguageCode);
        
// Create "Core" Elements.

$tblLanguage   = new FTable();
$parInfo       = new FParagraph();

// Create "Row" Elements.

$rowLanguage   = new FTableRow();

// "Table Language" Element Settings.

$tblLanguage->setID("language-table");
$tblLanguage->setClass("default-table");

$tblLanguage->addRow($rowLanguage);

// "Paragraph Info" Element Settings.

$parInfo->setAlignment(FParagraph::ALN_CENTER);

if (Session::isActive())
    $parInfo->setContent(Locales::getParagraph("language-set-const"));
else
    $parInfo->setContent(Locales::getParagraph("language-set-temp"));

// "Row Language" Element Settings.

$rowLanguage->setID("language-row");
$rowLanguage->setClass("default-table-row");

$rowLanguage->addCell(new FTableCell("language-flag", null, "<div id=\"language-icon\" style=\"background: url(./system/locales/$varLanguageCode/images/large_flag.png);\"><div class=\"protector\">$varLanguageName</div></div>"));
$rowLanguage->addCell(new FTableCell("language-name", null, $varLanguageName));

// Build Elements.

Build::element($tblLanguage);
Build::element($parInfo);

?>