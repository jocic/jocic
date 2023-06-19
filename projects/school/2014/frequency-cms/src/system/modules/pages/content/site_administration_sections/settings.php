<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: settings.php                                  *|
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

$varCoreLink           = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("settings");

$varCharsets           = array("utf-8", "windows-1256", "windows-1257", "iso-8859-6");

// Create "Core" Elements.

$hdCoreSettings        = new FHeader();
$fmCoreSettings        = new FForm();
$tblCoreSettings       = new FTable();

// Create "Row" Elements.

$rowWebsiteTitle       = new FTableRow();
$rowWebsiteTitleSufix  = new FTableRow();
$rowWebsiteBase        = new FTableRow();
$rowWebsiteCharset     = new FTableRow();
$rowWebsiteKeywords    = new FTableRow();
$rowWebsiteDescription = new FTableRow();
$rowOfficialEmail      = new FTableRow();
$rowRegistrationMode   = new FTableRow();
$rowSocialIntegration  = new FTableRow();
$rowShowLatestPages    = new FTableRow();
$rowSubmit             = new FTableRow();

// Create "Input" Elements.

$inpWebsiteTitle       = new FInput();
$inpWebsiteTitleSufix  = new FInput();
$inpWebsiteBase        = new FInput();
$selWebsiteCharset     = new FSelect();
$inpWebsiteKeywords    = new FInput();
$inpWebsiteDescription = new FInput();
$inpOfficialEmail      = new FInput();
$selRegistrationMode   = new FSelect();
$selSocialIntegration  = new FSelect();
$selShowLatestPages    = new FSelect();
$btnReset              = new FButton();
$btnSubmit             = new FButton();

// "Header Core Settings" Element Settings.

$hdCoreSettings->setLevel(2);
$hdCoreSettings->setContent(Locales::getTitle("core-settings"));

// "Form Core Settings" Element Settings.

$fmCoreSettings->setID("core-settings-form");
$fmCoreSettings->setClass("default-form");
$fmCoreSettings->setMethod(FForm::MTD_POST);
$fmCoreSettings->setAction($varCoreLink);

$fmCoreSettings->addItem($tblCoreSettings);

// "Table Core Settings" Element Settings.

$tblCoreSettings->setID("core-settings-table");
$tblCoreSettings->setClass("default-admin-table");

$tblCoreSettings->addRow($rowWebsiteTitle);
$tblCoreSettings->addRow($rowWebsiteTitleSufix);
$tblCoreSettings->addRow($rowWebsiteBase);
$tblCoreSettings->addRow($rowWebsiteCharset);
$tblCoreSettings->addRow($rowWebsiteKeywords);
$tblCoreSettings->addRow($rowWebsiteDescription);
$tblCoreSettings->addRow($rowOfficialEmail);
$tblCoreSettings->addRow($rowRegistrationMode);
$tblCoreSettings->addRow($rowSocialIntegration);
$tblCoreSettings->addRow($rowShowLatestPages);
$tblCoreSettings->addRow($rowSubmit);

// "Row Website Title" Element Settings.

$rowWebsiteTitle->setID("website-title-row");

$rowWebsiteTitle->addCell(new FTableCell(null, "table-cell-1", new FLabel("website-title", Locales::getCore("website-title"))));
$rowWebsiteTitle->addCell(new FTableCell(null, "table-cell-2", $inpWebsiteTitle));

// "Row Website Title Sufix" Element Settings.

$rowWebsiteTitleSufix->setID("website-title-sufix-row");

$rowWebsiteTitleSufix->addCell(new FTableCell(null, "table-cell-1", new FLabel("website-title-sufix", Locales::getCore("website-title-sufix"))));
$rowWebsiteTitleSufix->addCell(new FTableCell(null, "table-cell-2", $inpWebsiteTitleSufix));

// "Row Website Base" Element Settings.

$rowWebsiteBase->setID("website-base-row");

