<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: errors.php                                    *|
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

$prevPageLink   = "./?" . $pnv . "=" . $_GET[$pnv];
$pageTitle      = Locales::getTitle($_GET[$pnv]);

// Create "Core" Objects.

$hdError        = new FHeader();
$tblError       = new FTable();
$rwErrorOne     = new FTableRow();
$rwErrorTwo     = new FTableRow();
$clErrorIcon    = new FTableCell();
$clErrorTitle   = new FTableCell();
$clErrorContent = new FTableCell();
$parError       = new FParagraph();

// "Page Title" Variable Settings.

if ($pageTitle == "?")
    $pageTitle = Locales::getTitle("general-page");

// "Header Error" Element Settings.

$hdError->setLevel(1);
$hdError->setContent($pageTitle . " - " . Locales::getTitle("error-page"));

// "Table Error" Element Settings.

$tblError->setID("error-table");
$tblError->setClass("info-table");
$tblError->addRow($rwErrorOne);
$tblError->addRow($rwErrorTwo);

// "Collumn Error Icon" Element Settings.

$clErrorIcon->setID("error-icon");
$clErrorIcon->setClass("info-icon");
$clErrorIcon->setRowSpan(2);
$clErrorIcon->setContent(new FDiv(null, "protector", "Error Icon"));

$rwErrorOne->addCell($clErrorIcon);

// "Collumn Error Title" Element Settings.

$clErrorTitle->setID("error-title");
$clErrorTitle->setClass("info-title");

$rwErrorOne->addCell($clErrorTitle);

// "Collumn Error Content" Element Settings.

$clErrorContent->setID("error-content");
$clErrorContent->setClass("info-content");

$rwErrorTwo->addCell($clErrorContent);

// "Paragraph Error" Element Settings.

$parError->setAlignment(FParagraph::ALN_CENTER);

// Specific Element Settings.

