#include "mainwindow.h"
#include "./ui_mainwindow.h"

#include <QHBoxLayout>
#include <QDateTime>
#include <QtCharts/QChartView>
#include <QtCharts/QChart>
#include <QtCharts/QLineSeries>
#include <QtCharts/QSplineSeries>
#include <QtCharts/QValueAxis>

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    ///////////////////////////
    
    customPlot = new QCustomPlot();
    
    customPlot->addGraph();
    customPlot->graph(0)->setPen(QPen(Qt::blue));
    customPlot->graph(0)->setBrush(QBrush(QColor(0, 0, 255, 20)));
    
    customPlot->xAxis2->setVisible(true);
    customPlot->xAxis2->setTickLabels(false);
    
    customPlot->yAxis2->setVisible(true);
    customPlot->yAxis2->setTickLabels(false);
    
    connect(customPlot->xAxis, SIGNAL(rangeChanged(QCPRange)), customPlot->xAxis2, SLOT(setRange(QCPRange)));
    connect(customPlot->yAxis, SIGNAL(rangeChanged(QCPRange)), customPlot->yAxis2, SLOT(setRange(QCPRange)));
    
    customPlot->graph(0)->rescaleAxes();
    
    customPlot->setInteractions(QCP::iRangeDrag | QCP::iRangeZoom | QCP::iSelectPlottables);
    
    ///////////////////////////
    
    this->setLayout(new QHBoxLayout());
    
    this->layout()->addWidget(customPlot);
    
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
    
    static qreal x = 0;
    static qreal y = 0;
    
    static QVector<double> x_points;
    static QVector<double> y_points;
    
    y = (rand() % 300) - 150;
    
    x_points.append(x++);
    y_points.append(y);
    
    if (x_points.size() >= 100) {
        
        customPlot->graph(0)->setData(x_points, y_points);
        customPlot->replot();
        
        x = 0;
        
        x_points.clear();
        y_points.clear();
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
