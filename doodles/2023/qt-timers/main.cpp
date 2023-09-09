#include <QDebug>
#include <QCoreApplication>
#include <QTimer>
#include <QThread>

#include "events.h"



int main(int argc, char *argv[]) {
    
    QCoreApplication a(argc, argv);
    
    ////////////////////////////////
    
    QTimer tmr_interval;
    Events evt_interval("EVT1");
    
    QEventLoop::connect(&tmr_interval, &QTimer::timeout,
        &evt_interval, &Events::count);
    
    tmr_interval.start();
    
    ////////////////////////////////
    
    QTimer tmr_oneshot;
    Events evt_oneshot("EVT2", &tmr_oneshot);
    
    QEventLoop::connect(&tmr_oneshot, &QTimer::timeout,
        &evt_oneshot, &Events::count);
    
    tmr_oneshot.setSingleShot(true);
    tmr_oneshot.start();
    
    ////////////////////////////////
    
    QTimer tmr_multi_1, tmr_multi_2;
    Events evt_multi("EVT3");
    
    QEventLoop::connect(&tmr_multi_1, &QTimer::timeout,
        &evt_multi, &Events::count);
    
    QEventLoop::connect(&tmr_multi_2, &QTimer::timeout,
        &evt_multi, &Events::count);
    
    tmr_multi_1.start();
    tmr_multi_2.start();
    
    ////////////////////////////////
    
    QTimer tmr_eval;
    
    QEventLoop::connect(&tmr_eval, &QTimer::timeout,
        &evt_interval, &Events::print);
    
    QEventLoop::connect(&tmr_eval, &QTimer::timeout,
        &evt_oneshot, &Events::print);
    
    QEventLoop::connect(&tmr_eval, &QTimer::timeout,
        &evt_multi, &Events::print);
    
    tmr_eval.setInterval(1000);
    tmr_eval.start();
    
    return a.exec();
}
