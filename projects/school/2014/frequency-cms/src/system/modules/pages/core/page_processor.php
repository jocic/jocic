<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: page_processor.php                            *|
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

abstract class PageProcessor
{
    // "Core" Variables.
    
    protected $pvn  = null; // Page Variable Name.
    protected $ovn  = null; // Option Variable Name.
    protected $idvn = null; // ID Variable Name.
    protected $evn  = null; // Error Variable Name.
    protected $nvn  = null; // Notice Variable Name.
    
    protected $pnv  = null; // Page Name Variable.
    
    protected $ep   = null; // Error Prefix.
    protected $np   = null; // Notice Prefix.
    
    protected $cl   = null; // Core Link.
    
    // "Constructor/s."
    
    public function __construct($pageName = null)
    {
        // Set "Page Name" (log-in, register, resend-email-verification).
        
        $this->setPageName($pageName);
        
        // Set "Page Variables Names" - Differ Because Of Locales.
        
        $this->setPageVariableName();
        $this->setOptionVariableName();
        $this->setIDVariableName();
        $this->setErrorVariableName();
        $this->setNoticeVariableName();
        
        // Set "Core Link".
        
        $this->setCoreLink();
        
        // Set "Error" And "Notice" Prefixes.
        
        $this->setErrorLocationPrefix();
        $this->setNoticeLocationPrefix();
    }
    
    // "Set" Methods.
    
    protected function setPageName($pageName)
    {
        $this->pnv = $pageName;
    }
    
    protected function setCoreLink()
    {
        $this->cl = "./?" . $this->pvn . "=" . $this->pnv;
    }
    
    protected function setPageVariableName()
    {
        $this->pvn = Locales::getVariable("page");
    }
    
    protected function setOptionVariableName()
    {
        $this->ovn = Locales::getVariable("option");
    }
    
    protected function setIDVariableName()
    {
        $this->idvn = Locales::getVariable("id");
    }
    
    protected function setErrorVariableName()
    {
        $this->evn = Locales::getVariable("error");
    }
    
    protected function setNoticeVariableName()
    {
        $this->nvn = Locales::getVariable("notice");
    }
    
    protected function setErrorLocationPrefix()
    {
        $this->ep = $this->getCoreLink() . "&" . $this->getErrorVariableName() . "=";
    }
    
    protected function setNoticeLocationPrefix()
    {
        $this->np = $this->getCoreLink() . "&" . $this->getNoticeVariableName() . "=";
    }
    
    // "Get" Methods.
    
    protected function getPageName()
    {
        return $this->pnv;
    }
    
    protected function getCoreLink()
    {
        return $this->cl;
    }
    
    protected function getPageVariableName()
    {
        return $this->pvn;
    }
    
    protected function getIDVariableName()
    {
        return $this->idvn;
    }
    
    protected function getOptionVariableName()
    {
        return $this->ovn;
    }
    
    protected function getErrorVariableName()
    {
        return $this->evn;
    }
    
    protected function getNoticeVariableName()
    {
        return $this->nvn;
    }
    
    protected function getErrorLocationPrefix()
    {
        return $this->ep;
    }
    
    protected function getNoticeLocationPrefix()
    {
        return $this->np;
    }
    
    // "Is" Methods.
    
    protected function isCorePageSelected()
    {
        return Locales::getLink($this->getPageName()) != "?";
    }
    
    protected function isPageSelected()
    {
        return !empty($_GET[$this->getPageVariableName()]) && strtolower($_GET[$this->getPageVariableName()]) == $this->getPageName();
    }
    
    protected function isErrorShown()
    {
        return !empty($_GET[$this->getErrorVariableName()]);
    }
    
    protected function isNoticeShown()
    {
        return !empty($_GET[$this->getNoticeVariableName()]);
    }
    
    protected function isPostEmpty()
    {
        return empty($_POST);
    }
    
    // "Main" Methods.
    
    public abstract function execute();
    
    public function start()
    {
        $this->execute();
    }
}

?>