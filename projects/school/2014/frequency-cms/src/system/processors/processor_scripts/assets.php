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

if (!empty($_GET[Locales::getVariable("option")]))
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("picture-assets")) // # PICTURE ASSETS #
    {
        if (!empty($_GET[Locales::getVariable("suboption")]))
        {
            if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset")) // >> ADD OPTION <<
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("post-size")));
                
                if (!empty($_FILES["req_file"])) // Check If File Exists.
                {
                    // Create "Core" Variables.

                    $varFile          = $_FILES["req_file"];
                    $varError         = $_FILES["req_file"]["error"];
                    $varFilename      = basename($_FILES["req_file"]["name"]);
                    $varExtension     = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAssetName     = "/";
                    $varAssetFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    // "Asset Name" Variable Settings.

                    if (!empty($_POST["req_name"]))
                        $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_file"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if (($varExtension == "jpg") ||
                                ($varExtension == "jpeg") ||
                                ($varExtension == "gif") ||
                                ($varExtension == "png"))
                            {

                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "images" .
                                               DIRECTORY_SEPARATOR .
                                               $varAssetFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        EasyInsert::execute
                                        (
                                            "TS: assets",
                                            "CS: type, name, filename",
                                            "VLS: 0, $varAssetName, $varAssetFilename"
                                        );
                                    }
                                }

                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets")));
                            }
                            else
                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-upload")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset")) // >> EDIT OPTION <<
            {
                if (!$this->isPostEmpty())
                {
                    if (!empty($_GET[Locales::getVariable("id")]))
                    {
                        // Create "Core" Variables.

                        $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                        $varAssetName     = "/";

                        // "Asset Name" Variable Settings.

                        if (!empty($_POST["req_name"]))
                            $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                        // Alter Data.

                        EasyUpdate::execute
                        (
                            "TS: assets",
                            "CS: name",
                            "VLS: " . $varAssetName,
                            "ARGS: id = " . $varAssetID
                        );
                    }

                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("delete-asset")) // >> DELETE OPTION <<
            {
                if (!empty($_GET[Locales::getVariable("id")]))
                {
                    // Create "Core" Variables.

                    $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                    $varAssetFilename = Assets::fetchAssetFilename($varAssetID);
                    $varLocation      = DOC_ROOT . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $varAssetFilename;

                    // Delete A File If Exists.

                    if (file_exists($varLocation) && unlink($varLocation))
                    {
                        // Delete Database Data.

                        EasyDelete::execute
                        (
                            "TS: assets",
                            "ARGS: id = $varAssetID"
                        );
                    }
                }

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("picture-assets")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("video-assets")) // # VIDEO ASSETS #
    {
        if (!empty($_GET[Locales::getVariable("suboption")]))
        {
            if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset")) // >> ADD OPTION <<
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("post-size")));
                
                if (!empty($_FILES["req_file"])) // Check If File Exists.
                {
                    // Create "Core" Variables.

                    $varFile          = $_FILES["req_file"];
                    $varError         = $_FILES["req_file"]["error"];
                    $varFilename      = basename($_FILES["req_file"]["name"]);
                    $varExtension     = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAssetName     = "/";
                    $varAssetFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    // "Asset Name" Variable Settings.

                    if (!empty($_POST["req_name"]))
                        $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_file"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if (($varExtension == "avi") ||
                                ($varExtension == "wmv") ||
                                ($varExtension == "mp4") ||
                                ($varExtension == "flv") ||
                                ($varExtension == "ogv"))
                            {
                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "videos" .
                                               DIRECTORY_SEPARATOR .
                                               $varAssetFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        EasyInsert::execute
                                        (
                                            "TS: assets",
                                            "CS: type, name, filename",
                                            "VLS: 1, $varAssetName, $varAssetFilename"
                                        );
                                    }
                                }

                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets")));
                            }
                            else
                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-upload")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset")) // >> EDIT OPTION <<
            {
                if (!$this->isPostEmpty())
                {
                    if (!empty($_GET[Locales::getVariable("id")]))
                    {
                        // Create "Core" Variables.

                        $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                        $varAssetName     = "/";

                        // "Asset Name" Variable Settings.

                        if (!empty($_POST["req_name"]))
                            $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                        // Alter Data.

                        EasyUpdate::execute
                        (
                            "TS: assets",
                            "CS: name",
                            "VLS: " . $varAssetName,
                            "ARGS: id = " . $varAssetID
                        );
                    }

                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("delete-asset")) // >> DELETE OPTION <<
            {
                if (!empty($_GET[Locales::getVariable("id")]))
                {
                    // Create "Core" Variables.

                    $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                    $varAssetFilename = Assets::fetchAssetFilename($varAssetID);
                    $varLocation      = DOC_ROOT . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "videos" . DIRECTORY_SEPARATOR . $varAssetFilename;

                    // Delete A File If Exists.

                    if (file_exists($varLocation) && unlink($varLocation))
                    {
                        // Delete Database Data.

                        EasyDelete::execute
                        (
                            "TS: assets",
                            "ARGS: id = $varAssetID"
                        );
                    }
                }

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("video-assets")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("audio-assets")) // # AUDIO ASSETS #
    {
        if (!empty($_GET[Locales::getVariable("suboption")]))
        {
            if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset")) // >> ADD OPTION <<
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("post-size")));
                
                if (!empty($_FILES["req_file"])) // Check If File Exists.
                {
                    // Create "Core" Variables.

                    $varFile          = $_FILES["req_file"];
                    $varError         = $_FILES["req_file"]["error"];
                    $varFilename      = basename($_FILES["req_file"]["name"]);
                    $varExtension     = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAssetName     = "/";
                    $varAssetFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    // "Asset Name" Variable Settings.

                    if (!empty($_POST["req_name"]))
                        $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_file"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if (($varExtension == "mp3") ||
                                ($varExtension == "wma"))
                            {
                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "audio" .
                                               DIRECTORY_SEPARATOR .
                                               $varAssetFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        EasyInsert::execute
                                        (
                                            "TS: assets",
                                            "CS: type, name, filename",
                                            "VLS: 2, $varAssetName, $varAssetFilename"
                                        );
                                    }
                                }

                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets")));
                            }
                            else
                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-upload")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset")) // >> EDIT OPTION <<
            {
                if (!$this->isPostEmpty())
                {
                    if (!empty($_GET[Locales::getVariable("id")]))
                    {
                        // Create "Core" Variables.

                        $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                        $varAssetName     = "/";

                        // "Asset Name" Variable Settings.

                        if (!empty($_POST["req_name"]))
                            $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                        // Alter Data.

                        EasyUpdate::execute
                        (
                            "TS: assets",
                            "CS: name",
                            "VLS: " . $varAssetName,
                            "ARGS: id = " . $varAssetID
                        );
                    }

                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("delete-asset")) // >> DELETE OPTION <<
            {
                if (!empty($_GET[Locales::getVariable("id")]))
                {
                    // Create "Core" Variables.

                    $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                    $varAssetFilename = Assets::fetchAssetFilename($varAssetID);
                    $varLocation      = DOC_ROOT . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "audio" . DIRECTORY_SEPARATOR . $varAssetFilename;

                    // Delete A File If Exists.

                    if (file_exists($varLocation) && unlink($varLocation))
                    {
                        // Delete Database Data.

                        EasyDelete::execute
                        (
                            "TS: assets",
                            "ARGS: id = $varAssetID"
                        );
                    }
                }

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("audio-assets")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("archive-assets")) // # ARCHIVE ASSETS #
    {
        if (!empty($_GET[Locales::getVariable("suboption")]))
        {
            if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset")) // >> ADD OPTION <<
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("post-size")));
                
                if (!empty($_FILES["req_file"])) // Check If File Exists.
                {
                    // Create "Core" Variables.

                    $varFile          = $_FILES["req_file"];
                    $varError         = $_FILES["req_file"]["error"];
                    $varFilename      = basename($_FILES["req_file"]["name"]);
                    $varExtension     = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAssetName     = "/";
                    $varAssetFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    // "Asset Name" Variable Settings.

                    if (!empty($_POST["req_name"]))
                        $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_file"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if (($varExtension == "zip") ||
                                ($varExtension == "rar") ||
                                ($varExtension == "7z"))
                            {
                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "archives" .
                                               DIRECTORY_SEPARATOR .
                                               $varAssetFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        EasyInsert::execute
                                        (
                                            "TS: assets",
                                            "CS: type, name, filename",
                                            "VLS: 3, $varAssetName, $varAssetFilename"
                                        );
                                    }
                                }

                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets")));
                            }
                            else
                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-upload")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset")) // >> EDIT OPTION <<
            {
                if (!$this->isPostEmpty())
                {
                    if (!empty($_GET[Locales::getVariable("id")]))
                    {
                        // Create "Core" Variables.

                        $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                        $varAssetName     = "/";

                        // "Asset Name" Variable Settings.

                        if (!empty($_POST["req_name"]))
                            $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                        // Alter Data.

                        EasyUpdate::execute
                        (
                            "TS: assets",
                            "CS: name",
                            "VLS: " . $varAssetName,
                            "ARGS: id = " . $varAssetID
                        );
                    }

                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("delete-asset")) // >> DELETE OPTION <<
            {
                if (!empty($_GET[Locales::getVariable("id")]))
                {
                    // Create "Core" Variables.

                    $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                    $varAssetFilename = Assets::fetchAssetFilename($varAssetID);
                    $varLocation      = DOC_ROOT . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR . $varAssetFilename;

                    // Delete A File If Exists.

                    if (file_exists($varLocation) && unlink($varLocation))
                    {
                        // Delete Database Data.

                        EasyDelete::execute
                        (
                            "TS: assets",
                            "ARGS: id = $varAssetID"
                        );
                    }
                }

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("archive-assets")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("document-assets")) // # DOCUMENT ASSETS #
    {
        if (!empty($_GET[Locales::getVariable("suboption")]))
        {
            if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset")) // >> ADD OPTION <<
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("post-size")));
                
                if (!empty($_FILES["req_file"])) // Check If File Exists.
                {
                    // Create "Core" Variables.

                    $varFile          = $_FILES["req_file"];
                    $varError         = $_FILES["req_file"]["error"];
                    $varFilename      = basename($_FILES["req_file"]["name"]);
                    $varExtension     = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAssetName     = "/";
                    $varAssetFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    // "Asset Name" Variable Settings.

                    if (!empty($_POST["req_name"]))
                        $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_file"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if (($varExtension == "pdf") ||
                                ($varExtension == "txt") ||
                                ($varExtension == "doc") ||
                                ($varExtension == "docx"))
                            {
                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "documents" .
                                               DIRECTORY_SEPARATOR .
                                               $varAssetFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        EasyInsert::execute
                                        (
                                            "TS: assets",
                                            "CS: type, name, filename",
                                            "VLS: 4, $varAssetName, $varAssetFilename"
                                        );
                                    }
                                }

                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets")));
                            }
                            else
                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-upload")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset")) // >> EDIT OPTION <<
            {
                if (!$this->isPostEmpty())
                {
                    if (!empty($_GET[Locales::getVariable("id")]))
                    {
                        // Create "Core" Variables.

                        $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                        $varAssetName     = "/";

                        // "Asset Name" Variable Settings.

                        if (!empty($_POST["req_name"]))
                            $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                        // Alter Data.

                        EasyUpdate::execute
                        (
                            "TS: assets",
                            "CS: name",
                            "VLS: " . $varAssetName,
                            "ARGS: id = " . $varAssetID
                        );
                    }

                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("delete-asset")) // >> DELETE OPTION <<
            {
                if (!empty($_GET[Locales::getVariable("id")]))
                {
                    // Create "Core" Variables.

                    $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                    $varAssetFilename = Assets::fetchAssetFilename($varAssetID);
                    $varLocation      = DOC_ROOT . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "documents" . DIRECTORY_SEPARATOR . $varAssetFilename;

                    // Delete A File If Exists.

                    if (file_exists($varLocation) && unlink($varLocation))
                    {
                        // Delete Database Data.

                        EasyDelete::execute
                        (
                            "TS: assets",
                            "ARGS: id = $varAssetID"
                        );
                    }
                }

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("document-assets")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
        }
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("other-assets")) // # OTHER ASSETS #
    {
        if (!empty($_GET[Locales::getVariable("suboption")]))
        {
            if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("add-asset")) // >> ADD OPTION <<
            {
                // Check If Post Data Length Is OK.
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST) && empty($_FILES) && $_SERVER["CONTENT_LENGTH"] > 0)
                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("post-size")));
                
                if (!empty($_FILES["req_file"])) // Check If File Exists.
                {
                    // Create "Core" Variables.

                    $varFile          = $_FILES["req_file"];
                    $varError         = $_FILES["req_file"]["error"];
                    $varFilename      = basename($_FILES["req_file"]["name"]);
                    $varExtension     = strtolower(substr($varFilename, strrpos($varFilename, ".") + 1));
                    $varAssetName     = "/";
                    $varAssetFilename = sha1($varFilename . "_" . rand(0, 9999999) . "_" . rand(0, 9999999) . "_" . rand(0, 9999999)) . "." . $varExtension;

                    // "Asset Name" Variable Settings.

                    if (!empty($_POST["req_name"]))
                        $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                    if ($varError == 0) // Check If File Doesn't Contain Any Errors.
                    {
                        if ($_FILES["req_file"]["size"] < 2000000) // Check The File Type And If Files Size Is Less Than 2 MB.
                        {
                            if ($varExtension != "php")
                            {
                                // Determine The Path To Which We Want To Save This File.

                                $varLocation = DOC_ROOT .
                                               DIRECTORY_SEPARATOR .
                                               "assets" .
                                               DIRECTORY_SEPARATOR .
                                               "other" .
                                               DIRECTORY_SEPARATOR .
                                               $varAssetFilename;

                                if (!file_exists($varLocation)) // Check If The File With The Same Name Is Already Exists On The Server.
                                {
                                    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $varLocation))  // Attempt To Move The Uploaded File To It's New Place.
                                    {
                                        EasyInsert::execute
                                        (
                                            "TS: assets",
                                            "CS: type, name, filename",
                                            "VLS: 5, $varAssetName, $varAssetFilename"
                                        );
                                    }
                                }

                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets")));
                            }
                            else
                                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-extension")));
                        }
                        else
                            exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-size")));
                    }
                    else
                        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets") . "&" . Locales::getVariable("suboption") . "=" . Locales::getLink("add-asset") . "&" . Locales::getVariable("error") . "=" . Locales::getErrorLink("file-upload")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("edit-asset")) // >> EDIT OPTION <<
            {
                if (!$this->isPostEmpty())
                {
                    if (!empty($_GET[Locales::getVariable("id")]))
                    {
                        // Create "Core" Variables.

                        $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                        $varAssetName     = "/";

                        // "Asset Name" Variable Settings.

                        if (!empty($_POST["req_name"]))
                            $varAssetName = Filter::forAlphaNumericWithSpace($_POST["req_name"]);

                        // Alter Data.

                        EasyUpdate::execute
                        (
                            "TS: assets",
                            "CS: name",
                            "VLS: " . $varAssetName,
                            "ARGS: id = " . $varAssetID
                        );
                    }

                    exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets")));
                }
            }
            else if ($_GET[Locales::getVariable("suboption")] == Locales::getLink("delete-asset")) // >> DELETE OPTION <<
            {
                if (!empty($_GET[Locales::getVariable("id")]))
                {
                    // Create "Core" Variables.

                    $varAssetID       = Filter::forNumeric($_GET[Locales::getVariable("id")]);
                    $varAssetFilename = Assets::fetchAssetFilename($varAssetID);
                    $varLocation      = DOC_ROOT . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "other" . DIRECTORY_SEPARATOR . $varAssetFilename;

                    // Delete A File If Exists.

                    if (file_exists($varLocation) && unlink($varLocation))
                    {
                        // Delete Database Data.

                        EasyDelete::execute
                        (
                            "TS: assets",
                            "ARGS: id = $varAssetID"
                        );
                    }
                }

                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("other-assets")));
            }
            else
                exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
        }
    }
    else
        exit(header("location: " . $this->getCoreLink() . "&" . Locales::getVariable("workplace") . "=" . Locales::getLink("assets")));
}

?>