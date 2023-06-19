<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_lane_one.php                          *|
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

// Create "Notices" Elements.

$divNotices      = new FDiv();
$hdNotice        = new FHeader();
$tblNotice       = new FTable();
$rowNoticeOne    = new FTableRow();
$rowNoticeTwo    = new FTableRow();
$rowNoticeThree  = new FTableRow();

// Create "Quick Stats" Elements.

$divQuickStats   = new FDiv();
$hdStats         = new FHeader();
$tblStats        = new FTable();
$rowTotalHits    = new FTableRow();
$rowPageHits     = new FTableRow();
$rowUserCount    = new FTableRow();
$rowMaleCount    = new FTableRow();
$rowFemaleCount  = new FTableRow();
$rowOtherCount   = new FTableRow();
$rowMessageCount = new FTableRow();
$rowCommentCount = new FTableRow();
$rowPagesCount   = new FTableRow();

// Create "Useful Links" Elements.

$divUsefulLinks  = new FDiv();
$hdUsefulLinks   = new FHeader();
$tblUsefulLinks  = new FTable();
$rowEledgen      = new FTableRow();
$rowWThree       = new FTableRow();
$rowApache       = new FTableRow();
$rowPHP          = new FTableRow();
$rowMySQL        = new FTableRow();
$rowJQuery       = new FTableRow();
$rowAF           = new FTableRow();

// "Div Notices" Element Settings.

$divNotices->setID("frequency-notices");
$divNotices->setClass("default-info-section");

$divNotices->addElement($hdNotice);
$divNotices->addElement($tblNotice);

// "Header Notice" Element Settings.

$hdNotice->setLevel(1);
$hdNotice->setContent(Locales::getCore("frequency-notices"));

// "Table Notice" Element Settings.

$tblNotice->setID("frequency-notice-table");
$tblNotice->setClass("admin-info-table");

// Handle Notices (Messages).

if (empty($varNoticeOne) && empty($varNoticeTwo) && empty($varNoticeThree))
{
    // "Row Message One" Element Settings.
    
    $rowNoticeOne->setID("no-frequency-notices");
    
    $rowNoticeOne->addCell(new FTableCell(null, null, Locales::getParagraph("no-notices"), 2));
    
    // Append Elements To "Table Notice" Element.

    $tblNotice->addRow($rowNoticeOne);
}
else
{
    // Create "Temp" Variables.
    
    $tempLinkArray = array
    (
        1 => "http://www.frequency-cms.com/?page=downloads",
        2 => "http://www.frequency-cms.com/?page=security-patches",
        3 => "http://www.frequency-cms.com/?page=modules",
        4 => "http://www.frequency-cms.com/?page=themes",
        5 => "http://www.frequency-cms.com/?page=important-news",
        6 => "http://www.frequency-cms.com/?page=help-needed"
    );
    
    // Handle Notice #1.
    
    if (!empty($varNoticeOne))
    {
        // "Row Notice One" Element Settings.

        $rowNoticeOne->setID("frequency-notice-one");

        $rowNoticeOne->addCell(new FTableCell(null, null, Locales::getParagraph("notice-$varNoticeOne")));
        $rowNoticeOne->addCell(new FTableCell(null, null, "<strong><a href=\"" . $tempLinkArray[$varNoticeOne] . "\">" . Locales::getCore("link") . "</a></strong>"));

        // Append Elements To "Table Notice" Element.

        $tblNotice->addRow($rowNoticeOne);
    }

    if (!empty($varNoticeTwo))
    {
        // "Row Notice Two" Element Settings.

        $rowNoticeTwo->setID("frequency-notice-two");

        $rowNoticeTwo->addCell(new FTableCell(null, null, Locales::getParagraph("notice-$varNoticeTwo")));
        $rowNoticeTwo->addCell(new FTableCell(null, null, "<strong><a href=\"" . $tempLinkArray[$varNoticeTwo] . "\">" . Locales::getCore("link") . "</a></strong>"));

        // Append Elements To "Table Notice" Element.

        $tblNotice->addRow($rowNoticeTwo);
    }

    if (!empty($varNoticeThree))
    {
        // "Row Notice Three" Element Settings.

        $rowNoticeThree->setID("frequency-notice-two");

        $rowNoticeThree->addCell(new FTableCell(null, null, Locales::getParagraph("notice-$varNoticeThree")));
        $rowNoticeThree->addCell(new FTableCell(null, null, "<strong><a href=\"" . $tempLinkArray[$varNoticeThree] . "\">" . Locales::getCore("link") . "</a></strong>"));

        // Append Elements To "Table Notice" Element.

        $tblNotice->addRow($rowNoticeThree);
    }
    
    // Unset "Temp" Variables.
    
    unset($tempLinkArray);
}

// "Div Quick Stats" Element Settings.

$divQuickStats->setID("quick-stats");
$divQuickStats->setClass("default-info-section");

$divQuickStats->addElement($hdStats);
$divQuickStats->addElement($tblStats);

// "Header Stats" Element Settings.

$hdStats->setLevel(1);
$hdStats->setContent(Locales::getCore("quick-stats"));

// "Table Stats" Element Settings.

$tblStats->setID("quick-stats-info-table");
$tblStats->setClass("admin-info-table");

$tblStats->addRow($rowTotalHits);
$tblStats->addRow($rowPageHits);
$tblStats->addRow($rowUserCount);
$tblStats->addRow($rowMaleCount);
$tblStats->addRow($rowFemaleCount);
$tblStats->addRow($rowOtherCount);
$tblStats->addRow($rowMessageCount);
$tblStats->addRow($rowCommentCount);
$tblStats->addRow($rowPagesCount);

