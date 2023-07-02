#include "main_window.h"

#include <QApplication>

/*
 * TO-DO (Tomorrow)
 *   - Update samples/duration in real time
 *   - playback feature - remove the tab, add a button with the play icon - don't overthink it or overengineer it (just needs to play the samples at the specified sample rate)
 * TO-DO (Paid Version):
 *   - Add an Icon
 *   - Saving/Loading procedure should be optimized and done using Threads in combination with a progress bar
 *   - Improve UI (use those tabs that can be moved around/docked etc)
 *   - Add ability to issue commands to the connected device
 *   - Configuration Window (UART -> Baud Rate,Parity, Samples -> Sample Format (Binary, Text), Hardware -> ADC Resolution, Positive/Negative Reference Voltages, etc)
 *   - Improve sample management feature - general overview, view values by interval (minute, secons, etc), generate waveform, play interval, etc
 *   - automatically etermine the sample rate
 *   - make an efficient custom chart that oesn't crash the program with >1024 points
 *   - show some notice when there are no samples
 *   - make the ui look sexy AF
 *   - data receiver should exten qserialbus which extens qioevice - ez pz
 *   - have a tab terminal for serial i/o
 *   - Options for the bits per sample should be uint8, int16, int32 - and that's it
 *   - option to "slow down" the waveform 
**/

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    MainWindow w;
    w.show();
    return a.exec();
}
