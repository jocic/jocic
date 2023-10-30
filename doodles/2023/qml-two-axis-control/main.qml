import QtQuick 
import QtQuick.Controls
import QtQuick.Layouts

Window {
    id: app
    width: 640
    height: 480
    visible: true
    title: qsTr("Digital 2-Axis Potentiometer")
    
    property var x_axis : 0
    property var y_axis : 0
    
    Image {
        id: pot_bg
        width: 300
        height: 300
        anchors.verticalCenter: parent.verticalCenter
        anchors.horizontalCenter: parent.horizontalCenter
        source: "img/pot_bg.png"
        opacity: 0.5
        
        MouseArea {
            anchors.fill: parent
            drag.axis: Drag.XAndYAxis
            drag.minimumX: 0
            drag.maximumX: pot_bg.width - pot_knob.width
            drag.minimumY: 0
            drag.maximumY: pot_bg.height - pot_knob.height
            drag.target: pot_knob
            
            onPositionChanged: (mouse) => {
                
                x_axis = ((pot_knob.x + pot_knob.width / 2) - (pot_bg.width / 2));
                y_axis = ((pot_knob.y + pot_knob.height / 2) - (pot_bg.height / 2)) * -1;
            }
            
            onReleased: (mouse) => {
                
                pot_knob.x = (pot_bg.width / 2) - (pot_knob.width / 2);
                pot_knob.y = (pot_bg.width / 2) - (pot_knob.width / 2);
                
                x_axis = 0;
                y_axis = 0;
            }
        }
        
        Image {
            id: pot_knob
            width: 60
            height: 60
            source: "img/pot.png"
            x: (parent.width / 2) - (width / 2)
            y: (parent.height / 2) - (height / 2)
        }
    }
    
    Column {
        anchors.bottom: parent.bottom
        leftPadding: 10
        bottomPadding: 10
        
        /* X Axis */
        
        Row {
            spacing: 10
            
            Text {
                text: "X:"
            }
            
            Text {
                id: lbl_x
                text: x_axis
            }
        }
        
        /* Y Axis */
        
        Row {
            spacing: 10
            
            Text {
                text: "Y:"
            }
            
            Text {
                id: lbl_y
                text: y_axis
            }
        }
    }
}
