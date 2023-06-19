<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: index.php                                     *|
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

$linkPrefix   = "./?" .
                Locales::getVariable("page") .
                "=" .
                Locales::getLink("set-language") .
                "&" .
                Locales::getVariable("language") .
                "=";

// Create "Core" Elements.

$moduleHeader = new FHeader();
$divLanguages = new FDiv();
$anchorEN     = new FAnchor();
$anchorRS     = new FAnchor();
$anchorDE     = new FAnchor();
$anchorIT     = new FAnchor();
$anchorRU     = new FAnchor();
$anchorGR     = new FAnchor();
$parInfo      = new FParagraph();

// "Module Header" Element Settings.

$moduleHeader->setLevel(1);
$moduleHeader->setContent(Locales::getTitle("languages"));

// "Language Section" Element Settings.

$divLanguages->setID("language-section");
$divLanguages->addElement($anchorEN);
$divLanguages->addElement($anchorRS);
$divLanguages->addElement($anchorDE);
$divLanguages->addElement($anchorIT);
$divLanguages->addElement($anchorRU);
$divLanguages->addElement($anchorGR);

// "Anchor EN" Element Settings.

$title = Locales::getCore("en");

$anchorEN->setID("lang-en");
$anchorEN->setLink($linkPrefix . "en");
$anchorEN->setLinkTitle($title);
$anchorEN->setContent("<img id=\"en-icon\" class=\"lang-icon\" src=\"system/assets/images/flags/en.png\" alt=\"$title\" border=\"0\" />");

// "Anchor RS" Element Settings.

$title = Locales::getCore("rs");

$anchorRS->setLink($linkPrefix . "rs");
$anchorRS->setLinkTitle($title);
$anchorRS->setContent("<img id=\"rs-icon\" class=\"lang-icon\" src=\"system/assets/images/flags/rs.png\" alt=\"$title\" border=\"0\" />");

// "Anchor DE" Element Settings.

$title = Locales::getCore("de");

$anchorDE->setLink($linkPrefix . "de");
$anchorDE->setLinkTitle($title);
$anchorDE->setContent("<img id=\"de-icon\" class=\"lang-icon\" src=\"system/assets/images/flags/de.png\" alt=\"$title\" border=\"0\" />");

// "Anchor IT" Element Settings.

$title = Locales::getCore("it");

$anchorIT->setLink($linkPrefix . "it");
$anchorIT->setLinkTitle($title);
$anchorIT->setContent("<img id=\"it-icon\" class=\"lang-icon\" src=\"system/assets/images/flags/it.png\" alt=\"$title\" border=\"0\" />");

// "Anchor RU" Element Settings.

$title = Locales::getCore("ru");

$anchorRU->setLink($linkPrefix . "ru");
$anchorRU->setLinkTitle($title);
$anchorRU->setContent("<img id=\"ru-icon\" class=\"lang-icon\" src=\"system/assets/images/flags/ru.png\" alt=\"$title\" border=\"0\" />");

// "Anchor GR" Element Settings.

$title = Locales::getCore("gr");

$anchorGR->setLink($linkPrefix . "gr");
$anchorGR->setLinkTitle($title);
$anchorGR->setContent("<img id=\"gr-icon\" class=\"lang-icon\" src=\"system/assets/images/flags/gr.png\" alt=\"$title\" border=\"0\" />");

// "Paragraph Info" Element Settings.

$parInfo->setAlignment(FParagraph::ALN_CENTER);
$parInfo->setContent("<strong>" . Locales::getCore("selected") . ":</strong> " . Locales::getCore(Locales::getLocale()));

// Build Elements.

Build::element($moduleHeader);
Build::element($divLanguages);
Build::element($parInfo);

?> 