

#include <QMessageBox>
#include <QFileDialog>
#include <QDebug>
#include <QFile>

#include <iostream>

using namespace std;

#include "main_window.h"
#include "./ui_main_window.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
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

void MainWindow::on_btnCapture_clicked()
{
    
}


void MainWindow::on_btnSave_clicked()
{
    
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
    
    qDebug() << "Bits per Sample: " << ui_bits_value;
    qDebug() << "Sample Signed: " << (ui_sample_signed ? "Yes" : "No");
    
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
        
        // Display Info
        
        quint64 dump_samples = this->samples.size();
        qreal   dump_duration = dump_samples / qreal(ui_rate_value);
        
        this->ui->lblSampleCount->setText(QString::asprintf("%lld", dump_samples));
        this->ui->lblDurationCount->setText(QString::asprintf("%.2fs", dump_duration));
        
        qDebug() << "Loaded " << this->samples.count()
            << " samples from the \"" << dump_filepath << "\" file";
        
        // Generate Human-Readable Samples
        
        QString ui_samples;
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
                    ui_samples += QString::asprintf("%02X ", quint8(sample));
                    break;
                case 16:
                ui_samples += QString::asprintf("%02X", quint8((sample >> 8) & 0xFF));
                    ui_samples += QString::asprintf("%02X ", quint8(sample & 0xFF));
                    break;
                case 32:
                    ui_samples += QString::asprintf("%02X", quint8((sample >> 24) & 0xFF));
                    ui_samples += QString::asprintf("%02X", quint8((sample >> 16) & 0xFF));
                    ui_samples += QString::asprintf("%02X", quint8((sample >> 8) & 0xFF));
                    ui_samples += QString::asprintf("%02X ", quint8(sample & 0xFF));
                    break;
                default:
                    this->showErrorMessage("Application Error", "Invalid bits per sample value.");
                    return;
            }
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
            
            switch (arg1.size()) {
                case 2:
                    value_sig = qint8(value);
                    break;
                case 4:
                    value_sig = qint16(value);
                    break;
                case 8:
                    value_sig = qint32(value);
                    break;
                case 16:
                    value_sig = qint64(value);
                    break;
                default:
                    value_sig = 0;
            }
            
            text = QString::asprintf("%lld", value_sig);
        }
        else {
            text = QString::asprintf("%lld", value);
        }
    }
    
    this->ui->txtDec_1->setText(text);
    
    qDebug() << "Hex to Dec: " << arg1 << "(" << (sig ? "Yes" : "No") << ")";
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
                // doesn't work - text = QString::asprintf("%016X", value_sig);
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
    
    qDebug() << "Dec to Hex: " << arg1;
}

