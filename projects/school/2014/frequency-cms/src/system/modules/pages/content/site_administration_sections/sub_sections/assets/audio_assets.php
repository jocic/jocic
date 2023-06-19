<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: audio_assets.php                              *|
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
               Locales::getLink("assets") .
               "&" .
               Locales::getVariable("option") .
               "=" .
               Locales::getLink("audio-assets");

$varAssetLink         = CMS_ROOT . "assets/audio/";
$varErrorInfo         = null;

$varAssetNumber       = Assets::countAssets(Assets::TP_AUDIO_ASSETS);
$varAssets            = Assets::fetchAssets(Assets::TP_AUDIO_ASSETS);

// Create "Prefix And Sufix Stuff For Links" Variables.

$varEditAssetPrefix   = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-asset") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("edit-asset") . "&" . Locales::getVariable("id") . "=";
$varDeleteAssetPrefix = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-asset") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("delete-asset") . "&" . Locales::getVariable("id") . "=";

$varEditAssetSufix    = "\" />" . Locales::getCore("edit-asset") . "</a>";
$varDeleteAssetSufix  = "\" />" . Locales::getCore("delete-asset") . "</a>";

// Create "Core" Elements.

$parInfo        = new FParagraph();
$fmAddAsset     = new FForm();
$tblAddAsset    = new FTable();
$fmEditAsset    = new FForm();
$tblEditAsset   = new FTable();
$divAssets      = new FDiv();
$tblAssets      = new FTable();

// Create "Row" Elements.

$rowErrorInfo   = new FTableRow();
$rowAssetName   = new FTableRow();
$rowAssetFile   = new FTableRow();
$rowSubmit      = new FTAbleRow();
$rowExtensions  = new FTableRow();

// Create "Input" Elements.

$inpAssetName   = new FInput();
$inpAssetFile   = new FInput();
$btnReset       = new FButton();
$btnSubmit      = new FButton();

// "Error Info" Variable Settings.

if (!empty($_GET[Locales::getVariable("error")]))
{
    if ($_GET[Locales::getVariable("error")] == Locales::getErrorLink("post-size"))
        $varErrorInfo = Locales::getErrorContent("post-size");
    else if ($_GET[Locales::getVariable("error")] == Locales::getErrorLink("file-upload"))
        $varErrorInfo = Locales::getErrorContent("file-upload");
    else if ($_GET[Locales::getVariable("error")] == Locales::getErrorLink("file-size"))
        $varErrorInfo = Locales::getErrorContent("file-size");
    else if ($_GET[Locales::getVariable("error")] == Locales::getErrorLink("file-extension"))
        $varErrorInfo = Locales::getErrorContent("file-extension");
    else
        $varErrorInfo = Locales::getErrorContent("unknown-error");
    
    $varErrorInfo = "<strong>" . Locales::getCore("error") . ":</strong> " . $varErrorInfo;
}

// "Paragraph Info" Element Settings.

$parInfo->setID("assets-info");
$parInfo->setAlignment(FParagraph::ALN_CENTER);

if ($varAssetNumber == 0)
    $parInfo->setContent(Locales::getParagraph("no-audio-assets"));
else
    $parInfo->setContent(Locales::getParagraph("add-audio-asset"));

