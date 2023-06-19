<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: comments.php                                  *|
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

class Comments
{
    // "Main" Methods.
    
    public static function isCommentPosted($commentID)
    {
        // Filter Comment ID.
        
        $commentID = Filter::forNumeric($commentID);
        
        // Fetch All Comments.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $commentData = EasyGet::execute
        (
            "TS: page_comments",
            "CS: COUNT(`id`)",
            "ARGS: id = " . $commentID
        );

        // Return All Data.

        return $commentData[0][0] == 1;
    }
    
    public static function fetchAllComments()
    {
        // Fetch All Comments.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $commentData = EasyGet::execute
        (
            "TS: page_comments",
            "CS: *"
        );

        // Return All Data.

        return $commentData;
    }
    
    public static function countPageComments($pageID)
    {
        // Filter Page ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($pageID);

        $filteredID = $filteredID->getValue();
        
        // Fetch Number Of Comments.

        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

        $data = EasyGet::execute
        (
            "TS: page_comments",
            "CS: COUNT(`id`)",
            "ARGS: page_id = $filteredID"
        );

        // Proccess Data.

        return $data[0][0];
    }
    
    public static function fetchPageComments($pageID, $startFrom = null)
    {
        // Filter Page ID.
        
        $filteredID = Filter::forNumeric($pageID);
        
        // Fetch Comments.

        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        EasyGet::setOrderBy("id", EasyGet::OB_DESC);
        
        EasyGet::setLimit(10, $startFrom);

        $commentData = EasyGet::execute
        (
            "TS: page_comments",
            "CS: content, sender_id",
            "ARGS: page_id = $filteredID"
        );
        
        return $commentData;
    }
    
    public static function fetchComment($commentID)
    {
        // Filter Comment ID.
        
        $commentID = Filter::forNumeric($commentID);
        
        // Fetch Data.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $varComment = EasyGet::execute
        (
            "TS: page_comments",
            "CS: *",
            "ARGS: id = " . $commentID
        );
        
        // Return Data.
        
        return $varComment;
    }
    
    public static function deleteComment($commentID)
    {
        // Filter Comment ID.
        
        $commentID = Filter::forNumeric($commentID);
        
        // Delete Comment.
        
        EasyDelete::execute
        (
            "TS: page_comments",
            "ARGS: id = $commentID"
        );
    }
    
    public static function addComment($pageID, $usersComment, $userID)
    {
        // Custom Value Selection.

        $customSelection = new ValueSelection();

        $customSelection->setOption(ValueSelection::OPT_ENCODE);

        $customSelection->addValues($pageID, $_POST["req_comment"], $userID);
        
        // Perform Insertion.

        EasyInsert::execute
        (
            "TS: page_comments",
            "CS: page_id, content, sender_id",
            $customSelection
        );
    }
}

?>