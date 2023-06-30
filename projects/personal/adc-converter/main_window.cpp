#include <QSerialPortInfo>
#include <QSerialPort>
#include <QMessageBox>
#include <QFileDialog>
#include <QDateTime>
#include <QDebug>
#include <QFile>

#include <iostream>

using namespace std;

#include "main_window.h"
#include "scope_widget.h"
#include "data_receiver.h"
#include "./ui_main_window.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    this->setupConnections();
    
    emit this->on_btnRefresh_clicked();
}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::showErrorMessage(QString title, QString message) {
    
    QMessageBox error;
    
    error.setWindowTitle(title);
    error.setText(message);
    
    error.exec();
}

void MainWindow::setupConnections() {
    
    connect(&this->receiver, &DataReceiver::new_data,
        this->ui->wdScope->dat_ctl, &DataControl::on_new_data);
    
    
}

void MainWindow::on_btnCapture_clicked()
{
    QString ui_rate_text;
    quint64 ui_rate_value;
    QString ui_bits_text;
    quint8  ui_bits_value;
    bool    ui_signed_value;
    QString ui_port_text;
    QString ui_baud_text;
    quint16 ui_baud_value;
    
    ui_rate_text    = this->ui->txtSampleRate->text();
    ui_rate_value   = ui_rate_text.toULong(NULL, 10);
    ui_bits_text    = this->ui->cmbBitsPerSample->currentText();
    ui_bits_value   = ui_bits_text.toUInt(NULL, 10);
    ui_signed_value = this->ui->cbSignedInteger->isChecked();
    ui_port_text    = this->ui->cmbPort->currentText();
    ui_baud_text    = this->ui->cmbBaud->currentText();
    ui_baud_value   = ui_baud_text.toUInt(NULL, 10);
    
    qDebug() << "Sample Rate =" << ui_rate_value
             << "Bits Per Sample =" << ui_bits_value
             << "Signed =" << ui_signed_value
             << "Port =" << ui_port_text
             << "Baud =" << ui_baud_value;
    
    if (ui_port_text.length() == 0) {
        this->showErrorMessage("Generic Error", "COM port not selected.");
        return;
    }
    
    this->receiver.setBitsPerSample(ui_bits_value, ui_signed_value);
    this->receiver.setSampleRate(ui_rate_value);
    
    if (!this->receiver.configure(ui_port_text, ui_baud_value)) {
        this->showErrorMessage("Generic Error", "Invalid serial configuration parameters.");
        return;
    }
    
    this->ui->tabMain->setCurrentIndex(0);
    
    if (this->receiver.isRunning()) {
        this->ui->btnCapture->setText("Connect");
        this->ui->btnRefresh->setEnabled(true);
        this->ui->tabMain->setEnabled(true);
        this->receiver.terminate();
    } else {
        this->ui->btnCapture->setText("Disconnect");
        this->ui->btnRefresh->setEnabled(false);
        this->ui->tabMain->setEnabled(false);
        this->receiver.start();
    }
}

void MainWindow::on_btnRefresh_clicked()
{
    quint8 rate_index;
    quint8 rate_temp;
    
    qDebug() << "Enumerating COM ports...";
    
    // COM Ports
    
    this->ui->cmbPort->clear();
    
    for (const auto& port : QSerialPortInfo::availablePorts()) {
        this->ui->cmbPort->addItem(port.portName());
        qDebug() << "Found:" << port.portName();
    }
    
    this->ui->cmbBaud->clear();
    
    // Baud Rates
    
    rate_temp = 0;
    
    for (const auto& rate : QSerialPortInfo::standardBaudRates()) {
        
        this->ui->cmbBaud->addItem(QString::asprintf("%d", rate));
        
        if (rate == 19200) {
            rate_index = rate_temp;
        }
        
        rate_temp++;
    }
    
    this->ui->cmbBaud->setCurrentIndex(rate_index);
}

