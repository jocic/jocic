<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: shoutbox.php                                  *|
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

class Shoutbox
{
    // "Fetch" Methods.
    
    public static function fetchRecentPosts()
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setLimit(10);
        EasyGet::setOrderBy("id", EasyGet::OB_DESC);

        $varPosts = EasyGet::execute
        (
            "TS: shoutbox",
            "CS: *"
        );
        
        return $varPosts;
    }
    
    public static function fetchAllPosts()
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varPosts = EasyGet::execute
        (
            "TS: shoutbox",
            "CS: *"
        );
        
        return $varPosts;
    }
    
    public static function fetchPost($parPostID)
    {
        // Filter Users ID.
        
        $parPostID = Filter::forNumeric($parPostID);
        
        // Perform Fetching.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varPost = EasyGet::execute
        (
            "TS: shoutbox",
            "CS: *",
            "ARGS: id = $parPostID"
        );
        
        // Return Data.
        
        return $varPost;
    }
    
    // "Main" Methods.
    
    public static function isShoutPosted($parShoutID)
    {
        // Filter Comment ID.
        
        $parShoutID = Filter::forNumeric($parShoutID);
        
        // Count Shouts With Given ID.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $shoutData = EasyGet::execute
        (
            "TS: shoutbox",
            "CS: COUNT(`id`)",
            "ARGS: id = " . $parShoutID
        );

        // Return All Data.

        return $shoutData[0][0] == 1;
    }
    
    public static function addPost($parUsersID, $parContent)
    {
        // Filter Users ID.
        
        $parUsersID = Filter::forNumeric($parUsersID);

        // Custom Value Selection.
        
        $values = new ValueSelection();
        
        $values->setOption(ValueSelection::OPT_ENCODE);
        $values->addValues($parUsersID, $parContent);
        
        // Perform Insertion.
        
        EasyInsert::execute
        (
            "TS: shoutbox",
            "CS: poster_id, content",
            $values
        );
    }
    
    public static function deletePost($parPostID)
    {
        // Filter Post ID.
        
        $parPostID = Filter::forNumeric($parPostID);
        
        // Delete Comment.
        
        EasyDelete::execute
        (
            "TS: shoutbox",
            "ARGS: id = $parPostID"
        );
    }
}

?>
