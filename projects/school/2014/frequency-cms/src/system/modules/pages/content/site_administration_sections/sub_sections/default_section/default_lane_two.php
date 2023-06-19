<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_lane_two.php                          *|
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

$varSocialIcons = array
(
    "<a href=\"http://www.facebook.com/frequencyCMS\" title=\"" . Locales::getCore("frequency-facebook") . "\" target=\"_blank\"><span id=\"facebook\">" . Locales::getCore("frequency-facebook") . "</span></a>",
    "<a href=\"http://www.twitter.com/frequencyCMS\" title=\"" . Locales::getCore("frequency-twitter") . "\" target=\"_blank\"><span id=\"twitter\">" . Locales::getCore("frequency-twitter") . "</span></a>",
    "<a href=\"http://plus.google.com/117949248332795325198\" title=\"" . Locales::getCore("frequency-gplus") . "\" target=\"_blank\"><span id=\"gplus\">" . Locales::getCore("frequency-gplus") . "</span></a>",
    "<a href=\"http://www.youtube.com/user/frequencyCMS\" title=\"" . Locales::getCore("frequency-youtube") . "\" target=\"_blank\"><span id=\"youtube\">" . Locales::getCore("frequency-youtube") . "</span></a>"
    
);

// Create "Quick Links" Elements.

$divQuickLinks       = new FDiv();
$hdQuickLinks        = new FHeader();
$tblQuickLinks       = new FTable();
$rowFreqHomepage     = new FTableRow();
$rowFreqNews         = new FTableRow();
$rowFreqDownloads    = new FTableRow();
$rowFreqChangelogs   = new FTableRow();
$rowFreqHelp         = new FTableRow();
$rowFreqFAQ          = new FTableRow();
$rowFreqReportBugs   = new FTableRow();
$rowFreqSubmitIdeas  = new FTableRow();
$rowFreqContact      = new FTableRow();
$rowFreqAbout        = new FTableRow();

// Create "Info" Elements.

$divSystemInfo       = new FDiv();
$hdSystemInfo        = new FHeader();
$tblSystemInfo       = new FTable();
$rowCurrentVersion   = new FTableRow();
$rowAvailableVersion = new FTableRow();
$rowPHPVersion       = new FTableRow();
$rowServerName       = new FTableRow();
$rowServerPort       = new FTableRow();
$rowProtocol         = new FTableRow();
$rowRemotePort       = new FTableRow();

// Create "Social" Elements.

$divSocialInfo       = new FDiv();
$hdSocialInfo        = new FHeader();
$tblSocialInfo       = new FTable();
$rowSocialIcons      = new FTableRow();

// "Div Quick Links" Element Settings.

$divQuickLinks->setID("quick-links");
$divQuickLinks->setClass("default-info-section");

$divQuickLinks->addElement($hdQuickLinks);
$divQuickLinks->addElement($tblQuickLinks);

// "Header Quick Links" Element Settings.

$hdQuickLinks->setLevel(1);
$hdQuickLinks->setContent(Locales::getCore("quick-links"));

// "Table Quick Links" Element Settings.

$tblQuickLinks->setID("system-info-table");
$tblQuickLinks->setClass("admin-info-table");

$tblQuickLinks->addRow($rowFreqHomepage);
$tblQuickLinks->addRow($rowFreqNews);
$tblQuickLinks->addRow($rowFreqDownloads);
$tblQuickLinks->addRow($rowFreqChangelogs);
$tblQuickLinks->addRow($rowFreqHelp);
$tblQuickLinks->addRow($rowFreqFAQ);
$tblQuickLinks->addRow($rowFreqReportBugs);
$tblQuickLinks->addRow($rowFreqSubmitIdeas);
$tblQuickLinks->addRow($rowFreqContact);
$tblQuickLinks->addRow($rowFreqAbout);

// "Row Frequency Home" Element Settings.

$rowFreqHomepage->setID("frequency-home-page");

$rowFreqHomepage->addCell(new FTableCell(null, null, Locales::getCore("frequency-home-page")));
$rowFreqHomepage->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency News" Element Settings.

$rowFreqNews->setID("frequency-home-page");

$rowFreqNews->addCell(new FTableCell(null, null, Locales::getCore("frequency-news")));
$rowFreqNews->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=news\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency Downloads" Element Settings.

$rowFreqDownloads->setID("frequency-downloads");

$rowFreqDownloads->addCell(new FTableCell(null, null, Locales::getCore("frequency-downloads")));
$rowFreqDownloads->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=downloads\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency Changelogs" Element Settings.

$rowFreqChangelogs->setID("frequency-changelogs");

$rowFreqChangelogs->addCell(new FTableCell(null, null, Locales::getCore("frequency-changelogs")));
$rowFreqChangelogs->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=changelogs\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency Help" Element Settings.

$rowFreqHelp->setID("frequency-help");

$rowFreqHelp->addCell(new FTableCell(null, null, Locales::getCore("frequency-help")));
$rowFreqHelp->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=help\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency FAQ" Element Settings.

$rowFreqFAQ->setID("frequency-faq");

$rowFreqFAQ->addCell(new FTableCell(null, null, Locales::getCore("frequency-faq")));
$rowFreqFAQ->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=faq\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency Report A Bug" Element Settings.

$rowFreqReportBugs->setID("frequency-report-bug");

