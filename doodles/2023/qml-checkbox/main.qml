import QtQuick 
import QtQuick.Layouts
import QtQuick.Controls

Window {
    width: 600
    height: 480
    visible: true
    title: qsTr("QML Checkbox")
    
    RowLayout {
        anchors.fill: parent
        Layout.fillWidth: true
        Layout.fillHeight: true
        spacing: 0
        
        SwitchDelegate {
            Layout.alignment: Qt.AlignCenter
            
            id: option_one
            width: 100
            text: qsTr("Option 1")
            leftPadding: 10
            rightPadding: 10
            topPadding: 10
            bottomPadding: 10
            font.pixelSize: Qt.application.font.pixelSize * 1.25
            font.bold: false
            
            contentItem: Text {
                rightPadding: option_one.indicator.width + option_one.spacing
                text: option_one.text
                font: option_one.font
                opacity: enabled ? 1.0 : 0.3
                color: "#7283da"
                elide: Text.ElideRight
                verticalAlignment: Text.AlignVCenter
            }
            
            indicator:Rectangle {
                width: 30
                height: 30
                x: option_one.width - width - option_one.rightPadding
                y: option_one.topPadding + option_one.availableHeight / 2 - height / 2
                border.width: 2
                border.color: "#e3e3e3"
                radius: 5
                
                RowLayout {
                    anchors.fill: parent
                    Layout.fillWidth: true
                    Layout.fillHeight: false
                    
                    Label {
                        Layout.alignment: Qt.AlignCenter
                        text: qsTr("🗸")
                        font.pixelSize: Qt.application.font.pixelSize * 1.5
                        width: 20
                        height: 20
                        x: 5
                        y: 5
                        color: "#6073d5"
                        visible: option_one.checked
                    }
                }
            }
            
            background:Rectangle {
                color: "transparent"
            }
        }
        
        Button {
            Layout.alignment: Qt.AlignCenter
            
            id: submit
            text: qsTr("Submit")
            font.pixelSize: Qt.application.font.pixelSize * 1.25
            font.bold: false
            onClicked: __test.test()
            
            contentItem: Text {
                text: submit.text
                font: submit.font
                opacity: enabled ? 1.0 : 0.3
                color: "#6073d5"
                horizontalAlignment: Text.AlignHCenter
                verticalAlignment: Text.AlignVCenter
                elide: Text.ElideRight
            }
        
            background: Rectangle {
                implicitWidth: 100
                implicitHeight: 40
                opacity: enabled ? 1 : 0.3
                border.width: 1
                border.color: "#6073d5"
                radius: 5
            }
        }
    }
}
