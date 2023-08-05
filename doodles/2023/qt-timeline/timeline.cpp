#include <QWidget>
#include <QScrollArea>
#include <QHBoxLayout>
#include <QGridLayout>
#include <QLabel>

#include "timeline.h"

TimelineWidget::TimelineWidget(QWidget* parent, Qt::WindowFlags f) {
    
    QWidget*     wd_main  = new QWidget();
    QScrollArea* sa_main  = new QScrollArea();
    QGridLayout* lay_main = new QGridLayout();
    
    for (int i = 0; i < 1000; i++) {
        
        int row = i / 10;
        int col = i % 10;
        
        QWidget*     wd_element  = new QWidget();
        QGridLayout* lay_element = new QGridLayout();
        
        QLabel* lbl_hex     = new QLabel("HEX");
        QLabel* lbl_dec     = new QLabel("DEC");
        QLabel* lbl_hex_val = new QLabel("0xFF");
        QLabel* lbl_dec_val = new QLabel("255");
        
        QString hex_style = "text-align: center;" \
            "font-weight: bold;" \
            "background: #5eba7d;" \
            "color: #fff;";
        
        QString dec_style = "text-align: center;" \
            "font-weight: bold;" \
            "background: #0074cc;" \
            "color: #fff;";
        
        QString val_style = "text-align: center;" \
            "font-weight: bold;" \
            "background: none;" \
            "color: #333;";
        
        lbl_hex->setStyleSheet(hex_style);
        lbl_dec->setStyleSheet(dec_style);
        lbl_hex_val->setStyleSheet(val_style);
        lbl_dec_val->setStyleSheet(val_style);
        
        lbl_hex->setAlignment(Qt::AlignHCenter);
        lbl_dec->setAlignment(Qt::AlignHCenter);
        lbl_hex_val->setAlignment(Qt::AlignHCenter);
        lbl_dec_val->setAlignment(Qt::AlignHCenter);
        
        lay_element->addWidget(lbl_hex, 0, 0);
        lay_element->addWidget(lbl_dec, 0, 1);
        lay_element->addWidget(lbl_hex_val, 1, 0);
        lay_element->addWidget(lbl_dec_val, 1, 1);
        
        lay_element->setContentsMargins(0, 0, 0, 0);
        
        wd_element->setLayout(lay_element);
        
        if (col == 0) {
            
            QLabel* lbl_range = new QLabel();
            
            lbl_range->setText(QString::asprintf("%d - %d",
                (row * 10) + 1, ((row + 1) * 10)));
            
            lay_main->addWidget(lbl_range, row, 0);
            lay_main->addWidget(wd_element, row, 1);
            
            lay_main->setColumnStretch(0, 0);
            lay_main->setColumnStretch(1, 1);
            
        }
        else {
            
            lay_main->addWidget(wd_element, row, col + 1);
            lay_main->setColumnStretch(col + 1, 1);
        }
    }
    
    sa_main->setWidgetResizable(true);
    wd_main->setLayout(lay_main);
    sa_main->setWidget(wd_main);
    
    this->setLayout(new QHBoxLayout());
    
    this->layout()->addWidget(sa_main);
}
