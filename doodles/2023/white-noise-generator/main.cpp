#include <QDebug>
#include <QThread>
#include <QTextStream>
#include <QCoreApplication>

#include <QtMultimedia/QMediaDevices>
#include <QtMultimedia/QAudioDevice>
#include <QtMultimedia/QAudioFormat>
#include <QtMultimedia/QAudioSink>

#include "noise_source.h"

#define ERR_NO_OUTPUT          1
#define ERR_UNSUPPORTED_FORMAT 2
#define ERR_UNKOWN             3

QTextStream out(stdout);
QTextStream in(stdin);
QTextStream err(stderr);

int main(int argc, char *argv[])
{
    QCoreApplication a(argc, argv);
    
    QAudioDevice  audio_output;
    QAudioFormat  audio_format;
    QAudioSink*   audio_sink;
    NoiseSource*  noise_source;
    
    audio_output = QMediaDevices::defaultAudioOutput();
    
    if (audio_output.isNull()) {
        err << "[x] Couldn't find an output device";
        return ERR_NO_OUTPUT;
    }
    
    audio_format.setSampleRate(44100);
    audio_format.setChannelCount(1);
    audio_format.setSampleFormat(QAudioFormat::Int16);
    
    if (!audio_output.isFormatSupported(audio_format)) {
        err << "[x] Audio format not supported";
        return ERR_UNSUPPORTED_FORMAT;
    }
    
    audio_sink   = new QAudioSink(audio_format, NULL);
    noise_source = new NoiseSource();
    
    audio_sink->start(noise_source);
    
    return a.exec();
}
