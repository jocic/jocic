<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: page_info.php                                 *|
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

class PageInfo
{
    // "Published Status" Contants.
    
    const PG_NOT_PUBLISHED     = 0;
    const PG_PUBLISHED         = 1;
    
    // "Comments Enabled Status" Constants.
    
    const PC_DISABLED          = 0;
    const PC_ENABLED           = 1;
    
     // "Column" Constants.
    
    const COL_TITLE            = "title";
    const COL_DESCRIPTION      = "description";
    const COL_CONTENT          = "content";
    const COL_CUSTOM_ID        = "custom_id";
    const COL_TAGS             = "tags";
    const COL_PUBLISHED        = "published";
    const COL_COMMENTS_ENABLED = "comments_enabled";
    
    // "Is" Methods.
    
    public static function isCreated($pageID)
    {
        // Filter Page ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($pageID);

        $filteredID = $filteredID->getValue();
        
        // Fetch Page Data.
        
        if (!empty($filteredID))
        {
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $data = EasyGet::execute
            (
                "TS: pages",
                "CS: COUNT(`id`)",
                "ARGS: id = $filteredID"
            );

            // Return The Value.

            return $data[0][0] == 1;
        }
        else
            return null;
    }
    
    public static function isPublished($pageID)
    {
        // Filter Page ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($pageID);

        $filteredID = $filteredID->getValue();
        
        // Fetch Page Data.
        
        if (!empty($filteredID))
        {
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $data = EasyGet::execute
            (
                "TS: pages",
                "CS: COUNT(`id`)",
                "ARGS: id = $filteredID AND published = 1"
            );

            // Return The Value.
            
            return $data[0][0] == 1;
        }
        else
            return null;
    }
    
    public static function isCommentingEnabled($pageID)
    {
        // Filter Page ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($pageID);

        $filteredID = $filteredID->getValue();
        
        // Fetch Page Data.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: pages",
            "CS: comments_enabled",
            "ARGS: id = $filteredID"
        );
        
        // Return The Value.
        
        return $data[0][0] == 1;
    }
    
    // "Get" Methods.
    
    public static function getTitle($pageID)
    {
        // Filter Page ID.
        
        $pageID = Filter::forNumeric($pageID);
        
        // Fetch Page Data.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: pages",
            "CS: title",
            "ARGS: id = $pageID"
        );
        
        // Return The Value.
        
        return $data[0][0];
    }
    
    public static function getDescription($pageID)
    {
        return self::genericGet($pageID, self::COL_DESCRIPTION);
    }
    
    public static function getContent($pageID)
    {
        return self::genericGet($pageID, self::COL_CONTENT);
    }
    
    public static function getCustomID($pageID)
    {
        return self::genericGet($pageID, self::COL_CUSTOM_ID);
    }
    
    public static function getTags($pageID)
    {
        return self::genericGet($pageID, self::COL_TAGS);
    }
    
    // "Main" Methods.
    
    private static function genericGet($id, $column)
    {
        // Filter Page ID.
        
        $filteredID = new FilteredVariable();

        $filteredID->setType(FilteredVariable::TP_NUMBERS);
        $filteredID->setValue($id);

        $filteredID = $filteredID->getValue();
        
        // Filter Column.
        
        $filteredColumn = new FilteredVariable();
        
        $filteredColumn->setType(FilteredVariable::TP_CUSTOM);
        $filteredColumn->setRegularExpression("/[^a-zA-Z0-9_]/");
        $filteredColumn->setValue($column);
        
        $filteredColumn = $filteredColumn->getValue();
        
        // Fetch Page Data.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);
        
        $data = EasyGet::execute
        (
            "TS: pages",
            "CS: $filteredColumn",
            "ARGS: id = $filteredID"
        );
        
        // Return The Value.
        
        return $data[0][0];
    }
    
    public static function convertCustomID($customID)
    {
        // Filter Page ID.

        $filteredCustomID = new FilteredVariable();

        $filteredCustomID->setType(FilteredVariable::TP_CUSTOM);
        $filteredCustomID->setRegularExpression("/[^a-zA-Z0-9\-]/");
        $filteredCustomID->setValue($customID);

        $filteredCustomID = $filteredCustomID->getValue();
        
        // Fetch Regular ID.
        
        if (!empty($filteredCustomID))
        {
            EasyGet::setFetchMode(EasyGet::FM_BY_NUMBER);

            $data = EasyGet::execute
            (
                "TS: pages",
                "CS: id",
                "ARGS: custom_id = $filteredCustomID"
            );

            // Return The Value.

            return $data[0][0];
        }
        else
            return null;
    }
}

?>