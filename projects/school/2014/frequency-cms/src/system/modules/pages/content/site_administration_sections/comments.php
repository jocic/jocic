<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: comments.php                                  *|
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
               Locales::getLink("comments");

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "comments" .
                    DIRECTORY_SEPARATOR;

$varComments         = Comments::fetchAllComments();
$varViewCommentPrefix = "<a id=\"search-icon\" class=\"options-icon\" title=\"" . Locales::getCore("view-comment") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-comment") . "&" . Locales::getVariable("id") . "=";
$varViewCommentSufix  = "\">" . Locales::getCore("view-comment") . "</a>";
$varViewProfilePrefix = "<a id=\"profile-icon\" class=\"options-icon\" title=\"" . Locales::getCore("view-profile") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-profile") . "&" . Locales::getVariable("id") . "=";
$varViewProfileSufix  = "\">" . Locales::getCore("view-profile") . "</a>";
$varDeleteLinkPrefix  = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-comment") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-comment") . "&" . Locales::getVariable("id") . "=";
$varDeleteLinkSufix   = "\">" . Locales::getCore("delete-comment") . "</a>";

// Create "Core" Elements.

$hdComments          = new FHeader();
$parInfo             = new FParagraph();
$tblComments         = new FTable();
$rowInfoRow          = new FTableRow();

// SPECIFIC PAGE ACTION STARTS HERE.

if (!empty($_GET[Locales::getVariable("option")]) && !empty($_GET[Locales::getVariable("id")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-comment")) // Show Comment Information (If Selected).
        require_once $varSubScriptRoot . "view_comment.php";
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-profile")) // Show Profile Information (If Selected).
        require_once $varSubScriptRoot . "view_profile.php";
}

// SPECIFIC PAGE ACTION ENDS HERE.

// "Header Comments" Element Settings.

$hdComments->setLevel(2);
$hdComments->setContent(Locales::getTitle("all-comments"));

// "Paragraph Info" Element Settings.

$parInfo->setClass("info-paragraph");
$parInfo->setAlignment(FParagraph::ALN_CENTER);
$parInfo->setContent(Locales::getParagraph("no-comments-posted"));

// "Table Comments" Element Settings.

$tblComments->setID("comments-table");
$tblComments->setClass("default-admin-table");
$tblComments->setAlignment(FTable::ALN_CENTER);

$tblComments->addRow($rowInfoRow);

// Loop Through All Messages.

if ($varComments != null)
{
    foreach($varComments as $varComment)
    {
        // Process "Page ID".

        $varComment["page_id"] = PageInfo::getTitle($varComment["page_id"]);
        
        if (strlen($varComment["page_id"]) > 20)
            $varComment["page_id"] = substr($varComment["page_id"], 0, 20) . "...";

        // Process "Content".
         
        if (strlen($varComment["content"]) > 30)
            $varComment["content"] = substr($varComment["content"], 0, 30) . "...";
        
        // Process "Timestamp".
        
        $varComment["timestamp"] = str_replace("-", ".", $varComment["timestamp"]);
        $varComment["timestamp"] = str_replace(" ", ". - ", $varComment["timestamp"]);

        // Create A Temp Row.

        $tempRow = new FTableRow();

        $tempRow->addCell(new FTableCell(null, "table-cell-id", $varComment["id"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-page", $varComment["page_id"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-poster", InfoFetch::fetchUsername($varComment["sender_id"])));
        $tempRow->addCell(new FTableCell(null, "table-cell-content", $varComment["content"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-timestamp", $varComment["timestamp"]));
        $tempRow->addCell(new FTableCell(null, "table-cell-options", $varViewCommentPrefix . $varComment["id"] . $varViewCommentSufix . " " . $varViewProfilePrefix . $varComment["sender_id"] . $varViewProfileSufix . " " . $varDeleteLinkPrefix . $varComment["id"] . $varDeleteLinkSufix));

        // Add A Temp Row.

        $tblComments->addRow($tempRow);
    }
}

// "Row Info Row" Element Settings.

$rowInfoRow->setID("comments-info-row");
$rowInfoRow->setClass("info-row");

$rowInfoRow->addCell(new FTableCell(null, "table-cell-id", "#"));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-page", Locales::getCore("page")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-poster", Locales::getCore("poster")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-content", Locales::getCore("content")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-timestamp", Locales::getCore("timestamp")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdComments);

if ($varComments == null)
    $divWorkplace->addElement($parInfo);
else
    $divWorkplace->addElement($tblComments);

?>