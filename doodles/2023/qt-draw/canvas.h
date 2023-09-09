#ifndef CANVAS_H

#define CANVAS_H

#include <QWidget>
#include <QObject>

class Canvas : public QWidget {
    
    Q_OBJECT
    
    public:
        Canvas();
    
    protected:
        void paintEvent(QPaintEvent* event) override;
};

#endif
