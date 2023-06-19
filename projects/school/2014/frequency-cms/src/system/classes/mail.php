<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: mail.php                                      *|
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

// Class Starts.

class Mail
{
    // "Main" Variables.
    
    private $to   = null;
    private $from = null;
    private $subj = null;
    private $msg  = null;
    private $hdrs = null;
    
    // "Set" Methods.
    
    public function setTo($sendTo)
    {
        $this->to = $sendTo;
    }
    
    public function setFrom($sendFrom)
    {
        $this->from = $sendFrom;
    }
    
    public function setSubject($subject)
    {
        $this->subj = $subject;
    }
    
    public function setMessage($message)
    {
        $this->msg = $message;
    }
    
    public function setHeaders($header)
    {
        $this->hdrs = $header;
    }
    
    public function setDefaultHeaders()
    {
        $this->hdrs  = "MIME-Version: 1.0\r\n";
        $this->hdrs .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $this->hdrs .= "From: " . Core::get(Core::WEBSITE_TITLE) . " <noreply@" . Core::get(Core::WEBSITE_BASE) . ">\r\n";
    }
    
    // "Get" Methods.
    
    public function getTo()
    {
        return $this->to;
    }
    
    public function getFrom()
    {
        return $this->from;
    }
    
    public function getSubject()
    {
        return $this->subj;
    }
    
    public function getMessage()
    {
        return $this->msg;
    }
    
    public function getHeader()
    {
        return $this->hdrs;
    }
    
    // "Main" Methods.
    
    public function send()
    {
        if ($this->hdrs == null)
            $this->setDefaultHeaders();
        
        @mail($this->to, $this->subj, $this->msg, $this->hdrs);
    }
}

?>
