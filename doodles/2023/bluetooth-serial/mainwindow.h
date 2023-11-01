#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QBluetoothDeviceDiscoveryAgent>
#include <QBluetoothDeviceInfo>
#include <QBluetoothSocket>
#include <QVector>

QT_BEGIN_NAMESPACE
namespace Ui { class MainWindow; }
QT_END_NAMESPACE

class MainWindow : public QMainWindow
{
    Q_OBJECT
    
public:
    QBluetoothDeviceDiscoveryAgent* m_BTE_Agent;
    QVector<QBluetoothDeviceInfo>* m_BTE_Devices;
    QBluetoothDeviceInfo* m_BTE_Selected;
    QBluetoothSocket* m_BTE_Socket;
    MainWindow(QWidget *parent = nullptr);
    ~MainWindow();
    
public:
    void on_Device_Discovered(const QBluetoothDeviceInfo &info);
    void on_Scan_Finished();
    void on_Connected();
    void on_Disconnected();
    void on_Error(QBluetoothSocket::SocketError error);
    
private slots:
    
    void on_cb_Devices_currentIndexChanged(int index);
    
    void on_btn_Scan_clicked();
    
    void on_btn_Connect_clicked();
    
    void on_btn_TH0_clicked();
    
    void on_btn_TH1_clicked();
    
    void on_btn_TH2_clicked();
    
    void on_btn_TH3_clicked();
    
    void on_btn_TH4_clicked();
    
    void on_btn_TH5_clicked();
    
    void on_btn_TH6_clicked();
    
    void on_btn_TH7_clicked();
    
    void on_btn_TH8_clicked();
    
    void on_btn_TH9_clicked();
    
    void on_btn_TH10_clicked();
    
private:
    Ui::MainWindow *ui;
};
#endif // MAINWINDOW_H
