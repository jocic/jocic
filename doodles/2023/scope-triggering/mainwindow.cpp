#include "mainwindow.h"
#include "./ui_mainwindow.h"

#include <QtMath>
#include <QDebug>
#include <QHBoxLayout>
#include <QPainter>
#include <QtCharts/QChartView>
#include <QtCharts/QChart>
#include <QtCharts/QSplineSeries>
#include <QtCharts/QValueAxis>

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    ///////////////////////////
    
    QHBoxLayout*   layout = new QHBoxLayout();
    QChartView*    view   = new QChartView();
    QChart*        chart  = new QChart();
    QSplineSeries* series = new QSplineSeries();
    QValueAxis*    x_axis = new QValueAxis();
    QValueAxis*    y_axis = new QValueAxis();
    
    x_axis->setTitleText("Time");
    x_axis->setRange(0, 100);
    
    y_axis->setTitleText("Voltage");
    y_axis->setRange(0, 40);
    
    chart->addSeries(series);
    chart->addAxis(x_axis, Qt::AlignmentFlag::AlignBottom);
    chart->addAxis(y_axis, Qt::AlignmentFlag::AlignLeft);
    chart->legend()->hide();
    
    series->useOpenGL();
    series->attachAxis(x_axis);
    series->attachAxis(y_axis);
    
    view->setChart(chart);
    view->setContentsMargins(0, 30, 0, 0);
    view->setStyleSheet("background: #fff");
    
    layout->addWidget(view);
    layout->setContentsMargins(0, 0, 0, 0);
    
    ui->chartArea->setLayout(layout);
    
    ///////////////////////////
    
    this->series = series;
    this->x_axis = x_axis;
    this->y_axis = y_axis;
    
    this->samples = new QVector<qreal>();
    
    ///////////////////////////
    
    adc_timer = new QTimer();
    
    adc_timer->start();
    
    connect(adc_timer, &QTimer::timeout, this, &MainWindow::next_sample);
    
    ///////////////////////////
    
    display_timer = new QTimer();
    
    display_timer->start();
    
    connect(display_timer, &QTimer::timeout, this, &MainWindow::next_print);
}

MainWindow::~MainWindow() {
    delete ui;
}

void MainWindow::next_sample() {
    
    static qreal x = -3.14;
    
    qreal y = qSin(x) * 10 + 20;
    
    x += 0.1;
    
    if (x > 3.14) {
        x = -3.14;
    }
    
    qreal trig_val = ui->slide_Trigger->value();
    bool  trig_chk = ui->cb_Trigger->isChecked();
    
    qreal trig_min = trig_val - 0.5;
    qreal trig_max = trig_val + 0.5;
    
    qDebug() << y << trig_val << trig_chk << this->samples->count();
    
    ui->lbl_Trigger->setText(QString::asprintf("%0.2fV", trig_val));
    
    if (trig_chk) {
        
        if (y >= trig_min && y <= trig_max) {
            this->trig = true;
        }
        
        if (this->trig && this->samples->count() < 100) {
            this->samples->push_back(y);
        }
    }
    else {
        this->samples->push_back(y);
    }
}

void MainWindow::next_print() {
    
    static quint64 x = 0;
    
    if (this->samples->count() >= 100) {
        
        qDebug() << "Print";
        
        this->series->clear();
        
        for (quint64 i = 0; i < 100; i++) {
            qreal y = this->samples->at(i);
            this->series->append(x++, y);
        }
        
        this->x_axis->setRange(x - 100, x);
        this->samples->clear();
        
        this->trig = false;
    }
}
