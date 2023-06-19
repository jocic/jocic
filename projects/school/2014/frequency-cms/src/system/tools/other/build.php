<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: build.php                                     *|
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

class Build
{
    // "Main" Variables.
    
    private static $BP = null;
    
    // "Set" Methods.
    
    public static function setBlankPrefix($blankPrefix)
    {
        self::$BP = $blankPrefix;
    }
    
    // "Get" Methods.
    
    public static function getBlankPrefix()
    {
        return self::$BP;
    }
    
    // "Print" Methods.
    
    private static function objectID($id)
    {
        if ($id != null)
            echo " id=\"" . $id . "\"";
    }
    
    private static function objectClass($class)
    {
        if ($class != null)
            echo " class=\"" . $class . "\"";
    }
    
    private static function objectStyle($style)
    {
        if ($style != null)
            echo " style=\"" . $style . "\"";
    }
    
    private static function objectName($name)
    {
        if ($name != null)
            echo " name=\"" . $name . "\"";
    }
    
    private static function objectsAlignment($alignment)
    {
        if ($alignment != null)
            echo " align=\"" . $alignment . "\"";
    }
    
    private static function objectString($string, $indent = null)
    {
        if ($string != null)
        {
            $lines = explode("\n", $string);
        
            foreach ($lines as $line)
                echo self::$BP . $indent . $line . "\n";
        }
    }
    
    private static function objectAnchor($aObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<a";
        
        // Print Objects ID And Class.
        
        self::objectID($aObject->getID());
        self::objectClass($aObject->getClass());
        
        // Print Title.
        
        if ($aObject->getLinkTitle())
            echo " title=\"" . $aObject->getLinkTitle() . "\"";
        
        // Print Href.
        
        if ($aObject->getLink() != null)
            echo " href=\"" . $aObject->getLink() . "\"";
        
        // Print Target.
        
        if ($aObject->getOpenNewWindow())
            echo " target=\"_blank\"";
        
        echo ">";
        
        // Print Content.
        
        echo "<span>" . $aObject->getContent() . "</span>";
        
        // Print Second Tag.
        
        echo "</a>\n";
    }
    
    private static function objectParagraph($parObject, $indent = null)
    {
        if ($parObject->getContent() != null)
        {
            // Print First Tag.

            echo self::$BP . $indent . "<p";

            // Print Objects ID And Class.

            self::objectID($parObject->getID());
            self::objectClass($parObject->getClass());
            
            // Print Alignment.
            
            self::objectsAlignment($parObject->getAlignment());

            echo ">";
            
            // Print Content.
            
            echo $parObject->getContent();
            
            // Print Click Here Link.
            
            if ($parObject->getLink() != null)
            {
                // Create Variables.
                
                $content = $parObject->getContent();
                
                // Check Content Ending.
                
                $click = Locales::getCore("click");
                
                if ($content[strlen($content) - 1] != ".")
                    $click = strtolower($click);
                
                // Print Click Link.
                
                echo " " .
                     $click .
                     " " .
                     "<a href=\"" .
                     $parObject->getLink() .
                     "\" " . 
                     "title=\"" .
                     $parObject->getLinkTitle() .
                     "\">" .
                     Locales::getCore("here") .
                     "</a>.";
            }
            
            // Print Last Tag.

            echo "</p>\n";
        }
    }
    
    private static function objectHeader($headerObject, $indent = null)
    {
        echo self::$BP .
             $indent .
             "<h" .
             $headerObject->getLevel() .
             ">" .
             $headerObject->getContent() .
             "</h" .
             $headerObject->getLevel() .
             ">\n";
    }
    
    private static function objectButton($buttonObject, $indent = null)
    {
        // Print The First Part Of The First Tag.

        echo self::$BP . $indent . "<button";
        
        // Print Objects ID And Class.

        self::objectID($buttonObject->getID());
        self::objectClass($buttonObject->getClass());
        
        // Print Type.
        
        if ($buttonObject->getType() != null)
            echo " type=\"" . $buttonObject->getType() . "\"";
        
        // Print The Last Part Of The First Tag.
        
        echo ">";
        
        // Print Value.
        
        echo "<span>" . $buttonObject->getContent() . "</span>";
        
        // Print Last Tag.

        echo "</button>\n";
    }
    
    private static function objectSelectOption($selectOptionObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<option";
        
        // Print Value.
        
        echo " value=\"" . $selectOptionObject->getValue() . "\"";
        
        // Print Selected.
        
        if ($selectOptionObject->isSelected())
            echo " selected=\"selected\"";
        
        // Print The Last Part Of The First Tag.
        
        echo ">";
        
        // Print Content.
        
        echo $selectOptionObject->getContent();
        
        // Print Last Tag.

        echo "</option>\n";
    }
    
