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

// Check If Option And ID Selected.

if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("edit-core-page"))
{
    // Check ID.
    
    if (empty($_GET[Locales::getVariable("id")]))
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    
    // Check ID Values.
    
    if ($_GET[Locales::getVariable("id")] < 1 || $_GET[Locales::getVariable("id")] > 3)
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    
    // Check If Edit Was Attempted.
    
    if (!$this->isPostEmpty())
    {
        if (!empty($_POST["req_content"]))
        {
            if ($_GET[Locales::getVariable("id")] == 1)
                CorePage::set($_POST["req_content"], "homepage");
            else if ($_GET[Locales::getVariable("id")] == 2)
                CorePage::set($_POST["req_content"], "terms-of-service");
            else if ($_GET[Locales::getVariable("id")] == 3)
                CorePage::set($_POST["req_content"], "privacy-policy");
        }
        
        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    }
}
else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("add"))
{
    if (!$this->isPostEmpty())
    {
        // Create "Core" Variables.
        
        $varTags     = null;
        $varCustomID = null;
        
        // "Title" Check.

        if (empty($_POST["req_title"]))
            return;

        // "Description" Check.

        if (empty($_POST["req_description"]))
            return;

        // "Content" Check.

        if (empty($_POST["req_content"]))
            return;

        // "Custom ID" Check.

        if (!empty($_POST["req_custom"]))
        {
            // Check If Custom ID is Unique.

            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $varCheck = EasyGet::execute
            (
                "TS: pages",
                "CS: COUNT(`id`)",
                "ARGS: custom_id = " . $_POST["req_custom"]
            );

            if ($varCheck[0][0] == 1)
                return;

            $varCustomID = $_POST["req_custom"];
        }

        if (Locales::getLink("$varCustomID") != "?")
            return;

        // "Tags" Check.

        if (!empty($_POST["req_tags"]))
            $varTags = $_POST["req_tags"];

        // "Comments Enabled" Check.

        if (!isset($_POST["req_comments"]))
            return;
        else if ($_POST["req_comments"] < 0 || $_POST["req_comments"] > 1)
            return;

        // Add A Page.

        $tempVLS = new ValueSelection();

        $tempVLS->addValues
        (
            array
            (
                $_POST["req_title"],
                $_POST["req_description"],
                $_POST["req_content"],
                $varCustomID,
                $varTags,
                $_POST["req_comments"]
            )
        );

        EasyInsert::execute
        (
            "TS: pages",
            "CS: title, description, content, custom_id, tags, comments_enabled",
            $tempVLS
        );

        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    }

}
else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("edit-page"))
{
    // Create "Core" Variables.
    
    $varPageID = Filter::forNumeric($_GET[Locales::getVariable("id")]);
    
    if (empty($varPageID))
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    else
    {
        if ($this->isPostEmpty())
        {
            // Check If Page Exists.

            if (!PageInfo::isCreated($varPageID))
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
        }
        else
        {
            // Create "Core" Variables.

            $varTags     = null;
            $varCustomID = null;
            
            // "Title" Check.

            if (empty($_POST["req_title"]))
                return;

            // "Description" Check.

            if (empty($_POST["req_description"]))
                return;

            // "Content" Check.

            if (empty($_POST["req_content"]))
                return;

            // "Custom ID" Check.

            if (!empty($_POST["req_custom"]))
            {
                // Check If Custom ID is Unique.

                EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

                $varCheck = EasyGet::execute
                (
                    "TS: pages",
                    "CS: COUNT(`id`)",
                    "ARGS: id <> " . $varPageID . " AND custom_id = " . $_POST["req_custom"]
                );

                if ($varCheck[0][0] == 1)
                    return;

                $varCustomID = $_POST["req_custom"];
            }
            
            // "Tags" Check.
            
            if (!empty($_POST["req_tags"]))
                $varTags = $_POST["req_tags"];

            // "Comments Enabled" Check.

            if (!isset($_POST["req_comments"]))
                return;
            else if ($_POST["req_comments"] < 0 || $_POST["req_comments"] > 1)
                return;

            // "Published" Check.

            if (!isset($_POST["req_published"]))
                return;
            else if ($_POST["req_published"] < 0 || $_POST["req_published"] > 1)
                return;

            // Edit A Page.
            
            $tempVLS = new ValueSelection();

            $tempVLS->addValues
            (
                array
                (
                    $_POST["req_title"],
                    $_POST["req_description"],
                    $_POST["req_content"],
                    $varCustomID,
                    $varTags,
                    $_POST["req_published"],
                    $_POST["req_comments"]
                )
            );

            EasyUpdate::execute
            (
                "TS: pages",
                "CS: title, description, content, custom_id, tags, published, comments_enabled",
                $tempVLS,
                "ARGS: id = " . $varPageID
            );
            
            // Reddirect.

            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
        }
    }
}
else if (!empty($_GET[Locales::getVariable("option")]) && $_GET[Locales::getVariable("option")] == Locales::getLink("delete-page"))
{
    // Create "Core" Variables.
    
    $varPageID = Filter::forNumeric($_GET[Locales::getVariable("id")]);
    
    if (empty($varPageID))
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    else
    {
        // Fetch Page Data.

        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $varCheck = EasyGet::execute
        (
            "TS: pages",
            "CS: COUNT(`id`)",
            "ARGS: id = $varPageID"
        );

        // Check If Comment Exists.

        if ($varCheck[0][0] != 1)
            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));

        // Delete Comment.

        EasyDelete::execute
        (
            "TS: pages",
            "ARGS: id = $varPageID"
        );

        // Reddirect.

        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("pages")));
    }
}

?>