$parInfo->setLink($varCoreLink . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset")); 

// "Form Add Asset" Element Settings.

$fmAddAsset->setID("asset-main-form");
$fmAddAsset->setClass("default-form");
$fmAddAsset->setType("multipart/form-data");
$fmAddAsset->setMethod(FForm::MTD_POST);
$fmAddAsset->setAction($varCoreLink . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset"));

$fmAddAsset->addItem($tblAddAsset);

// "Table Add Asset" Element Settings.

$tblAddAsset->setID("manipulate-asset-table");
$tblAddAsset->setClass("default-admin-table");

if (!empty($varErrorInfo))
    $tblAddAsset->addRow($rowErrorInfo);

$tblAddAsset->addRow($rowAssetName);
$tblAddAsset->addRow($rowAssetFile);
$tblAddAsset->addRow($rowSubmit);
$tblAddAsset->addRow($rowExtensions);

// "Form Edit Asset" Element Settings.

$fmEditAsset->setID("asset-main-form");
$fmEditAsset->setClass("default-form");
$fmEditAsset->setMethod(FForm::MTD_POST);

$fmEditAsset->addItem($tblEditAsset);

// "Table Edit Asset" Element Settings.

$tblEditAsset->setID("manipulate-asset-table");
$tblEditAsset->setClass("default-admin-table");

$tblEditAsset->addRow($rowAssetName);
$tblEditAsset->addRow($rowSubmit);

// "Div Assets" Element Settings.

$divAssets->setID("assets-holder");

$divAssets->addElement($tblAssets);

// "Table Assets" Element Settings.

$tblAssets->setID("audio-assets-table");
$tblAssets->setClass("default-admin-table");

if ($varAssets != null)
{
    foreach ($varAssets as $asset)
    {
        // Create "Core" Elements.

        $tmpRowOne       = new FTableRow();
        $tmpRowTwo       = new FTableRow();
        $tmpRowThree     = new FTableRow();
        $tmpRowFour      = new FTableRow();
        $tmpRowFive      = new FTableRow();
        $tmpRowSeparator = new FTableRow();

        // "Temp Row One" Element Settings.

        $tmpRowOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("asset-name") . ":</strong>"));
        $tmpRowOne->addCell(new FTableCell(null, null, $asset["name"]));

        // "Temp Row Two" Element Settings.

        $tmpRowTwo->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("filename") . ":</strong>"));
        $tmpRowTwo->addCell(new FTableCell(null, null, $asset["filename"]));

        // "Temp Row Three" Element Settings.

        $tmpRowThree->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("html-object") . ":</strong>"));
        $tmpRowThree->addCell(new FTableCell(null, null, "<input type='text' value='<object data=\"" . $varAssetLink . $asset["filename"] . "\" height=\"50\" width=\"150\" border=\"1\"></object>' />"));

        // "Temp Row Four" Element Settings.

        $tmpRowFour->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("asset-link") . ":</strong>"));
        $tmpRowFour->addCell(new FTableCell(null, null, "<input type='text' value='<a href=\"" . $varAssetLink . $asset["filename"] . "\" target=\"_blank\">Link</a>' />"));

        // "Temp Row Four" Element Settings.

        $tmpRowFive->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("options") . ":</strong>"));
        $tmpRowFive->addCell(new FTableCell(null, null, $varEditAssetPrefix . $asset["id"] . $varEditAssetSufix . " " . $varDeleteAssetPrefix . $asset["id"] . $varDeleteAssetSufix));

        // "Temp Row Six" Element Settings.

        $tmpRowSeparator->addCell(new FTableCell(null, null, new FDiv(null, "asset-separator"), 2));

        // Append Element To "Table" Element.

        $tblAssets->addRow($tmpRowOne);
        $tblAssets->addRow($tmpRowTwo);
        $tblAssets->addRow($tmpRowThree);
        $tblAssets->addRow($tmpRowFour);
        $tblAssets->addRow($tmpRowFive);
        $tblAssets->addRow($tmpRowSeparator);
    }
}

// "Row Error Info" Element Settings.

$rowErrorInfo->addCell(new FTableCell(null, null, $varErrorInfo, 2, null, FTableCell::ALN_CENTER));

// "Row Asset Name" Element Settings.

$rowAssetName->addCell(new FTableCell(null, "left-side", "<strong>" . Locales::getCore("asset-name") . ":</strong>"));
$rowAssetName->addCell(new FTableCell(null, "right-side", $inpAssetName));

// "Row Asset File" Element Settings.

$rowAssetFile->addCell(new FTableCell(null, "left-side", "<strong>" . Locales::getCore("asset-file") . ":</strong>"));
$rowAssetFile->addCell(new FTableCell(null, "right-side", $inpAssetFile));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));

// "Row Extensions" Element Settings.

$rowExtensions->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("allowed-extensions") . ":</strong> .mp3, .wma", 2));

// "Input Asset Name" Element Settings.

$inpAssetName->setID("asset-name-input");
$inpAssetName->setClass("form-input");
$inpAssetName->setType("text");
$inpAssetName->setMaxLength(100);
$inpAssetName->setName("req_name");

// "Input Asset File" Element Settings.

$inpAssetFile->setID("asset-file-input");
$inpAssetFile->setClass("form-input");
$inpAssetFile->setType("file");
$inpAssetFile->setName("req_file");

// "Button Reset" Element Settings.

$btnReset->setID("asset-reset-button");
$btnReset->setClass("form-button");
$btnReset->setType(FButton::TP_RESET);
$btnReset->setContent(Locales::getCore("reset"));

// "Button Submit" Element Settings.

$btnSubmit->setID("asset-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);

// Append Elements To "Workplace" Element.

if (!empty($_GET[Locales::getVariable("suboption")]))
{
    if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset"))
    {
        $btnSubmit->setContent(Locales::getCore("upload"));
        
        $divDetailsHolder->addElement($fmAddAsset);
    }
    else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset"))
    {
        if (!empty($_GET[Locales::getVariable("id")]))
        {
            $fmEditAsset->setAction($varCoreLink . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("edit-asset") . "&" . Locales::getVariable("id") . "=" . $_GET[Locales::getVariable("id")]);
            
            $inpAssetName->setContent(Assets::fetchAssetName($_GET[Locales::getVariable("id")]));
        }
        
        $btnSubmit->setContent(Locales::getCore("edit"));
        
        $divDetailsHolder->addElement($fmEditAsset);
    }
    else
        $divDetailsHolder->addElement($parInfo);
}
else
    $divDetailsHolder->addElement($parInfo);

if ($varAssets != null)
    $divDetailsHolder->addElement($divAssets);

?>