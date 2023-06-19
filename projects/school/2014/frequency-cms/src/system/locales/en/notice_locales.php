<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: notice_locales.php                            *|
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

// "Notice Link" Locales.

$LCL_NOTICE_LINKS["already-registered"]         = "already-registered";
$LCL_NOTICE_LINKS["success"]                    = "success";
$LCL_NOTICE_LINKS["already-logged-in"]          = "already-logged-in";
$LCL_NOTICE_LINKS["already-logged-out"]         = "already-logged-out";
$LCL_NOTICE_LINKS["already-activated"]          = "already-activated";
$LCL_NOTICE_LINKS["logged-in"]                  = "logged-in";
$LCL_NOTICE_LINKS["unknown-notice"]             = "unknown-notice";
$LCL_NOTICE_LINKS["password-changed"]           = "password-changed";
$LCL_NOTICE_LINKS["account-deactivated"]        = "account-deactivated";

// "Notice Title" Locales.

$LCL_NOTICE_TITLES["registration-notice"]       = "Registration Notice";
$LCL_NOTICE_TITLES["log-in-notice"]             = "Log-In Notice";
$LCL_NOTICE_TITLES["log-out-notice"]            = "Log-Out Notice";
$LCL_NOTICE_TITLES["rem-notice"]                = "Resend Activation Email Notice";
$LCL_NOTICE_TITLES["ar-notice"]                 = "Account Recovery Notice";
$LCL_NOTICE_TITLES["aa-notice"]                 = "Account Activation Notice";
$LCL_NOTICE_TITLES["pr-notice"]                 = "Password Reset Notice";
$LCL_NOTICE_TITLES["set-language"]              = "Set Language Notice";
$LCL_NOTICE_TITLES["one-step-away"]             = "You are just one step away!";
$LCL_NOTICE_TITLES["ydrae"]                     = "You didn't receive an activation email?";
$LCL_NOTICE_TITLES["acc-info"]                  = "Did you forget your account information?";
$LCL_NOTICE_TITLES["unknown-page"]              = "Unknown Page";
$LCL_NOTICE_TITLES["your-profile"]              = "Your Profile Notice";
$LCL_NOTICE_TITLES["oops"]                      = "Ooooops...";
$LCL_NOTICE_TITLES["unknown-notice"]            = "Unknown Notice";
$LCL_NOTICE_TITLES["password-changed"]          = "Password Changed";
$LCL_NOTICE_TITLES["account-deactivated"]       = "Account Deactivated";
$LCL_NOTICE_TITLES["messages"]                  = "Messaging Notice";

// Notice Content.

$LCL_NOTICE_CONTENT["already-registered"]       = "You are already registered.";
$LCL_NOTICE_CONTENT["registration-success"]     = "You have successfully created an account. E-mail with verification code has been sent to your email address.";
$LCL_NOTICE_CONTENT["registration-unavailable"] = "Registration is not currently available.";
$LCL_NOTICE_CONTENT["log-in-success"]           = "You have been successfully logged in.";
$LCL_NOTICE_CONTENT["log-out-success"]          = "You are now logged out.";
$LCL_NOTICE_CONTENT["already-logged-in"]        = "You are already logged in.";
$LCL_NOTICE_CONTENT["already-logged-out"]       = "You are already logged out.";
$LCL_NOTICE_CONTENT["ydrae"]                    = "Don't despair! Just enter your email address bellow and click resend!";
$LCL_NOTICE_CONTENT["acc-info"]                 = "Relax! Enter the email address you used to create your account in the box bellow and we'll send you a link you can use to reset your password.";
$LCL_NOTICE_CONTENT["already-activated"]        = "Your account is already activated.";
$LCL_NOTICE_CONTENT["rem-success"]              = "Email containing activation code has been sent.";
$LCL_NOTICE_CONTENT["ar-success"]               = "Email containing password recovery link has been sent.";
$LCL_NOTICE_CONTENT["aa-logged-in"]             = "You can't use account activation tool while logged in. Please log out and try again.";
$LCL_NOTICE_CONTENT["aa-success"]               = "Congratulations! You account has been activated, you can now log in!";
$LCL_NOTICE_CONTENT["pr-success"]               = "You have successfully reseted your password.";
$LCL_NOTICE_CONTENT["sl-success"]               = "Congratulations! You have successfully changed the language of the site.";
$LCL_NOTICE_CONTENT["ar-logged-in"]             = "You can't use account recovery tool while logged in. Please log out and try again.";
$LCL_NOTICE_CONTENT["one-step-away"]            = "Just enter your new password bellow and you are good to go!";
$LCL_NOTICE_CONTENT["unknown-page"]             = "The page you requested does not exist.";
$LCL_NOTICE_CONTENT["unknown-notice"]           = "An unknown notice has occured. Please contact the site administrator.";
$LCL_NOTICE_CONTENT["password-changed"]         = "You have successfully changed your password.";
$LCL_NOTICE_CONTENT["m-success"]                = "You have successfully sent a message.";
$LCL_NOTICE_CONTENT["account-deactivated"]      = "You have successfully deactivated your account. You can reactivate it by logging in again.";

?>