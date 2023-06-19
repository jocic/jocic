<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: themes.php                                    *|
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

$varCoreLink       = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes");
$varStyles         = Styles::getAll();
$varActivatePrefix = "<a href=\"" . "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("themes") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("activate-theme") .  "&" . Locales::getVariable("value") . "=";
$varActivateSufix  = "\">" . Locales::getCore("activate-theme") . "</a>";
$varActiveTheme    = Core::get(Core::SELECTED_THEME);
$varThemeNumber    = 1;
$varThemeDirs      = scandir(DOC_ROOT . DIRECTORY_SEPARATOR . "themes");
$varEditPrefix     = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-style") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-style") . "&" . Locales::getVariable("id") . "=";
$varEditSufix      = "\">" . Locales::getCore("edit-advert") . "</a>";
$varDeletePrefix   = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-style") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-style") . "&" . Locales::getVariable("id") . "=";
$varDeleteSufix    = "\">" . Locales::getCore("delete-advert") . "</a>";

// Create "Core" Elements.

$hdThemes          = new FHeader();
$divThemeHolder    = new FDiv();
$hdCustomCSS       = new FHeader();
$tblCustomCSS      = new FTable();
$parNoCSStyles     = new FParagraph();
$divOptionLinks    = new FDiv();
$hdAddCustomCSS    = new FHeader();
$fmCustomCSS       = new FForm();
$tblCustomCSSInp   = new FTable();
$hdEditCustomCSS   = new FHeader();

// Create "Row" Elements.

$rowInfoRow        = new FTableRow();
$rowName           = new FTableRow();
$rowContent        = new FTableRow();
$rowSubmit         = new FTableRow();

// Create "Input" Elements.

$inpName           = new FInput();
$txtContent        = new FTextArea();
$btnReset          = new FButton();
$btnSubmit         = new FButton();

// "Header Themes" Element Settings.

$hdThemes->setLevel(2);
$hdThemes->setContent(Locales::getTitle("available-themes"));

// "Div Theme Holder" Element Settings.

$divThemeHolder->setID("theme-holder");

// Append Themes.

