#ifndef DATARECEIVER_H
#define DATARECEIVER_H

#include <QThread>
#include <QSerialPort>
#include <QtCore/QList>
#include <QtCore/QPointF>
#include <QtCore/QQueue>

typedef struct Data {
    QList<QPointF> samples;
} SerialData;

class DataReceiver : public QThread
{
    Q_OBJECT
    
    private:
        QSerialPort* serial_port;
        quint8 bps;
    
    public:
        DataReceiver();
        bool configure(QString port_name, quint32 baud_rate, quint8 bits_per_sample);
        void run();
        
    signals:
        void new_data(SerialData* data);
};

#endif // DATARECEIVER_H
