#include "main_window.h"

#include <QApplication>

/*
 * TO-DO (Tomorrow)
 *   - com port couln't be open - error message not invali config
 *   - implement basic vertical controls - left click zoom in, right click zoom out, scroll wheel shifts the range up/own
 *   - Update samples/duration in real time
 *   - move the range continously even if there's no signal (set it to 1ms per division)
 *   - playback feature - remove the tab, add a button with the play icon - don't overthink it or overengineer it (just needs to play the samples at the specified sample rate)
 * TO-DO (Paid Version):
 *   - Add an Icon
 *   - Saving/Loading procedure should be optimized and done using Threads in combination with a progress bar
 *   - Improve UI (use those tabs that can be moved around/docked etc)
 *   - Add ability to issue commands to the connected device
 *   - Configuration Window (UART -> Baud Rate,Parity, Samples -> Sample Format (Binary, Text), Hardware -> ADC Resolution, Positive/Negative Reference Voltages, etc)
 **/

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    MainWindow w;
    w.show();
    return a.exec();
}
