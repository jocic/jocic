#ifndef SCOPE_WIDGET_H
#define SCOPE_WIDGET_H

#include <QHBoxLayout>
#include <QThread>
#include <QRandomGenerator>

#include <QtCore/QPointF>

#include <QtWidgets/QWidget>

#include <QtCharts/QChartView>
#include <QtCharts/QLineSeries>
#include <QtCharts/QChart>
#include <QtCharts/QValueAxis>

#include "data_receiver.h"

class ScopeWidget : public QWidget
{
    Q_OBJECT
    
    private:
        QWidget*     parent;
        QHBoxLayout* layout;
        QChartView*  chart_view;
        QChart*      chart;
        QLineSeries* chart_series;
        QValueAxis*  chart_x;
        QValueAxis*  chart_y;
    
    public:
        ScopeWidget(QWidget* parent);
        
    public slots:
        void on_new_scope_data(SerialData* data);
};

#endif // SCOPE_WIDGET_H