    private static function objectSelect($selectObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<select";
        
        // Print Object ID.

        self::objectID($selectObject->getID());
        
         // Print Object Class.
        
        self::objectClass($selectObject->getClass());
        
        // Print Object Name.
        
        self::objectName($selectObject->getName());
        
        // Print The Last Part Of The First Tag.
        
        echo ">\n";
        
        // Print Select Content.
        
        for ($i = 0; $i < $selectObject->countOptions(); $i ++)
            self::objectSelectOption($selectObject->getOptionAt($i), $indent . "    ");
            
        // Print Last Tag.

        echo self::$BP . $indent . "</select>\n";
    }
    
    private static function objectLabel($labelObject, $indent = null)
    {
            // Print First Tag.

            echo self::$BP . $indent . "<label";
            
            if ($labelObject->getFor() != null)
                echo " for=\"" . $labelObject->getFor() . "\"";
            
            echo ">";
            
            // Print Content.
            
            echo $labelObject->getContent();
            
            // Print Last Tag.

            echo "</label>\n";
    }
    
    private static function objectInput($inputObject, $indent = null)
    {
        // Print First Tag.

        echo self::$BP . $indent . "<input";

        // Print Objects ID And Class.

        self::objectID($inputObject->getID());
        self::objectClass($inputObject->getClass());
        
        // Print Max Length.
        
        if ($inputObject->getMaxLength() != null)
            echo " maxlength=\"" . $inputObject->getMaxLength() . "\"";
        
        // Print Value.
        
        if ($inputObject->getContent() != null)
            echo " value=\"" . $inputObject->getContent() . "\"";
        
        if ($inputObject->getValue() != null)
            echo " value=\"" . $inputObject->getValue() . "\"";
        
        // Print Type.
        
        if ($inputObject->getType() != null)
            echo " type=\"" . $inputObject->getType() . "\"";
        
        // Print Name.
        
        if ($inputObject->getName() != null)
            echo " name=\"" . $inputObject->getName() . "\"";

        // Print Last Tag.

        echo " />\n";
    }
    
    private static function objectTextArea($textareaObject, $indent = null)
    {
        // Print First Tag.

        echo self::$BP . $indent . "<textarea";

        // Print Objects ID, Class, Name.

        self::objectID($textareaObject->getID());
        self::objectClass($textareaObject->getClass());
        self::objectName($textareaObject->getName());
        
        // Print Max Length.
        
        if ($textareaObject->getMaxLength() != null)
            echo " maxlength=\"" . $textareaObject->getMaxLength() . "\"";
        
        // Print The Last Part Of The First Tag.
        
        echo ">";
        
        // Print Content.
        
        echo $textareaObject->getContent();
        
        // Print Last Tag.

        echo "</textarea>\n";
    }
    
    private static function objectTableCell($cellObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<td";
        
        // Print Objects ID And Class.
        
        self::objectID($cellObject->getID());
        self::objectClass($cellObject->getClass());
        
        // Print Row Span.
        
        if ($cellObject->getRowSpan() != null)
            echo " rowspan=\"" . $cellObject->getRowSpan() . "\"";
        
        // Print Cell Span.
        
        if ($cellObject->getColSpan() != null)
            echo " colspan=\"" . $cellObject->getColSpan() . "\"";
        
        // Print Alignment.

        self::objectsAlignment($cellObject->getAlignment());
        
        echo ">\n";
        
        // Print Content.
        
        if ($cellObject->getContent() != null)
            self::element($cellObject->getContent(), $indent . "    ");
        
        // Print Last Tag.
        
        echo self::$BP . $indent . "</td>\n";
    }
    
    private static function objectTableRow($rowObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<tr";
        
        // Print Objects ID And Class.
        
        self::objectID($rowObject->getID());
        self::objectClass($rowObject->getClass());
        
        echo ">\n";
        
        // Print Content.
        
        if ($rowObject->getCells() != null)
        {
            foreach ($rowObject->getCells() as $cell)
                self::objectTableCell($cell, $indent . "    ");
        }
        
        // Print Last Tag.
        
        echo self::$BP . $indent . "</tr>\n";
    }
    
    private static function objectTable($tableObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<table";
        
        // Print Objects ID And Class.
        
        self::objectID($tableObject->getID());
        self::objectClass($tableObject->getClass());
        
        // Print Alignment.

        self::objectsAlignment($tableObject->getAlignment());
        
        echo ">\n";
        
        // Print Content.
        
        if ($tableObject->getRows() != null)
        {
            foreach ($tableObject->getRows() as $row)
                self::objectTableRow($row, $indent . "    ");
        }
        
        // Print Last Tag.
        
        echo self::$BP . $indent . "</table>\n";
    }
    
