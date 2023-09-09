#include <QDebug>
#include <QBrush>
#include <QPainter>
#include <QPainterPath>
#include "canvas.h"

Canvas::Canvas() {
    
    qDebug() << "Canvas instantiated...";
    
    this->setMinimumWidth(300);
    this->setMinimumHeight(300);
}

void Canvas::paintEvent(QPaintEvent* event) {
    
    QPainter painter(this);
    
    ////////////////////////
    
    QBrush brush_background;
    
    brush_background.setColor(Qt::GlobalColor::white);
    brush_background.setStyle(Qt::BrushStyle::SolidPattern);
    
    ////////////////////////
    
    QPen pen_border;
    
    pen_border.setColor(Qt::GlobalColor::black);
    pen_border.setWidth(2);
    
    QPen pen_chart_1;
    
    pen_chart_1.setColor(Qt::GlobalColor::red);
    pen_chart_1.setWidth(1);
    
    QPen pen_chart_2;
    
    pen_chart_2.setColor(Qt::GlobalColor::blue);
    pen_chart_2.setWidth(3);
    
    ////////////////////////
    
    painter.fillRect(0, 0, 300, 300, brush_background);
    
    painter.setPen(pen_border);
    
    painter.drawLine(10, 10, 290, 10);
    painter.drawLine(290, 10, 290, 290);
    painter.drawLine(290, 290, 10, 290);
    painter.drawLine(10, 290, 10, 10);
    
    ////////////////////////
    
    painter.setPen(pen_chart_1);
    
    painter.drawLine(15, 285, 40, 100);
    painter.drawLine(40, 100, 80, 240);
    painter.drawLine(80, 240, 120, 50);
    painter.drawLine(120, 50, 160, 270);
    painter.drawLine(160, 270, 200, 200);
    painter.drawLine(200, 200, 285, 285);
    
    ////////////////////////
    
    painter.setPen(pen_chart_2);
    
    QPainterPath path;
    
    path.moveTo(15, 285);
    path.lineTo(35, 185);
    path.lineTo(60, 120);
    path.lineTo(90, 230);
    path.lineTo(150, 10);
    path.lineTo(180, 240);
    path.lineTo(240, 240);
    path.lineTo(285, 285);
    
    painter.drawPath(path);
}
