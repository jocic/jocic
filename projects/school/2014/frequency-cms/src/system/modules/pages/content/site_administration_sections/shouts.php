<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: shouts.php                                    *|
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

$varCoreLink = CMS_ROOT .
               "?" .
               Locales::getVariable("page") .
               "=" .
               Locales::getLink("site-administration") .
               "&" .
               Locales::getVariable("workplace") .
               "=" .
               Locales::getLink("shouts");

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "shouts" .
                    DIRECTORY_SEPARATOR;

$varShouts            = Shoutbox::fetchAllPosts();
$varViewCommentPrefix = "<a id=\"search-icon\" class=\"options-icon\" title=\"" . Locales::getCore("view-shout") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-shout") . "&" . Locales::getVariable("id") . "=";
$varViewCommentSufix  = "\">" . Locales::getCore("view-shout") . "</a>";
$varViewProfilePrefix = "<a id=\"profile-icon\" class=\"options-icon\" title=\"" . Locales::getCore("view-profile") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-profile") . "&" . Locales::getVariable("id") . "=";
$varViewProfileSufix  = "\">" . Locales::getCore("view-profile") . "</a>";
$varDeleteLinkPrefix  = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-shout") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-shout") . "&" . Locales::getVariable("id") . "=";
$varDeleteLinkSufix   = "\">" . Locales::getCore("delete-shout") . "</a>";

// Create "Core" Elements.

$hdShouts            = new FHeader();
$parInfo             = new FParagraph();
$tblShouts           = new FTable();
$rowInfoRow          = new FTableRow();

// SPECIFIC PAGE ACTION STARTS HERE.

if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-shout")) // Show Comment Information (If Selected).
        require_once $varSubScriptRoot . "view_shout.php";
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-profile")) // Show Profile Information (If Selected).
        require_once $varSubScriptRoot . "view_profile.php";
}

// SPECIFIC PAGE ACTION ENDS HERE.

// "Header Shouts" Element Settings.

$hdShouts->setLevel(2);
$hdShouts->setContent(Locales::getTitle("all-shouts"));

// "Paragraph Info" Element Settings.

$parInfo->setClass("info-paragraph");
$parInfo->setAlignment(FParagraph::ALN_CENTER);
$parInfo->setContent(Locales::getParagraph("no-shoutbox-posts"));

// "Table Shouts" Element Settings.

$tblShouts->setID("shouts-table");
$tblShouts->setClass("default-admin-table");
$tblShouts->setAlignment(FTable::ALN_CENTER);

$tblShouts->addRow($rowInfoRow);

// Loop Through All Shouts.

if ($varShouts != null)
{
    foreach($varShouts as $varShout)
    {
        // Process "Content".
         
        if (strlen($varShout["content"]) > 30)
            $varShout["content"] = substr($varShout["content"], 0, 30) . "...";
        
        // Process "Timestamp".
        
        $varShout["timestamp"] = str_replace("-", ".", $varShout["timestamp"]);
        $varShout["timestamp"] = str_replace(" ", ". - ", $varShout["timestamp"]);

        // Create A Temp Row.

        $tempRow = new FTableRow();

        $tempRow->addCell(new FTableCell(null, "table-cell-id", $varShout["id"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-poster", InfoFetch::fetchUsername($varShout["poster_id"])));
        $tempRow->addCell(new FTableCell(null, "table-cell-content", $varShout["content"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-timestamp", $varShout["timestamp"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-options", $varViewCommentPrefix . $varShout["id"] . $varViewCommentSufix . " " . $varViewProfilePrefix . $varShout["poster_id"] . $varViewProfileSufix . " " . $varDeleteLinkPrefix . $varShout["id"] . $varDeleteLinkSufix));

        // Add A Temp Row.

        $tblShouts->addRow($tempRow);
    }
}

// "Row Info Row" Element Settings.

$rowInfoRow->setID("comments-info-row");
$rowInfoRow->setClass("info-row");

$rowInfoRow->addCell(new FTableCell(null, "table-cell-id", "#"));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-poster", Locales::getCore("poster")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-content", Locales::getCore("content")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-timestamp", Locales::getCore("timestamp")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdShouts);

if ($varShouts == null)
    $divWorkplace->addElement($parInfo);
else
    $divWorkplace->addElement($tblShouts);

?>