void MainWindow::on_btnSave_clicked()
{
    // Get UI Options
    
    quint16  ui_bits_index;
    QString  ui_bits_text;
    quint8   ui_bits_value;
    bool     ui_sample_signed;
    
    ui_bits_index = this->ui->cmbBitsPerSample->currentIndex();
    ui_bits_text  = this->ui->cmbBitsPerSample->itemText(ui_bits_index);
    ui_bits_value = ui_bits_text.toUInt(NULL, 10);
    
    // Save Dump File
    
    QFileDialog file_dialog;
    QString     dump_filename;
    QFile       dump_file;
    quint64     dump_size;
    quint8      sample_length;
    
    dump_filename = "dump_" + QDateTime::currentDateTime().toString("yyyyMMdd_hhmmss") + ".dat";
    
    file_dialog.setWindowTitle("Save Dump");
    file_dialog.setAcceptMode(QFileDialog::AcceptSave);
    file_dialog.selectFile(dump_filename);
    file_dialog.exec();
    
    if (file_dialog.selectedFiles().count() > 0) {
        
        dump_filename = file_dialog.selectedFiles().front();
        
        dump_file.setFileName(dump_filename);
        dump_file.open(QFile::OpenModeFlag::WriteOnly);
        
        if (dump_file.isOpen()) {
            
            sample_length = ui_bits_value / 8;
            dump_size     = this->samples.size() * sample_length;
            
            for (const auto& sample : this->samples) {
                
                switch (ui_bits_value) {
                    case 8:
                    case 16:
                    case 32:
                        dump_file.write((char*)&sample, sample_length);
                        break;
                    
                    default:
                        this->showErrorMessage("Application Error", "Invalid bits per sample value.");
                        return;
                }
            }
            
            if (dump_file.size() != dump_size) {
                this->showErrorMessage("I/O Error", "File couldn't be saved properly.");
            }
            
            dump_file.close();
        }
        else {
            this->showErrorMessage("I/O Error", "Specified file couldn't be created.");
        }
    }
    
    qDebug() << "Saving Samples =" << this->samples.size()
        << ", Filename =" << dump_filename;
}

void MainWindow::on_btnLoad_clicked()
{
    // Get UI Options
    
    QString  ui_rate_text;
    quint32  ui_rate_value;
    quint16  ui_bits_index;
    QString  ui_bits_text;
    quint8   ui_bits_value;
    bool     ui_sample_signed;
    
    ui_rate_text  = this->ui->txtSampleRate->text();
    ui_rate_value = ui_rate_text.toUInt(NULL, 10);
    
    ui_bits_index = this->ui->cmbBitsPerSample->currentIndex();
    ui_bits_text  = this->ui->cmbBitsPerSample->itemText(ui_bits_index);
    ui_bits_value = ui_bits_text.toUInt(NULL, 10);
    
    ui_sample_signed = this->ui->cbSignedSample->isChecked();
    
    qDebug() << "Bits per Sample =" << ui_bits_value;
    qDebug() << "Sample Signed =" << (ui_sample_signed ? "Yes" : "No");
    
    // Load Dump File
    
    QFileDialog file_dialog;
    QString     dump_filepath;
    QFile       dump_file;
    quint32     dump_sample;
    quint64     dump_limit;
    
    file_dialog.setWindowTitle("Load Dump");
    file_dialog.exec();
    
    if (file_dialog.selectedFiles().size() > 0) {
        
        dump_filepath = file_dialog.selectedFiles().front();
        
        dump_file.setFileName(dump_filepath);
        dump_file.open(QIODevice::ReadOnly);
        
        if (!dump_file.isOpen()) {
            this->showErrorMessage("I/O Error", "Specified file couldn't be open.");
            return;
        }
        
        this->samples.clear();
        
        while (!dump_file.atEnd()) {
            
            dump_sample = 0;
            
            switch (ui_bits_value) {
                
                case 8:
                    dump_file.read((char*)&dump_sample, 1);
                    break;
                
                case 16:
                    dump_file.read((char*)&dump_sample, 2);
                    break;
                    
                case 32:
                    dump_file.read((char*)&dump_sample, 4);
                    break;
                    
                default:
                    this->showErrorMessage("Application Error", "Invalid bits per sample value.");
                    return;
            }
            
            this->samples.push_back(dump_sample);
        }
        
        dump_file.close();
        
        // Display Info
        
        quint64 dump_samples = this->samples.size();
        qreal   dump_duration = dump_samples / qreal(ui_rate_value);
        
        this->ui->lblSampleCount->setText(QString::asprintf("%lld", dump_samples));
        this->ui->lblDurationCount->setText(QString::asprintf("%.2fs", dump_duration));
        
        qDebug() << "Loaded Samples =" << this->samples.count()
            << ", Filepath =" << dump_filepath;
        
        // Generate Human-Readable Samples
        
        QString ui_samples;
        QString ui_temp;
        qint16  ui_tab_samples_index = -1;
        
        for (qint16 i = 0; i < this->ui->tabMain->count(); i++) {
            
            if (this->ui->tabMain->tabText(i) == "Samples") {
                ui_tab_samples_index = i;
                break;
            }
        }
        
        if (ui_tab_samples_index == -1) {
            this->showErrorMessage("Application Error", "Samples tab is missing.");
            return;
        }
        
        for (const auto& sample : this->samples) {
            
            switch (ui_bits_value) {
                case 8:
                    ui_temp = QString::asprintf("%02X ", quint8(sample));
                    break;
                case 16:
                    ui_temp  = QString::asprintf("%02X", quint8((sample >> 8) & 0xFF));
                    ui_temp += QString::asprintf("%02X ", quint8(sample & 0xFF));
                    break;
                case 32:
                    ui_temp  = QString::asprintf("%02X", quint8((sample >> 24) & 0xFF));
                    ui_temp += QString::asprintf("%02X", quint8((sample >> 16) & 0xFF));
                    ui_temp += QString::asprintf("%02X", quint8((sample >> 8) & 0xFF));
                    ui_temp += QString::asprintf("%02X ", quint8(sample & 0xFF));
                    break;
                default:
                    this->showErrorMessage("Application Error", "Invalid bits per sample value.");
                    return;
            }
            
            ui_samples += ui_temp;
        }
        
        this->ui->txtSamples->clear();
        this->ui->txtSamples->insertPlainText(ui_samples);
        
        this->ui->tabMain->setCurrentIndex(ui_tab_samples_index);
    }
}


