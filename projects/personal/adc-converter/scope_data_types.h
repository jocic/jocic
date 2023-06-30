#ifndef SCOPE_DATA_TYPES_H
#define SCOPE_DATA_TYPES_H

#include <QtCharts/QChartView>
#include <QtCharts/QChart>
#include <QtCharts/QLineSeries>
#include <QtCharts/QValueAxis>

typedef struct chart_ref {
    QChartView*  view;
    QChart*      chart;
    QLineSeries* series;
    QValueAxis*  x_axis;
    QValueAxis*  y_axis;
} chart_ref_t;

#endif // SCOPE_DATA_TYPES_H
