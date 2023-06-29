#include <QDebug>
#include <QRandomGenerator>

#include "data_receiver.h"

DataReceiver::DataReceiver()
{
    this->serial_port = new QSerialPort();
}

bool DataReceiver::configure(QString port_name, quint32 baud_rate, quint8 bits_per_sample) {
    
    if (this->serial_port->isOpen()) {
        this->serial_port->close();
    }
    
    this->serial_port->setPortName(port_name);
    this->serial_port->setBaudRate(QSerialPort::Baud19200);
    this->serial_port->setParity(QSerialPort::NoParity);
    this->serial_port->setDataBits(QSerialPort::Data8);
    this->serial_port->setStopBits(QSerialPort::OneStop);
    
    this->bps = bits_per_sample;
    
    return this->serial_port->open(QSerialPort::ReadWrite);
}

void DataReceiver::run() {
    
    SerialData data;
    quint16    sample;
    
    int i = 0;
    
    while (true) {
        
        this->serial_port->read((char*)&sample, 2);
        
        if (this->serial_port->waitForReadyRead()) {
            
            quint8 first = sample & 0xFF;
            quint8 second = sample >> 8;    
            
            data.samples.push_back({ double(i), double(sample & 0xFFFF) });
            //qDebug() << first << second;
            i++;
            
            if (i == 10) {
                i = 0;
                emit this->new_data(&data);
            }
        }
        
    }
}