void MainWindow::on_txtHex_1_textChanged(const QString &arg1)
{
    bool    sig;
    quint64 value;
    qint64  value_sig;
    QString text;
    
    if (arg1.size() == 0) {
        
        text = "";
    }
    else {
        
        sig   = this->ui->cbSignedInteger->isChecked();
        value = arg1.toULongLong(NULL, 16);
        
        if (sig) {
            
            if (arg1.size() <= 2) {
                value_sig = qint8(value);
            } else if (arg1.size() <= 4) {
                value_sig = qint16(value);
            } else if (arg1.size() <= 8) {
                value_sig = qint32(value);
            } else if (arg1.size() <= 16) {
                value_sig = qint64(value);
            } else {
                value_sig = 0;
            }
            
            text = QString::asprintf("%lld", value_sig);
        }
        else {
            text = QString::asprintf("%lld", value);
        }
    }
    
    this->ui->txtDec_1->setText(text);
    
    qDebug() << "Hex to Dec: Input=" << arg1 << "Signed =" << (sig ? "Yes" : "No");
}

void MainWindow::on_cbSignedInteger_toggled(bool checked)
{
    qDebug() << "Signed Integer: " << checked;
    
    QString text = this->ui->txtHex_1->text();
    
    emit on_txtHex_1_textChanged(text);
}

void MainWindow::on_txtDec_2_textChanged(const QString &arg1)
{
    bool    sig;
    quint64 value;
    qint64  value_sig;
    QString text;
    
    if (arg1.size() > 0) {
        
        sig = (arg1.front() == '-');
        
        value_sig = arg1.toLongLong(NULL, 10);
        
        if (sig) {
            
            if (-128 <= value_sig) {
                text = QString::asprintf("%02X", quint8(value_sig));
            } else if (-32768 <= value_sig) {
                text = QString::asprintf("%04X", quint16(value_sig));
            }  else if (-2147483648 <= value_sig) {
                text = QString::asprintf("%08X", quint32(value_sig));
            } else {
                text  = QString::asprintf("%08X", quint32((value_sig >> 32) & 0xFFFFFFFFFFFFFFFF));
                text += QString::asprintf("%08X", quint32((value          ) & 0xFFFFFFFFFFFFFFFF));
            } 
        }
        else {
            
            value = arg1.toULongLong(NULL, 10);
            
            while (value > 0) {
                text = QString::asprintf("%02X", (value & 0xFF)) + text;
                value >>= 8;
            }
        }
        
        if (text.size() == 0) {
            text = "00";
        }
    }
    
    
    this->ui->txtHex_2->setText(text);
    
    qDebug() << "Dec to Hex: Input =" << arg1;
}


void MainWindow::on_txtSamples_selectionChanged()
{
    // Get UI Parameters
    
    QString ui_bits_text;
    quint8  ui_bits_value;
    
    ui_bits_text  = this->ui->cmbBitsPerSample->currentText();
    ui_bits_value = ui_bits_text.toUInt(NULL, 10);
    
    // Extract Clicked Word
    
    QString text;
    quint64 text_cursor;
    QString word;
    qint64  word_i, word_j;
    quint8  word_length;
    
    text        = this->ui->txtSamples->toPlainText();
    text_cursor = this->ui->txtSamples->textCursor().selectionStart();
    
    qDebug() << "Text Cursor=" << text_cursor;
    
    if (text.size() > 0) {
        
        word_length = ui_bits_value / 4;
        
        word_i = word_j = text_cursor;
        
        while (word_j < text.size()) {
            
            if (text[word_j] == ' ') {
                word_j--;
                break;
            }
            
            word_j++;
        }
        
        if ((word_j - word_i) < word_length) {
            
            word_i = text_cursor - 1;
            
            while (word_i > 0) {
                
                if (text[word_i] == ' ') {
                    word_i++;
                    break;
                }
                
                word_i--;
            }
            
            if (word_i < 0) {
                word_i = 0;
            }
        }
        
        word = QString(&text[word_i], word_length);
        
        this->ui->txtHex_1->setText(word);
    }
    
    qDebug() << "Extracted Word=" << word;
}

