#include <QDebug>
#include "events.h"

Events::Events(QString id, QTimer* tmr) {
    
    m_Tmr = tmr;
    
    m_Count = 0;
    m_Id    = id;
}

quint64 Events::get_Count() {
    
    return m_Count;
}

void Events::count() {
    
    m_Count++;
    
    if (m_Tmr != NULL) {
        m_Tmr->start();
    }
}

void Events::print() {
    
    qDebug() << m_Id << m_Count;
}
