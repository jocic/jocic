#include <QHBoxLayout>

#include "mainwindow.h"
#include "basic_plot.h"
#include "./ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    
    auto plot_buffer = ui->plot->get_Buffer();
    
    plot_buffer->append({ 0, 0 });
    plot_buffer->append({ 50, 400 });
    plot_buffer->append({ 100, 0 });
    plot_buffer->append({ 300, 300 });
    plot_buffer->append({ 400, 800 });
    plot_buffer->append({ 800, 3000 });
    plot_buffer->append({ 3800, 2000 });
    plot_buffer->append({ 4000, 4000 });
    
    ui->plot->refresh();
}

MainWindow::~MainWindow()
{
    delete ui;
}

