<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: list.php                                      *|
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

class Messages
{
    // "Read Status" Constants.
    
    const RSTS_UNREAD  = 0;
    const RSTS_READ    = 1;
    
    // "Status" Constants.
    
    const STS_NORMAL   = 0;
    const STS_ARCHIVED = 1;
    const STS_DELETED  = 2;
    
    // "Fetch" Methods.
    
    public static function fetchAllMessages()
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $messages = EasyGet::execute
        (
            "TS: messages",
            "CS: *"
        );
        
        return $messages;
    }
    
    public static function fetchMessageByID($messageID)
    {
        // Filter Users ID.
        
        $messageID = self::filterID($messageID);
        
        // Fetch Message.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $message = EasyGet::execute
        (
            "TS: messages",
            "CS: *",
            "ARGS: id = $messageID"
        );
        
        return $message;
    }
            
    public static function fetchUsersInboxMessages($usersID)
    {
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch Messages.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $messages = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: *",
            "ARGS: receiver_id = $usersID AND status = 0"
        );

        return $messages;
    }
    
    public static function fetchUsersInboxMessage($messageID, $usersID)
    {
        // Filter Message ID.
        
        $messageID = self::filterID($messageID);
        
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch All Message Info.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
            
        $message = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: sender_id, date_sent, title, content",
            "ARGS: receiver_id = $usersID AND id = $messageID AND status = 0"
        );

        return $message[0];
    }
    
    public static function fetchUsersSentMessages($usersID)
    {
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch Messages.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $messages = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: *",
            "ARGS: sender_id = $usersID"
        );

        return $messages;
    }
    
    public static function fetchUsersSentMessage($messageID, $usersID)
    {
        // Filter Message ID.
        
        $messageID = self::filterID($messageID);
        
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch All Message Info.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
            
        $message = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: sender_id, date_sent, title, content",
            "ARGS: sender_id = $usersID AND id = $messageID"
        );

        return $message[0];
    }
    
    public static function fetchUsersArchivedMessages($usersID)
    {
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch Messages.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $messages = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: *",
            "ARGS: receiver_id = $usersID AND status = 1"
        );

        return $messages;
    }
    
    public static function fetchUsersArchivedMessage($messageID, $usersID)
    {
        // Filter Message ID.
        
        $messageID = self::filterID($messageID);
        
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch All Message Info.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
            
        $message = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: sender_id, date_sent, title, content",
            "ARGS: receiver_id = $usersID AND id = $messageID AND status = 1"
        );

        return $message[0];
    }
    
    public static function fetchUsersDeletedMessages($usersID)
    {
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch Messages.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $messages = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: *",
            "ARGS: receiver_id = $usersID AND status = 2"
        );

        return $messages;
    }
    
    public static function fetchUsersDeletedMessage($messageID, $usersID)
    {
        // Filter Message ID.
        
        $messageID = self::filterID($messageID);
        
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch All Message Info.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
            
        $message = EasyGet::execute // Get Message.
        (
            "TS: messages",
            "CS: sender_id, date_sent, title, content",
            "ARGS: receiver_id = $usersID AND id = $messageID AND status = 2"
        );

        return $message[0];
    }
    
    // "Change" Methods.
    
    public static function changeStatus($messageID, $status, $ownersID)
    {
        // Filter Message ID.
        
        $messageID = Filter::forNumeric($messageID);
        
        // Filter Status.
        
        $status = Filter::forNumeric($status);
        
        // Filter Owners ID.
        
        $ownersID = Filter::forNumeric($ownersID);
        
        if ($status == null)
            $status = 0;
        
        // Change Status.
        
        EasyUpdate::execute
        (
            "TS: messages",
            "CS: status",
            "VLS: $status",
            "ARGS: id = $messageID AND receiver_id = $ownersID"
        );
    }
    
    public static function changeReadStatus($messageID)
    {
        // Filter Message ID.
        
        $messageID = self::filterID($messageID);
        
        // Change Status.
        
        EasyUpdate::execute
        (
            "TS: messages",
            "CS: read_status",
            "VLS: 1",
            "ARGS: id = $messageID"
        );
    }
    
    // "Other" Methods.
    
    public static function sendMessage($title, $content, $senderID, $receiverID)
    {        
        // Filter Sender ID.
        
        $senderID = self::filterID($senderID);
        
        // Filter Receiver ID.
        
        $receiverID = self::filterID($receiverID);

        // Get Date From The Server.
        
        $date = date("Y-m-d");
        
        // Custom Value Selection.
        
        $values = new ValueSelection();
        
        $values->setOption(ValueSelection::OPT_ENCODE);
        $values->addValues($date, $title, $content, $senderID, $receiverID);
        
        // Perform Insertion.
        
        EasyInsert::execute
        (
            "TS: messages",
            "CS: date_sent, title, content, sender_id, receiver_id",
            $values
        );
    }
    
    public static function newReceived($usersID)
    {
        // Filter Users ID.
        
        $usersID = self::filterID($usersID);
        
        // Fetch All Messages.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        // Check For New Messages.

        $messageStatus = EasyGet::execute // Check Read Status.
        (
            "TS: messages",
            "CS: COUNT(`id`)",
            "ARGS: receiver_id = $usersID AND read_status = 0"
        );

        if ($messageStatus[0][0] >= 1)
            return true;
        else
            return false;
    }
    
    // "Other" Methods.
    
    public static function messageExists($messageID)
    {
        // Filter Message ID.
        
        $messageID = self::filterID($messageID);
        
        // Count Messages.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $messageStatus = EasyGet::execute
        (
            "TS: messages",
            "CS: COUNT(`id`)",
            "ARGS: id = $messageID"
        );
        
        return $messageStatus[0][0] == 1;
    }
    
    private static function filterID($usersID)
    {
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($usersID);

        $filteredID = $filteredID->getValue();
        
        return $filteredID;
    }
}

?>