    private static function objectForm($formObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<form";
        
        // Print Objects ID And Class.
        
        self::objectID($formObject->getID());
        self::objectClass($formObject->getClass());
        
        // Print Type.
        
        if ($formObject->getType() != null)
            echo " enctype=\"" . $formObject->getType() . "\"";
        
        // Print Method.
        
        if ($formObject->getMethod() != null)
            echo " method=\"" . $formObject->getMethod() . "\"";
        
        // Print Action.
        
        if ($formObject->getAction() != null)
            echo " action=\"" . $formObject->getAction() . "\"";

        echo ">\n";
        
        // Print Content.
        
        if ($formObject->getItems() != null)
        {
            // Print Elements.
            
            foreach ($formObject->getItems() as $item)
                self::element($item, $indent . "    ");
        }
        
        // Print Last Tag.
        
        echo self::$BP . $indent . "</form>\n";
    }
    
    private static function objectListItem($listItemObject, $indent = null)
    {
        // Print First Tag.
        
        echo self::$BP . $indent . "<li";
        
        // Print Objects ID And Class.
        
        self::objectID($listItemObject->getID());
        self::objectClass($listItemObject->getClass());
        
        echo ">\n";
        
        // Print Content.

        self::element($listItemObject->getContent(), $indent . "    ");

        // Print Last Tag.
        
        echo self::$BP . $indent . "</li>\n";
    }
    
    private static function objectList($listObject, $indent = null)
    {
        // Print Name.

        self::objectString($listObject->getName(), $indent);
        
        // Print First Tag.
        
        echo self::$BP . $indent . "<" . $listObject->getType();
        
        // Print Objects ID And Class.
        
        self::objectID($listObject->getID());
        self::objectClass($listObject->getClass());
        
        echo ">\n";
                
        // Print List Items.
        
        for ($i = 0; $i < $listObject->countItems(); $i ++)
            self::element($listObject->getItemAt($i), $indent . "    ");
        
        // Print Last Tag.
        
        echo self::$BP . $indent . "</" . $listObject->getType() . ">\n";
    }
    
    private static function objectDiv($divObject, $indent = null)
    {   
        // Print First Tag.
        
        echo self::$BP . $indent . "<div";
        
        // Print Objects ID, Class And Style.
        
        self::objectID($divObject->getID());
        self::objectClass($divObject->getClass());
        self::objectStyle($divObject->getStyle());
        
        echo ">\n";
        
        // Print Content.
        
        if ($divObject->getContent() != null) // Print Content (If Any).
             self::element($divObject->getContent(), $indent . "    ");
        else if ($divObject->getElements() != null)
            self::element($divObject->getElements(), $indent . "    ");
        
        // Print Last Tag.
        
        echo self::$BP . $indent . "</div>\n";
    }
    
    private static function objectArray($arrayObject, $indent = null)
    {
        foreach ($arrayObject as $object)
            self::element($object, $indent);
    }
    
    // "Main" Methods.
    
    public static function element($elementObject, $indent = null)
    {
        if ($elementObject instanceof FDiv)
            self::objectDiv($elementObject, $indent);
        else if ($elementObject instanceof FAnchor)
            self::objectAnchor($elementObject, $indent);
        else if ($elementObject instanceof FHeader)
            self::objectHeader($elementObject, $indent);
        else if ($elementObject instanceof FInput)
            self::objectInput($elementObject, $indent);
        else if ($elementObject instanceof FTextArea)
            self::objectTextarea($elementObject, $indent);
        else if ($elementObject instanceof FButton)
            self::objectButton($elementObject, $indent);
         else if ($elementObject instanceof FSelect)
            self::objectSelect($elementObject, $indent);
        else if ($elementObject instanceof FLabel)
            self::objectLabel($elementObject, $indent);
        else if ($elementObject instanceof FParagraph)
            self::objectParagraph($elementObject, $indent);
        else if ($elementObject instanceof FTable)
            self::objectTable($elementObject, $indent);
        else if ($elementObject instanceof FForm)
            self::objectForm($elementObject, $indent);
        else if ($elementObject instanceof FList)
            self::objectList($elementObject, $indent);
        else if ($elementObject instanceof FListItem)
            self::objectListItem($elementObject, $indent);
        else if (is_array($elementObject))
            self::objectArray($elementObject, $indent);
        else
            self::objectString($elementObject, $indent);
    }
}

?>