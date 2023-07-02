#ifndef NOISE_SOURCE_H
#define NOISE_SOURCE_H

#include <QIODevice>

class NoiseSource : public QIODevice {
    
    public:
        NoiseSource();
    
    protected:
        qint64 readData(char *data, qint64 maxlen) override;
        qint64 writeData(const char *data, qint64 len) override;
};

#endif // NOISE_SOURCE_H
