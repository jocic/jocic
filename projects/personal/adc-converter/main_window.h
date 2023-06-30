#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QVector>
#include <QPlainTextEdit>

#include "data_receiver.h"

QT_BEGIN_NAMESPACE
namespace Ui { class MainWindow; }
QT_END_NAMESPACE

class MainWindow : public QMainWindow
{
    Q_OBJECT
    
    public:
        
        MainWindow(QWidget *parent = nullptr);
        ~MainWindow();
        
    private slots:
        
        // UI
        
        void on_btnCapture_clicked();
        void on_btnSave_clicked();
        void on_btnLoad_clicked();
        void on_txtHex_1_textChanged(const QString &arg1);
        void on_txtDec_2_textChanged(const QString &arg1);
        void on_cbSignedInteger_toggled(bool checked);
        void on_btnRefresh_clicked();
        void on_txtSamples_selectionChanged();
        void on_cmbBitsPerSample_currentIndexChanged(int index);
        
    private:
        
        Ui::MainWindow* ui;
        DataReceiver    receiver;
        QVector<qint64> samples;
        
        void setupConnections();
        void showErrorMessage(QString title, QString message);
        
    signals:
        
        void adc_resolution_changed(int resolution);
        
};
#endif // MAINWINDOW_H