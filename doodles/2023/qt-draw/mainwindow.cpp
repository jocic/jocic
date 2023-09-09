#include "mainwindow.h"
#include "canvas.h"
#include "./ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    //////////////
    
    this->setMinimumWidth(300);
    this->setMinimumHeight(300);
    
    this->setMaximumWidth(300);
    this->setMaximumHeight(300);
    
    //////////////
    
    Canvas* canvas = new Canvas();
    
    this->layout()->addWidget(canvas);
}

MainWindow::~MainWindow()
{
    delete ui;
}

