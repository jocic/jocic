#include <QDebug>
#include <QFile>
#include <QList>
#include <QCoreApplication>

#include <QtMultimedia/QMediaDevices>
#include <QtMultimedia/QAudioDevice>
#include <QtMultimedia/QAudioFormat>
#include <QtMultimedia/QAudioSink>

#define WAV_FILE "test.wav"

QFile       audio_file;
QAudioSink* audio_sink;

void on_state_changed(QAudio::State state) {
    
    if (state == QAudio::ActiveState) {
        
        audio_sink->stop();
        audio_file.close();
        
        delete audio_sink;
        
        QCoreApplication::quit();
    }
}

int main(int argc, char *argv[]) {
    
    QCoreApplication a(argc, argv);
    
    QList<QAudioDevice> audio_outputs;
    QAudioDevice        audio_output;
    QAudioFormat        audio_format;
    
    // List Available Outputs
    
    qDebug() << "[*] Available outputs:";
    
    audio_outputs = QMediaDevices::audioOutputs();
    
    for (const auto& audio_output : audio_outputs) {
        qDebug() << "-" << audio_output.description();
    }
    
    // Pick Default Output
    
    audio_output = QMediaDevices::defaultAudioOutput();
    
    qDebug() << "[*] Picked default output:" << audio_output.description();
    
    // Specify Playback Format
    
    audio_format.setSampleRate(6750);
    audio_format.setChannelCount(1);
    audio_format.setSampleFormat(QAudioFormat::Int16);
    
    qDebug() << "[*] Audio Format:";
    
    qDebug() << "-" << "Sample Rate: " << audio_format.sampleRate();
    qDebug() << "-" << "Channel Count: " << audio_format.channelCount();
    qDebug() << "-" << "Sample Format: " << audio_format.sampleFormat();
    
    qDebug() << "- Format Supported:" <<
        (audio_output.isFormatSupported(audio_format) ? "Yes" : "No");
    
    // Play WAV File
    
    audio_file.setFileName(WAV_FILE);
    audio_file.open(QFile::ReadOnly);
    
    if (!audio_file.isOpen()) {
        qDebug() << "[x] Couldn't open the speicified file...";
    }
    
    audio_sink = new QAudioSink(audio_format, NULL);
    
    audio_sink->start(&audio_file);
    
    QAudioSink::connect(audio_sink, &QAudioSink::stateChanged,
        audio_sink, &on_state_changed);
    
    return a.exec();
}