foreach ($varThemeDirs as $varDir)
{
    if ($varDir === "." || $varDir === "..")
        continue;
    else
    {
        // Create "Temp" Variable For Theme Location.
        
        $tempRoot = DOC_ROOT . DIRECTORY_SEPARATOR . "themes" . DIRECTORY_SEPARATOR . $varDir . DIRECTORY_SEPARATOR;

        // Check Theme Files.

        if (file_exists($tempRoot . "info.xml") &&
            file_exists($tempRoot . "thumb.png") &&
            file_exists($tempRoot . "pages" . DIRECTORY_SEPARATOR . "default_page.html"))
        {
            // Create "Temp" Variables.
            
            $tempXMLData             = simplexml_load_file($tempRoot . "info.xml");
            $tempName                = htmlentities($tempXMLData->name);
            $tempDescription         = htmlentities($tempXMLData->description);
            $tempAuthor              = htmlentities($tempXMLData->author);
            $tempYear                = htmlentities($tempXMLData->year);
            $tempVersion             = htmlentities($tempXMLData->version);
            $tempContact             = htmlentities($tempXMLData->contact);
            $tempWebsite             = htmlentities($tempXMLData->website);
            $tempOptions             = null;
            
            // Create "Temp" Elements.
            
            $tempDivThemeSection     = new FDiv();
            $tempTblThemeInfo        = new FTable();
            
            // Create "Temp Row" Elements.
            
            $tempRowThemeIcon        = new FTableRow();
            $tempRowThemeName        = new FTableRow();
            $tempRowThemeDescription = new FTableRow();
            $tempRowThemePublished   = new FTableRow();
            $tempRowThemeAuthor      = new FTableRow();
            $tempRowThemeWebsite     = new FTableRow();
            $tempRowThemeContact     = new FTableRow();
            $tempRowThemeOptions     = new FTableRow();
            
            // "Options" Temp Variable Settings.

            if ($varDir == $varActiveTheme)
                $tempOptions = Locales::getCore("none") . " - " . Locales::getText("theme-is-active");
            else
                $tempOptions = $varActivatePrefix . $varDir . $varActivateSufix;

            // "Name" Temp Variable Settings.

            if ($tempName == null)
                $tempName = Locales::getCore("unknown-theme");
            
            // "Description" Temp Variable Settings.

            if ($tempDescription == null)
                $tempDescription = Locales::getCore("unknown-description");
            
            // "Author" Temp Variable Settings.

            if ($tempAuthor == null)
                $tempAuthor = Locales::getCore("unknown-author");
            else
                $tempAuthor = $tempAuthor;
            
            // "Year" Temp Variable Settings.

            if ($tempYear == null)
                $tempYear = Locales::getCore("unknown-year");
            else
                $tempYear =  $tempYear;

            // "Version" Temp Variable Settings.
            
            if ($tempVersion == null)
                $tempVersion = Locales::getCore("unknown-version");
            
            // "Contact" Temp Variable Settings.

            if ($tempContact == null)
                $tempContact = Locales::getCore("unknown-contact");
            else
                $tempContact = $tempContact;

            // "Website" Temp Variable Settings.
            
            if ($tempWebsite == null)
                $tempWebsite = Locales::getCore("unknown-website");
            else
                $tempWebsite = "<a href=\"$tempWebsite\">$tempWebsite</a>";

            // "Div Theme Section" Temp Element Settings.
            
            $tempDivThemeSection->setID("theme-$varThemeNumber");
            $tempDivThemeSection->setClass("theme-section");
            
            $tempDivThemeSection->addElement($tempTblThemeInfo);
            
            // "Table Theme Info" Temp Element Settings.
            
            $tempTblThemeInfo->setID("theme-info-$varThemeNumber");
            $tempTblThemeInfo->setClass("theme-info");
            
            $tempTblThemeInfo->addRow($tempRowThemeIcon);
            $tempTblThemeInfo->addRow($tempRowThemeName);
            $tempTblThemeInfo->addRow($tempRowThemeDescription);
            $tempTblThemeInfo->addRow($tempRowThemePublished);
            $tempTblThemeInfo->addRow($tempRowThemeAuthor);
            $tempTblThemeInfo->addRow($tempRowThemeWebsite);
            $tempTblThemeInfo->addRow($tempRowThemeContact);
            $tempTblThemeInfo->addRow($tempRowThemeOptions);
            
            // "Row Theme Icon" Temp Element Settings.
            
            $tempRowThemeIcon->setID("theme-icon-$varThemeNumber");
            $tempRowThemeIcon->setClass("theme-icon");
            
            $tempRowThemeIcon->addCell(new FTableCell(null, null, "<img src=\"./themes/$varDir/thumb.png" . "\" />", null, 8));
            
            // "Row Theme Name" Temp Element Settings.
            
            $tempRowThemeName->setID("theme-name-$varThemeNumber");
            $tempRowThemeName->setClass("theme-name");
            
            $tempRowThemeName->addCell(new FTableCell(null, null, $tempName . " - " . $tempVersion, 2));
            
            // "Row Theme Description" Temp Element Settings.
            
            $tempRowThemeDescription->setID("theme-description-$varThemeNumber");
            $tempRowThemeDescription->setClass("theme-description");
            
            $tempRowThemeDescription->addCell(new FTableCell(null, null, $tempDescription, 2));
            
            // "Row Theme Published" Temp Element Settings.
            
            $tempRowThemePublished->setID("theme-published-$varThemeNumber");
            $tempRowThemePublished->setClass("theme-published");
            
            $tempRowThemePublished->addCell(new FTableCell(null, "info-cell", "<strong>" . Locales::getCore("published") . ":</strong>"));
            $tempRowThemePublished->addCell(new FTableCell(null, null, $tempYear));
            
            // "Row Theme Author" Temp Element Settings.
            
            $tempRowThemeAuthor->setID("theme-author-$varThemeNumber");
            $tempRowThemeAuthor->setClass("theme-author");
            
            $tempRowThemeAuthor->addCell(new FTableCell(null, "info-cell", "<strong>" . Locales::getCore("author") . ":</strong>"));
            $tempRowThemeAuthor->addCell(new FTableCell(null, null, $tempAuthor));
            
            // "Row Theme Website" Temp Element Settings.
            
            $tempRowThemeWebsite->setID("theme-website-$varThemeNumber");
            $tempRowThemeWebsite->setClass("theme-website");
            
            $tempRowThemeWebsite->addCell(new FTableCell(null, "info-cell", "<strong>" . Locales::getCore("website") . ":</strong>"));
            $tempRowThemeWebsite->addCell(new FTableCell(null, null, $tempWebsite));
            
            // "Row Theme Contact" Temp Element Settings.
            
            $tempRowThemeContact->setID("theme-contact-$varThemeNumber");
            $tempRowThemeContact->setClass("theme-contact");
            
            $tempRowThemeContact->addCell(new FTableCell(null, "info-cell", "<strong>" . Locales::getCore("contact") . ":</strong>"));
            $tempRowThemeContact->addCell(new FTableCell(null, null, $tempContact));
            
            // "Row Theme Contact" Temp Element Settings.
            
            $tempRowThemeOptions->setID("theme-options-$varThemeNumber");
            $tempRowThemeOptions->setClass("theme-options");
            
            $tempRowThemeOptions->addCell(new FTableCell(null, "info-cell", "<strong>" . Locales::getCore("options") . ":</strong>"));
            $tempRowThemeOptions->addCell(new FTableCell(null, null, $tempOptions));
            
            // Append The Child Element.
            
            $divThemeHolder->addElement($tempDivThemeSection);
            
            // Increment Theme Number.
            
            $varThemeNumber ++;
        }
    }
}