// "Row Total Hits" Element Settings.

$rowTotalHits->setID("total-hits");

$rowTotalHits->addCell(new FTableCell(null, null, Locales::getCore("total-hits") . ":"));
$rowTotalHits->addCell(new FTableCell(null, null, "<strong>" . Statistics::getTotalHits() . "</strong>"));

// "Row Page Hits" Element Settings.

$rowPageHits->setID("page-hits");

$rowPageHits->addCell(new FTableCell(null, null, Locales::getCore("page-hits") . ":"));
$rowPageHits->addCell(new FTableCell(null, null, "<strong>" . Statistics::getPageHits() . "</strong>"));

// "Row User Count" Element Settings.

$rowUserCount->setID("users-registered");

$rowUserCount->addCell(new FTableCell(null, null, Locales::getCore("users-registered") . ":"));
$rowUserCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getUserCount() . "</strong>"));

// "Row Male Count" Element Settings.

$rowMaleCount->setID("males-registered");

$rowMaleCount->addCell(new FTableCell(null, null, Locales::getCore("males-registered") . ":"));
$rowMaleCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getMaleUserCount() . "</strong>"));

// "Row Female Count" Element Settings.

$rowFemaleCount->setID("females-registered");

$rowFemaleCount->addCell(new FTableCell(null, null, Locales::getCore("females-registered") . ":"));
$rowFemaleCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getFemaleUserCount() . "</strong>"));

// "Row Ohter Count" Element Settings.

$rowOtherCount->setID("others-registered");

$rowOtherCount->addCell(new FTableCell(null, null, Locales::getCore("others-registered") . ":"));
$rowOtherCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getFemaleUserCount() . "</strong>"));

// "Row Messages Count" Element Settings.

$rowMessageCount->setID("messages-sent");

$rowMessageCount->addCell(new FTableCell(null, null, Locales::getCore("messages-sent") . ":"));
$rowMessageCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getMessagesCount() . "</strong>"));

// "Row Comment Count" Element Settings.

$rowCommentCount->setID("comments-posted");

$rowCommentCount->addCell(new FTableCell(null, null, Locales::getCore("comments-posted") . ":"));
$rowCommentCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getCommentCount() . "</strong>"));

// "Row Comment Count" Element Settings.

$rowPagesCount->setID("pages-created");

$rowPagesCount->addCell(new FTableCell(null, null, Locales::getCore("pages-created") . ":"));
$rowPagesCount->addCell(new FTableCell(null, null, "<strong>" . Statistics::getPagesCount() . "</strong>"));

// "Div Useful Links" Element Settings.

$divUsefulLinks->setID("useful-links");
$divUsefulLinks->setClass("default-info-section");

$divUsefulLinks->addElement($hdUsefulLinks);
$divUsefulLinks->addElement($tblUsefulLinks);

// "Header Useful Links" Element Settings.

$hdUsefulLinks->setLevel(1);
$hdUsefulLinks->setContent(Locales::getCore("useful-links"));

// "Table Useful Links" Element Settings.

$tblUsefulLinks->setID("useful-links-table");
$tblUsefulLinks->setClass("admin-info-table");

$tblUsefulLinks->addRow($rowEledgen);
$tblUsefulLinks->addRow($rowWThree);
$tblUsefulLinks->addRow($rowApache);
$tblUsefulLinks->addRow($rowPHP);
$tblUsefulLinks->addRow($rowMySQL);
$tblUsefulLinks->addRow($rowJQuery);
$tblUsefulLinks->addRow($rowAF);

// "Row Eledgen" Element Settings.

$rowEledgen->setID("eledgen-link");

$rowEledgen->addCell(new FTableCell(null, null, Locales::getCore("eledgen-link") . ":"));
$rowEledgen->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.eledgen.com/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row W3Schools" Element Settings.

$rowWThree->setID("w3schools-link");

$rowWThree->addCell(new FTableCell(null, null, Locales::getCore("w3schools-link") . ":"));
$rowWThree->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.w3schools.com/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Apache" Element Settings.

$rowApache->setID("apache-link");

$rowApache->addCell(new FTableCell(null, null, Locales::getCore("apache-link") . ":"));
$rowApache->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.apache.org/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row PHP" Element Settings.

$rowPHP->setID("apache-link");

$rowPHP->addCell(new FTableCell(null, null, Locales::getCore("php-link") . ":"));
$rowPHP->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.php.net/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row MySQL" Element Settings.

$rowMySQL->setID("mysql-link");

$rowMySQL->addCell(new FTableCell(null, null, Locales::getCore("mysql-link") . ":"));
$rowMySQL->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.mysql.com/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row JQuery" Element Settings.

$rowJQuery->setID("jquery-link");

$rowJQuery->addCell(new FTableCell(null, null, Locales::getCore("jquery-link") . ":"));
$rowJQuery->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.jquery.com/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// "Row Apache Friends" Element Settings.

$rowAF->setID("apache-friends-link");

$rowAF->addCell(new FTableCell(null, null, Locales::getCore("apachefriends-link") . ":"));
$rowAF->addCell(new FTableCell(null, null, "<strong><a href=\"http://www.apachefriends.org/\" target=\"_blank\">" . Locales::getCore("link") . "</a></strong>"));

// Append Elements To "Lane One" Element.

$divLaneOne->addElement($divNotices);
$divLaneOne->addElement($divQuickStats);
$divLaneOne->addElement($divUsefulLinks);

?>