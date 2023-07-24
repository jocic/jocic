#ifndef TESTCLASS_H
#define TESTCLASS_H

#include <QObject>
#include <QDebug>

class TestClass : public QObject {
    
    Q_OBJECT
    
    public:
        
        Q_INVOKABLE inline void test() {
            qDebug() << "All is good...";
        }
};

#endif // TESTCLASS_H