// "Header Custom CSS" Element Settings.

$hdCustomCSS->setLevel(2);
$hdCustomCSS->setContent(Locales::getTitle("custom-css-styles"));

// "Paragraph No CSS Styles" Element Settings.

$parNoCSStyles->setClass("info-paragraph");
$parNoCSStyles->setAlignment(FParagraph::ALN_CENTER);
$parNoCSStyles->setContent(Locales::getParagraph("no-css-styles-added"));

// "Table Custom CSS" Element Settings.

$tblCustomCSS->setID("custom-css-table");
$tblCustomCSS->setClass("default-admin-table");

$tblCustomCSS->addRow($rowInfoRow);

if ($varStyles != null)
{
    foreach ($varStyles as $varStyle)
    {
        // Create "Temp" Rows.
        
        $tempRowStyle = new FTableRow();
        
        // "Row Style" Temp Element Settings.
        
        $tempRowStyle->addCell(new FTableCell(null, "table-cell-1", $varStyle["id"]));
        $tempRowStyle->addCell(new FTableCell(null, "table-cell-2", "<a title=\"" . Locales::getCore("edit-style") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-style") . "&" . Locales::getVariable("id") . "=" . $varStyle["id"] . "\">" . $varStyle["name"] . "</a>"));
        $tempRowStyle->addCell(new FTableCell(null, "table-cell-3", $varEditPrefix . $varStyle["id"] . $varEditSufix . $varDeletePrefix . $varStyle["id"] . $varDeleteSufix));
        
        // Append Elements To "Table Custom CSS" Element.
        
        $tblCustomCSS->addRow($tempRowStyle);
    }
}

// "Div Option Links" Element Settings.

$divOptionLinks->setClass("option-links");

