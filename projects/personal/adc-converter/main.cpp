#include "main_window.h"

#include <QApplication>

/*
 * TO-DO (Paid Version):
 *   - Add an Icon
 *   - Saving/Loading procedure should be optimized and done using Threads in combination with a progress bar
 *   - Improve UI (use those tabs that can be moved around/docked etc)
 *   - Add ability to issue commands to the connected device
 *   - Configuration Window (Baud Rate,Parity, Sample Format (Binary, Text) etc)
 **/

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    MainWindow w;
    w.show();
    return a.exec();
}
