#include "mainwindow.h"
#include "./ui_mainwindow.h"

#include <QHBoxLayout>
#include <QElapsedTimer>
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
    
    QHBoxLayout* layout = new QHBoxLayout();
    QChartView*  view   = new QChartView();
    QChart*      chart  = new QChart();
    QSplineSeries* series = new QSplineSeries();
    QValueAxis*  x_axis = new QValueAxis();
    QValueAxis*  y_axis = new QValueAxis();
    
    x_axis->setTitleText("Time");
    x_axis->setRange(0, 100);
    
    y_axis->setTitleText("Voltage");
    y_axis->setRange(-500, 500);
    
    chart->addSeries(series);
    chart->addAxis(x_axis, Qt::AlignmentFlag::AlignBottom);
    chart->addAxis(y_axis, Qt::AlignmentFlag::AlignLeft);
    chart->legend()->hide();
    
    series->useOpenGL();
    series->attachAxis(x_axis);
    series->attachAxis(y_axis);
    
    view->setChart(chart);
    view->setContentsMargins(0, 20, 0, 0);
    view->setStyleSheet("background: #fff");
    
    layout->addWidget(view);
    layout->setContentsMargins(0, 0, 0, 0);
    
    ui->chartArea->setLayout(layout);
    
    ///////////////////////////
    
    this->series = series;
    this->x_axis = x_axis;
    this->y_axis = y_axis;
    
    ///////////////////////////
    
    Updater* updater = new Updater();
    
    updater->start(QThread::TimeCriticalPriority);
    
    connect(updater, &Updater::sig_next, this, &MainWindow::on_next);
}

MainWindow::~MainWindow() {
    delete ui;
}

void MainWindow::on_next() {
    
    static qreal x = 0;
    static qreal y = 0;
    
    static QList<QPointF> points;
    
    x += 1;
    y  = (rand() % 300) - 150;
    
    points.append(QPointF(x, y));
    
    if (points.size() == 1000) {
        
        this->series->replace(points);
        this->x_axis->setRange(x - 1000, x);
        
        points.clear();
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
        
        if (tmr_flow_control.nsecsElapsed() >= 50000) {
            tmr_flow_control.restart();
            emit Updater::sig_next();
            points_updated++;
        }
    }
}
