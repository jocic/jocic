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
    
    quint16  ui_bits_index;
    QString  ui_bits_text;
    quint8   ui_bits_value;
    bool     ui_sample_signed;
    
    ui_bits_index = this->ui->cmbBitsPerSample->currentIndex();
    ui_bits_text  = this->ui->cmbBitsPerSample->itemText(ui_bits_index);
    ui_bits_value = ui_bits_text.toUInt(NULL, 10);
    
    ui_sample_signed = this->ui->cbSigned->isChecked();
    
    qDebug() << "Bits per Sample: " << ui_bits_value;
    qDebug() << "Sample Signed: " << (ui_sample_signed ? "Yes" : "No");
    
    // Load Dump File
    
    QFileDialog file_dialog;
    QString     dump_filepath;
    QFile       dump_file;
    quint16     dump_sample;
    
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
                    dump_sample = ui_sample_signed ? qint8(dump_sample) : quint8(dump_sample);
                    break;
                
                case 16:
                    dump_file.read((char*)&dump_sample, 2);
                    dump_sample = ui_sample_signed ? qint16(dump_sample) : quint16(dump_sample);
                    break;
                    
                case 32:
                    dump_file.read((char*)&dump_sample, 4);
                    dump_sample = ui_sample_signed ? qint32(dump_sample) : quint32(dump_sample);
                    break;
                    
                default:
                    this->showErrorMessage("Application Error", "Invalid bits per sample value.");
                    return;
            }
            
            this->samples.push_back(dump_sample);
        }
        
        qDebug() << "Loaded " << this->samples.count()
            << " samples from the \"" << dump_filepath << "\" file";
    }
}

