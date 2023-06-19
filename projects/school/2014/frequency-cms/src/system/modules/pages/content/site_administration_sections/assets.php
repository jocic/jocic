<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: assets.php                                    *|
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
               Locales::getLink("assets");

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "assets" .
                    DIRECTORY_SEPARATOR;

// Create "Core" Elements.

$divOptionHolder   = new FDiv();
$divPictureAssets  = new FDiv();
$divVideoAssets    = new FDiv();
$divAudioAssets    = new FDiv();
$divArchiveAssets  = new FDiv();
$divDocumentAssets = new FDiv();
$divOtherAssets    = new FDiv();
$divDetailsHolder  = new FDiv();

// "Option Holder" Element Settings.

$divOptionHolder->setID("option-holder");

$divOptionHolder->addElement($divPictureAssets);
$divOptionHolder->addElement($divVideoAssets);
$divOptionHolder->addElement($divAudioAssets);
$divOptionHolder->addElement($divArchiveAssets);
$divOptionHolder->addElement($divDocumentAssets);
$divOptionHolder->addElement($divOtherAssets);

// "Picture Assets" Element Settings.

$title = Locales::getCore("picture-assets");
$link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets");

$divPictureAssets->setClass("asset-option");
$divPictureAssets->addElement(new FAnchor("picture-assets", "asset-link", $link, $title, $title));

// "Video Assets" Element Settings.

$title = Locales::getCore("video-assets");
$link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets");

$divVideoAssets->setClass("asset-option");
$divVideoAssets->addElement(new FAnchor("video-assets", "asset-link", $link, $title, $title));

// "Audio Assets" Element Settings.

$title = Locales::getCore("audio-assets");
$link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets");

$divAudioAssets->setClass("asset-option");
$divAudioAssets->addElement(new FAnchor("audio-assets", "asset-link", $link, $title, $title));

// "Archive Assets" Element Settings.

$title = Locales::getCore("archive-assets");
$link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets");

$divArchiveAssets->setClass("asset-option");
$divArchiveAssets->addElement(new FAnchor("archive-assets", "asset-link", $link, $title, $title));

// "Document Assets" Element Settings.

$title = Locales::getCore("document-assets");
$link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets");

$divDocumentAssets->setClass("asset-option");
$divDocumentAssets->addElement(new FAnchor("document-assets", "asset-link", $link, $title, $title));

// "Other Assets" Element Settings.

$title = Locales::getCore("other-assets");
$link  = $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets");

$divOtherAssets->setClass("asset-option");
$divOtherAssets->addElement(new FAnchor("other-assets", "asset-link", $link, $title, $title));

// "Details" Element Settings.

$divDetailsHolder->setID("details-holder");

if (empty($_GET[Locales::getVariable("option")]))
{
    // Create "Core" Elements.
    
    $parInfo = new FParagraph();
    
    // "Paragraph Info" Element Settings.

    $parInfo->setID("assets-info");
    $parInfo->setAlignment(FParagraph::ALN_CENTER);
    $parInfo->setContent(Locales::getParagraph("select-an-asset"));
    
    $divDetailsHolder->addElement($parInfo);
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("picture-assets"))
{
    require_once $varSubScriptRoot . "picture_assets.php";
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("video-assets"))
{
    require_once $varSubScriptRoot . "video_assets.php";
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("audio-assets"))
{
    require_once $varSubScriptRoot . "audio_assets.php";
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("archive-assets"))
{
    require_once $varSubScriptRoot . "archive_assets.php";
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("document-assets"))
{
    require_once $varSubScriptRoot . "document_assets.php";
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("other-assets"))
{
    require_once $varSubScriptRoot . "other_assets.php";
}

// Append Elements To "Workplace".

$divWorkplace->addElement($divOptionHolder);
$divWorkplace->addElement($divDetailsHolder);

?>