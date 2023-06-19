/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: ace_implement_advert.js                       *|
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

$(document).ready(function() {
    // Switching Textarea Element With Pre Element.
    
    $('#advert-content textarea').hide();
    
    $('#advert-content-editor').prepend('<pre id="ace-css-editor">' + 
            $('#advert-content textarea').val() + '</pre>');
    
    // Initializing Ace.
    
    var editor = ace.edit("ace-css-editor");
    
    editor.setTheme("ace/theme/dawn");
    editor.getSession().setMode("ace/mode/html");
    
    // Custom Click Function.
    
    $("#add-advert-submit-button").click(function() {
        $('#advert-content textarea').val(editor.getSession().getValue());
    });
});