<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_view.php                                 *|
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

class EasyView
{
    // "Core" Variables.

    private $viewName  = null;
    private $colSel    = null;
    private $tblSel    = null;
    private $arguments = null;

    // Constructor/s.

    public function __construct($params = null)
    {
        if ($params != null)
        {
            $queryBuilder = new DataQueryBuilder();

            // Processors.

            $tp = new TableProcessor();
            $cp = new ColumnProcessor();
            $ap = new ArgumentProcessor();

            $params = func_get_args();

            foreach ($params as $value)
            {
                if (is_object($value))
                {
                    if ($value instanceof TableSelection)
                        $this->tblSel = $value;

                    else if ($value instanceof ColumnSelection)
                        $this->colSel = $value;

                    else if ($value instanceof ArgumentSelection)
                        $this->arguments = $value;

                    else
                        new Error("EasyView", "You have used a wrong object in the constructor.");
                }
                else if (is_string($value))
                {
                    if ($tp->isTableSelection($value))
                        $this->tblSel = $tp->processVariable($value);

                    else if ($cp->isColumnSelection($value))
                        $this->colSel = $cp->processVariable($value);

                    else if ($ap->isArgumentSelection($value))
                        $this->arguments = $ap->processVariable($value);

                    else
                        $this->setName($value);
                }
            }
        }
    }
	
    // "Set" Methods.

    public function setName($value)
    {
        if (is_string($value))
            $this->viewName = @mysql_real_escape_string($value);
        else
            new Error("EasyView", "Name of the view must be string.");
    }

    public function setColumnSelection($params = null)
    {
        $params = func_get_args();

        $cs = new ColumnProcessor();

        $this->colSel = $cs->processVariable($params);
    }
	
    public function setTableSelection($params = null)
    {
        $params = func_get_args();

        $ts = new TableProcessor();

        $this->tblSel = $ts->processVariable($params);
    }
	
    public function setArgumentSelection($params = null)
    {
        $params = func_get_args();

        $as = new ArgumentProcessor();

        $this->arguments = $as->processVariable($params);
    }
	
    // "Get" Methods.

    public function getName()
    {
        return $this->viewName;
    }
	
    public function getColumnSelection()
    {
        return $this->colSel;
    }
	
    public function getTableSelection()
    {
        return $this->tblSel;
    }

    public function getArgumentSelection()
    {
        return $this->arguments;
    }
	
    // "Other" Methods.

    public function exists()
    {
        $arg_1 = new Argument("table_schema", "=", EasyCore::getSchemaName());
        $arg_2 = new Argument("table_name", "=", EasyCore::getViewPrefix() . $this->getName());

        EasyGet::setParameters
        (
            new ColumnSelection("*"),
            new TableSelection("information_schema.VIEWS"),
            new ArgumentSelection($arg_1, Argument::AO_AND, $arg_2)
        );

        return (EasyGet::execute() != null);
    }
}

?>