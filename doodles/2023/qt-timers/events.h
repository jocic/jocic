#include <QObject>
#include <QTimer>

class Events : public QObject {
    
    Q_OBJECT
    
    private:
        QTimer* m_Tmr;
        QString m_Id;
        quint64 m_Count;
        
    public:
        Events(QString id, QTimer* tmr = NULL);
        quint64 get_Count();
    
    public slots:
        void print();
        void count();
};
