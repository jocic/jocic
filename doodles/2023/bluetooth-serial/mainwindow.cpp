#include <QDebug>
#include <QThread>
#include <QMessageBox>

#include "mainwindow.h"
#include "./ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    ////////////////////
    
    m_BTE_Agent = new QBluetoothDeviceDiscoveryAgent();
    
    m_BTE_Agent->setLowEnergyDiscoveryTimeout(1000);
    
    connect(m_BTE_Agent, &QBluetoothDeviceDiscoveryAgent::deviceDiscovered,
        this, &MainWindow::on_Device_Discovered);
    
    connect(m_BTE_Agent, &QBluetoothDeviceDiscoveryAgent::finished,
        this, &MainWindow::on_Scan_Finished);
    
    ////////////////////
    
    m_BTE_Devices = new QVector<QBluetoothDeviceInfo>();
    
    ////////////////////
    
    m_BTE_Socket = new QBluetoothSocket(QBluetoothServiceInfo::Protocol::RfcommProtocol);
    
    connect(m_BTE_Socket, &QBluetoothSocket::connected,
        this, &MainWindow::on_Connected);
    
    connect(m_BTE_Socket, &QBluetoothSocket::disconnected,
        this, &MainWindow::on_Disconnected);
    
    connect(m_BTE_Socket, &QBluetoothSocket::errorOccurred,
        this, &MainWindow::on_Error);
    
    ////////////////////
    
    m_BTE_Selected = NULL;
    
    ////////////////////
    
    ui->btn_TH0->setEnabled(false);
    ui->btn_TH1->setEnabled(false);
    ui->btn_TH2->setEnabled(false);
    ui->btn_TH3->setEnabled(false);
    ui->btn_TH4->setEnabled(false);
    ui->btn_TH5->setEnabled(false);
    ui->btn_TH6->setEnabled(false);
    ui->btn_TH7->setEnabled(false);
    ui->btn_TH8->setEnabled(false);
    ui->btn_TH9->setEnabled(false);
    ui->btn_TH10->setEnabled(false);
}

MainWindow::~MainWindow()
{
    delete ui;
    
    delete m_BTE_Agent;
    delete m_BTE_Devices;
    delete m_BTE_Socket;
}

void MainWindow::on_Device_Discovered(const QBluetoothDeviceInfo &info) {
    
    QString device_name    = info.name();
    QString device_address = info.address().toString();
    
    QString device_identifier = device_name + " (" + device_address + ")";
    
    m_BTE_Devices->push_back(info);
    
    ui->cb_Devices->addItem(device_identifier);
    
    qDebug() << "Discovered:" << device_identifier;
}

void MainWindow::on_Scan_Finished() {
    
    ui->cb_Devices->setEnabled(true);
    ui->btn_Scan->setEnabled(true);
    ui->btn_Connect->setEnabled(true);
    
    qDebug() << "Scanning done...";
}

void MainWindow::on_Connected() {
    
    ui->btn_TH0->setEnabled(true);
    ui->btn_TH1->setEnabled(true);
    ui->btn_TH2->setEnabled(true);
    ui->btn_TH3->setEnabled(true);
    ui->btn_TH4->setEnabled(true);
    ui->btn_TH5->setEnabled(true);
    ui->btn_TH6->setEnabled(true);
    ui->btn_TH7->setEnabled(true);
    ui->btn_TH8->setEnabled(true);
    ui->btn_TH9->setEnabled(true);
    ui->btn_TH10->setEnabled(true);
    
    ///////////////////
    
    ui->btn_Connect->setText("Disconnect");
}

void MainWindow::on_Disconnected() {
    
    ui->btn_Connect->setText("Connect");
    
    ui->cb_Devices->setEnabled(true);
    ui->btn_Scan->setEnabled(true);
    ui->btn_Connect->setEnabled(true);
    
    ui->btn_TH0->setEnabled(false);
    ui->btn_TH1->setEnabled(false);
    ui->btn_TH2->setEnabled(false);
    ui->btn_TH3->setEnabled(false);
    ui->btn_TH4->setEnabled(false);
    ui->btn_TH5->setEnabled(false);
    ui->btn_TH6->setEnabled(false);
    ui->btn_TH7->setEnabled(false);
    ui->btn_TH8->setEnabled(false);
    ui->btn_TH9->setEnabled(false);
    ui->btn_TH10->setEnabled(false);
}

