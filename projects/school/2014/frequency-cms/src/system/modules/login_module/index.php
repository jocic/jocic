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

// Module Starts.

if (Session::isActive())
{
    // Create "Core" Elements.
    
    $varSufix             = null;
    
    // Create "Main" Elements.

    $hdLoginModule        = new FHeader();
    $divLoginModuleHolder = new FDiv();
    $divOptionAdmin       = new FDiv();
    $divOptionProfile     = new FDiv();
    $divOptionMessages    = new FDiv();
    $divOptionLogOut      = new FDiv();
    
    // "Sufix" Variable Settings.
    
    // "Header Login Module" Element Settings.
    
    $hdLoginModule->setLevel(1);
    $hdLoginModule->setContent(Locales::getCore("user-options"));
    
    // "Div Login Module Holder" Element Settings.
    
    $divLoginModuleHolder->setID("user-options");
    
    $usersID     = IDFetch::byUsername(Session::getUsername());
    $usersStatus = InfoFetch::fetchStatus($usersID);
    
    if (Messages::newReceived($usersID))
        $varSufix = "<strong>" . Locales::getCore("new") . "</strong>";
    
    if ($usersStatus == Account::STS_SUPER_ADMIN ||  $usersStatus == Account::STS_ADMIN)
        $divLoginModuleHolder->addElement($divOptionAdmin);
    
    $divLoginModuleHolder->addElement($divOptionProfile);
    $divLoginModuleHolder->addElement($divOptionMessages);
    $divLoginModuleHolder->addElement($divOptionLogOut);
    $divLoginModuleHolder->addElement(new FDiv(null, "clr"));
    
    // "Div Option Admin" Element Settings.
    
    $divOptionAdmin->setID("user-option-site-administration");
    $divOptionAdmin->setClass("item");
    $divOptionAdmin->addElement(new FDiv("option-icon-site-administration", "option-icon", new FDiv(null, "protector", Locales::getTitle("site-administration"))));
    $divOptionAdmin->addElement(new FDiv(null, "option-link", new FAnchor(null, null, "./?" . Locales::getVariable("page") . "=" . Locales::getLink("site-administration"), Locales::getTitle("site-administration"), Locales::getTitle("site-administration"))));
    
    // "Div Option Profile" ELement Settings.
    
    $divOptionProfile->setID("user-option-your-profile");
    $divOptionProfile->setClass("item");
    $divOptionProfile->addElement(new FDiv("option-icon-your-profile", "option-icon", new FDiv(null, "protector", Locales::getTitle("your-profile"))));
    $divOptionProfile->addElement(new FDiv(null, "option-link", new FAnchor(null, null, "./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile"), Locales::getTitle("your-profile"), Locales::getTitle("your-profile"))));
    
    // "Div Option Message" Element Settings.
    
    $divOptionMessages->setID("user-option-messages");
    $divOptionMessages->setClass("item");
    $divOptionMessages->addElement(new FDiv("option-icon-your-messages", "option-icon", new FDiv(null, "protector", Locales::getTitle("messages"))));
    $divOptionMessages->addElement(new FDiv(null, "option-link", array(new FAnchor(null, null, "./?" . Locales::getVariable("page") . "=" . Locales::getLink("messages"), Locales::getTitle("messages"), Locales::getTitle("messages")), $varSufix)));
    
    // "Option Log-Out" Element Settings.
    
    $divOptionLogOut->setID("user-option-logout");
    $divOptionLogOut->setClass("item");
    $divOptionLogOut->addElement(new FDiv("option-icon-your-log-out", "option-icon", new FDiv(null, "protector", Locales::getTitle("log-out"))));
    $divOptionLogOut->addElement(new FDiv(null, "option-link", new FAnchor(null, null, "./?" . Locales::getVariable("page") . "=" . Locales::getLink("log-out"), Locales::getTitle("log-out"), Locales::getTitle("log-out"))));
    
    // Build Elements.

    Build::element($hdLoginModule);
    Build::element($divLoginModuleHolder);
}
else
{
    // Create "Main" Elements.

    $hdLoginModule      = new FHeader();
    $fmLoginModule      = new FForm();
    $tblInputHolder = new FTable();

    // Create "Row" Elements.

    $rowUsername = new FTableRow();
    $rowPassword = new FTableRow();
    $rowCaptcha  = new FTableRow();
    $rowSubmit   = new FTableRow();

    // Create "Input" Elements.

    $inpUsername = new FInput();
    $inpPassword = new FInput();
    $inpCaptcha  = new FInput();
    $lnkRegister = new FAnchor();
    $btnSubmit   = new FButton();
    
    // "Header" Element Settings.
    
    $hdLoginModule->setLevel(1);
    $hdLoginModule->setContent(Locales::getCore("log-in"));

    // "Form Login Module" Element Settings.

    $fmLoginModule->setID("side-log-in-form");
    $fmLoginModule->setClass("default-form");
    $fmLoginModule->setMethod(FForm::MTD_POST);
    $fmLoginModule->setAction("./?" . Locales::getVariable("page") . "=" . Locales::getLink("log-in") . "");

    // "Table Input Holder" Element Settings.

    $tblInputHolder->setID("side-log-in-table");
    $tblInputHolder->setClass("form-table");

    // "Input Username" Element Settings.

    $inpUsername->setID("username-input");
    $inpUsername->setClass("form-input");
    $inpUsername->setMaxLength(20);
    $inpUsername->setType(FInput::TP_TEXT);
    $inpUsername->setName("req_username");

    // "Input Password" Element Settings.

    $inpPassword->setID("password-input");
    $inpPassword->setClass("form-input");
    $inpPassword->setMaxLength(50);
    $inpPassword->setType(FInput::TP_PASSWORD);
    $inpPassword->setName("req_password");

    // "Input Captcha" Element Settings.

    $inpCaptcha->setID("captcha-input");
    $inpCaptcha->setClass("form-input");
    $inpCaptcha->setMaxLength(2);
    $inpCaptcha->setType(FInput::TP_TEXT);
    $inpCaptcha->setName("req_captcha");

    // "Input Submit" Element Settings.

    $btnSubmit->setID("login-button");
    $btnSubmit->setClass("form-button");
    $btnSubmit->setType(FInput::TP_SUBMIT);
    $btnSubmit->setContent(Locales::getCore("log-in"));

    // "Link Register" Element Settings.

    $lnkRegister->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("registration"));
    $lnkRegister->setLinkTitle(Locales::getCore("register"));
    $lnkRegister->setContent(Locales::getCore("register"));

    // "Username Row" Element Settings.

    $rowUsername->addCell(new FTableCell(null, null, new FLabel("username", Locales::getCore("username"))));
    $rowUsername->addCell(new FTableCell(null, null, $inpUsername));

    // "Password Row" Element Settings.

    $rowPassword->addCell(new FTableCell(null, null, new FLabel("password", Locales::getCore("password"))));
    $rowPassword->addCell(new FTableCell(null, null, $inpPassword));

    // "CAPTCHA Row" Element Settings.

    $rowCaptcha->addCell(new FTableCell(null, "captcha-left", new FLabel("login-captcha", Captcha::getChallenge()), null, null, FTableCell::ALN_RIGHT));
    $rowCaptcha->addCell(new FTableCell(null, "captcha-right", $inpCaptcha));

    // "Submit Row" Element Settings.

    $rowSubmit->addCell(new FTableCell(null, null, $lnkRegister, null, null, FTableCell::ALN_LEFT));
    $rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, null, null, FTableCell::ALN_RIGHT));

    // Append Elements To "Input Holder" Element.

    $tblInputHolder->addRow($rowUsername);
    $tblInputHolder->addRow($rowPassword);

    if (Core::get(Core::DEPLOY_CAPTCHA) == "yes") // Append "CAPTCHA Row".
        $tblInputHolder->addRow($rowCaptcha);

    $tblInputHolder->addRow($rowSubmit);

    // Append Elements To "Form" Element.

    $fmLoginModule->addItem($tblInputHolder);

    // Build Elements.

    Build::element($hdLoginModule);
    Build::element($fmLoginModule);
}

?>