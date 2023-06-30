#include <QDebug>

#include "data_control.h"

DataControl::DataControl(chart_ref_t ref)
{
    this->chart_ref  = ref;
    this->data_raw   = new QQueue<QByteArray>();
    this->data       = new QQueue<qint64>();
    
    this->configure(10);
}

void DataControl::configure(quint64 queue_delay_ms)
{
    this->queue_delay_ms = queue_delay_ms;
}

void DataControl::run()
{
    quint64 _x = 0, x = 0;
    
    while (true) {
        
        if (!this->data_raw->empty()) {
            
            this->chart_ref.view->setUpdatesEnabled(false);
            
            QByteArray bytes = this->data_raw->front();
            
            this->data_raw->pop_front();
            
            qint64  sample_value  = 0;
            quint64 array_length  = bytes.size() - 1;
            bool    skipped_first = false;
            
            for (quint64 i = 0; i < array_length; i++) {
                
                if (   (bytes[i] == '\r' && bytes[i + 1] == '\n')
                    || (bytes[i] == '\n' && bytes[i + 1] == '\r')) {
                    
                    if (skipped_first) {
                        
                        if (_x % 16 == 0) {
                            this->chart_ref.series->append(x, sample_value);
                            x += 16;
                        }
                        
                        
                        _x++;
                    }
                    
                    sample_value  = 0;
                    skipped_first = true;
                }
                
                if (!skipped_first) {
                    continue;
                }
                
                if (bytes[i] >= '0' && bytes[i] <= '9') {
                    sample_value *= 10;
                    sample_value += bytes[i] - '0';
                }
            }
            
            if (_x > 1024) {
                this->chart_ref.x_axis->setRange(_x - 1024, _x);
                
                if (_x % 16 == 0)
                this->chart_ref.series->remove(0);
            }
            
            this->chart_ref.view->setUpdatesEnabled(true);
        }
        
        //this->msleep(this->queue_delay_ms);
    }
}

void DataControl::on_new_data(QByteArray data) {
    
    *this->data_raw += data;
}
