<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_ads.php                                 *|
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

if (!defined("CONST_EASY_SQL")) exit("Action not allowed.");

// Row "Demo Advert 1".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 1", "<img src=\"./assets/images/aff28e587ea3f3128b3bf73fcfa74b09fdb18905.png\" border=\"0\" />", "leaderboard-728x90", 0))
);

// Row "Demo Advert 2".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 2", "<img src=\"./assets/images/4874a74d62be5fb4dcb5c2cee61c710b0016506e.png\" border=\"0\" />", "leaderboard-728x90", 0))
);

// Row "Demo Advert 3".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 3", "<img src=\"./assets/images/be7dc2fd2b05418dbc660a9b267696e61c605459.png\" border=\"0\" />", "leaderboard-728x90", 0))
);

// Row "Demo Advert 4".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 4", "<img src=\"./assets/images/f50ecf28c3b2a272534579ed5a49b9c10031941b.png\" border=\"0\" />", "half-banner-200x60", 1))
);

// Row "Demo Advert 5".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 5", "<img src=\"./assets/images/c21c62e3253c8a53710893bb92475bfb543ec639.png\" border=\"0\" />", "half-banner-200x60", 1))
);


// Row "Demo Advert 6".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 6", "<img src=\"./assets/images/2a52e95826e9f09d4dac931103814aaec5f92125.png\" border=\"0\" />", "half-banner-200x60", 1))
);

// Row "Demo Advert 7".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 7", "<img src=\"./assets/images/f50ecf28c3b2a272534579ed5a49b9c10031941b.png\" border=\"0\" />", "half-banner-200x60", 2))
);

// Row "Demo Advert 8".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 8", "<img src=\"./assets/images/c21c62e3253c8a53710893bb92475bfb543ec639.png\" border=\"0\" />", "half-banner-200x60", 2))
);


// Row "Demo Advert 9".

EasyInsert::execute
(
    new TableSelection("ads"),
    new ColumnSelection("name", "content", "css_class", "section"),
    new ValueSelection(array("Demo Advert 9", "<img src=\"./assets/images/2a52e95826e9f09d4dac931103814aaec5f92125.png\" border=\"0\" />", "half-banner-200x60", 2))
);

?>