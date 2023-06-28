#include <QDebug>

#include "scope_widget.h"

ScopeWidget::ScopeWidget(QWidget* parent)
{
    // Chart Setup
    
    this->layout = new QHBoxLayout();
    
    this->chart_view   = new QChartView();
    this->chart        = new QChart();
    this->chart_series = new QLineSeries();
    this->chart_x      = new QValueAxis();
    this->chart_y      = new QValueAxis();
    
    this->setContentsMargins(0, 0, 0, 0);
    
    this->chart_x->setTitleText("Time");
    this->chart_x->setRange(0, 2000);
    
    this->chart_y->setTitleText("ADC Value");
    this->chart_y->setRange(0, 1024);
    
    this->chart->setBackgroundVisible(false);
    this->chart->addSeries(this->chart_series);
    this->chart->addAxis(this->chart_x, Qt::AlignmentFlag::AlignBottom);
    this->chart->addAxis(this->chart_y, Qt::AlignmentFlag::AlignLeft);
    this->chart->legend()->hide();
    
    this->chart_series->attachAxis(this->chart_x);
    this->chart_series->attachAxis(this->chart_y);
    
    this->chart_view->setChart(this->chart);
    this->chart_view->setContentsMargins(0, 0, 0, 0);
    
    this->layout->addWidget(this->chart_view);
    
    this->setLayout(this->layout);
    
    // Data Processor Setup
    
    DataProcessor* dp = new DataProcessor(this);
    
    dp->start();
}
