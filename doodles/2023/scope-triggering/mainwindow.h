#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QTimer>
#include <QQueue>
#include <QVector>
#include <QtCharts/QChartView>
#include <QtCharts/QChart>
#include <QtCharts/QSplineSeries>
#include <QtCharts/QValueAxis>

QT_BEGIN_NAMESPACE
namespace Ui { class MainWindow; }
QT_END_NAMESPACE

class MainWindow : public QMainWindow {
    
    Q_OBJECT
    
    public:
        MainWindow(QWidget *parent = nullptr);
        ~MainWindow();
    
    private:
        Ui::MainWindow* ui;
        QVector<qreal>* samples;
        QTimer*         adc_timer;
        QTimer*         display_timer;
        QSplineSeries*  series;
        QValueAxis*     x_axis;
        QValueAxis*     y_axis;
        bool            trig;
    
    private slots:
        void next_sample();
        void next_print();
        
};
#endif // MAINWINDOW_H
