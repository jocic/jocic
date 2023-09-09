#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QThread>
#include <QtCharts/QLineSeries>
#include <QtCharts/QValueAxis>

QT_BEGIN_NAMESPACE
namespace Ui { class MainWindow; }
QT_END_NAMESPACE

class Updater : public QThread {
    
    Q_OBJECT
    
    private:
        bool ready;
    
    public:
        void run();
    
    public slots:
        void on_ready();
    
    signals:
        void sig_next();
};

class MainWindow : public QMainWindow {
    
    Q_OBJECT
    
    public:
        MainWindow(QWidget *parent = nullptr);
        ~MainWindow();
        
    private:
        Ui::MainWindow* ui;
        QLineSeries*    series;
        QValueAxis*     x_axis;
        QValueAxis*     y_axis;
        
    private slots:
        void on_next();
    
    signals:
        void sig_ready();
};
#endif // MAINWINDOW_H