$divOptionLinks->addElement("<strong>" . Locales::getCore("options") . ":</strong>");
$divOptionLinks->addElement(new FAnchor(null, null, $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-style"), null, Locales::getCore("add-style")));

// "Header Add Style" Element Settings.

$hdAddCustomCSS->setLevel(2);
$hdAddCustomCSS->setContent(Locales::getTitle("add-css-style"));

// "Header Edit Style" Element Settings.

$hdEditCustomCSS->setLevel(2);
$hdEditCustomCSS->setContent(Locales::getTitle("edit-css-style"));

// "Form Custom CSS" Element Settings.

$fmCustomCSS->setID("custom-css-form");
$fmCustomCSS->setClass("default-form");
$fmCustomCSS->setMethod(FForm::MTD_POST);

$fmCustomCSS->addItem($tblCustomCSSInp);

// "Table Custom CSS Input" Element Settings.

$tblCustomCSSInp->setID("custom-css-input-table");
$tblCustomCSSInp->setClass("default-admin-table");

$tblCustomCSSInp->addRow($rowName);
$tblCustomCSSInp->addRow($rowContent);
$tblCustomCSSInp->addRow($rowSubmit);

// "Row Info Row" Element Settings.

$rowInfoRow->setID("adverts-info-row");
$rowInfoRow->setClass("info-row");

$rowInfoRow->addCell(new FTableCell(null, "table-cell-1", "#"));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-2", Locales::getCore("name")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-3", Locales::getCore("options")));

// "Row Name" Element Settings.

$rowName->addCell(new FTableCell(null, null, new FLabel("name", Locales::getCore("name"))));
$rowName->addCell(new FTableCell(null, null, $inpName));

// "Row Content" Element Settings.

$rowContent->addCell(new FTableCell("css-content-title", null, new FLabel("content", Locales::getCore("content"))));
$rowContent->addCell(new FTableCell("css-content-editor", null, $txtContent));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));

// "Input Name" Element Settings.

$inpName->setID("name-input");
$inpName->setClass("form-input");
$inpName->setType(FInput::TP_TEXT);
$inpName->setMaxLength(200);
$inpName->setName("req_name");

if (!empty($_GET[Locales::getVariable("id")]))
{
    $tempID   = $_GET[Locales::getVariable("id")];
    $tempName = null;
    
    if (Styles::isStyleCreated($tempID))
    {
        $tempName = Styles::getStyle($tempID);
        $tempName = $tempName["name"];
        
        $inpName->setContent($tempName);
    }
}

// "Textarea Content" Element Settings.

$txtContent->setID("content-input");
$txtContent->setClass("form-textarea");
$txtContent->setName("req_content");

if (!empty($_GET[Locales::getVariable("id")]))
{
    $tempID      = $_GET[Locales::getVariable("id")];
    $tempContent = null;
    
    if (Styles::isStyleCreated($tempID))
    {
        $tempContent = Styles::getStyle($tempID);
        $tempContent = $tempContent["content"];
        
        $txtContent->setContent($tempContent);
    }
}

// "Button Reset" Element Settings.

$btnReset->setID("custom-css-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("custom-css-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("submit"));

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($hdThemes);
$divWorkplace->addElement($divThemeHolder);

if (isset($_GET[Locales::getVariable("option")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-style"))
    {
        $fmCustomCSS->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-style"));
        
        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ace/ace.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ace/ace_implement_css.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement($hdAddCustomCSS);
        $divWorkplace->addElement($fmCustomCSS);
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-style"))
    {
        $fmCustomCSS->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-style") . "&" . Locales::getVariable("id") . "=" . $_GET[Locales::getVariable("id")]);
        
        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ace/ace.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement("<script src=\"../../../../system/assets/scripts/ace/ace_implement_css.js\" type=\"text/javascript\"></script>");
        $divWorkplace->addElement($hdEditCustomCSS);
        $divWorkplace->addElement($fmCustomCSS);
    }
    else
    {
        $divWorkplace->addElement($hdCustomCSS);
        
        if ($varStyles == null)
            $divWorkplace->addElement($parNoCSStyles);
        else
            $divWorkplace->addElement($tblCustomCSS);

        $divWorkplace->addElement($divOptionLinks);
    }
}
else
{
    $divWorkplace->addElement($hdCustomCSS);
    
    if ($varStyles == null)
        $divWorkplace->addElement($parNoCSStyles);
    else
        $divWorkplace->addElement($tblCustomCSS);

    $divWorkplace->addElement($divOptionLinks);
}

?>