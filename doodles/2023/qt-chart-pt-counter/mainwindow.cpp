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
    
    QHBoxLayout* layout = new QHBoxLayout();
    QChartView*  view   = new QChartView();
    QChart*      chart  = new QChart();
    QLineSeries* series = new QLineSeries();
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
    
    static QList<QPointF> points;
    
    x += 1;
    y  = (rand() % 300) - 150;
    
    points.append(QPointF(x, y));
    
    if (points.size() == 1000) {
        
        this->series->replace(points);
        this->x_axis->setRange(x - 1000, x);
        
        points.clear();
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
