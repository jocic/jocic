#include <QHBoxLayout>
#include <QElapsedTimer>

#include "mainwindow.h"
#include "basic_plot.h"
#include "./ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    ///////////////////////////
    
    ui->plot->set_Resolution(100, 100);
    
    ///////////////////////////
    
    Updater* updater = new Updater();
    
    updater->start(QThread::Priority::TimeCriticalPriority);
    
    connect(updater, &Updater::sig_next, this, &MainWindow::on_next);
}

MainWindow::~MainWindow() {
    delete ui;
}

void MainWindow::on_next() {
    
    static QVector<QPair<qint64, qint64>> data;
    
    qint64 x = data.size();
    qint64 y = (rand() % 100) + 150;
    
    data.push_back({ x, y });
    
    if (data.size() >= 400) {
        
        ui->plot->get_Buffer()->clear();
        ui->plot->get_Buffer()->append(data);
        
        ui->plot->refresh();
        
        data.clear();
    }
}

///////////////////////////

void Updater::run() {
    
    QElapsedTimer tmr_benchmark;
    QElapsedTimer tmr_flow_control;
    
    quint64 points_updated = 0;
    
    tmr_benchmark.start();
    tmr_flow_control.start();
    
    while (true) {
        
        if (tmr_benchmark.elapsed() >= 1000) {
            tmr_benchmark.restart();
            qDebug() << "Points Updated" << points_updated;
            points_updated = 0;
        }
        
        if (tmr_flow_control.nsecsElapsed() >= 25000) {
            tmr_flow_control.restart();
            emit Updater::sig_next();
            points_updated++;
        }
    }
}
