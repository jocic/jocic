<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: display.php                                   *|
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

class Display
{
    // Main Methods.
    
    public static function page()
    {
        // Check For Installation Files.
        
        if (file_exists(INSTALL_ROOT . "index.php"))
            exit(header("location: " . CMS_ROOT . "installation/index.php"));

        // Start Session.
        
        if (!isset($_SESSION))
            session_start();
        
        // Load Locales.
        
        Locales::loadFiles();
        
        // Perform Few Checks If Session Is Active.
        
        if (Session::isActive())
        {
            // Fetch Users ID.
            
            $userID = IDFetch::byUsername(Session::getUsername());
            
            // Set Prefered Locale.
            
            $preferedLanguage = InfoFetch::fetchPreferedLanguage($userID);
            
            if (Locales::getLocale() != $preferedLanguage)
            {
                Locales::setLocale($preferedLanguage);
                
                Locales::loadFiles();
            }
            
            // Check If User Is Banned.
            
            if (Account::isBanned($userID))
            {
                Session::stop();
            
                exit(header("location: " . CMS_ROOT));
            }
            
            if (empty($_SESSION["logged_in"]))
            {
                $_SESSION["logged_in"] = true;

                Session::refresh();

                exit(header("location: " . CMS_ROOT));
            }
        }
        
        $pnv = Locales::getVariable("page");
        
        // Execute Processors.
        
        self::executeProcessors();
        
        // Generate New CAPTCHA Challenge.
        
        Captcha::generateChallenge();
        
        // Display Page.
        
        if ($_SERVER["REQUEST_URI"] == CMS_ROOT)
            self::frontPage();
        else if (!empty($_GET[$pnv]) && $_GET[$pnv] == Locales::getLink("site-administration"))
            self::administrationPage();
        else
            self::defaultPage();
    }
    
    private static function frontPage()
    {
        // Check if theme exists.
        
        $themeName    = Core::get(Core::SELECTED_THEME);
        
        $pageLocation = DOC_ROOT . "/themes/$themeName/pages/front_page.html";
        
        // Increment Hits.
        
        Statistics::incrementTotalHits();
        
        // Display Page.
        
        if (file_exists($pageLocation))
            self::parseThemeFile($pageLocation);
        else
            self::defaultPage();
    }
    
    private static function administrationPage()
    {
        // Check If Theme Exists.
        
        $themeName    = Core::get(Core::SELECTED_THEME);
        
        $pageLocation = DOC_ROOT . "/themes/$themeName/pages/administration_page.html";
        
        // Display Page.
        
        if (file_exists($pageLocation))
            self::parseThemeFile($pageLocation);
        else
            self::defaultPage();
    }
    
    private static function defaultPage()
    {
        // Check if theme exists.
        
        $themeName    = Core::get(Core::SELECTED_THEME);
        
        $pageLocation = DOC_ROOT . "/themes/$themeName/pages/default_page.html";
        
        // Increment Hits.
        
        Statistics::incrementTotalHits();
        
        // Display Page.
        
        if (file_exists($pageLocation))
            self::parseThemeFile($pageLocation);
        else
            new Error("Display", "Theme or theme file for the <b>default page</b> does not exists.");
    }
    
    private static function executeProcessors()
    {
        $selectedPage = null;
        
        // Fetch Selected Page Name.
        
        if (!empty($_GET[Locales::getVariable("page")]))
            $selectedPage = Locales::getLink($_GET[Locales::getVariable("page")]);

        // Fetch Page Root.

        $pr = DOC_ROOT .
              DIRECTORY_SEPARATOR .
              "system" .
              DIRECTORY_SEPARATOR .
              "processors" .
              DIRECTORY_SEPARATOR;
        
        // Include General Processor.
        
        require_once $pr . "general_processor.php";

        // Include Proper Processor.
        
        $varProcessorIncluded = true;

        if ($selectedPage == Locales::getLink("log-in"))
            require_once $pr . "log_in_processor.php";
        else if ($selectedPage == Locales::getLink("log-out"))
            require_once $pr . "log_out_processor.php";
        else if ($selectedPage == Locales::getLink("registration"))
            require_once $pr . "registration_processor.php";
        else if ($selectedPage == Locales::getLink("activate-account"))
            require_once $pr . "activate_account_processor.php";
        else if ($selectedPage == Locales::getLink("resend-activation-email"))
            require_once $pr . "resend_activation_email_processor.php";
        else if ($selectedPage == Locales::getLink("account-recovery"))
            require_once $pr . "account_recovery_processor.php";
        else if ($selectedPage == Locales::getLink("password-reset"))
            require_once $pr . "password_reset_processor.php";
        else if ($selectedPage == Locales::getLink("site-administration"))
            require_once $pr . "system_administration_processor.php";
        else if ($selectedPage == Locales::getLink("set-language"))
            require_once $pr . "set_language_processor.php";
        else if ($selectedPage == Locales::getLink("messages"))
            require_once $pr . "messages_processor.php";
        else if ($selectedPage == Locales::getLink("your-profile"))
            require_once $pr . "your_profile_processor.php";
        else if ($selectedPage == Locales::getLink("view-profile"))
            require_once $pr . "view_profile_processor.php";
        else
            $varProcessorIncluded = false;

        // Execute General Processor.
        
        $general = new GeneralProcessor();
        
        $general->execute();
        
        // Execute Proper Processor If Was Included.
        
        if ($varProcessorIncluded)
        {
            $processor = new Processor();

            $processor->execute();
        }
        
        // Fetch Names Of All Active Modules.

        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $data = EasyGet::execute
        (        
            "TS: modules",
            "CS: name",
            "ARGS: status = 1"
        );
        
        // Execute Module Processors.
        
        if ($data != null)
        {
            foreach ($data as $row)
            {
                $processor = new ModuleProcessor();

                $processor->setName($row["name"]);

                $processor->execute();
            }
        }
    }
    
