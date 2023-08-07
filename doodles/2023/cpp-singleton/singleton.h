#ifndef SINGLETON_H

#define SINGLETON_H

#include <string>
#include <mutex>

using namespace std;

class Singleton
{
    private:
        string m_Value;
        static Singleton* M_INSTANCE;
        static mutex M_MUTEX;
        Singleton();
        Singleton(Singleton& clone) = delete;
        void operator = (const Singleton&) = delete;
    
    public:
        static Singleton* getInstance();
        string getValue();
        void setValue(string value);
        
};

#endif // SINGLETON_H