if ($_GET[$pnv] == Locales::getLink("registration")) // >> Registration << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("captcha-error")) // "Captcha Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("captcha-error"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("terms-not-accepted")) // "Terms Not Accepted" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("terms-of-service"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("name-empty")) // "Name Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("name-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("name-length")) // "Name Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("name-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("name-content")) // "Name Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("name-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("middle-name-empty")) // "Middle Name Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("middle-name-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("middle-name-length")) // "Middle Name Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("middle-name-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("middle-name-content")) // "Middle Name Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("middle-name-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("surname-empty")) // "Surname Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("surname-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("surname-length")) // "Surname Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("surname-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("surname-content")) // "Surname Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("surname-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("gender-empty")) // "Gender" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("gender-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-gender-value")) // "Invalid Gender Value" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-gender-value"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("birthday-empty")) // "Birthday Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("birthday-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("birthday-content")) // "Birthday Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("birthday-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-birthday-date")) // "Invalid Birthday Date" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-birthday-date"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-empty")) // "Username Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-length")) // "Username Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-content")) // "Username Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-empty")) // "Password Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-length")) // "Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-content")) // "Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-empty")) // "Confirmation Password Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-length")) // "Confirmation Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-content")) // "Confirmation Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-content"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("passwords-not-equal")) // "Passwords Not Equal" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("passwords-not-equal"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-empty")) // "Email Address Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-empty"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-length")) // "Email Address Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-length"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-email-address")) // "Invalid Email Address" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-email-address"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-taken")) // "Email Taken" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-taken"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-taken")) // "Username Taken" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-taken"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("registration-failed")) // "Registration Failed" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("registration-error"));
        $clErrorContent->setContent(Locales::getErrorContent("registration-failed"));
        
        $parError->setContent(Locales::getParagraph("registration-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("registration"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("log-in")) // >>  Log-In << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("captcha-error")) // "Captcha Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("captcha-error"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-empty")) // "Username Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-empty"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-length")) // "Username Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-length"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-content")) // "Username Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("username-content"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-empty")) // "Password Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-empty"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-length")) // "Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-length"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-content")) // "Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-content"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("incorrect-username")) // "Incorrect Username" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("incorrect-username"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("incorrect-password")) // "Incorrect Password" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("incorrect-password"));
        
        $parError->setContent(Locales::getParagraph("log-in-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("log-in"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("account-pending-verification")) // "Account Pending Verification" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("account-pending-verification"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    } 
    else if ($_GET[$env] == Locales::getErrorLink("account-banned")) // "Account Banned" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("log-in-error"));
        $clErrorContent->setContent(Locales::getErrorContent("account-banned"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("resend-activation-email")) // >> Resend Activation Email << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("email-empty")) // "Email Address Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("rem-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-empty"));
        
        $parError->setContent(Locales::getParagraph("rem-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("resend-activation-email"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-length")) // "Email Address Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("rem-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-length"));
        
        $parError->setContent(Locales::getParagraph("rem-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("resend-activation-email"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-email-address")) // "Invalid Email Address" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("rem-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-email-address"));
        
        $parError->setContent(Locales::getParagraph("rem-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("resend-activation-email"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-does-not-exist")) // "Email Does Not Exist" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("rem-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-does-not-exist"));
        
        $parError->setContent(Locales::getParagraph("rem-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("resend-activation-email"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("account-recovery")) // >> Account Recovery << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("email-empty")) // "Email Address Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("ar-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-empty"));
        
        $parError->setContent(Locales::getParagraph("ar-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("account-recovery"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-length")) // "Email Address Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("ar-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-length"));
        
        $parError->setContent(Locales::getParagraph("ar-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("account-recovery"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-email-address")) // "Invalid Email Address" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("ar-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-email-address"));
        
        $parError->setContent(Locales::getParagraph("ar-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("account-recovery"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-does-not-exist")) // "Email Does Not Exist" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("ar-error"));
        $clErrorContent->setContent(Locales::getErrorContent("email-does-not-exist"));
        
        $parError->setContent(Locales::getParagraph("ar-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("account-recovery"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("account-not-active")) // "Account Not Active" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("ar-error"));
        $clErrorContent->setContent(Locales::getErrorContent("account-not-active"));
        
        $parError->setContent(Locales::getParagraph("ar-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("account-recovery"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("account-banned")) // "Account Banned" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("ar-error"));
        $clErrorContent->setContent(Locales::getErrorContent("account-banned"));
        
        $parError->setContent(Locales::getParagraph("ar-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("account-recovery"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("activate-account")) // >> Activate Account << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("key-params-missing")) // "Key Parameters Missing" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("aa-error"));
        $clErrorContent->setContent(Locales::getErrorContent("key-params-missing"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("params-not-correct")) // "Parameters Not Correct" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("aa-error"));
        $clErrorContent->setContent(Locales::getErrorContent("params-not-correct"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-account")) // "Invalid Account" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("aa-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-account"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("activation-failed")) // "Parameters Not Correct" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("aa-error"));
        $clErrorContent->setContent(Locales::getErrorContent("activation-failed"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("password-reset")) // >> Password Reset << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("key-params-missing")) // "Key Parameters Missing" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("key-params-missing"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("params-not-correct")) // "Parameters Not Correct" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("params-not-correct"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-account")) // "Invalid Account" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-account"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-empty")) // "Password Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-empty"));
        
        $paragraph = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-length")) // "Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-length"));
        
        $parError = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-content")) // "Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-content"));
        
        $parError = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-empty")) // "Confirmation Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-empty"));
        
        $parError = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-length")) // "Confirmation Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-length"));
        
        $parError = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-content")) // "Confirmation Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-content"));
        
        $parError = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("passwords-not-equal")) // "Passwords Not Equal" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("passwords-not-equal"));
        
        $parError = null;
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-reset-failed")) // "Password Reset Failed" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("pr-error"));
        $clErrorContent->setContent(Locales::getErrorContent("password-reset-failed"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("set-language")) // >> Set Language << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("no-code")) // "No Code" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("set-language"));
        $clErrorContent->setContent(Locales::getErrorContent("no-code"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-language-code")) // "Invalid Language Code" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("set-language"));
        $clErrorContent->setContent(Locales::getErrorContent("no-language-support"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("messages")) // >> Messages << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("captcha-error")) // "Captcha Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("general-page"));
        $clErrorContent->setContent(Locales::getErrorContent("captcha-error"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("to-empty")) // "To Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("to-empty"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("to-length")) // "To Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("to-length"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("to-content")) // "To Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("to-content"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-user")) // "Invalid User" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-user"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("title-empty")) // "Title Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("title-empty"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("title-length")) // "Title Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("title-length"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("content-empty")) // "Content Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("content-empty"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("content-length")) // "Content Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("content-length"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("deactivated-user")) // "Deactivated User" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("messages"));
        $clErrorContent->setContent(Locales::getErrorContent("deactivated-user"));
        
        $parError->setContent(Locales::getParagraph("retry"));
        $parError->setLink($prevPageLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("compose"));
        $parError->setLinkTitle(Locales::getTitle("compose"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else if ($_GET[$pnv] == Locales::getLink("your-profile")) // >> Your Profile << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("status-length")) // "Username Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("status-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("post-size")) // "Post Size" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("post-size"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("file-extension")) // "File Extension" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("file-extension"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("file-size")) // "File Size" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("file-size"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("file-upload")) // "File Upload" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("file-upload"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-empty")) // "Username Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("username-empty"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-length")) // "Username Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("username-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-content")) // "Username Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("username-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("username-taken")) // "Username Taken" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("username-taken"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("name-length")) // "Name Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("name-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("name-content")) // "Name Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("name-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("middle-name-length")) // "Middle Name Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("middle-name-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("middle-name-content")) // "Middle Name Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("middle-name-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("surname-length")) // "Surname Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("surname-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("surname-content")) // "Surname Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("surname-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("gender-empty")) // "Gender" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("gender-empty"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-gender-value")) // "Invalid Gender Value" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-gender-value"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("birthday-empty")) // "Birthday Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("birthday-empty"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("birthday-content")) // "Birthday Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("birthday-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-birthday-date")) // "Invalid Birthday Date" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-birthday-date"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-empty")) // "Email Address Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("email-empty"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-length")) // "Email Address Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("email-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("invalid-email-address")) // "Invalid Email Address" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("invalid-email-address"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("email-taken")) // "Email Taken" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("email-taken"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("biography-length")) // "Biography Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("biography-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("current-password")) // "Current Password" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("current-password"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-empty")) // "Password Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("password-empty"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-length")) // "Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("password-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("password-content")) // "Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("password-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-empty")) // "Confirmation Password Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-empty"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-length")) // "Confirmation Password Length" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-length"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("confirmation-password-content")) // "Confirmation Password Content" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("confirmation-password-content"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("passwords-not-equal")) // "Passwords Not Equal" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("passwords-not-equal"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else if ($_GET[$env] == Locales::getErrorLink("deactivation-failed")) // "Deactivation Failed" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("your-profile"));
        $clErrorContent->setContent(Locales::getErrorContent("deactivation-failed"));
        
        $parError->setContent(Locales::getParagraph("yp-retry"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("your-profile"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}
else // >> General << Errors.
{
    if ($_GET[$env] == Locales::getErrorLink("captcha-error")) // "Captcha Empty" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("general-page"));
        $clErrorContent->setContent(Locales::getErrorContent("captcha-error"));
        
        $parError->setContent(Locales::getParagraph("gbta"));
        $parError->setLink($prevPageLink);
        $parError->setLinkTitle(Locales::getTitle("general-page"));
    }
    else // "Unknown" Error.
    {
        $clErrorTitle->setContent(Locales::getErrorTitle("unknown-error"));
        $clErrorContent->setContent(Locales::getErrorContent("unknown-error"));
        
        $parError->setContent(Locales::getParagraph("go-home"));
        $parError->setLink("/");
        $parError->setLinkTitle(Locales::getTitle("homepage"));
    }
}

// Build Elements.

Build::element($hdError);
Build::element($tblError);
Build::element($parError);

?>