    private static function parseThemeFile($fileLocation)
    {
        $file = file($fileLocation);

        for ($i = 0; $i < count($file); $i ++) // Go trough "theme.html" file, line by line.
        {
            $line = $file[$i]; // Theme line.
            
            if (StringCheck::containsNeedle($line, "#")) // If there is a block, handle it.
            {
                $blockData = self::fetchElementName($line, "#");
                
                if ($blockData == null)
                    echo $line;
                else
                {
                    for ($j = 0; $j < count($blockData); $j ++)
                    {
                        // Print prefix or set it if it's all whitespace.
                        
                        $block = new Block($blockData[$j][1]);
                        
                        if (StringCheck::constainsAll($blockData[$j][0], " "))
                            $block->setBlankPrefix($blockData[$j][0]);
                        else
                            echo $blockData[$j][0];

                        // Include all modules tied to the block.

                        $block->includeModules();
                        
                        // Print sufix.

                        if (!($blockData[$j][2] == "\r\n" || $blockData[$j][2] == "\n"))
                            echo $blockData[$j][2];
                    }
                }
            }
            else if (StringCheck::containsNeedle($line, "|"))
            {
                $varData = self::fetchElementName($line, "|");
                
                if ($varData == null)
                    echo $line;
                else
                {
                    for ($j = 0; $j < count($varData); $j ++)
                    {
                        // Print Prefix.
                        
                        echo $varData[$j][0];
                        
                        // Print Content.
                        
                        if ($varData[$j][1] == "title")
                            echo Core::get(Core::WEBSITE_TITLE);
                        else if ($varData[$j][1] == "title-sufix")
                            echo Core::get(Core::WEBSITE_TITLE_SUFIX);
                        else if ($varData[$j][1] == "base")
                            echo Core::get(Core::WEBSITE_BASE);
                        else if ($varData[$j][1] == "charset")
                            echo Core::get(Core::WEBSITE_CHARSET);

                        // Print sufix.

                        if (!($varData[$j][2] == "\r\n" || $varData[$j][2] == "\n"))
                            echo $varData[$j][2];
                    }
                }
            }
            else if (StringCheck::containsNeedle($line, "$"))
            {
                $varData = self::fetchElementName($line, "$");
                
                if ($varData == null)
                    echo $line;
                else
                {
                    for ($j = 0; $j < count($varData); $j ++)
                    {
                        // Print Prefix.
                        
                        echo $varData[$j][0];
                        
                        // Print Content.
                        
                        if ($varData[$j][1] == "advert-section-1")
                            echo Adverts::getRandomAdvertString(0);
                        else if ($varData[$j][1] == "advert-section-2")
                            echo Adverts::getRandomAdvertString(1);
                        else if ($varData[$j][1] == "advert-section-3")
                            echo Adverts::getRandomAdvertString(2);
                        else if ($varData[$j][1] == "advert-section-4")
                            echo Adverts::getRandomAdvertString(3);
                        else if ($varData[$j][1] == "advert-section-5")
                            echo Adverts::getRandomAdvertString(4);

                        // Print sufix.

                        if (!($varData[$j][2] == "\r\n" || $varData[$j][2] == "\n"))
                            echo $varData[$j][2];
                    }
                }
            }
            else
                echo $line;
        }
    }
    
    private static function fetchElementName($line, $elementWall)
    {
        // Control Variables.
        
        $fwf = false; // FWF - First wall found.
        $swf = false; // SWF - Second wall found.
        
        // Data Variables.
        
        $leftSide  = "";
        $rightSide = "";
        $blockName = "";
        
        $blockData = null;
        
        for ($i = 0; $i < strlen($line); $i ++) // Loop through the line.
        {
            if ($line[$i] == $elementWall)
            {
                if ($fwf && $swf) // If found another potential block.
                {   
                    // Trim and append the previous one.
                    
                    $blockName = trim($blockName);
                    
                    $blockData[] = array($leftSide, $blockName, $rightSide);
                    
                    // Reset variables and start checking the name again.
                    
                    $fwf = $swf = false;
                    $leftSide = $blockName = $rightSide = "";
                }
                
                if (!$fwf)
                    $fwf = true;
                else
                    $swf = true;
            }
            else
            {
                if (!$fwf)
                    $leftSide .= $line[$i];
                else if ($swf)
                    $rightSide .= $line[$i];
                else
                    $blockName .= $line[$i];
            }
        }
        
        // Trim Block Name.
        
        $blockName = trim($blockName);
        
        $blockData[] = array($leftSide, $blockName, $rightSide);
        
        // Return Data.
        
        if (!$swf)
            return null;
        else
            return $blockData;
    }
}

?>