void MainWindow::on_Error(QBluetoothSocket::SocketError error) {
    
    if (QBluetoothSocket::SocketError::UnknownSocketError == error) {
        ui->cb_Devices->setEnabled(true);
        ui->btn_Scan->setEnabled(true);
        ui->btn_Connect->setEnabled(true);
    }
    
    qDebug() << "Socket error:" << int(error);
    
    QMessageBox error_dialog;
    
    error_dialog.setText(m_BTE_Socket->errorString());
    error_dialog.exec();
}

void MainWindow::on_cb_Devices_currentIndexChanged(int index)
{
    if (index == -1) {
        m_BTE_Selected = NULL;
        return;
    }
    
    ////////////////////
    
    qDebug() << "Attempting to selected device at index:" << index;
    
    if (m_BTE_Devices->count() > index) {
        m_BTE_Selected = (QBluetoothDeviceInfo*)&m_BTE_Devices->at(index);
        qDebug() << "Success...";
    }
}

void MainWindow::on_btn_Scan_clicked()
{
    ui->cb_Devices->setEnabled(false);
    ui->btn_Scan->setEnabled(false);
    ui->btn_Connect->setEnabled(false);
    
    ui->btn_TH0->setEnabled(false);
    ui->btn_TH1->setEnabled(false);
    ui->btn_TH2->setEnabled(false);
    ui->btn_TH3->setEnabled(false);
    ui->btn_TH4->setEnabled(false);
    ui->btn_TH5->setEnabled(false);
    ui->btn_TH6->setEnabled(false);
    ui->btn_TH7->setEnabled(false);
    ui->btn_TH8->setEnabled(false);
    ui->btn_TH9->setEnabled(false);
    ui->btn_TH10->setEnabled(false);
    
    ///////////////////
    
    ui->cb_Devices->clear();
    
    m_BTE_Devices->clear();
    
    m_BTE_Selected = NULL;
    
    ///////////////////
    
    qDebug() << "Scanning for BTE devices...";
    
    m_BTE_Agent->start();
}

void MainWindow::on_btn_Connect_clicked()
{
    if (ui->btn_Connect->text() == "Disconnect") {
        
        m_BTE_Socket->disconnectFromService();
    }
    else {
        
        if (m_BTE_Selected == NULL) {
            return;
        }
        
        ///////////////////
        
        ui->cb_Devices->setEnabled(false);
        ui->btn_Scan->setEnabled(false);
        ui->btn_Connect->setEnabled(false);
        
        ui->btn_TH0->setEnabled(false);
        ui->btn_TH1->setEnabled(false);
        ui->btn_TH2->setEnabled(false);
        ui->btn_TH3->setEnabled(false);
        ui->btn_TH4->setEnabled(false);
        ui->btn_TH5->setEnabled(false);
        ui->btn_TH6->setEnabled(false);
        ui->btn_TH7->setEnabled(false);
        ui->btn_TH8->setEnabled(false);
        ui->btn_TH9->setEnabled(false);
        ui->btn_TH10->setEnabled(false);
        
        ///////////////////
        
        QBluetoothAddress address = m_BTE_Selected->address();
        
        qDebug() << "Attempting to connect to:" << address.toString();
        
        QBluetoothAddress test("00:20:12:08:76:D2");
        m_BTE_Socket->connectToService(test, 1);
    }
}

void MainWindow::on_btn_TH0_clicked()
{
    char payload = 0;
    
    m_BTE_Socket->write(&payload, 1);
}


void MainWindow::on_btn_TH1_clicked()
{
    char payload = 1;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH2_clicked()
{
    char payload = 2;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH3_clicked()
{
    char payload = 3;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH4_clicked()
{
    char payload = 4;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH5_clicked()
{
    char payload = 5;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH6_clicked()
{
    char payload = 6;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH7_clicked()
{
    char payload = 7;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH8_clicked()
{
    char payload = 8;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH9_clicked()
{
    char payload = 9;
    
    m_BTE_Socket->write(&payload, 1);
}

void MainWindow::on_btn_TH10_clicked()
{
    char payload = 10;
    
    m_BTE_Socket->write(&payload, 1);
}
