<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: modules.php                                   *|
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

$varCoreLink         = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules");
$varModulesRoot      = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules";
$varModuleDirs       = scandir($varModulesRoot);
$varTiePrefix        = "<a href=\"" . $varCoreLink .  "&" . Locales::getVariable("option") . "=" . Locales::getLink("tie-module") . "&" . Locales::getVariable("value") . "=";
$varTieSufix         = "\">" . Locales::getCore("tie-module") . "</a>";
$varEditPrefix       = "<a href=\"" . $varCoreLink .  "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-module") . "&" . Locales::getVariable("value") . "=";
$varEditSufix        = $els = "\">" . Locales::getCore("edit-module") . "</a>";
$varReleasePrefix    = "<a href=\"" . $varCoreLink .  "&" . Locales::getVariable("option") . "=" . Locales::getLink("release-module") . "&" . Locales::getVariable("value") . "=";
$varReleaseSufix     = "\">" . Locales::getCore("release-module") . "</a>";
$varActivatePrefix   = "<a href=\"" . $varCoreLink .  "&" . Locales::getVariable("option") . "=" . Locales::getLink("activate-module") . "&" . Locales::getVariable("value") . "=";
$varActivateSufix    = "\">" . Locales::getCore("activate-module") . "</a>";
$varDeactivatePrefix = "<a href=\"" . $varCoreLink .  "&" . Locales::getVariable("option") . "=" . Locales::getLink("deactivate-module") . "&" . Locales::getVariable("value") . "=";
$varDeactivateSufix  = "\">" . Locales::getCore("deactivate-module") . "</a>";

$varModuleStack = array
(
    array(), // Head Modules.
    array(), // Top Modules.
    array(), // Nav Modules.
    array(), // Side 1 Modules.
    array(), // Side 2 Modules.
    array(), // Side 3 Modules.
    array(), // Main Modules.
    array(), // Front Page Modules.
    array(), // Custom 1 Modules.
    array(), // Custom 2 Modules.
    array(), // Custom 3 Modules.
    array(), // Footer Modules.
    array() // Free Modules.
);

// Create "Core" Elements.

$parNoTiedModules = new FParagraph();
$parNoFreeModules = new FParagraph();

// "Module Types" Variable Settings.

foreach ($varModuleDirs as $varDir)
{
    if ($varDir === "." || $varDir === "..")
    {
        continue;
    }
    else
    {
        // Check If Module Contains Core Files.

        if (file_exists($varModulesRoot . DIRECTORY_SEPARATOR . $varDir . DIRECTORY_SEPARATOR . "index.php") &&
            file_exists($varModulesRoot . DIRECTORY_SEPARATOR .  $varDir . DIRECTORY_SEPARATOR . "module.xml"))
        {
            // Create "Temp" Variables.
            
            $tempModuleStatus = null;
            
            // "Module Status" Temp Variable Settings.

            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

            $tempModuleStatus = EasyGet::execute
            (
                "TS: modules",
                "CS: block",
                "ARGS: name = $varDir"
            );

            if ($tempModuleStatus == null)
                $varModuleStack[12][] = $varDir;
            else
            {
                if ($tempModuleStatus[0]["block"] == "head")
                    $varModuleStack[0][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "top")
                    $varModuleStack[1][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "navigation")
                    $varModuleStack[2][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "side-1")
                    $varModuleStack[3][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "side-2")
                    $varModuleStack[4][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "side-3")
                    $varModuleStack[5][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "main")
                    $varModuleStack[6][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "front-page")
                    $varModuleStack[7][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "custom-1")
                    $varModuleStack[8][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "custom-2")
                    $varModuleStack[9][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "custom-3")
                    $varModuleStack[10][] = $varDir;
                else if ($tempModuleStatus[0]["block"] == "footer")
                    $varModuleStack[11][] = $varDir;
            }
        }
    }
}

// "Paragraph No Tied Modules" Element Settings.

$parNoTiedModules->setID("no-tied-modules-paragraph");
$parNoTiedModules->setClass("info-paragraph");
$parNoTiedModules->setAlignment(FParagraph::ALN_CENTER);
$parNoTiedModules->setContent(Locales::getParagraph("no-tied-modules"));

// "Paragraph No Free Modules" Element Settings.

$parNoFreeModules->setID("no-free-modules-paragraph");
$parNoFreeModules->setClass("info-paragraph");
$parNoFreeModules->setAlignment(FParagraph::ALN_CENTER);
$parNoFreeModules->setContent(Locales::getParagraph("no-free-modules"));

// Append Elements To "Workplace" Element.

