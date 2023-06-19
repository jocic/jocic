<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: statistics.php                                *|
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

// Create "Core" Variables.

$varMaxHeight = 200;

// Create "Core" Elements.

$hdVisits     = new FHeader();
$divVisits    = new FDiv();
$hdUsers      = new FHeader();
$divUsers     = new FDiv();

// "Header Visits" Element Settings.

$hdVisits->setLevel(2);
$hdVisits->setContent(Locales::getTitle("visitor-statistics"));

// "Div Visits" Element Settings.

$divVisits->setID("visitor-statistics");
$divVisits->setClass("stats-container");

Statistics::printVisits($divVisits, $varMaxHeight);

// "Header Visits" Element Settings.

$hdUsers->setLevel(2);
$hdUsers->setContent(Locales::getTitle("user-statistics"));

// "Div Users" Element Settings.

$divUsers->setID("user-statistics");
$divUsers->setClass("stats-container");

Statistics::printUsers($divUsers, $varMaxHeight);

// Append Elements To "Workplace".

$divWorkplace->addElement($hdVisits);
$divWorkplace->addElement($divVisits);
$divWorkplace->addElement($hdUsers);
$divWorkplace->addElement($divUsers);

?>