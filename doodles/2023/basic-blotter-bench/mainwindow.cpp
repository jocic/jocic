#include <QHBoxLayout>
#include <QDateTime>

#include "mainwindow.h"
#include "basic_plot.h"
#include "./ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    ///////////////////////////
    
    ui->plot->set_Resolution(200, 200);
    
    ///////////////////////////
    
    Updater* updater = new Updater();
    
    updater->start(QThread::HighestPriority);
    
    connect(updater, &Updater::sig_next, this, &MainWindow::on_next);
    connect(this, &MainWindow::sig_ready, updater, &Updater::on_ready);
    
    ///////////////////////////
    
    emit MainWindow::sig_ready();
}

MainWindow::~MainWindow() {
    delete ui;
}

void MainWindow::on_next() {
    
    static QVector<QPair<qint64, qint64>> data;
    
    qint64 x = data.size();
    qint64 y = (rand() % 100) + 350;
    
    data.push_back({ x, y });
    
    if (data.size() >= 800) {
        
        ui->plot->get_Buffer()->clear();
        ui->plot->get_Buffer()->append(data);
        
        ui->plot->refresh();
        
        data.clear();
    }
    
    emit MainWindow::sig_ready();
}

///////////////////////////

void Updater::on_ready() {
    this->ready = true;
}

void Updater::run() {
    
    quint64 time_last = 0, time_diff = 0;
    
    quint64 points_updated = 0;
    
    while (true) {
        
        time_diff = QDateTime::currentMSecsSinceEpoch() - time_last;
        
        if (time_diff >= 1000) {
            time_last = QDateTime::currentMSecsSinceEpoch();
            qDebug() << "Points Updated" << points_updated;
            points_updated = 0;
        }
        
        if (this->ready) {
            this->ready = false;
            emit Updater::sig_next();
            points_updated++;
        }
    }
}
