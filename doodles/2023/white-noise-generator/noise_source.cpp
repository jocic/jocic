#include <QtMath>

#include "noise_source.h"

NoiseSource::NoiseSource() {
    this->open(QIODevice::ReadOnly);
}

qint64 NoiseSource::readData(char *data, qint64 maxlen) {
    
    qint64 magnitude = qPow(2, 12);
    
    for (int i = 0; i < maxlen; i++) {
        data[i] = rand() % magnitude;
    }
    
    return maxlen;
}

qint64 NoiseSource::writeData(const char *data, qint64 len) {
    return 0;
}