$rowWebsiteBase->addCell(new FTableCell(null, "table-cell-1", new FLabel("website-base", Locales::getCore("website-base"))));
$rowWebsiteBase->addCell(new FTableCell(null, "table-cell-2", $inpWebsiteBase));

// "Row Website Charset" Element Settings.

$rowWebsiteCharset->setID("website-charset-row");

$rowWebsiteCharset->addCell(new FTableCell(null, "table-cell-1", new FLabel("website-charset", Locales::getCore("website-charset"))));
$rowWebsiteCharset->addCell(new FTableCell(null, "table-cell-2", $selWebsiteCharset));

// "Row Website Keywords" Element Settings.

$rowWebsiteKeywords->setID("website-keywords-row");

$rowWebsiteKeywords->addCell(new FTableCell(null, "table-cell-1", new FLabel("website-keywords", Locales::getCore("website-keywords"))));
$rowWebsiteKeywords->addCell(new FTableCell(null, "table-cell-2", $inpWebsiteKeywords));

// "Row Website Description" Element Settings.

$rowWebsiteDescription->setID("website-description-row");

$rowWebsiteDescription->addCell(new FTableCell(null, "table-cell-1", new FLabel("website-description", Locales::getCore("website-description"))));
$rowWebsiteDescription->addCell(new FTableCell(null, "table-cell-2", $inpWebsiteDescription));

// "Row Website Description" Element Settings.

$rowOfficialEmail->setID("official-email-row");

$rowOfficialEmail->addCell(new FTableCell(null, "table-cell-1", new FLabel("official-email", Locales::getCore("official-email"))));
$rowOfficialEmail->addCell(new FTableCell(null, "table-cell-2", $inpOfficialEmail));

// "Row Registration Mode" Element Settings.

$rowRegistrationMode->setID("registration-mode-row");

$rowRegistrationMode->addCell(new FTableCell(null, "table-cell-1", new FLabel("registration-mode", Locales::getCore("registration-mode"))));
$rowRegistrationMode->addCell(new FTableCell(null, "table-cell-2", $selRegistrationMode));

// "Row Social Integration" Element Settings.

$rowSocialIntegration->setID("social-integration-row");

$rowSocialIntegration->addCell(new FTableCell(null, "table-cell-1", new FLabel("social-integration", Locales::getCore("social-integration"))));
$rowSocialIntegration->addCell(new FTableCell(null, "table-cell-2", $selSocialIntegration));

// "Row Show Latest Pages" Element Settings.

$rowShowLatestPages->setID("show-latest-pages-row");

$rowShowLatestPages->addCell(new FTableCell(null, "table-cell-1", new FLabel("show-latest-pages", Locales::getCore("show-latest-pages"))));
$rowShowLatestPages->addCell(new FTableCell(null, "table-cell-2", $selShowLatestPages));

// "Row Submit" Element Settings.

$rowSubmit->setID("submit-row");

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));

// "Input Website Title" Element Settings.

$inpWebsiteTitle->setMaxLength(255);
$inpWebsiteTitle->setType(FInput::TP_TEXT);
$inpWebsiteTitle->setName("req_title");
$inpWebsiteTitle->setContent(Core::get(Core::WEBSITE_TITLE));

// "Input Website Title Sufix" Element Settings.

$inpWebsiteTitleSufix->setMaxLength(255);
$inpWebsiteTitleSufix->setType(FInput::TP_TEXT);
$inpWebsiteTitleSufix->setName("req_title_sufix");
$inpWebsiteTitleSufix->setContent(Core::get(Core::WEBSITE_TITLE_SUFIX));

// "Input Website Base" Element Settings.

$inpWebsiteBase->setMaxLength(255);
$inpWebsiteBase->setType(FInput::TP_TEXT);
$inpWebsiteBase->setName("req_base");
$inpWebsiteBase->setContent(Core::get(Core::WEBSITE_BASE));

// "Select Charset" Element Settings.

$selWebsiteCharset->setClass("form-select");

$tempCharset = Core::get(Core::WEBSITE_CHARSET);

