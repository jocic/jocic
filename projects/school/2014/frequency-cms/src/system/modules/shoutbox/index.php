<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: index.php                                     *|
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

$varPosts             = Shoutbox::fetchRecentPosts();
$varViewProfilePrefix = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("view-profile") . "&" . Locales::getVariable("id") . "=";

// Create "Main" Elements.

$hdShoutbox           = new FHeader();
$divPosts             = new FDiv();
$divOptions           = new FDiv();
$fmShoutbox           = new FForm();

// Create "Input" Elements.

$txtContent           = new FTextArea();
$btnSubmit            = new FButton();

// "Header" Element Settings.

$hdShoutbox->setLevel(1);
$hdShoutbox->setContent(Locales::getCore("shoutbox"));

// "Div Posts" Element Settings.

$divPosts->setID("shoutbox-posts");

if ($varPosts == null)
    $divPosts->addElement(new FDiv("shoutbox-info", null, Locales::getParagraph("no-shoutbox-posts")));
else
{
    foreach ($varPosts as $varPost)
    {
        // Create "Temp" Variables.
        
        $varPosterID  = $varPost["poster_id"];
        $varTimestamp = explode(" ", $varPost["timestamp"]);
        $varPoster    = InfoFetch::fetchUsername($varPosterID);
        $varContent   = $varPost["content"];
        
        // Create "Temp" Elements.
        
        $tempPost     = new FDiv();
        $tempInfo     = new FDiv();
        $tempDelete   = new FAnchor();
        
        // "Temp Timestamp" Variable Settings.
        
        $varTimestamp = $varTimestamp[1];
        
        // "Temp Content" Variable Settings.
        
        $varContent = str_replace("]:)", "<img src=\"./../../../system/assets/images/smileys/devil.png\" alt=\"*devil*\" />", $varContent);
        $varContent = str_replace(":)", "<img src=\"./../../../system/assets/images/smileys/smiling.png\" alt=\"*smiling*\" />", $varContent);
        $varContent = str_replace(";)", "<img src=\"./../../../system/assets/images/smileys/winking.png\" alt=\"*winking*\" />", $varContent);
        $varContent = str_replace(":(", "<img src=\"./../../../system/assets/images/smileys/frowning.png\" alt=\"*frowning*\" />", $varContent);
        $varContent = str_replace(":D", "<img src=\"./../../../system/assets/images/smileys/grinning.png\" alt=\"*grinning*\" />", $varContent);
        $varContent = str_replace(":P", "<img src=\"./../../../system/assets/images/smileys/tongue_out.png\" alt=\"*tongue_out*\" />", $varContent);
        $varContent = str_replace(":/", "<img src=\"./../../../system/assets/images/smileys/unsure.png\" alt=\"*unsure*\" />", $varContent);
        $varContent = str_replace("xD", "<img src=\"./../../../system/assets/images/smileys/laughing.png\" alt=\"*laughing*\" />", $varContent);
        $varContent = str_replace(":3", "<img src=\"./../../../system/assets/images/smileys/cute.png\" alt=\"*cute*\" />", $varContent);
        $varContent = str_replace("o.O", "<img src=\"./../../../system/assets/images/smileys/surprised_1.png\" alt=\"*surprised*\" />", $varContent);
        $varContent = str_replace("O.o", "<img src=\"./../../../system/assets/images/smileys/surprised_2.png\" alt=\"*surprised*\" />", $varContent);
        $varContent = str_replace("^^", "<img src=\"./../../../system/assets/images/smileys/shy.png\" alt=\"*shy*\" />", $varContent);
        
        // "Temp Post" Element Settings.
        
        $tempPost->setClass("shoutbox-post");

        $tempPost->addElement($tempInfo);
        $tempPost->addElement(new FDiv(null, "shoutbox-content", $varContent));

        // "Temp Info" Element Settings.
        
        $tempInfo->setClass("shoutbox-info");
        
        $tempInfo->addElement(new FDiv(null, "shoutbox-poster", "<a href=\"" . $varViewProfilePrefix . $varPosterID . "\">" . $varPoster . "</a>"));
        $tempInfo->addElement(new FDiv(null, "shoutbox-timestamp", $varTimestamp));
        $tempInfo->addElement(new FDiv(null, "clr"));
        
        // Add Child Element To Parent Element.
        
        $divPosts->addElement($tempPost);
    }
}

// "Div Options" Element Settings.

$divOptions->setID("shoutbox-options");

$divOptions->addElement($fmShoutbox);

// "Form Shoutbox" Element Settings.

$fmShoutbox->setID("shoutbox-form");
$fmShoutbox->setClass("default-form");
$fmShoutbox->setMethod(FForm::MTD_POST);
$fmShoutbox->setAction("");

$fmShoutbox->addItem(new FDiv("shoutbox-textarea", null, $txtContent));
$fmShoutbox->addItem(new FDiv("shoutbox-submit", null, $btnSubmit));

// "Input Content" Element Settings.

$txtContent->setID("content-input");
$txtContent->setClass("form-textarea");
$txtContent->setMaxLength(255);
$txtContent->setName("req_shout");

// "Button Submit" Element Settings.

$btnSubmit->setID("compose-submit-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FButton::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("post"));

// Build Elements.

Build::element($hdShoutbox);
Build::element($divPosts);

if (Session::isActive())
    Build::element($divOptions);

?>