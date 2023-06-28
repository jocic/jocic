#ifndef SCOPE_WIDGET_H
#define SCOPE_WIDGET_H

#include <QHBoxLayout>
#include <QThread>
#include <QRandomGenerator>

#include <QtCore/QPointF>
#include <QtCore/QList>
#include <QtCore/QQueue>

#include <QtWidgets/QWidget>

#include <QtCharts/QChartView>
#include <QtCharts/QLineSeries>
#include <QtCharts/QChart>
#include <QtCharts/QValueAxis>


class ScopeWidget : public QWidget
{
    Q_OBJECT
    
    private:
    
    
    QList<QPointF> test;
    
        QWidget*     parent;
        QHBoxLayout* layout;
        QChartView*  chart_view;
        QChart*      chart;
        QLineSeries* chart_series;
        QValueAxis*  chart_x;
        QValueAxis*  chart_y;
    
    public:
        ScopeWidget(QWidget* parent);
        
        void does_smth() {
            
            test.clear();
            
            for (int i = 0; i < 44100; i++) {
                
                double x = QRandomGenerator::global()->generateDouble();
                double y = QRandomGenerator::global()->generateDouble();
                
                y *= 200;
                y += 412;
                
                QPointF point(i, y);
                test.push_back(point);
            }
            
            this->chart_series->replace(test);
        }
};

class DataProcessor : public QThread {
    
private:
    
    ScopeWidget* reference;
    
public:
    
    DataProcessor(ScopeWidget* reference) {
        this->reference = reference;
    }
    
    void run() {
        
        while (true) {
            this->reference->does_smth();
            this->msleep(100);
        }
    }
};

#endif // SCOPE_WIDGET_H
