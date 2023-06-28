#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QVector>
#include <QPlainTextEdit>

QT_BEGIN_NAMESPACE
namespace Ui { class MainWindow; }
QT_END_NAMESPACE

class MainWindow : public QMainWindow
{
    Q_OBJECT
    
public:
    MainWindow(QWidget *parent = nullptr);
    ~MainWindow();
    void showErrorMessage(QString title, QString message);
    
private slots:
    void on_btnCapture_clicked();
    void on_btnSave_clicked();
    void on_btnLoad_clicked();
    
    void on_txtHex_1_textChanged(const QString &arg1);
    
    void on_txtDec_2_textChanged(const QString &arg1);
    
    void on_cbSignedInteger_toggled(bool checked);
    
    void on_btnRefresh_clicked();
    
    void on_txtSamples_selectionChanged();
    
private:
    Ui::MainWindow *ui;
    QVector<qint64> samples;
};
#endif // MAINWINDOW_H
