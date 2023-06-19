<?php

/***********************************************************\
|* Magnum CMS v1.0.0                                       *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: session.php                                   *|
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

class Session
{
    // "Variable" Constants.
    
    const VAR_USERNAME = "var_username";
    const VAR_PASSWORD = "var_password";
    const VAR_TOKEN    = "var_token";
    
    // "Regular Expression" Constants.
    
    const RE_USERNAME  = "/^[A-z0-9]+$/";
    const RE_PASSWORD  = "/^[A-z0-9!@#$%^&*()_+]+$/";
    
    // "Is" Methods.
    
    private static function isUsernameValid()
    {
        if (empty($_COOKIE[self::VAR_USERNAME]))
            return false;
        else
            return StringCheck::between($_COOKIE[self::VAR_USERNAME], 5, 20) && preg_match(self::RE_USERNAME, $_COOKIE[self::VAR_USERNAME]);
    }
    
    private static function isPasswordValid()
    {
        if (empty($_COOKIE[self::VAR_PASSWORD]))
            return false;
        else
            return StringCheck::between($_COOKIE[self::VAR_PASSWORD], 5, 50) && preg_match(self::RE_PASSWORD, $_COOKIE[self::VAR_PASSWORD]);
    }
    
    private static function isTokenValid()
    {
        $token = self::fetchToken();
        
        if (empty($_COOKIE[self::VAR_TOKEN]))
            return false;
        else
            return $_COOKIE[self::VAR_TOKEN] == $token;
    }
    
    public static function isActive()
    {
        $sessionActive = false;
        
        if (self::isUsernameValid() && self::isPasswordValid() && self::isTokenValid())
        {
            // Fetch Users ID.
            
            $usersID = IDFetch::byUsername(Session::getUsername());
            
            // Fetch Users Password.
            
            $password = InfoFetch::fetchPassword($usersID);
            
            // Process Users Password.
            
            $password = sha1($password . " - " . $_SERVER["REMOTE_ADDR"] . " - " . $_SERVER["HTTP_USER_AGENT"]);

            // Compare Password.
            
            $sessionActive = ($password == Session::getPassword());
        }
        
        return $sessionActive;
    }
    
    // "Get" Methods.
    
    public static function getUsername()
    {
        if (self::isUsernameValid())
            return $_COOKIE[self::VAR_USERNAME];
        else
            return null;
    }
    
    public static function getPassword()
    {
        if (self::isPasswordValid())
            return $_COOKIE[self::VAR_PASSWORD];
        else
            return null;
    }
    
    public static function getToken()
    {   
        if (self::isTokenValid())
            return $_COOKIE[self::VAR_TOKEN];
        else
            return null;
    }
    
    // "Main" Methods.
    
    public static function start($username, $password)
    {
        // Filter Username.
        
        $filteredUsername = new FilteredVariable();
        
        $filteredUsername->setType(FilteredVariable::TP_CUSTOM);
        $filteredUsername->setRegularExpression("/[^\da-z]/i");
        $filteredUsername->setValue($username);
        
        $filteredUsername = $filteredUsername->getValue();
        
        // Filter Password.
        
        $filteredPassword = new FilteredVariable();
        
        $filteredPassword->setType(FilteredVariable::TP_CUSTOM);
        $filteredPassword->setRegularExpression("/[^\da-z!@#$%^&*()_+]/i");
        $filteredPassword->setValue($password);
        
        $filteredPassword = $filteredPassword->getValue();
        
        // Set "Username".
        
        setcookie(self::VAR_USERNAME, $filteredUsername, time() + 28800, "/");
        
         // Set "Password".
        
        $filteredPassword = sha1($filteredPassword . " - " . Core::get(Core::PASSWORD_SALT));
        
        $filteredPassword = sha1($filteredPassword . " - " . $_SERVER["REMOTE_ADDR"] . " - " . $_SERVER["HTTP_USER_AGENT"]);
        
        setcookie(self::VAR_PASSWORD, $filteredPassword, time() + 28800, "/");
        
        // Set "Token".
        
        $token = self::generateToken();
        
        setcookie(self::VAR_TOKEN, $token, time() + 28800, "/");
        
        // Add Session Info To Database.
        
        $usersID = IDFetch::byUsername($filteredUsername);
        
        EasyUpdate::execute
        (
            "TS: sessions",
            "CS: token",
            "VLS: $token",
            "ARGS: users_id = $usersID"
        );
    }
    
    public static function refresh()
    {
        // Fetch Users ID.
        
        $usersID = IDFetch::byUsername(self::getUsername());
        
        // Generate New Token.
        
        $newToken = self::generateToken();
        
        // Perform Alteration.
        
        EasyUpdate::execute
        (
            "TS: sessions",
            "CS: token",
            "VLS: $newToken",
            "ARGS: users_id = $usersID"
        );
        
        // Reset Cookies.
        
        setcookie(self::VAR_USERNAME, self::getUsername(), time() + 28800, "/");
        
         // Unset "Password".
        
        setcookie(self::VAR_PASSWORD, self::getPassword(), time() + 28800, "/");
        
         // Unset "Token".
        
        setcookie(self::VAR_TOKEN, $newToken, time() + 28800, "/");
    }
    
    public static function stop()
    {
        // Change Session Variable.
        
        $_SESSION["logged_in"] = false;
        
        // Remove Session Info From The Database.
        
        $usersID  = IDFetch::byUsername(self::getUsername());
        
        $newToken = sha1(rand(0, 1000000) . " - " . time() . " - " . Core::get(Core::TOKEN_SALT)); // "Random" Token.
        
        EasyUpdate::execute
        (
            "TS: sessions",
            "CS: token",
            "VLS: $newToken",
            "ARGS: users_id = $usersID"
        );
        
        // Unset "Username".
        
        setcookie(self::VAR_USERNAME, "", time() - 28800, "/");
        
         // Unset "Password".
        
        setcookie(self::VAR_PASSWORD, "", time() - 28800, "/");
        
         // Unset "Token".
        
        setcookie(self::VAR_TOKEN, "", time() - 28800, "/");
    }
    
    // "Other" Methods.
    
    private static function generateToken()
    {
        return sha1($_SERVER["REMOTE_ADDR"] . " - " . $_SERVER["HTTP_USER_AGENT"] . " - " . rand(0, 1000000) . " - " . Core::get(Core::TOKEN_SALT));
    }
    
    private static function fetchToken()
    {
        // Fetch Users ID.
        
        $usersID = IDFetch::byUsername(self::getUsername());
        
        // Perform Fetching.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: sessions",
            "CS: token",
            "ARGS: users_id = $usersID"
        );
        
        return $data[0][0];
    }
}

?>
