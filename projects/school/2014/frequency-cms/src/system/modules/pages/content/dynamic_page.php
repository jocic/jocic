<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: dynamic_page.php                              *|
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

// Set Blank Prefix.

Build::setBlankPrefix($this->getBlankPrefix());

// Create "Core" Variables.

$varPageID                  = $_GET[Locales::getVariable("page")];
$varPageTitle               = null;
$varPageURL                 = "http://" . Core::get(Core::WEBSITE_BASE) . "/?" . Locales::getVariable("page") . "=" . $varPageID;
$varShareInfo               = null;
$varViewProfilePrefix       = "./?" . Locales::getVariable("page") . "=" . Locales::getLink("view-profile") . "&" . Locales::getVariable("id") . "=";
$varCommentPagePrefix       = "./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-comments") . "&" . Locales::getVariable("comment-page") . "=";
$varCommentPageNumber       = 0;

// Create "Core" Elements.

$hdDynamicPage           = new FHeader();
$divDynamicPageContent   = new FDiv();
$divSocialButtons        = new FDiv();
$divPageOptions          = new FDiv();
$divPageOptionsLeftSide  = new FDiv();
$divPageOptionsRightSide = new FDiv();
$lnkCommentNummber       = new FAnchor();
$lnkCommentOption        = new FAnchor();
$divPageCommentSection   = new FDiv();
$divPageCommentOptions   = new FDiv();
$divPageComments         = new FDiv();
$divPageCommentNumbers   = new FDiv();
$fmComment               = new FForm();
$divPostComment          = new FDiv();
$parToComment            = new FParagraph();
$parLogInToComment       = new FParagraph();

// Create "Div" Elements.

$divCommentTitle         = new FDiv();
$divCommentContent       = new FDiv();
$divCaptcha              = new FDiv();
$divSubmit               = new FDiv();

// Create "Input" Elements.

$txtComment              = new FTextArea();
$inpCaptcha              = new FInput();
$btnSubmit               = new FButton();

// "Page ID" Variable Settings.

if (!is_numeric($varPageID))
    $varPageID = PageInfo::convertCustomID($varPageID);

// "Page Title" Variable Settings.

$varPageTitle = PageInfo::getTitle($varPageID);

// "Share Info" Variable Settings.

$varShareInfo = Core::get(Core::WEBSITE_TITLE) . " - " . $varPageTitle;

// "Comment Page Number" Variable Settings.

if (!empty($_GET[Locales::getVariable("comment-page")]))
    $varCommentPageNumber = Filter::forNumeric($_GET[Locales::getVariable("comment-page")] - 1);

// "Header Dynamic Page" Element Settings.

$hdDynamicPage->setLevel(1);
$hdDynamicPage->setContent($varPageTitle);

// "Div Dynamic Page Content" Element Settings.

$divDynamicPageContent->setID("page-content");
$divDynamicPageContent->setContent(PageInfo::getContent($varPageID));

// "Div Social Buttons" Element Settings.

$divSocialButtons->setID("social-buttons");

$divSocialButtons->addElement("<script src=\"../../../../system/assets/scripts/social_integration.js\" type=\"text/javascript\"></script>");
$divSocialButtons->addElement(new FDiv("twitter-button", "social-button", "<a href=\"https://twitter.com/intent/tweet?original_referer=$varPageURL&url=$varPageURL&count-url=$varPageURL&text=$varShareInfo\" target=\"_blank\" class=\"twitter-share-button\" data-url=\"$varPageURL\" data-counturl=\"$varPageURL\" data-text=\"$varShareInfo\" data-lang=\"en\" data-count=\"vertical\">Tweet</a>"));
$divSocialButtons->addElement(new FDiv("google-button", "social-button", "<g:plusone size=\"tall\"><a href=\"https://plus.google.com/share?url=$varPageURL\" target=\"_blank\">G +1</a></g:plusone>"));
$divSocialButtons->addElement(new FDiv("facebook-like-button", "social-button", "<div class=\"fb-like\" data-href=\"$varPageURL\" data-layout=\"box_count\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"><a href=\"http://www.facebook.com/sharer.php?u=$varPageURL\" target=\"_blank\">Like</a></div>"));
$divSocialButtons->addElement(new FDiv("facebook-share-button", "social-button", "<div class=\"fb-share-button\" data-href=\"$varPageURL\" data-type=\"box_count\"><a href=\"http://www.facebook.com/sharer.php?u=$varPageURL\" target=\"_blank\">Share</a></div>"));
$divSocialButtons->addElement(new FDiv(null, "clr"));

