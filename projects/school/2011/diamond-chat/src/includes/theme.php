<?php
/***********************************************************\
|* Diamond Chat v1.0.0                                     *|
|* Author: Đorđe Jocić                                     *|
|* Year: 2011                                              *|
|* ------------------------------------------------------- *|
|* Filename: theme.php                                     *|
|* ------------------------------------------------------- *|
|* Copyright (C) 2011                                      *|
|* ------------------------------------------------------- *|
|* This program is free software: you can redistribute     *|
|* it and/or modify it under the terms of the GNU Affero   *|
|* General Public License as published by the Free         *|
|* Software Foundation, either version 3 of the            *|
|* License, or (at your option) any later version.         *|
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

// No direct access.
defined('_EXECUTION') or die();

// Theme.
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>\n";
echo Basics::addSpaces(3) . "<head>\n";
echo Basics::addSpaces(5) . "<title>". Basics::$INF_TITLE . " - $title</title>\n";
echo Basics::addSpaces(5) . "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>\n";
echo Basics::addSpaces(5) . "<script type='text/javascript' src='scripts/basic.js'></script>\n";
echo Basics::addSpaces(5) . "<link rel='stylesheet' type='text/css' href='style.css' />\n";
echo Basics::addSpaces(5) . "<link rel='icon' type='image/png' href='images/favico.png' />\n";
echo Basics::addSpaces(3) . "</head>\n";
echo Basics::addSpaces(3) . "<body>\n";
echo Basics::addSpaces(5) . "<div id='header'>". Basics::$INF_TITLE . " - $title</div>\n";
echo Basics::addSpaces(5) . "<div id='logo'></div>\n";
insertPageContent();

echo Basics::addSpaces(7) . "<div id='footer'>\n";
echo Basics::addSpaces(9) . "<p>All rights reserved. 2011 &#169;</p>\n";
echo Basics::addSpaces(7) . "</div>\n";
echo Basics::addSpaces(3) . "</body>\n";
echo "</html>";
?>
