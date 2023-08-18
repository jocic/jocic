#include <QCoreApplication>
#include <QThread>
#include <QTextStream>
#include <QFile>
#include <QtMultimedia/QMediaDevices>
#include <QtMultimedia/QAudioSink>
#include <QtMultimedia/QAudioDevice>
#include <QtMultimedia/QAudioFormat>

#define ERR_NONE      0
#define ERR_NO_SOURCE 1
#define ERR_NO_DEVICE 2
#define ERR_FORMAT    3

QTextStream out(stdout);
QTextStream err(stderr);    

int main(int argc, char *argv[]) {
    
    // Open Audio Source
    
    QFile audio_source;
    
    QCoreApplication a(argc, argv);
    
    audio_source.setFileName("./test.wav");
    audio_source.open(QFile::OpenModeFlag::ReadOnly);
    
    if (!audio_source.isOpen()) {
        err << "[x] Source file couldn't be opened.";
        return ERR_NO_SOURCE;
    }
    
    // Set Audio Format
    
    QAudioDevice audio_output;
    QAudioFormat audio_format;
    
    audio_output = QMediaDevices::defaultAudioOutput();
    
    if (audio_output.isNull()) {
        err << "[x] No output device available.";
        return ERR_NO_DEVICE;
    }
    
    audio_format.setSampleRate(44100);
    audio_format.setChannelCount(1);
    audio_format.setSampleFormat(QAudioFormat::Int16);
    
    if (!audio_output.isFormatSupported(audio_format)) {
        err << "[x] Format not supported.";
        return ERR_FORMAT;
    }
    
    // Play Audio
    
    QAudioSink sink(audio_format, &a);
    
    sink.start(&audio_source);
    
    return a.exec();
}