for ($i = 0; $i < count($varCharsets); $i ++)
{
    $tempSelected = $varCharsets[$i] == $tempCharset;
        
    $selWebsiteCharset->addOption(new FSelectOption($varCharsets[$i], $varCharsets[$i], $tempSelected));
}

unset($tempCharset);

$selWebsiteCharset->setName("req_charset");

// "Input Website Keywords" Element Settings.

$inpWebsiteKeywords->setMaxLength(255);
$inpWebsiteKeywords->setType(FInput::TP_TEXT);
$inpWebsiteKeywords->setName("req_keywords");
$inpWebsiteKeywords->setContent(Core::get(Core::WEBSITE_KEYWORDS));

// "Input Website Description" Element Settings.

$inpWebsiteDescription->setMaxLength(255);
$inpWebsiteDescription->setType(FInput::TP_TEXT);
$inpWebsiteDescription->setName("req_description");
$inpWebsiteDescription->setContent(Core::get(Core::WEBSITE_DESCRIPTION));

// "Input Official Email" Element Settings.

$inpOfficialEmail->setMaxLength(255);
$inpOfficialEmail->setType(FInput::TP_TEXT);
$inpOfficialEmail->setName("req_email");
$inpOfficialEmail->setContent(Core::get(Core::WEBSITE_MAIL));

// "Select Registration Mode" Element Settings.

$selRegistrationMode->setClass("form-select");

$tempMode = Core::get(Core::REGISTRAION_MODE);

if ($tempMode == "minimal")
    $selRegistrationMode->addOption(new FSelectOption("minimal", Locales::getCore("minimal"), true));
else
    $selRegistrationMode->addOption(new FSelectOption("minimal", Locales::getCore("minimal"), false));

if ($tempMode == "normal")
    $selRegistrationMode->addOption(new FSelectOption("normal", Locales::getCore("normal"), true));
else
    $selRegistrationMode->addOption(new FSelectOption("normal", Locales::getCore("normal"), false));

if ($tempMode == "full")
    $selRegistrationMode->addOption(new FSelectOption("full", Locales::getCore("full"), true));
else
    $selRegistrationMode->addOption(new FSelectOption("full", Locales::getCore("full"), false));

unset($tempMode);

$selRegistrationMode->setName("req_mode");

// "Select Social Integration" Element Settings.

$selSocialIntegration->setClass("form-select");

$tempMode = Core::get(Core::SOCIAL_INTEGRATION);

if ($tempMode == "yes")
    $selSocialIntegration->addOption(new FSelectOption("yes", Locales::getCore("yes"), true));
else
    $selSocialIntegration->addOption(new FSelectOption("yes", Locales::getCore("yes"), false));

if ($tempMode == "no")
    $selSocialIntegration->addOption(new FSelectOption("no", Locales::getCore("no"), true));
else
    $selSocialIntegration->addOption(new FSelectOption("no", Locales::getCore("no"), false));

unset($tempMode);

$selSocialIntegration->setName("req_social");

// "Select Show Latest Pages" Element Settings.

$selShowLatestPages->setClass("form-select");

$tempMode = Core::get(Core::SHOW_LATEST_PAGES);

if ($tempMode == "yes")
    $selShowLatestPages->addOption(new FSelectOption("yes", Locales::getCore("yes"), true));
else
    $selShowLatestPages->addOption(new FSelectOption("yes", Locales::getCore("yes"), false));

if ($tempMode == "no")
    $selShowLatestPages->addOption(new FSelectOption("no", Locales::getCore("no"), true));
else
    $selShowLatestPages->addOption(new FSelectOption("no", Locales::getCore("no"), false));

unset($tempMode);

$selShowLatestPages->setName("req_latest_pages");

// "Button Reset" Element Settings.

$btnReset->setID("core-settings-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("core-settings-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("apply"));

// Append Elements To "Workplace".

$divWorkplace->addElement($hdCoreSettings);
$divWorkplace->addElement($fmCoreSettings);

?>