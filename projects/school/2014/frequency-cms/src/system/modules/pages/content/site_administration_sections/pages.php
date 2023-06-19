<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: pages.php                                     *|
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

if (!empty($_GET[Locales::getVariable("option")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-core-page"))
    {
        // Create "Core" Variables.
        
        $varCoreLink = CMS_ROOT .
                       "?" .
                       Locales::getVariable("page") .
                       "=" .
                       Locales::getLink("site-administration") .
                       "&" .
                       Locales::getVariable("workplace") .
                       "=" .
                       Locales::getLink("pages");
        
        $varTitleSufix  = null;
        $varContent     = null;
        
        // Create "Core" Elements.
        
        $hdEditCorePage = new FHeader();
        $fmEditCorePage = new FForm();
        $tbEditCorePage = new FTable();
        
        // Create "Row" Elements.
        
        $rowContent          = new FTableRow();
        $rowContentInput     = new FTableRow();
        $rowSubmit           = new FTableRow();
        
        // Create "Input" Elements.
        
        $txtContent          = new FTextArea();
        $btnReset            = new FButton();
        $btnSubmit           = new FButton();
        
        // "Title Sufix" Variable Settings.
        
        if ($_GET[Locales::getVariable("id")] == 1)
            $varTitleSufix = Locales::getCore("homepage");
        else if ($_GET[Locales::getVariable("id")] == 2)
            $varTitleSufix = Locales::getCore("terms-of-service");
        else if ($_GET[Locales::getVariable("id")] == 3)
            $varTitleSufix = Locales::getCore("privacy-policy");
        
        // "Content" Variable Settings.
        
        if ($_GET[Locales::getVariable("id")] == 1)
            $varContent = CorePage::get("homepage");
        else if ($_GET[Locales::getVariable("id")] == 2)
            $varContent = CorePage::get("terms-of-service");
        else if ($_GET[Locales::getVariable("id")] == 3)
            $varContent = CorePage::get("privacy-policy");
        
        // "Header Edit Core Pages" Element Settings.
        
        $hdEditCorePage->setLevel(2);
        $hdEditCorePage->setContent(Locales::getTitle("edit-core-page") . " - " . $varTitleSufix);
        
        // "Form Option Edit Core Page" Element Settings.
        
        $fmEditCorePage->setID("edit-core-page-form");
        $fmEditCorePage->setClass("default-form");
        $fmEditCorePage->setMethod(FForm::MTD_POST);
        $fmEditCorePage->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-core-page") . "&" . Locales::getVariable("id") . "=" . $_GET[Locales::getVariable("id")]);
        
        $fmEditCorePage->addItem($tbEditCorePage);
        
        // "Table Option Edit Core Page" Element Settigngs.
        
        $tbEditCorePage->setID("pages-table");
        $tbEditCorePage->setClass("default-admin-table");
        $tbEditCorePage->setAlignment(FTable::ALN_CENTER);
        
        $tbEditCorePage->addRow($rowContent);
        $tbEditCorePage->addRow($rowContentInput);
        $tbEditCorePage->addRow($rowSubmit);
        
        // "Row Content" Element Settings.
        
        $rowContent->setID("page-content");
        $rowContent->setClass("title");
        $rowContent->addCell(new FTableCell(null, null, new FLabel("content", Locales::getCore("content")), 2));
        
        // "Row Content Input" Element Settings.
        
        $rowContentInput->setID("page-content-input");
        $rowContentInput->addCell(new FTableCell(null, null, $txtContent, 2));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->setID("page-submit");
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));
        
        // "Textarea Content" Element Settings.
        
        $txtContent->setID("page-content-input");
        $txtContent->setClass("ckeditor");
        $txtContent->setContent($varContent);
        $txtContent->setName("req_content");
        
         // "Button Reset" Element Settings.
        
        $btnReset->setID("edit-core-page-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));

        // "Button Submit" Element Settings.
        
        $btnSubmit->setID("edit-core-page-submit-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FButton::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("edit"));
        
        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ckeditor/ckeditor.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement($hdEditCorePage);
        $divWorkplace->addElement($fmEditCorePage);
    }
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("add"))
    {
        // Create "Core" Variables.
        
        $varCoreLink = CMS_ROOT .
                       "?" .
                       Locales::getVariable("page") .
                       "=" .
                       Locales::getLink("site-administration") .
                       "&" .
                       Locales::getVariable("workplace") .
                       "=" .
                       Locales::getLink("pages");
        
        $varTitle            = null;
        $varDescription      = null;
        $varContent          = null;
        $varTags             = null;
        $varCustomID         = null;
        $varCommentsEnabled  = null;
        
        // Create "Core" Elements.
        
        $hdOptionAdd         = new FHeader();
        $fmOptionAdd         = new FForm();
        $tblOptionAdd        = new FTable();
        
        // Create "Row" Elements.
        
        $rowTitle            = new FTableRow();
        $rowTitleInput       = new FTableRow();
        $rowDescription      = new FTableRow();
        $rowDescriptionInput = new FTableRow();
        $rowContent          = new FTableRow();
        $rowContentInput     = new FTableRow();
        $rowTags             = new FTableRow();
        $rowTagsInput        = new FTableRow();
        $rowCustomID         = new FTableRow();
        $rowCustomIDInput    = new FTableRow();
        $rowComments         = new FTableRow();
        $rowSubmit           = new FTableRow();
        
        // Create "Input" Elements.
        
        $inpTitle            = new FInput();
        $txtDescription      = new FTextArea();
        $txtContent          = new FTextArea();
        $inpTags             = new FInput();
        $inpCustomID         = new FInput();
        $selComments         = new FSelect();
        $btnReset            = new FButton();
        $btnSubmit           = new FButton();
        
        // "Title" Variable Settings.
        
        if (!empty($_POST["req_title"]))
            $varTitle = $_POST["req_title"];
        
        // "Description" Variable Settings.
        
        if (!empty($_POST["req_description"]))
            $varDescription = $_POST["req_description"];
        
        // "Content" Variable Settings.
        
        if (!empty($_POST["req_content"]))
            $varContent = $_POST["req_content"];
        
        // "Custom ID" Variable Settings.
        
        if (!empty($_POST["req_custom"]))
            $varCustomID = $_POST["req_custom"];
        
        // "Tags" Variable Settings.
        
        if (!empty($_POST["req_tags"]))
            $varTags = $_POST["req_tags"];
        
        // "Comments Enabled" Variable Settings.
        
        if (!empty($_POST["req_comments"]))
            $varCommentsEnabled = $_POST["req_comments"];
        
        // "Header Option Add" Element Settings.
        
        $hdOptionAdd->setLevel(2);
        $hdOptionAdd->setContent(Locales::getCore("add-page"));
        
        // "Form Option Add" Element Settings.
        
        $fmOptionAdd->setID("pages-option-form");
        $fmOptionAdd->setClass("default-form");
        $fmOptionAdd->setMethod(FForm::MTD_POST);
        $fmOptionAdd->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add"));
        
        $fmOptionAdd->addItem($tblOptionAdd);
        
        // "Table Option Add" Element Settigngs.
        
        $tblOptionAdd->setID("pages-table");
        $tblOptionAdd->setClass("default-admin-table");
        $tblOptionAdd->setAlignment(FTable::ALN_CENTER);
        
        $tblOptionAdd->addRow($rowTitle);
        $tblOptionAdd->addRow($rowTitleInput);
        $tblOptionAdd->addRow($rowDescription);
        $tblOptionAdd->addRow($rowDescriptionInput);
        $tblOptionAdd->addRow($rowContent);
        $tblOptionAdd->addRow($rowContentInput);
        $tblOptionAdd->addRow($rowTags);
        $tblOptionAdd->addRow($rowTagsInput);
        $tblOptionAdd->addRow($rowCustomID);
        $tblOptionAdd->addRow($rowCustomIDInput);
        $tblOptionAdd->addRow($rowComments);
        $tblOptionAdd->addRow($rowSubmit);
        
        // "Row Title" Element Settings.
        
        $rowTitle->setID("page-title");
        $rowTitle->setClass("title");
        $rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title") . " *"), 2));
        
        // "Row Title Input" Element Settings.
        
        $rowTitleInput->setID("page-title-input");
        $rowTitleInput->addCell(new FTableCell(null, null, $inpTitle, 2));
        
        // "Row Description" Element Settings.
        
        $rowDescription->setID("page-description");
        $rowDescription->setClass("title");
        $rowDescription->addCell(new FTableCell(null, null, new FLabel("description", Locales::getCore("description") . " *"), 2));
        
        // "Row Description Input" Element Settings.
        
        $rowDescriptionInput->setID("page-description-input");
        $rowDescriptionInput->addCell(new FTableCell(null, null, $txtDescription, 2));
        
        // "Row Content" Element Settings.
        
        $rowContent->setID("page-content");
        $rowContent->setClass("title");
        $rowContent->addCell(new FTableCell(null, null, new FLabel("content", Locales::getCore("content") . " *"), 2));
        
        // "Row Content Input" Element Settings.
        
        $rowContentInput->setID("page-content-input");
        $rowContentInput->addCell(new FTableCell(null, null, $txtContent, 2));
        
        // "Row Tags" Element Settings.
        
        $rowTags->setID("page-tags");
        $rowTags->setClass("title");
        $rowTags->addCell(new FTableCell(null, null, new FLabel("tags", Locales::getCore("tags")), 2));
        
        // "Row Tags Input" Element Settings.
        
        $rowTagsInput->setID("page-tags");
        $rowTagsInput->addCell(new FTableCell(null, null, $inpTags, 2));
        
        // "Row Custom ID" Element Settings.
        
        $rowCustomID->setID("page-custom-id");
        $rowCustomID->setClass("title");
        $rowCustomID->addCell(new FTableCell(null, null, new FLabel("custom-id", Locales::getCore("custom-id")), 2));
        
        // "Row Custom ID Input" Element Settings.
        
        $rowCustomIDInput->setID("page-custom-id-input");
        $rowCustomIDInput->addCell(new FTableCell(null, null, $inpCustomID, 2));
        
        // "Row Enable Comments" Element Settings.
        
        $rowComments->setID("page-enable-comments");
        $rowComments->setClass("title");
        $rowComments->addCell(new FTableCell(null, "table-cell-info", new FLabel("comments-enabled", Locales::getCore("comments-enabled") . ":")));
        $rowComments->addCell(new FTableCell(null, null, $selComments));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->setID("page-submit");
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));
        
        // "Input Title" Element Settings.
        
        $inpTitle->setClass("form-input");
        $inpTitle->setType(FInput::TP_TEXT);
        $inpTitle->setMaxLength(255);
        $inpTitle->setContent($varTitle);
        $inpTitle->setName("req_title");
        
        // "Textarea Description" Element Settings.
        
        $txtDescription->setID("description-input");
        $txtDescription->setClass("ckeditor");
        $txtDescription->setContent($varDescription);
        $txtDescription->setName("req_description");
        
        // "Textarea Content" Element Settings.
        
        $txtContent->setID("page-content-input");
        $txtContent->setClass("ckeditor");
        $txtContent->setContent($varContent);
        $txtContent->setName("req_content");
        
        // "Input Tags" Element Settings.
        
        $inpTags->setClass("form-input");
        $inpTags->setType(FInput::TP_TEXT);
        $inpTags->setMaxLength(255);
        $inpTags->setContent($varTags);
        $inpTags->setName("req_tags");
        
        // "Input Custom ID" Element Settings.
        
        $inpCustomID->setClass("form-input");
        $inpCustomID->setType(FInput::TP_TEXT);
        $inpCustomID->setMaxLength(255);
        $inpCustomID->setContent($varCustomID);
        $inpCustomID->setName("req_custom");
        
        // "Select Comments" Element Settings.
        
        $selComments->setID("pages-comments-enabled");
        $selComments->setClass("form-select");
        
        if (empty($varCommentsEnabled))
        {
            $selComments->addOption(new FSelectOption(0, Locales::getCore("no"), true));
            $selComments->addOption(new FSelectOption(1, Locales::getCore("yes"), false));
        }
        else
        {
            $selComments->addOption(new FSelectOption(0, Locales::getCore("no"), false));
            $selComments->addOption(new FSelectOption(1, Locales::getCore("yes"), true));
        }
        
        $selComments->setName("req_comments");
        
        // "Button Reset" Element Settings.
        
        $btnReset->setID("pages-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));

        // "Button Submit" Element Settings.
        
        $btnSubmit->setID("pages-submit-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FButton::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("add"));

        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ckeditor/ckeditor.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement($hdOptionAdd);
        $divWorkplace->addElement($fmOptionAdd);
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-page"))
    {
        // Create "Core" Variables.
        
        $varCoreLink = CMS_ROOT .
                       "?" .
                       Locales::getVariable("page") .
                       "=" .
                       Locales::getLink("site-administration") .
                       "&" .
                       Locales::getVariable("workplace") .
                       "=" .
                       Locales::getLink("pages");
        
        $varPageID           = $_GET[Locales::getVariable("id")];
        $varTitle            = null;
        $varDescription      = null;
        $varContent          = null;
        $varTags             = null;
        $varCustomID         = null;
        
        // Create "Core" Elements.
        
        $hdOptionAdd         = new FHeader();
        $fmOptionAdd         = new FForm();
        $tblOptionAdd        = new FTable();
        
        // Create "Row" Elements.
        
        $rowTitle            = new FTableRow();
        $rowTitleInput       = new FTableRow();
        $rowDescription      = new FTableRow();
        $rowDescriptionInput = new FTableRow();
        $rowContent          = new FTableRow();
        $rowContentInput     = new FTableRow();
        $rowTags             = new FTableRow();
        $rowTagsInput        = new FTableRow();
        $rowCustomID         = new FTableRow();
        $rowCustomIDInput    = new FTableRow();
        $rowPublished        = new FTableRow();
        $rowComments         = new FTableRow();
        $rowSubmit           = new FTableRow();
        
        // Create "Input" Elements.
        
        $inpTitle            = new FInput();
        $txtDescription      = new FTextArea();
        $txtContent          = new FTextArea();
        $inpTags             = new FInput();
        $inpCustomID         = new FInput();
        $selComments         = new FSelect();
        $selPublished        = new FSelect();
        $btnReset            = new FButton();
        $btnSubmit           = new FButton();
        
        // "Title" Variable Settings.
        
        $varTitle = PageInfo::getTitle($varPageID);
        
        // "Description" Variable Settings.
        
        $varDescription = PageInfo::getDescription($varPageID);
        
        // "Content" Variable Settings.
        
        $varContent = PageInfo::getContent($varPageID);
        
        // "Custom ID" Variable Settings.
        
        $varCustomID = PageInfo::getCustomID($varPageID);
        
        // "Tags" Variable Settings.
        
        $varTags = PageInfo::getTags($varPageID);
        
        // "Header Option Add" Element Settings.
        
        $hdOptionAdd->setLevel(2);
        $hdOptionAdd->setContent(Locales::getCore("add-page"));
        
        // "Form Option Add" Element Settings.
        
        $fmOptionAdd->setID("pages-option-form");
        $fmOptionAdd->setClass("default-form");
        $fmOptionAdd->setMethod(FForm::MTD_POST);
        $fmOptionAdd->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-page") . "&" . Locales::getVariable("id") . "=" . $varPageID);
        
        $fmOptionAdd->addItem($tblOptionAdd);
        
        // "Table Option Add" Element Settigngs.
        
        $tblOptionAdd->setID("pages-table");
        $tblOptionAdd->setClass("default-admin-table");
        $tblOptionAdd->setAlignment(FTable::ALN_CENTER);
        
        $tblOptionAdd->addRow($rowTitle);
        $tblOptionAdd->addRow($rowTitleInput);
        $tblOptionAdd->addRow($rowDescription);
        $tblOptionAdd->addRow($rowDescriptionInput);
        $tblOptionAdd->addRow($rowContent);
        $tblOptionAdd->addRow($rowContentInput);
        $tblOptionAdd->addRow($rowTags);
        $tblOptionAdd->addRow($rowTagsInput);
        $tblOptionAdd->addRow($rowCustomID);
        $tblOptionAdd->addRow($rowCustomIDInput);
        $tblOptionAdd->addRow($rowPublished);
        $tblOptionAdd->addRow($rowComments);
        $tblOptionAdd->addRow($rowSubmit);
        
        // "Row Title" Element Settings.
        
        $rowTitle->setID("page-title");
        $rowTitle->setClass("title");
        $rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title") . " *"), 2));
        
        // "Row Title Input" Element Settings.
        
        $rowTitleInput->setID("page-title-input");
        $rowTitleInput->addCell(new FTableCell(null, null, $inpTitle, 2));
        
        // "Row Description" Element Settings.
        
        $rowDescription->setID("page-description");
        $rowDescription->setClass("title");
        $rowDescription->addCell(new FTableCell(null, null, new FLabel("description", Locales::getCore("description") . " *"), 2));
        
        // "Row Description Input" Element Settings.
        
        $rowDescriptionInput->setID("page-description-input");
        $rowDescriptionInput->addCell(new FTableCell(null, null, $txtDescription, 2));
        
        // "Row Content" Element Settings.
        
        $rowContent->setID("page-content");
        $rowContent->setClass("title");
        $rowContent->addCell(new FTableCell(null, null, new FLabel("content", Locales::getCore("content") . " *"), 2));
        
        // "Row Content Input" Element Settings.
        
        $rowContentInput->setID("page-content-input");
        $rowContentInput->addCell(new FTableCell(null, null, $txtContent, 2));
        
        // "Row Tags" Element Settings.
        
        $rowTags->setID("page-tags");
        $rowTags->setClass("title");
        $rowTags->addCell(new FTableCell(null, null, new FLabel("tags", Locales::getCore("tags")), 2));
        
        // "Row Tags Input" Element Settings.
        
        $rowTagsInput->setID("page-tags");
        $rowTagsInput->addCell(new FTableCell(null, null, $inpTags, 2));
        
        // "Row Custom ID" Element Settings.
        
        $rowCustomID->setID("page-custom-id");
        $rowCustomID->setClass("title");
        $rowCustomID->addCell(new FTableCell(null, null, new FLabel("custom-id", Locales::getCore("custom-id")), 2));
        
        // "Row Custom ID Input" Element Settings.
        
        $rowCustomIDInput->setID("page-custom-id-input");
        $rowCustomIDInput->addCell(new FTableCell(null, null, $inpCustomID, 2));
        
        // "Row Published" Element Settings.
        
        $rowPublished->setID("page-published");
        $rowPublished->setClass("title");
        $rowPublished->addCell(new FTableCell(null, "table-cell-info", new FLabel("published", Locales::getCore("published") . ":")));
        $rowPublished->addCell(new FTableCell(null, null, $selPublished));
        
        // "Row Enable Comments" Element Settings.
        
        $rowComments->setID("page-enable-comments");
        $rowComments->setClass("title");
        $rowComments->addCell(new FTableCell(null, "table-cell-info", new FLabel("comments-enabled", Locales::getCore("comments-enabled") . ":"), null, null, FTableCell::ALN_LEFT));
        $rowComments->addCell(new FTableCell(null, null, $selComments, null, null, FTableCell::ALN_LEFT));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->setID("page-submit");
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));
        
        // "Input Title" Element Settings.
        
        $inpTitle->setClass("form-input");
        $inpTitle->setType(FInput::TP_TEXT);
        $inpTitle->setMaxLength(255);
        $inpTitle->setContent($varTitle);
        $inpTitle->setName("req_title");
        
        // "Textarea Description" Element Settings.
        
        $txtDescription->setID("description-input");
        $txtDescription->setClass("ckeditor");
        $txtDescription->setContent($varDescription);
        $txtDescription->setName("req_description");
        
        // "Textarea Content" Element Settings.
        
        $txtContent->setID("page-content-input");
        $txtContent->setClass("ckeditor");
        $txtContent->setContent($varContent);
        $txtContent->setName("req_content");
        
        // "Input Tags" Element Settings.
        
        $inpTags->setClass("form-input");
        $inpTags->setType(FInput::TP_TEXT);
        $inpTags->setMaxLength(255);
        $inpTags->setContent($varTags);
        $inpTags->setName("req_tags");
        
        // "Input Custom ID" Element Settings.
        
        $inpCustomID->setClass("form-input");
        $inpCustomID->setType(FInput::TP_TEXT);
        $inpCustomID->setMaxLength(255);
        $inpCustomID->setContent($varCustomID);
        $inpCustomID->setName("req_custom");
        
        // "Select Published" Element Settings.
        
        $selPublished->setID("pages-published");
        $selPublished->setClass("form-select");
        
        if (PageInfo::isPublished($varPageID))
        {
            $selPublished->addOption(new FSelectOption(0, Locales::getCore("no"), false));
            $selPublished->addOption(new FSelectOption(1, Locales::getCore("yes"), true));
        }
        else
        {
            $selPublished->addOption(new FSelectOption(0, Locales::getCore("no"), true));
            $selPublished->addOption(new FSelectOption(1, Locales::getCore("yes"), false));
        }
        
        $selPublished->setName("req_published");
        
        // "Select Comments" Element Settings.
        
        $selComments->setID("pages-comments-enabled");
        $selComments->setClass("form-select");
        
        if (PageInfo::isCommentingEnabled($varPageID))
        {
            $selComments->addOption(new FSelectOption(0, Locales::getCore("no"), false));
            $selComments->addOption(new FSelectOption(1, Locales::getCore("yes"), true));
        }
        else
        {
            $selComments->addOption(new FSelectOption(0, Locales::getCore("no"), true));
            $selComments->addOption(new FSelectOption(1, Locales::getCore("yes"), false));
        }
        
        $selComments->setName("req_comments");
        
        // "Button Reset" Element Settings.
        
        $btnReset->setID("pages-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));

        // "Button Submit" Element Settings.
        
        $btnSubmit->setID("pages-submit-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FButton::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("edit"));


        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ckeditor/ckeditor.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement($hdOptionAdd);
        $divWorkplace->addElement($fmOptionAdd);
    }
}
else
{
    // Create "Core" Variables.
    
    $varCoreLink = CMS_ROOT .
                   "?" .
                   Locales::getVariable("page") .
                   "=" .
                   Locales::getLink("site-administration") .
                   "&" .
                   Locales::getVariable("workplace") .
                   "=" .
                   Locales::getLink("pages");
    
    $varPages            = null;
    $varEditLinkPrefix   = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-page") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-page") . "&". Locales::getVariable("id") . "=";
    $varDeleteLinkPrefix = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-page") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-page") . "&" . Locales::getVariable("id") . "=";
    $varEditLinkSufix    =  "\">" . Locales::getCore("edit") . "</a>";
    $varDeleteLinkSufix  = "\">" . Locales::getCore("delete") . "</a>";
    $varOptionLinkAdd    = "<a href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add") . "\">" . Locales::getCore("add") . "</a>";
    
    // Create "Core" Elements.
    
    $hdCorePages         = new FHeader();
    $divOptionHolder     = new FDiv();
    $divHomepageOption   = new FDiv();
    $divTermsOption      = new FDiv();
    $divPrivacyOption    = new FDiv();
    $hdPages             = new FHeader();
    $parInfo             = new FParagraph();
    $tblPages            = new FTable();
    $rowInfo             = new FTableRow();
    $divOptionLinks      = new FDiv();
    
    // "Pages" Variable Settings.
    
    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

    $varPages = EasyGet::execute
    (
        "TS: pages",
        "CS: *"
    );
    
    // "Header Core Pages" Element Settings.
    
    $hdCorePages->setLevel(2);
    $hdCorePages->setContent(Locales::getTitle("core-pages"));
    
    // "Div Option Holder" Element Settings.
    
    $divOptionHolder->setID("core-pages-holder");

    $divOptionHolder->addElement($divHomepageOption);
    $divOptionHolder->addElement($divTermsOption);
    $divOptionHolder->addElement($divPrivacyOption);
    
    // "Div Homepage Option" Element Settings.
    
    $title = Locales::getCore("homepage");
    $link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-core-page") . "&" . Locales::getVariable("id") . "=1";

    $divHomepageOption->setClass("page-option");
    $divHomepageOption->addElement(new FAnchor("page-homepage", "core-page", $link, $title, $title));
    
    // "Div Terms Option" Element Settings.
    
    $title = Locales::getCore("terms-of-service");
    $link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-core-page") . "&" . Locales::getVariable("id") . "=2";

    $divTermsOption->setClass("page-option");
    $divTermsOption->addElement(new FAnchor("page-terms-of-service", "core-page", $link, $title, $title));
    
    // "Div Privacy Option" Element Settings.
    
    $title = Locales::getCore("privacy-policy");
    $link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-core-page") . "&" . Locales::getVariable("id") . "=3";

    $divPrivacyOption->setClass("page-option");
    $divPrivacyOption->addElement(new FAnchor("page-privacy-policy", "core-page", $link, $title, $title));
    
    // "Header Pages" Element Settings.
    
    $hdPages->setLevel(2);
    $hdPages->setContent(Locales::getTitle("dynamic-pages"));
    
    // "Paragraph Info" Element Settings.
    
    $parInfo->setID("ads-info");
    $parInfo->setClass("info-paragraph");
    $parInfo->setAlignment(FParagraph::ALN_CENTER);
    $parInfo->setContent(Locales::getParagraph("no-pages"));
    $parInfo->setLink($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add"));
    
    // "Table Pages" Element Settings.
    
    $tblPages->setID("pages-table");
    $tblPages->setClass("default-admin-table");
    $tblPages->setAlignment(FTable::ALN_CENTER);
    
    $tblPages->addRow($rowInfo);
    
    // "Row Info" Element Settings.
    
    $rowInfo->setClass("info-row");
    $rowInfo->addCell(new FTableCell(null, "table-cell-id", "#"));
    $rowInfo->addCell(new FTableCell(null, "table-cell-title", Locales::getCore("title")));
    $rowInfo->addCell(new FTableCell(null, "table-cell-published", Locales::getCore("published")));
    $rowInfo->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));
    
    // Loop Through All The Pages.
    
    if ($varPages != null)
    {
        foreach ($varPages as $loadedPage)
        {
            // Process Published Variable.

            if ($loadedPage["published"] == 0)
                $published = Locales::getCore("no");
            else
                $published = Locales::getCore("yes");

            // Create Temp Row.

            $tempRow = new FTableRow();

            $tempRow->addCell(new FTableCell(null, "table-cell-id", $loadedPage["id"]));
            $tempRow->addCell(new FTableCell(null, "table-cell-title", "<a href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-page") . "&". Locales::getVariable("id") . "=" . $loadedPage["id"] . "\">" . $loadedPage["title"] . "</a>"));
            $tempRow->addCell(new FTableCell(null, "table-cell-published", $published));
            $tempRow->addCell(new FTableCell(null, "table-cell-options", $varDeleteLinkPrefix . $loadedPage["id"] . $varDeleteLinkSufix . " " . $varEditLinkPrefix . $loadedPage["id"] . $varEditLinkSufix));

            // Add Temp Row To The Table.

            $tblPages->addRow($tempRow);
        }
    }
    
    // "Div Option Links" Element Settings.
    
    $divOptionLinks->setClass("option-links");
    $divOptionLinks->addElement("<strong>" . Locales::getCore("options") . ":</strong> $varOptionLinkAdd");
    
    // Append Elements To "Workplace" Element.
    
    $divWorkplace->addElement($hdCorePages);
    $divWorkplace->addElement($divOptionHolder);
    
    $divWorkplace->addElement($hdPages);
    
    if ($varPages == null)
        $divWorkplace->addElement($parInfo);
    else
    {
        $divWorkplace->addElement($tblPages);
        $divWorkplace->addElement($divOptionLinks);
    }
}

?>