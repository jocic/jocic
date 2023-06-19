<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: notices.php                                   *|
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

// Create Core Objects.

$hdNotice        = new FHeader();
$tblNotice       = new FTable();
$rwNoticeOne     = new FTableRow();
$rwNoticeTwo     = new FTableRow();
$clNoticeIcon    = new FTableCell();
$clNoticeTitle   = new FTableCell();
$clNoticeContent = new FTableCell();
$parNotice       = new FParagraph();

// "Header Notice" Element Settings.

$hdNotice->setLevel(1);
$hdNotice->setContent(Locales::getTitle($_GET[$pnv]) . " - " . Locales::getTitle("notice-page"));

// "Table Notice" Element Settings.

$tblNotice->setID("notice-table");
$tblNotice->setClass("info-table");
$tblNotice->addRow($rwNoticeOne);
$tblNotice->addRow($rwNoticeTwo);

// "Collumn Notice Icon" Element Settings.

$clNoticeIcon->setID("notice-icon");
$clNoticeIcon->setClass("info-icon");
$clNoticeIcon->setRowSpan(2);
$clNoticeIcon->setContent(new FDiv(null, "protector", "Notice Icon"));

$rwNoticeOne->addCell($clNoticeIcon);

// "Collumn Notice Title" Element Settings.

$clNoticeTitle->setID("notice-title");
$clNoticeTitle->setClass("info-title");

$rwNoticeOne->addCell($clNoticeTitle);

// "Collumn Notice Content" Element Settings.

$clNoticeContent->setID("notice-content");
$clNoticeContent->setClass("info-content");

$rwNoticeTwo->addCell($clNoticeContent);

// "Paragraph Notice" Element Settings.

$parNotice->setAlignment(FParagraph::ALN_CENTER);

// Specific Element Settings.

if ($_GET[$pnv] == Locales::getLink("registration")) // >> Registration << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("already-registered")) // "Already Registered" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("registration-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("already-registered"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("registration-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("registration-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("log-in")) // >> Log-In << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("already-logged-in")) // "Already Logged In" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("log-in-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("already-logged-in"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("log-in-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("log-in-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("log-out")) // >> Log-Out << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("log-out-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("log-out-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("already-logged-out")) // "Already Logged Out" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("log-out-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("already-logged-out"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("resend-activation-email")) // >> Resend Activation Email << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("rem-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("rem-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("already-activated")) // "Already Activated" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("rem-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("already-activated"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("account-recovery")) // >> Account Recovery << Errors.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("logged-in")) // "Logged In" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("ar-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("ar-logged-in"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("ar-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("ar-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("activate-account")) // >> Account Activation << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("logged-in")) // "Logged In" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("aa-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("aa-logged-in"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("aa-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("aa-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("already-activated")) // "Already Activated" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("aa-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("already-activated"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("password-reset")) // >> Password Reset << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Logged In" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("pr-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("pr-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("set-language")) // >> Set Language << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("set-language"));
        $clNoticeContent->setContent(Locales::getNoticeContent("sl-success"));
        
        $parNotice = null;
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("messages")) // >> Messages << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("success")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("messages"));
        $clNoticeContent->setContent(Locales::getNoticeContent("m-success"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("your-profile")) // >> Your Profile << Notices.
{
    if ($_GET[$nnv] == Locales::getNoticeLink("password-changed")) // "Success" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("password-changed"));
        $clNoticeContent->setContent(Locales::getNoticeContent("password-changed"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$nnv] == Locales::getNoticeLink("account-deactivated")) // "Account Deactivated" Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("account-deactivated"));
        $clNoticeContent->setContent(Locales::getNoticeContent("account-deactivated"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // Unknown Notice.
    {
        $clNoticeTitle->setContent(Locales::getNoticeTitle("unknown-notice"));
        $clNoticeContent->setContent(Locales::getNoticeContent("unknown-notice"));
        
        $parNotice->setContent(Locales::getParagraph("go-home"));
        $parNotice->setLink("/");
        $parNotice->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else
{
    
}

// Build Elements.

Build::element($hdNotice);
Build::element($tblNotice);
Build::element($parNotice);

?>