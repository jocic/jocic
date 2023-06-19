<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_section.php                           *|
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

$varCoreLink      = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("earnings");
$varAdverts       = Adverts::getAll();
$varEditPrefix    = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-advert") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-advert") . "&" . Locales::getVariable("id") . "=";
$varEditSufix     = "\">" . Locales::getCore("edit-advert") . "</a>";
$varDeletePrefix  = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-advert") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-advert") . "&" . Locales::getVariable("id") . "=";
$varDeleteSufix   = "\">" . Locales::getCore("delete-advert") . "</a>";

// Create "Core" Elements.

$hdEarnings       = new FHeader();
$tblAdverts       = new FTable();
$parNoAdvertsInfo = new FParagraph();
$divOptionLinks   = new FDiv();

// Create "Row" Elements.

$rowInfoRow       = new FTableRow();

// "Header Earnings" Element Settings.

$hdEarnings->setLevel(2);
$hdEarnings->setContent(Locales::getTitle("site-advertisments"));

// "Table Adverts" Element Settings.

$tblAdverts->setID("adverts-table");
$tblAdverts->setClass("default-admin-table");

$tblAdverts->addRow($rowInfoRow);

if ($varAdverts != null)
{
    foreach ($varAdverts as $varAdvert)
    {
        // "Section" Variable Settings.
        
        if ($varAdvert["section"] == 0)
            $varAdvert["section"] = Locales::getCore("advert-section-1");
        else if ($varAdvert["section"] == 1)
            $varAdvert["section"] = Locales::getCore("advert-section-2");
        else if ($varAdvert["section"] == 2)
            $varAdvert["section"] = Locales::getCore("advert-section-3");
        else if ($varAdvert["section"] == 3)
            $varAdvert["section"] = Locales::getCore("advert-section-4");
        else if ($varAdvert["section"] == 4)
            $varAdvert["section"] = Locales::getCore("advert-section-5");
        
        // Create "Temp" Elements.

        $tempRowAdvert = new FTableRow();

        // "Row Advert" Temp Element Settings.

        $tempRowAdvert->addCell(new FTableCell(null, "table-cell-1", $varAdvert["id"]));
        $tempRowAdvert->addCell(new FTableCell(null, "table-cell-2", "<a title=\"" . Locales::getCore("edit-advert") . "\" href=\"" . $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-advert") . "&" . Locales::getVariable("id") . "=" . $varAdvert["id"] . "\">" . $varAdvert["name"] . "</a>"));
        $tempRowAdvert->addCell(new FTableCell(null, "table-cell-3", $varAdvert["section"]));
        $tempRowAdvert->addCell(new FTableCell(null, "table-cell-4", $varEditPrefix . $varAdvert["id"] . $varEditSufix . $varDeletePrefix . $varAdvert["id"] . $varDeleteSufix));

        // Append Elements To "Table Adverts" Element.

        $tblAdverts->addRow($tempRowAdvert);
    }
}

// "Paragraph No Adverts Info" Element Settings.

$parNoAdvertsInfo->setClass("info-paragraph");
$parNoAdvertsInfo->setAlignment(FParagraph::ALN_CENTER);
$parNoAdvertsInfo->setContent(Locales::getParagraph("no-adverts-added"));

// "Div Option Links" Element Settings.

$divOptionLinks->setClass("option-links");

$divOptionLinks->addElement("<strong>" . Locales::getCore("options") . ":</strong>");
$divOptionLinks->addElement(new FAnchor(null, null, $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-advert"), null, Locales::getCore("add-advert")));

// "Row Info Row" Element Settings.

$rowInfoRow->setID("adverts-info-row");
$rowInfoRow->setClass("info-row");

$rowInfoRow->addCell(new FTableCell(null, "table-cell-1", "#"));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-2", Locales::getCore("name")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-3", Locales::getCore("section")));
$rowInfoRow->addCell(new FTableCell(null, "table-cell-4", Locales::getCore("options")));

// Append Elements To "Workplace".

$divWorkplace->addElement($hdEarnings);

if ($varAdverts == null)
    $divWorkplace->addElement($parNoAdvertsInfo);
else
    $divWorkplace->addElement($tblAdverts);

$divWorkplace->addElement($divOptionLinks);

?>