if (empty($_GET[Locales::getVariable("option")])) // Default Option.
{
    // Create "Core" Variables.
    
    $varArrangeModulesPrefix = "<a id=\"arrange-icon\" class=\"options-icon\" title=\"" . Locales::getCore("arrange-modules") . "\"  href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-modules") . "&" . Locales::getVariable("module-block") . "=";
    $varArrangeModulesSufix  = "\">" . Locales::getCore("arrange-modules") . "</a>";
    
    $varBlockCodes = array
    (
        Block::HEAD,
        Block::TOP,
        Block::NAVIGATION,
        Block::SIDE_1,
        Block::SIDE_2,
        Block::SIDE_3,
        Block::MAIN,
        Block::FRONT_PAGE,
        Block::CUSTOM_1,
        Block::CUSTOM_2,
        Block::CUSTOM_3,
        Block::FOOTER
    );
    
    $varBlockNames = array
    (
        Locales::getCore("head-module-block"),
        Locales::getCore("top-module-block"),
        Locales::getCore("nav-module-block"),
        Locales::getCore("side-1-module-block"),
        Locales::getCore("side-2-module-block"),
        Locales::getCore("side-3-module-block"),
        Locales::getCore("main-module-block"),
        Locales::getCore("front-page-module-block"),
        Locales::getCore("custom-1-module-block"),
        Locales::getCore("custom-2-module-block"),
        Locales::getCore("custom-3-module-block"),
        Locales::getCore("footer-module-block"),
    );
    
    // Create "Core" Elements.
    
    $hdReposition  = new FHEader();
    $tblReposition = new FTable();
    
    // Create "Row" Elements.
    
    $rowInfoRow   = new FTableRow();
    
    // "Header Reposition" Element Settings.
    
    $hdReposition->setLevel(2);
    $hdReposition->setContent(Locales::getTitle("reposition-modules"));
    
    // "Table Reposition" Element Settings.
    
    $tblReposition->setID("reposition-modules-table");
    $tblReposition->setClass("default-admin-table");
    
    $tblReposition->addRow($rowInfoRow);
    
    for ($i = 0; $i < 12; $i ++)
    {
        // Create "Temp" Variables.
        
        $tempAllModules         = "0";
        $tempActivatedModules   = "0";
        $tempDeactivatedModules = "0";
        
        // "All Modules" Temp Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $tempAllModules = EasyGet::execute
        (
            "TS: modules",
            "CS: COUNT(`id`)",
            "ARGS: block = " . $varBlockCodes[$i]
        );
        
        $tempAllModules = $tempAllModules[0][0];
        
        // "Activated Modules" Temp Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $tempActivatedModules = EasyGet::execute
        (
            "TS: modules",
            "CS: COUNT(`id`)",
            "ARGS: block = " . $varBlockCodes[$i] . " AND status = 1"
        );
        
        $tempActivatedModules = $tempActivatedModules[0][0];
        
        // "Deactivated Modules" Temp Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $tempDeactivatedModules = EasyGet::execute
        (
            "TS: modules",
            "CS: COUNT(`id`)",
            "ARGS: block = " . $varBlockCodes[$i] . " AND status = 0"
        );
        
        $tempDeactivatedModules = $tempDeactivatedModules[0][0];
        
        // Create "Temp" Elements.
        
        $tempRow = new FTableRow();
        
        $tempRow->addCell(new FTableCell(null, "table-cell-1", $varBlockNames[$i]));
        $tempRow->addCell(new FTableCell(null, "table-cell-2", $tempAllModules));
        $tempRow->addCell(new FTableCell(null, "table-cell-3", $tempActivatedModules));
        $tempRow->addCell(new FTableCell(null, "table-cell-4", $tempDeactivatedModules));
        $tempRow->addCell(new FTableCell(null, "table-cell-5", $varArrangeModulesPrefix . $varBlockCodes[$i] . $varArrangeModulesSufix));
        
        // Append Elements To "Table Reposition" Element.
        
        $tblReposition->addRow($tempRow);
    }
    
    // "Info Row" Element Settings.
    
    $rowInfoRow->setID("modules-info-row");
    $rowInfoRow->setClass("info-row");
    
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-1", Locales::getCore("module-block")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-2", Locales::getCore("all-modules")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-3", Locales::getCore("activated-modules")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-4", Locales::getCore("deactivated-modules")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-5", Locales::getCore("options")));
    
    // Append Elements To "Workplace" Element.
    
    $divWorkplace->addElement($hdReposition);
    $divWorkplace->addElement($tblReposition);
    
    // Module List And Their Options.
    
    for ($i = 0; $i < count($varModuleStack); $i ++)
    {
        // Append Title.
        
        if ($i == 0)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("head-modules")));
        else if ($i == 1)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("top-modules")));
        else if ($i == 2)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("nav-modules")));
        else if ($i == 3)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("side-1-modules")));
        else if ($i == 4)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("side-2-modules")));
        else if ($i == 5)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("side-3-modules")));
        else if ($i == 6)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("main-modules")));
        else if ($i == 7)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("front-page-modules")));
        else if ($i == 8)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("custom-1-modules")));
        else if ($i == 9)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("custom-2-modules")));
        else if ($i == 10)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("custom-3-modules")));
        else if ($i == 11)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("footer-modules")));
        else if ($i == 12)
            $divWorkplace->addElement(new FHeader(2, Locales::getTitle("free-modules")));
        
        // Append Modules.

        if ($varModuleStack[$i] == null)
        {
            if ($i == 12)
                $divWorkplace->addElement($parNoFreeModules);
            else
                $divWorkplace->addElement($parNoTiedModules);
        }
        else
        {
            // Add Modules.
            
            for ($j = 0; $j < count($varModuleStack[$i]); $j ++)
            {
                // Create "Temp Core" Variables.
                
                $tempModuleData   = null;
                $tempModuleInfo   = null;
                $tempModuleIcon   = null;
                $tempModuleStatus = null;
                
                // Create "Temp" Elements.

                $tempTblModule    = new FTable();
                $tempDivIcon      = new FDiv();
                $tempDivDescr     = new FDiv();
                
                // Create "Temp Row" Elements.
                
                $tempRowInfoOne   = new FTableRow();
                $tempRowInfoTwo   = new FTableRow();
                $tempRowInfoThree = new FTableRow();
                $tempRowInfoFour  = new FTableRow();
                $tempRowInfoFive  = new FTableRow();
                
                // "Module Data" Temp Variable Settings.
                
                EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

                $tempModuleData = EasyGet::execute
                (
                    "TS: modules",
                    "CS: status",
                    "ARGS: name = " . $varModuleStack[$i][$j]
                );
                
                // "Module Info" Temp Variable Settings.
                
                $tempModuleInfo = new Module();

                $tempModuleInfo->setLocation($varModulesRoot . DIRECTORY_SEPARATOR . $varModuleStack[$i][$j]);

                $tempModuleInfo->includeSettings();
                
                // "Module Icon" Temp Variable Settings.
                
                if (file_exists($tempModuleInfo->getLocation() . DIRECTORY_SEPARATOR . "icon.png"))
                    $tempModuleIcon = "<img src=\"./system/modules/" . $varModuleStack[$i][$j] . "/icon.png\" border=\"0\" />";
                else
                    $tempModuleIcon = "<img src=\"../../../../system/assets/images/other/module.png\" border=\"0\" />";
                
                // "Module Status" Temp Variable Settings.
                
                if ($tempModuleData[0]["status"] == 0)
                    $tempModuleStatus = Locales::getCore("inactive");
                else
                    $tempModuleStatus = Locales::getCore("active");
                
                // "Table Modules" Temp Element Settings.
                
                $tempTblModule->setClass("module-info-table");
                
                $tempTblModule->addRow($tempRowInfoOne);
                $tempTblModule->addRow($tempRowInfoTwo);
                $tempTblModule->addRow($tempRowInfoThree);
                $tempTblModule->addRow($tempRowInfoFour);
                $tempTblModule->addRow($tempRowInfoFive);   

                // "Div Icon" Temp Element Settings.
                
                $tempDivIcon->setClass("module-info-icon");
                
                $tempDivIcon->setContent($tempModuleIcon);
                
                // "Div Description" Temp Element Settings.
                
                $tempDivDescr->setClass("module-info-description");
                
                $tempDivDescr->setContent($tempModuleInfo->getDescription());
                
                // "Row Info One" Temp Element Settings.
                
                $tempRowInfoOne->setClass("module-info-header");
                
                $tempRowInfoOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("status") . ":</strong> " . $tempModuleStatus, null, null, FTableRow::ALN_LEFT));
                $tempRowInfoOne->addCell(new FTableCell(null, null, $tempModuleInfo->getName(), null, null, FTableRow::ALN_CENTER));
                $tempRowInfoOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("version") . ":</strong> " . $tempModuleInfo->getVersion(), null, null, FTableRow::ALN_RIGHT));
                
                // "Row Info Two" Temp Element Settings.
                
                $tempRowInfoTwo->setClass("module-info-main");
                
                $tempRowInfoTwo->addCell(new FTableCell(null, null, array($tempDivIcon, $tempDivDescr), 3));
                
                // "Row Info Three" Temp Element Settings.
                
                $tempRowInfoThree->setClass("module-info-options");
                
                $tempRowInfoThree->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("type") . ":</strong> " . $tempModuleInfo->getType(), null, null, FTableRow::ALN_LEFT));

                if ($i == 12)
                    $tempRowInfoThree->addCell(new FTableCell(null, null, $varTiePrefix . $varModuleStack[$i][$j] . $varTieSufix, 2, null, FTableCell::ALN_RIGHT));
                else
                {
                    if ($varModuleStack[$i][$j] == "pages")
                        $tempRowInfoThree->addCell(new FTableCell(null, null, $varEditPrefix . $varModuleStack[$i][$j] . $varEditSufix, 2, null, FTableRow::ALN_RIGHT));
                    else
                    {
                        if ($tempModuleData[0]["status"] == 0)
                            $tempRowInfoThree->addCell(new FTableCell(null, null, $varActivatePrefix . $varModuleStack[$i][$j] . $varActivateSufix, null, null, FTableRow::ALN_CENTER));
                        else
                            $tempRowInfoThree->addCell(new FTableCell(null, null, $varDeactivatePrefix . $varModuleStack[$i][$j] . $varDeactivateSufix, null, null, FTableRow::ALN_CENTER));
                        
                        $tempRowInfoThree->addCell(new FTableCell(null, null, $varEditPrefix . $varModuleStack[$i][$j] . $varEditSufix . " | " . $varReleasePrefix . $varModuleStack[$i][$j] . $varReleaseSufix, null, null, FTableRow::ALN_RIGHT));
                    }
                }
                
                // "Row Info Four" Temp Element Settings.
                
                $tempRowInfoFour->setClass("module-info-separator");
                
                $tempRowInfoFour->addCell(new FTableCell(null, null, "--------------", 3));
                
                // "Row Info Five" Temp Element Settings.
                
                $tempRowInfoFive->setClass("module-info-dev");
                
                $tempRowInfoFive->addCell(new FTableCell(null, null, $tempModuleInfo->getAuthor(), null, null, FTableRow::ALN_LEFT));
                $tempRowInfoFive->addCell(new FTableCell(null, null, $tempModuleInfo->getContact(), null, null, FTableRow::ALN_CENTER));
                $tempRowInfoFive->addCell(new FTableCell(null, null, "<a href=\"" . $tempModuleInfo->getWebsite() . "\" target=\"_blank\"/>" . $tempModuleInfo->getWebsite() . "</a>", null, null, FTableRow::ALN_RIGHT));
                
                // Append Elements To "Workplace" Element.
                
                $divWorkplace->addElement($tempTblModule);
            }
        }
    }
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("tie-module"))
{
    // Create "Core" Variables.
    
    $varModuleName = $_GET[Locales::getVariable("value")];
    $varModuleData = null;
    $varModuleInfo = null;
    $varModuleIcon = null;
    
    // Create "Core" Elements.
    
    $hdTieModule   = new FHeader();
    $tblMOdule     = new FTable();
    $divIcon       = new FDiv();
    $divDescr      = new FDiv();
    $fmTieModule   = new FForm();
    $tblTieModule  = new FTable();

    // Create "Row" Elements.

    $rowInfoOne    = new FTableRow();
    $rowInfoTwo    = new FTableRow();
    $rowInfoThree  = new FTableRow();
    $rowInfoFour   = new FTableRow();
    $rowInfoFive   = new FTableRow();
    $rowTieModule  = new FTableRow();
    
    // Create "Input" Elements.
    
    $selBlocks     = new FSelect();
    $btnSubmit     = new FButton();
    
    // "Module Data" Variable Settings.

    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

    $varModuleData = EasyGet::execute
    (
        "TS: modules",
        "CS: status",
        "ARGS: name = " . $varModuleName
    );

    if ($varModuleData[0]["status"] == 0)
        $varModuleData[0]["status"] = Locales::getCore("inactive");
    else
        $varModuleData[0]["status"] = Locales::getCore("active");
    
    // "Module Info" Variable Settings.

    $varModuleInfo = new Module();

    $varModuleInfo->setLocation($varModulesRoot . DIRECTORY_SEPARATOR . $varModuleName);

    $varModuleInfo->includeSettings();
    
    // "Module Icon" Variable Settings.

    if (file_exists($varModuleInfo->getLocation() . DIRECTORY_SEPARATOR . "icon.png"))
        $varModuleIcon = "<img src=\"/system/modules/" . $varModuleName . "/icon.png\" border=\"0\" />";
    else
        $varModuleIcon = "<img src=\"./../../../system/assets/images/other/module.png\" border=\"0\" />";
    
    // "Header Tie Module" Element Settings.
    
    $hdTieModule->setLevel(2);
    $hdTieModule->setContent(Locales::getTitle("tie-module"));
    
    // "Table Modules" Element Settings.
                
    $tblMOdule->setClass("module-info-table");

    $tblMOdule->addRow($rowInfoOne);
    $tblMOdule->addRow($rowInfoTwo);
    $tblMOdule->addRow($rowInfoThree);
    $tblMOdule->addRow($rowInfoFour);
    $tblMOdule->addRow($rowInfoFive);
    
    // "Div Icon" Element Settings.

    $divIcon->setClass("module-info-icon");

    $divIcon->setContent($varModuleIcon);

    // "Div Description" Element Settings.

    $divDescr->setClass("module-info-description");

    $divDescr->setContent($varModuleInfo->getDescription());
    
    // "Form Tie Module" Element Settings.
    
    $fmTieModule->setID("tie-module-form");
    $fmTieModule->setClass("default-form");
    $fmTieModule->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("tie-module") . "&" . Locales::getVariable("value") . "=" . $varModuleName);
    $fmTieModule->setMethod(FForm::MTD_POST);
    
    $fmTieModule->addItem($tblTieModule);
    
    // "Table Tie Module" Element Settings.
    
    $tblTieModule->setID("module-option-table");
    $tblTieModule->setClass("default-admin-table");
    
    $tblTieModule->addRow($rowTieModule);
    
    // "Row Info One" Element Settings.
                
    $rowInfoOne->setClass("module-info-header");

    $rowInfoOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("status") . ":</strong> " . $varModuleData[0]["status"], null, null, FTableRow::ALN_LEFT));
    $rowInfoOne->addCell(new FTableCell(null, null, $varModuleInfo->getName(), null, null, FTableRow::ALN_CENTER));
    $rowInfoOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("version") . ":</strong> " . $varModuleInfo->getVersion(), null, null, FTableRow::ALN_RIGHT));
    
    // "Row Info Two" Element Settings.

    $rowInfoTwo->setClass("module-info-main");

    $rowInfoTwo->addCell(new FTableCell(null, null, array($divIcon, $divDescr), 3));
    
    // "Row Info Three" Element Settings.

    $rowInfoThree->setClass("module-info-options");

    $rowInfoThree->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("type") . ":</strong> " . $varModuleInfo->getType(), null, null, FTableRow::ALN_LEFT));

    $rowInfoThree->addCell(new FTableCell(null, null, Locales::getCore("free-module"), 2, null, FTableCell::ALN_RIGHT));
    
    // "Row Info Four" Element Settings.

    $rowInfoFour->setClass("module-info-separator");

    $rowInfoFour->addCell(new FTableCell(null, null, "--------------", 3));
    
    // "Row Info Five" Element Settings.

    $rowInfoFive->setClass("module-info-dev");

    $rowInfoFive->addCell(new FTableCell(null, null, $varModuleInfo->getAuthor(), null, null, FTableRow::ALN_LEFT));
    $rowInfoFive->addCell(new FTableCell(null, null, $varModuleInfo->getContact(), null, null, FTableRow::ALN_CENTER));
    $rowInfoFive->addCell(new FTableCell(null, null, "<a href=\"" . $varModuleInfo->getWebsite() . "\" target=\"_blank\"/>" . $varModuleInfo->getWebsite() . "</a>", null, null, FTableRow::ALN_RIGHT));
    
    // "Row Tie Module" Element Settings.
    
    $rowTieModule->addCell(new FTableCell(null, null, array("<strong>" . Locales::getCore("to-block") . ":</strong>", $selBlocks, $btnSubmit)));
    
    // "Select Blocks" Element Settings.
    
    $selBlocks->setClass("form-select");
    
    $selBlocks->addOption(new FSelectOption(0, Locales::getCore("module-block") . ":", true));
    $selBlocks->addOption(new FSelectOption(1, Locales::getCore("head-module-block"), false));
    $selBlocks->addOption(new FSelectOption(2, Locales::getCore("top-module-block"), false));
    $selBlocks->addOption(new FSelectOption(3, Locales::getCore("nav-module-block"), false));
    $selBlocks->addOption(new FSelectOption(4, Locales::getCore("side-1-module-block"), false));
    $selBlocks->addOption(new FSelectOption(5, Locales::getCore("side-2-module-block"), false));
    $selBlocks->addOption(new FSelectOption(6, Locales::getCore("side-3-module-block"), false));
    $selBlocks->addOption(new FSelectOption(7, Locales::getCore("main-module-block"), false));
    $selBlocks->addOption(new FSelectOption(8, Locales::getCore("front-page-module-block"), false));
    $selBlocks->addOption(new FSelectOption(9, Locales::getCore("custom-1-module-block"), false));
    $selBlocks->addOption(new FSelectOption(10, Locales::getCore("custom-2-module-block"), false));
    $selBlocks->addOption(new FSelectOption(11, Locales::getCore("custom-3-module-block"), false));
    $selBlocks->addOption(new FSelectOption(12, Locales::getCore("footer-module-block"), false));
    
    $selBlocks->setName("req_block");
    
    // "Button Submit" Element Settings.
    
    $btnSubmit->setID("tie-module-submit-button");
    $btnSubmit->setClass("form-button");
    $btnSubmit->setType(FButton::TP_SUBMIT);
    $btnSubmit->setContent(Locales::getCore("tie"));
    
    // Append Elements To "Workplace" Element.
    
    $divWorkplace->addElement($hdTieModule);
    $divWorkplace->addElement($tblMOdule);
    $divWorkplace->addElement($fmTieModule);
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-module"))
{
    // Create "Core" Variables.
    
    $varModuleName  = $_GET[Locales::getVariable("value")];
    $varModuleData  = null;
    $varModuleInfo  = null;
    $varModuleBlock = null;
    $varModuleIcon  = null;
    
    // Create "Core" Elements.
    
    $hdEditModule   = new FHeader();
    $tblMOdule      = new FTable();
    $divIcon        = new FDiv();
    $divDescr       = new FDiv();
    $fmEditModule   = new FForm();
    $tblEditModule  = new FTable();

    // Create "Row" Elements.

    $rowInfoOne    = new FTableRow();
    $rowInfoTwo    = new FTableRow();
    $rowInfoThree  = new FTableRow();
    $rowInfoFour   = new FTableRow();
    $rowInfoFive   = new FTableRow();
    $rowEditModule  = new FTableRow();
    
    // Create "Input" Elements.
    
    $selBlocks     = new FSelect();
    $btnSubmit     = new FButton();
    
    // "Module Data" Variable Settings.

    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

    $varModuleData = EasyGet::execute
    (
        "TS: modules",
        "CS: block, status",
        "ARGS: name = " . $varModuleName
    );

    if ($varModuleData[0]["status"] == 0)
        $varModuleData[0]["status"] = Locales::getCore("inactive");
    else
        $varModuleData[0]["status"] = Locales::getCore("active");
    
    // "Module Info" Variable Settings.

    $varModuleInfo = new Module();

    $varModuleInfo->setLocation($varModulesRoot . DIRECTORY_SEPARATOR . $varModuleName);

    $varModuleInfo->includeSettings();
    
    // "Module Block" Variable Settings.
    
    if ($varModuleData[0]["block"] == Block::HEAD)
        $varModuleBlock = Locales::getCore("head-module-block");
    else if ($varModuleData[0]["block"] == Block::TOP)
        $varModuleBlock = Locales::getCore("top-module-block");
    else if ($varModuleData[0]["block"] == Block::NAVIGATION)
        $varModuleBlock = Locales::getCore("nav-module-block");
    else if ($varModuleData[0]["block"] == Block::SIDE_1)
        $varModuleBlock = Locales::getCore("side-1-module-block");
    else if ($varModuleData[0]["block"] == Block::SIDE_2)
        $varModuleBlock = Locales::getCore("side-2-module-block");
    else if ($varModuleData[0]["block"] == Block::SIDE_3)
        $varModuleBlock = Locales::getCore("side-3-module-block");
    else if ($varModuleData[0]["block"] == Block::MAIN)
        $varModuleBlock = Locales::getCore("main-module-block");
    else if ($varModuleData[0]["block"] == Block::FRONT_PAGE)
        $varModuleBlock = Locales::getCore("front-page-module-block");
    else if ($varModuleData[0]["block"] == Block::CUSTOM_1)
        $varModuleBlock = Locales::getCore("custom-1-module-block");
    else if ($varModuleData[0]["block"] == Block::CUSTOM_2)
        $varModuleBlock = Locales::getCore("custom-2-module-block");
    else if ($varModuleData[0]["block"] == Block::CUSTOM_3)
        $varModuleData[0]["block"] = Locales::getCore("custom-3-module-block");
    else if ($varModuleData[0]["block"] == Block::FOOTER)
        $varModuleBlock = Locales::getCore("footer-module-block");
    else
        $varModuleBlock = "?";
    
    // "Module Icon" Variable Settings.

    if (file_exists($varModuleInfo->getLocation() . DIRECTORY_SEPARATOR . "icon.png"))
        $varModuleIcon = "<img src=\"/system/modules/" . $varModuleName . "/icon.png\" border=\"0\" />";
    else
        $varModuleIcon = "<img src=\"./../../../system/assets/images/other/module.png\" border=\"0\" />";
    
    // "Header Edit Module" Element Settings.
    
    $hdEditModule->setLevel(2);
    $hdEditModule->setContent(Locales::getTitle("edit-module"));
    
    // "Table Modules" Element Settings.
                
    $tblMOdule->setClass("module-info-table");

    $tblMOdule->addRow($rowInfoOne);
    $tblMOdule->addRow($rowInfoTwo);
    $tblMOdule->addRow($rowInfoThree);
    $tblMOdule->addRow($rowInfoFour);
    $tblMOdule->addRow($rowInfoFive);
    
    // "Div Icon" Element Settings.

    $divIcon->setClass("module-info-icon");

    $divIcon->setContent($varModuleIcon);

    // "Div Description" Element Settings.

    $divDescr->setClass("module-info-description");

    $divDescr->setContent($varModuleInfo->getDescription());
    
    // "Form Tie Module" Element Settings.
    
    $fmEditModule->setID("edit-module-form");
    $fmEditModule->setClass("default-form");
    $fmEditModule->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-module") . "&" . Locales::getVariable("value") . "=" . $varModuleName);
    $fmEditModule->setMethod(FForm::MTD_POST);
    
    $fmEditModule->addItem($tblEditModule);
    
    // "Table Tie Module" Element Settings.
    
    $tblEditModule->setID("module-option-table");
    $tblEditModule->setClass("default-admin-table");
    
    $tblEditModule->addRow($rowEditModule);
    
    // "Row Info One" Element Settings.
                
    $rowInfoOne->setClass("module-info-header");

    $rowInfoOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("status") . ":</strong> " . $varModuleData[0]["status"], null, null, FTableRow::ALN_LEFT));
    $rowInfoOne->addCell(new FTableCell(null, null, $varModuleInfo->getName(), null, null, FTableRow::ALN_CENTER));
    $rowInfoOne->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("version") . ":</strong> " . $varModuleInfo->getVersion(), null, null, FTableRow::ALN_RIGHT));
    
    // "Row Info Two" Element Settings.

    $rowInfoTwo->setClass("module-info-main");

    $rowInfoTwo->addCell(new FTableCell(null, null, array($divIcon, $divDescr), 3));
    
    // "Row Info Three" Element Settings.

    $rowInfoThree->setClass("module-info-options");

    $rowInfoThree->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("type") . ":</strong> " . $varModuleInfo->getType(), null, null, FTableRow::ALN_LEFT));

    $rowInfoThree->addCell(new FTableCell(null, null, "<strong>" . Locales::getCore("tied-to") . ":</strong> " . $varModuleBlock, 2, null, FTableCell::ALN_RIGHT));
    
    // "Row Info Four" Element Settings.

    $rowInfoFour->setClass("module-info-separator");

    $rowInfoFour->addCell(new FTableCell(null, null, "--------------", 3));
    
    // "Row Info Five" Element Settings.

    $rowInfoFive->setClass("module-info-dev");

    $rowInfoFive->addCell(new FTableCell(null, null, $varModuleInfo->getAuthor(), null, null, FTableRow::ALN_LEFT));
    $rowInfoFive->addCell(new FTableCell(null, null, $varModuleInfo->getContact(), null, null, FTableRow::ALN_CENTER));
    $rowInfoFive->addCell(new FTableCell(null, null, "<a href=\"" . $varModuleInfo->getWebsite() . "\" target=\"_blank\"/>" . $varModuleInfo->getWebsite() . "</a>", null, null, FTableRow::ALN_RIGHT));
    
    // "Row Edit Module" Element Settings.
    
    $rowEditModule->addCell(new FTableCell(null, null, array("<strong>" . Locales::getCore("to-block") . ":</strong>", $selBlocks, $btnSubmit)));
    
    // "Select Blocks" Element Settings.
    
    $selBlocks->setClass("form-select");
    
    if ($varModuleData[0]["block"] == Block::HEAD)
        $selBlocks->addOption(new FSelectOption(0, Locales::getCore("head-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(0, Locales::getCore("head-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::TOP)
        $selBlocks->addOption(new FSelectOption(1, Locales::getCore("top-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(1, Locales::getCore("top-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::NAVIGATION)
        $selBlocks->addOption(new FSelectOption(2, Locales::getCore("nav-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(2, Locales::getCore("nav-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::SIDE_1)
        $selBlocks->addOption(new FSelectOption(3, Locales::getCore("side-1-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(3, Locales::getCore("side-1-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::SIDE_2)
        $selBlocks->addOption(new FSelectOption(4, Locales::getCore("side-2-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(4, Locales::getCore("side-2-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::SIDE_3)
        $selBlocks->addOption(new FSelectOption(5, Locales::getCore("side-3-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(5, Locales::getCore("side-3-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::MAIN)
        $selBlocks->addOption(new FSelectOption(6, Locales::getCore("main-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(6, Locales::getCore("main-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::FRONT_PAGE)
        $selBlocks->addOption(new FSelectOption(7, Locales::getCore("front-page-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(7, Locales::getCore("front-page-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::CUSTOM_1)
        $selBlocks->addOption(new FSelectOption(8, Locales::getCore("custom-1-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(8, Locales::getCore("custom-1-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::CUSTOM_2)
        $selBlocks->addOption(new FSelectOption(9, Locales::getCore("custom-2-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(9, Locales::getCore("custom-2-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::CUSTOM_3)
        $selBlocks->addOption(new FSelectOption(10, Locales::getCore("custom-3-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(10, Locales::getCore("custom-3-module-block"), false));
    
    if ($varModuleData[0]["block"] == Block::FOOTER)
        $selBlocks->addOption(new FSelectOption(11, Locales::getCore("footer-module-block"), true));
    else
        $selBlocks->addOption(new FSelectOption(11, Locales::getCore("footer-module-block"), false));
    
    $selBlocks->setName("req_block");
    
    // "Button Submit" Element Settings.
    
    $btnSubmit->setID("edit-module-submit-button");
    $btnSubmit->setClass("form-button");
    $btnSubmit->setType(FButton::TP_SUBMIT);
    $btnSubmit->setContent(Locales::getCore("tie"));
    
    // Append Elements To "Workplace" Element.
    
    $divWorkplace->addElement($hdEditModule);
    $divWorkplace->addElement($tblMOdule);
    $divWorkplace->addElement($fmEditModule);
}
else if ($_GET[Locales::getVariable("option")] == Locales::getLink("arrange-modules"))
{
    // Create "Core" Variables.

    $varBlockCodes = array
    (
        Block::HEAD,
        Block::TOP,
        Block::NAVIGATION,
        Block::SIDE_1,
        Block::SIDE_2,
        Block::SIDE_3,
        Block::MAIN,
        Block::FRONT_PAGE,
        Block::CUSTOM_1,
        Block::CUSTOM_2,
        Block::CUSTOM_3,
        Block::FOOTER
    );
    
    $varBlockNames = array
    (
        Block::HEAD       => Locales::getCore("head-module-block"),
        Block::TOP        => Locales::getCore("top-module-block"),
        Block::NAVIGATION => Locales::getCore("nav-module-block"),
        Block::SIDE_1     => Locales::getCore("side-1-module-block"),
        Block::SIDE_2     => Locales::getCore("side-2-module-block"),
        Block::SIDE_3     => Locales::getCore("side-3-module-block"),
        Block::MAIN       => Locales::getCore("main-module-block"),
        Block::FRONT_PAGE => Locales::getCore("front-page-module-block"),
        Block::CUSTOM_1   => Locales::getCore("custom-1-module-block"),
        Block::CUSTOM_2   => Locales::getCore("custom-2-module-block"),
        Block::CUSTOM_3   => Locales::getCore("custom-3-module-block"),
        Block::FOOTER     => Locales::getCore("footer-module-block"),
    );
    
    
    $varCoreLink        = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration") . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("modules");
    $varModulesRoot     = DOC_ROOT . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "modules";
    $varModuleBlock     = null;
    $varModules         = null;
    $varModuleCount     = null;
    $varMoveUpPrefix    = "<a id=\"move-up-icon\" class=\"options-icon\" title=\"" . Locales::getCore("move-up") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("move-up") . "&" . Locales::getVariable("value") . "=";
    $varMoveUpSufix     = "\">" . Locales::getCore("move-up") . "</a>";
    $varMoveDownPrefix  = "<a id=\"move-down-icon\" class=\"options-icon\" title=\"" . Locales::getCore("move-down") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("move-down") . "&" . Locales::getVariable("value") . "=";
    $varMoveDownSufix   = "\">" . Locales::getCore("move-down") . "</a>";
    
    // Create "Core" Elements.

    $hdArrangeModules   = new FHeader();
    $parModuleBlockInfo = new FParagraph();
    $parNoModules       = new FParagraph();
    $parNoBlockSelected = new FParagraph();
    $tblArrangeModules  = new FTable();
    
    // Create "Row" Elements.
    
    $rowInfoRow         = new FTableRow();
    
    // "Module Block" Variable Settings.
    
    if (!empty($_GET[Locales::getVariable("module-block")]))
        $varModuleBlock = Filter::forAlphaNumericWithDash($_GET[Locales::getVariable("module-block")]);
    
    // "Modules" Variable Settings.
    
    if (!empty($varModuleBlock))
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        EasyGet::setOrderBy("position", EasyGet::OB_ASC);
        
        $varModules = EasyGet::execute
        (
            "TS: modules",
            "CS: name, position, status",
            "ARGS: block = " . $varModuleBlock
        );
    }
    
    // "Module Count" Variable Settings.
    
    if (!empty($varModuleBlock))
        $varModuleCount = count($varModules);
    
    // "Header Arrange Modules" Element Settings.

    $hdArrangeModules->setLevel(2);
    $hdArrangeModules->setContent(Locales::getTitle("arrange-modules"));
    
    // "Paragraph Module Block Info" Element Settings.
    
    $parModuleBlockInfo->setClass("block-name-arrangment");
    
    $parModuleBlockInfo->setContent("<strong>" . Locales::getCore("module-block") . ":</strong> ");
    
    foreach ($varBlockNames as $key => $value)
    {
        if ($key == $varModuleBlock)
        {
            $parModuleBlockInfo->setContent($parModuleBlockInfo->getContent() . $value);
            
            break;
        }
    }
    
    // "Paragraph No Modules" Element Settings.

    $parNoModules->setClass("info-paragraph");
    $parNoModules->setAlignment(FParagraph::ALN_CENTER);
    $parNoModules->setContent(Locales::getParagraph("module-block-empty"));
    
    // "Paragraph No Block Selected" Element Settings.
    
    $parNoBlockSelected->setClass("info-paragraph");
    $parNoBlockSelected->setAlignment(FParagraph::ALN_CENTER);
    $parNoBlockSelected->setContent(Locales::getParagraph("no-module-block"));
    
    // "Table Arrange Modules" Element Settings.
    
    $tblArrangeModules->setID("arrange-modules-table");
    $tblArrangeModules->setClass("default-admin-table");
    
    $tblArrangeModules->addRow($rowInfoRow);
    
    if ($varModules != null)
    {
        foreach ($varModules as $module)
        {
            // Create "Temp" Variables.

            $tempModuleInfo = new Module();

            // Create "Temp" Elements.

            $tempModuleRow = new FTableRow();

            // "Module Info" Temp Variable Settings.

            $tempModuleInfo->setLocation($varModulesRoot . DIRECTORY_SEPARATOR . $module["name"]);

            $tempModuleInfo->includeSettings();

            // "Module Row" Temp Element Settings.

            if ($module["status"] == 0)
                $module["status"] = Locales::getCore("inactive");
            else
                $module["status"] = Locales::getCore("active");

            $tempModuleRow->addCell(new FTableCell(null, "table-cell-1", $tempModuleInfo->getName()));
            $tempModuleRow->addCell(new FTableCell(null, "table-cell-2", $tempModuleInfo->getDescription()));
            $tempModuleRow->addCell(new FTableCell(null, "table-cell-3", $module["status"]));
            $tempModuleRow->addCell(new FTableCell(null, "table-cell-4", $module["position"]));
            $tempModuleRow->addCell(new FTableCell(null, "table-cell-5", $varMoveUpPrefix . $module["name"] . $varMoveUpSufix . $varMoveDownPrefix . $module["name"] . $varMoveDownSufix));

            // Append Elements To "Table Arrange Modules" Element.

            $tblArrangeModules->addRow($tempModuleRow);
        }
    }
    
    // "Row Info Row" Element Settings.
    
    $rowInfoRow->setID("modules-info-row");
    $rowInfoRow->setClass("info-row");
    
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-1", Locales::getCore("name")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-2", Locales::getCore("description")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-3", Locales::getCore("status")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-4", Locales::getCore("position")));
    $rowInfoRow->addCell(new FTableCell(null, "table-cell-5", Locales::getCore("options")));
    
    // Append Elements To "Workplace".

    $divWorkplace->addElement($hdArrangeModules);
    
    if (empty($varModuleBlock))
        $divWorkplace->addElement($parNoBlockSelected);
    else
    {
        $divWorkplace->addElement($parModuleBlockInfo);
    
        if (empty($varModuleCount))
            $divWorkplace->addElement($parNoModules);
        else
            $divWorkplace->addElement($tblArrangeModules);
    }
}
else
{
    // Create "Core" Elements.

    $hdUnknownPage = new FHeader();
    $parInfo       = new FParagraph();

    // "Header Unknown Page" Element Settings.

    $hdUnknownPage->setLevel(2);
    $hdUnknownPage->setContent(Locales::getErrorTitle("page-not-found"));

    // "Paragraph Info" Element Settings.

    $parInfo->setClass("info-paragraph");
    $parInfo->setAlignment(FParagraph::ALN_CENTER);
    $parInfo->setContent(Locales::getErrorContent("page-not-found"));

    // Append Elements To "Workplace".

    $divWorkplace->addElement($hdUnknownPage);
    $divWorkplace->addElement($parInfo);
}

?>