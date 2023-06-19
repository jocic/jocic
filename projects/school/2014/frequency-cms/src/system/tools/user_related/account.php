<?php

/***********************************************************\
|* Magnum CMS v1.0.0                                       *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: account.php                                   *|
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

// Class Starts.

class Account
{
    // "Status" Constants.
    
    const STS_PENDING_VERIFICATION = 5;
    const STS_DEACTIVATED          = 4;
    const STS_BANNED               = 3;
    const STS_REGULAR              = 2;
    const STS_ADMIN                = 1;
    const STS_SUPER_ADMIN          = 0;
    
    // "Column" Constants.
    
    const COL_USERNAME             = "username";
    const COL_PASSWORD             = "password";
    const COL_STATUS               = "status";
    const COL_VERIFICATION         = "verification";
    const COL_FIRST_NAME           = "name";
    const COL_MIDDLE_NAME          = "middle_name";
    const COL_LAST_NAME            = "surname";
    const COL_GENDER               = "gender";
    const COL_BIRTHDAY             = "birthday";
    const COL_EMAIL                = "email";
    const COL_FIRST_IP             = "first_ip";
    const COL_LAST_IP              = "last_ip";
    
    // "Is" Methods.
    
    public static function isCreated($userID)
    {
        // Filter User ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($userID);

        $filteredID = $filteredID->getValue();
        
        // Execute The Query.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: users",
            "CS: COUNT(`id`)",
            "ARGS: id = $filteredID"
        );
        
        // Return The Value.
        
        return $data[0][0] == 1;
    }
    
    public static function isPendingVerification($userID)
    {
        // Return The Value.
        
        return self::genericIsCheck($userID, self::STS_PENDING_VERIFICATION);
    }
    
    public static function isDeactivated($userID)
    {
        // Return The Value.
        
        return self::genericIsCheck($userID, self::STS_DEACTIVATED);
    }
    
    public static function isBanned($userID)
    {
        // Return The Value.
        
        return self::genericIsCheck($userID, self::STS_BANNED);
    }
    
    public static function isRegular($userID)
    {
        // Return The Value.
        
        return self::genericIsCheck($userID, self::STS_REGULAR);
    }
    
    public static function isAdmin($userID)
    {
        // Return The Value.
        
        return self::genericIsCheck($userID, self::STS_ADMIN);
    }
    
    public static function isSuperAdmin($userID)
    {
        // Return The Value.
        
        return self::genericIsCheck($userID, self::STS_SUPER_ADMIN);
    }

    private static function genericIsCheck($userID, $statusValue)
    {
        // Filter User ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($userID);

        $filteredID = $filteredID->getValue();
        
        // Execute The Query.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: users",
            "CS: COUNT(`id`)",
            "ARGS: id = $filteredID AND status = $statusValue"
        );
        
        // Return The Value.
        
        return $data[0][0] == 1;
    }
    
    // "Main" Methods.
    
    public static function sendActivationEmail($userID)
    {
        // Filter User ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($userID);

        $filteredID = $filteredID->getValue();
        
        // Fetch Verification Code.
        
        $verification = InfoFetch::fetchVerification($filteredID);
        
        // Change Users Verification Code.
        
        InfoAlter::alterVerification(sha1($verification . " - " . Core::get(Core::VERIFICATION_SALT)), $userID);
        
        // Fetch Email Address.

        $emailAddress = InfoFetch::fetchEmailAddress($filteredID);
        
        // Create A Link.
        
        $link = "http://" . $_SERVER["SERVER_NAME"] . CMS_ROOT . "?page=activate-account&id=$filteredID&verification=$verification";
        
        // Create Message.
        
        $message = "<html>\r\n" .
                   "<p>Thank you for registering!</p>\r\n" .
                   "<p>In order to activate your account, please click the following link or paste it into your browser:</p>\r\n" .
                   "<p><a href=\"$link\" title=\"Activation Link\">$link</a></p>\r\n" .
                   "<p>Best regards,<br />Customer Support</p>\r\n" .
                   "<p>Please do not reply directly to this message, which was sent form an unmonitored e-mail address. Mail sent to this address cannot be answered.</p>\r\n" .
                   "</html>";
        
        // Check Email Address.
        
        if (!StringCheck::isEmailAddress($emailAddress))
            return;
        
        // Send Message.
        
        $mail = new Mail();

        $mail->setTo($emailAddress);
        $mail->setSubject(Core::get(Core::WEBSITE_TITLE) . " - Account Activation");
        $mail->setMessage($message);
        $mail->setFrom(Core::get(Core::WEBSITE_MAIL));
        $mail->setDefaultHeaders();

        $mail->send();
    }
    
    public static function sendRecoveryEmail($userID)
    {
        if (!self::isPendingVerification($userID) && !self::isBanned())
        {
            // Create "RandomStringGenerator" Object.

            $rsg = new RandomStringGenerator();

            $rsg->setOption(RandomStringGenerator::OPT_ALPHA_NUMERIC);
            $rsg->setSize(40);
            $rsg->generateString();

            // Create Verification Code.

            $verification = $rsg->getRandomString();

            // Change Users Verification Code.
            
            InfoAlter::alterVerification(sha1($verification . " - " . Core::get(Core::VERIFICATION_SALT)), $userID);

            // Fetch E-Mail Address.

            $emailAddress = InfoFetch::fetchEmailAddress($userID);

            // Create A Link.

            $link = "http://" . $_SERVER["SERVER_NAME"] . CMS_ROOT . "?page=password-reset&id=$userID&verification=$verification";

            // Create Message.

            $message = "<html>\r\n" .
                       "<p>In order to reset your password, please click the following link or paste it into your browser:</p>\r\n" .
                       "<p><a href=\"$link\" title=\"Password Reset Link\">$link</a></p>\r\n" .
                       "<p>Best regards,<br />Customer Support</p>\r\n" .
                       "<p>Please do not reply directly to this message, which was sent form an unmonitored e-mail address. Mail sent to this address cannot be answered.</p>\r\n" .
                       "</html>";

            // Check Email Address.

            if (!StringCheck::isEmailAddress($emailAddress))
                return;
            
            // Send Message.

            $mail = new Mail();

            $mail->setTo($emailAddress);
            $mail->setSubject(Core::get(Core::WEBSITE_TITLE) . " - Password Reset");
            $mail->setMessage($message);
            $mail->setFrom(Core::get(Core::WEBSITE_MAIL));
            $mail->setDefaultHeaders();

            $mail->send();
        }
    }
    
    public static function createNew($infoArray)
    {
        // Required Variables - Array.
        
        $requiredVariable = array
        (
            self::COL_USERNAME,
            self::COL_PASSWORD,
            self::COL_STATUS,
            self::COL_VERIFICATION,
            self::COL_FIRST_NAME,
            self::COL_MIDDLE_NAME,
            self::COL_LAST_NAME,
            self::COL_GENDER,
            self::COL_BIRTHDAY,
            self::COL_EMAIL,
            self::COL_FIRST_IP,
            self::COL_LAST_IP
        );
        
        // Check If Array Keys Exist.
        
        foreach ($requiredVariable as $value)
        {
            if (!array_key_exists($value, $infoArray))
                return;
        }
        
        // Create Filter Filter Variable.

        $fv = new FilteredVariable();
        
        $fv->setType(FilteredVariable::TP_CUSTOM);
        
        // Filter "Username" Variable.
        
        $fv->setRegularExpression("/[^\da-z]/i");
        $fv->setValue($infoArray[self::COL_USERNAME]);
        
        $infoArray[self::COL_USERNAME] = $fv->getValue();
        
        // Filter "Password" Variable.
        
        $fv->setRegularExpression("/[^\da-z!@#$%^&*()_+]/i");
        $fv->setValue($infoArray[self::COL_PASSWORD]);
        
        $infoArray[self::COL_PASSWORD] = $fv->getValue();
        
        // Check "Status" Variable.

        if (!is_numeric($infoArray[self::COL_STATUS]))
            return;
        
        // Check And Filter "Verification" Variable.
        
        if (!empty($infoArray[self::COL_VERIFICATION]))
        {
            $fv->setRegularExpression("/[^\da-z]/i");
            $fv->setValue($infoArray[self::COL_VERIFICATION]);

            $infoArray[self::COL_VERIFICATION] = $fv->getValue();
        }
        else
            return;
        
        // Filter "Name" Variable.
        
        if (!empty($infoArray[self::COL_FIRST_NAME]))
        {
            $fv->setRegularExpression("/[^\da-z]/i");
            $fv->setValue($infoArray[self::COL_FIRST_NAME]);

            $infoArray[self::COL_FIRST_NAME] = $fv->getValue();
        }
        
        // Filter "Middle Name" Variable.
        
        if (!empty($infoArray[self::COL_MIDDLE_NAME]))
        {
            $fv->setRegularExpression("/[^\da-z.]/i");
            $fv->setValue($infoArray[self::COL_MIDDLE_NAME]);

            $infoArray[self::COL_MIDDLE_NAME] = $fv->getValue();
        }
        
        // Filter "Surname" Variable.
        
        if (!empty($infoArray[self::COL_LAST_NAME]))
        {
            $fv->setRegularExpression("/[^\da-z]/i");
            $fv->setValue($infoArray[self::COL_LAST_NAME]);

            $infoArray[self::COL_LAST_NAME] = $fv->getValue();
        }
        
        // Check "Gender" Variable.
        
        if (!is_numeric($infoArray[self::COL_GENDER]) || ($infoArray[self::COL_GENDER] < 0 || $infoArray[self::COL_GENDER] > 2))
            return;
        
        // Check "Birthday" Variable.
        
        $fv->setRegularExpression("/[^\d-]/i");
        $fv->setValue($infoArray[self::COL_BIRTHDAY]);

        $infoArray[self::COL_BIRTHDAY] = $fv->getValue();
        
        // Check "Email" Variable.
        
        if (!StringCheck::isEmailAddress($infoArray[self::COL_EMAIL]))
            return;
        
        // Check "First IP" Variable.
        
        if (empty($infoArray[self::COL_FIRST_IP]))
            $infoArray[self::COL_FIRST_IP] = $_SERVER["REMOTE_ADDR"];
        else
        {
            $fv->setRegularExpression("/[^\da-z.:]/i");
            $fv->setValue($infoArray[self::COL_FIRST_IP]);

            $infoArray[self::COL_FIRST_IP] = $fv->getValue();
        }
        
        // Check "Last IP" Variable.
        
        if (empty($infoArray[self::COL_LAST_IP]))
            $infoArray[self::COL_LAST_IP] = $_SERVER["REMOTE_ADDR"];
        else
        {
            $fv->setRegularExpression("/[^\da-z.:]/i");
            $fv->setValue($infoArray[self::COL_LAST_IP]);

            $infoArray[self::COL_LAST_IP] = $fv->getValue();
        }
        
        // Crate "Salted Password".
        
        $infoArray[self::COL_PASSWORD] = sha1($infoArray[self::COL_PASSWORD] . " - " . Core::get(Core::PASSWORD_SALT));
        
        // Add User.

        EasyInsert::execute
        (
            "TS: users",
            "CS: username, password, status, verification",
            "VLS: " . $infoArray[self::COL_USERNAME] . ", " .
                      $infoArray[self::COL_PASSWORD] . ", " .
                      $infoArray[self::COL_STATUS] . ", " .
                      $infoArray[self::COL_VERIFICATION]
        );
        
        // Get User "ID" And Set It.
        
        $userID = IDFetch::byUsername($infoArray[self::COL_USERNAME]);
        
        // Add User Info.

        EasyInsert::execute
        (
            "TS: user_info",
            "CS: id, name, middle_name, surname, gender, birthday, email, first_ip, last_ip",
            "VLS: " . $userID . ", " .
                      $infoArray[self::COL_FIRST_NAME] . ", " .
                      $infoArray[self::COL_MIDDLE_NAME] . ", " .
                      $infoArray[self::COL_LAST_NAME] . ", " .
                      $infoArray[self::COL_GENDER] . ", " .
                      $infoArray[self::COL_BIRTHDAY] . ", " .
                      $infoArray[self::COL_EMAIL] . ", " .
                      $infoArray[self::COL_FIRST_IP] . ", " .
                      $infoArray[self::COL_LAST_IP]
        );
        
        // Add User Personals.
        
        EasyInsert::execute
        (
            "TS: user_personals",
            "CS: id",
            "VLS: " . $userID
        );
        
        // Add Session Row.
        
        EasyInsert::execute
        (
            "TS: sessions",
            "CS: users_id",
            "VLS: $userID"
        );

        // Send Email With Verification Code.

        self::sendActivationEmail($userID);
    }
}

?>