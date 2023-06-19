<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: frequency_classes.php                         *|
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

// "Core" Class Includes.

require_once CLASSES_ROOT . "date.php";
require_once CLASSES_ROOT . "random_string_generator.php";
require_once CLASSES_ROOT . "mail.php";

// "HTML Object" Core Class Includes.

require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "html_object.php";

// "HTML Object" Class Include.

require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "anchor.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "button.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "div.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "header.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "list.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "list_item.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "paragraph.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "label.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "input.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "textarea.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "select.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "select_option.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "table.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "form.php";

// "HTML Object" Child Class Include.

require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "child_objects" . DIRECTORY_SEPARATOR . "table_row.php";
require_once CLASSES_ROOT . "html_objects" . DIRECTORY_SEPARATOR . "child_objects" . DIRECTORY_SEPARATOR . "table_cell.php";

// "Content" Class Includes.

require_once CLASSES_ROOT . "content" . DIRECTORY_SEPARATOR . "html_includer.php";
require_once CLASSES_ROOT . "content" . DIRECTORY_SEPARATOR . "content_printer.php";

// "Block And Module" Class Includes.

require_once CLASSES_ROOT . "blocks_and_modules" . DIRECTORY_SEPARATOR . "block.php";
require_once CLASSES_ROOT . "blocks_and_modules" . DIRECTORY_SEPARATOR . "module.php";
require_once CLASSES_ROOT . "blocks_and_modules" . DIRECTORY_SEPARATOR . "page_processor.php";
require_once CLASSES_ROOT . "blocks_and_modules" . DIRECTORY_SEPARATOR . "module_processor.php";

?>