$rowFreqReportBugs->addCell(new FTableCell(null, null, Locales::getCore("frequency-report-bugs")));
$rowFreqReportBugs->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=report-a-bug\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency Submit An Idea" Element Settings.

$rowFreqSubmitIdeas->setID("frequency-idea");

$rowFreqSubmitIdeas->addCell(new FTableCell(null, null, Locales::getCore("frequency-submit-ideas")));
$rowFreqSubmitIdeas->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=submit-an-idea\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency Contact" Element Settings.

$rowFreqContact->setID("frequency-contact");

$rowFreqContact->addCell(new FTableCell(null, null, Locales::getCore("frequency-contact-dev")));
$rowFreqContact->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=contact\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Frequency About" Element Settings.

$rowFreqAbout->setID("frequency-about");

$rowFreqAbout->addCell(new FTableCell(null, null, Locales::getCore("frequency-about")));
$rowFreqAbout->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.frequency-cms.com/?page=about\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Div System Info" Element Settings.

$divSystemInfo->setID("system-info");
$divSystemInfo->setClass("default-info-section");

$divSystemInfo->addElement($hdSystemInfo);
$divSystemInfo->addElement($tblSystemInfo);

// "Header System Info" Element Settings.

$hdSystemInfo->setLevel(1);
$hdSystemInfo->setContent(Locales::getCore("system-information"));

// "Table System Info" Element Settings.

$tblSystemInfo->setID("system-info-table");
$tblSystemInfo->setClass("admin-info-table");

$tblSystemInfo->addRow($rowCurrentVersion);
$tblSystemInfo->addRow($rowAvailableVersion);
$tblSystemInfo->addRow($rowPHPVersion);
$tblSystemInfo->addRow($rowServerName);
$tblSystemInfo->addRow($rowServerPort);
$tblSystemInfo->addRow($rowProtocol);
$tblSystemInfo->addRow($rowRemotePort);

// "Row Current Version" Element Settings.

$rowCurrentVersion->setID("sytem-current-version");

$rowCurrentVersion->addCell(new FTableCell(null, null, Locales::getCore("system-version") . ":"));
$rowCurrentVersion->addCell(new FTableCell(null, null, "<strong>" . Core::get(Core::SYSTEM_VERSION) . "</strong>"));

// "Row Available Version" Element Settings.

$rowAvailableVersion->setID("system-available-version");

$rowAvailableVersion->addCell(new FTableCell(null, null, Locales::getCore("available-version") . ":"));

if ($varSystemVersion)
    $rowAvailableVersion->addCell(new FTableCell(null, null, "<strong>" . $varSystemVersion . "</strong>"));
else
    $rowAvailableVersion->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("unknown") . "</strong>"));

// "Row PHP Version" Element Settings.

$rowPHPVersion->setID("php-version");

$rowPHPVersion->addCell(new FTableCell(null, null, Locales::getCore("php-version") . ":"));
$rowPHPVersion->addCell(new FTableCell(null, null, "<strong>" . phpversion() . "</strong>"));

// "Row Server Name" Element Settings.

$rowServerName->setID("server-name");

$rowServerName->addCell(new FTableCell(null, null, Locales::getCore("server-name") . ":"));
$rowServerName->addCell(new FTableCell(null, null, "<strong>" . $_SERVER["SERVER_NAME"] . "</strong>"));

// "Row Server Port" Element Settings.

$rowServerPort->setID("server-port");

$rowServerPort->addCell(new FTableCell(null, null, Locales::getCore("server-port") . ":"));
$rowServerPort->addCell(new FTableCell(null, null, "<strong>" . $_SERVER["SERVER_PORT"] . "</strong>"));

// "Row Server Protocol" Element Settings.

$rowProtocol->setID("server-protocol");

$rowProtocol->addCell(new FTableCell(null, null, Locales::getCore("server-protocol") . ":"));
$rowProtocol->addCell(new FTableCell(null, null, "<strong>" . $_SERVER["SERVER_PROTOCOL"] . "</strong>"));

// "Row Remote Port" Element Settings.

$rowRemotePort->setID("remote-port");

$rowRemotePort->addCell(new FTableCell(null, null, Locales::getCore("remote-port") . ":"));
$rowRemotePort->addCell(new FTableCell(null, null, "<strong>" . $_SERVER["REMOTE_PORT"] . "</strong>"));

// "Div Social Info" Element Settings.

$divSocialInfo->setID("social-info");
$divSocialInfo->setClass("default-info-section");

$divSocialInfo->addElement($hdSocialInfo);
$divSocialInfo->addElement($tblSocialInfo);

// "Header Social Info" Element Settings.

$hdSocialInfo->setLevel(1);
$hdSocialInfo->setContent(Locales::getCore("social-info"));

// "Table Social Info" Element Settings.

$tblSocialInfo->setID("social-info-table");
$tblSocialInfo->setClass("admin-info-table");

$tblSocialInfo->addRow($rowSocialIcons);

// "Row Social Icons" Element Settings.

$rowSocialIcons->setID("social-icons");

$rowSocialIcons->addCell(new FTableCell(null, null, $varSocialIcons));

// Append Elements To "Lane Two" Element.

$divLaneTwo->addElement($divQuickLinks);
$divLaneTwo->addElement($divSystemInfo);
$divLaneTwo->addElement($divSocialInfo);

?>