// "Div Page Options" Element Settings.

$divPageOptions->setID("page-options");

$divPageOptions->addElement($divPageOptionsLeftSide);
$divPageOptions->addElement($divPageOptionsRightSide);
$divPageOptions->addElement(new FDiv(null, "clr"));

// "Div Page Options Left Side" Element Settings.

$divPageOptionsLeftSide->setClass("left-half");

$commentNumbers = Comments::countPageComments($varPageID);

if ($commentNumbers == 0)
    $divPageOptionsLeftSide->addElement(Locales::getCore("number-of-comments") . ": " . $commentNumbers);
else
    $divPageOptionsLeftSide->addElement($lnkCommentNummber);

// "Div Page Options Right Side" Element Settings.

$divPageOptionsRightSide->setClass("right-half");

if (Session::isActive())
    $divPageOptionsRightSide->addElement($lnkCommentOption);

// "Link Comment Number" Element Settings.

$lnkCommentNummber->setContent(Locales::getCore("number-of-comments") . ": " . $commentNumbers);
$lnkCommentNummber->setLink("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-comments"));

// "Link Comment Option" Element Settings.

$lnkCommentOption->setContent(Locales::getCore("comment"));
$lnkCommentOption->setLink("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("comment"));

// "Div Page Comment Section" Element Settings.

$divPageCommentSection->setID("page-comment-section");

$divPageCommentSection->addElement($fmComment);

// "Div Page Comment "

$divPageCommentOptions->setID("page-comment-options");

if (Session::isActive())
    $divPageCommentOptions->addElement($parToComment);
else
    $divPageCommentOptions->addElement($parLogInToComment);

// "Div Page Comments" Element Settings.

$divPageComments->setID("page-comments");

$commentArray = Comments::fetchPageComments($varPageID, $varCommentPageNumber * 10);

if (is_array($commentArray))
{
    $commentCount = 1;

    foreach ($commentArray as $comment)
    {
        $varTempUsername = InfoFetch::fetchUsername($comment["sender_id"]);
        $varTempAvatar   = InfoFetch::fetchAvatar($comment["sender_id"]);
        $varAvatarHolder = new FDiv(null, "comment-profile-image", $varTempUsername);
        
        if (empty($varTempAvatar))
            $varAvatarHolder->setStyle("background: url(" . CMS_ROOT . "system/assets/images/other/no_avatar.png) no-repeat center center; background-size: auto 100px;");
        else
            $varAvatarHolder->setStyle("background: url(" . CMS_ROOT . "assets/avatars/" . $varTempAvatar . ") no-repeat center center; background-size: auto 100px;");
        
        $divTempComment  = new FDiv();

        $divTempComment->setID("page-comment-$commentCount");
        $divTempComment->setClass("page-comment-holder");

        $divTempComment->addElement($varAvatarHolder);
        $divTempComment->addElement(new FDiv(null, "comment-poster", "<a href=\"$varViewProfilePrefix" . $comment["sender_id"] . "\">" . $varTempUsername . "</a>"));
        $divTempComment->addElement(new FDiv(null, "comment-content", $comment["content"]));
        $divTempComment->addElement(new FDiv(null, "clr"));
        
        
        $divPageComments->addElement($divTempComment);

        $commentCount ++;
    }
    
    if ($commentNumbers > 10)
    {
        $divPageComments->addElement($divPageCommentNumbers);
        
        for ($i = 0; $i < ($commentNumbers / 10); $i ++)
        {
            if ($i == $varCommentPageNumber)
                $divPageCommentNumbers->addElement("<strong>" . ($i + 1) . "</strong>");
            else
                $divPageCommentNumbers->addElement("<a href=\"" . $varCommentPagePrefix . ($i + 1) . "\">" . ($i + 1) . "</a>");
        }
    }
}

// "Div Page Comment Numbers" Element Settings.

$divPageCommentNumbers->setID("comment-page-numbers");

// "Form Comment" Element Settings.

$fmComment->setID("comment-form");
$fmComment->setClass("default-form");
$fmComment->setMethod(FForm::MTD_POST);
$fmComment->setAction("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("comment"));

$fmComment->addItem($divPostComment);

// "Div Post Comment" Element Settings.

$divPostComment->setID("post-comment-holder");

$divPostComment->addElement($divCommentTitle);
$divPostComment->addElement($divCommentContent);

if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
    $divPostComment->addElement($divCaptcha);

$divPostComment->addElement($divSubmit);
$divPostComment->addElement(new FDiv(null, "clr"));

// "Paragraph To Comment" Element Settings.

$parToComment->setID("comment-options");
$parToComment->setClass("comments-info");
$parToComment->setAlignment(FParagraph::ALN_CENTER);
$parToComment->setContent(Locales::getParagraph("to-comment"));
$parToComment->setLink("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("comment"));

// "Paragraph Log In To Comment" Element Settings.

$parLogInToComment->setID("comment-options");
$parLogInToComment->setClass("comments-info");
$parLogInToComment->setAlignment(FParagraph::ALN_CENTER);
$parLogInToComment->setContent(Locales::getParagraph("log-in-to-comment"));
$parLogInToComment->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("log-in"));

// "Div Comment Title" Element Settings.

$divCommentTitle->setID("comment-title");
$divCommentTitle->addElement(new FDiv(null, null, Locales::getCore("comment")));

// "Div Comment Content" Element Settings.

$divCommentContent->setID("comment-content");
$divCommentContent->addElement(new FDiv(null, null, $txtComment));

// "Div Captcha" Element Settings.

$divCaptcha->setID("comment-captcha");
$divCaptcha->addElement(new FDiv(null, null, array(new FLabel("comment-captcha", Captcha::getChallenge()), $inpCaptcha)));

// "Div Submit" Element Settings.

$divSubmit->setID("comment-submit");
$divSubmit->addElement(new FDiv(null, null, $btnSubmit));

// "Textarea Comment" Element Settings.

$txtComment->setID("comment");
$txtComment->setName("req_comment");
$txtComment->setContent(null);
$txtComment->setMaxLength(1000);

// "Input Captcha" Element Settings.

$inpCaptcha->setID("captcha-input");
$inpCaptcha->setClass("form-input");
$inpCaptcha->setMaxLength(2);
$inpCaptcha->setType(FInput::TP_TEXT);
$inpCaptcha->setName("req_captcha");

// "Input Submit" Element Settings.

$btnSubmit->setID("comment-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("post"));

// Build Elements.

Build::element($hdDynamicPage);
Build::element($divDynamicPageContent);

if (Core::get(Core::SOCIAL_INTEGRATION) == "yes")
    Build::element($divSocialButtons);

if (PageInfo::isCommentingEnabled($varPageID))
{
    if (empty($_GET[Locales::getVariable("option")]))
        Build::element($divPageOptions);
    else
    {
        if ($_GET[Locales::getVariable("option")] == Locales::getLink("comment"))
            Build::element($divPageCommentSection);
        else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-comments"))
            Build::element($divPageCommentOptions);
        
        Build::element($divPageComments);
    }
}

// Increment Page Hits.
            
Statistics::incrementPageHits();

?>