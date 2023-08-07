#include "singleton.h"

Singleton* Singleton::M_INSTANCE = NULL;
mutex      Singleton::M_MUTEX;

Singleton::Singleton() {
    // Only looks pretty...
}

Singleton* Singleton::getInstance() {
    
    lock_guard<mutex> guard(M_MUTEX);
    
    if (M_INSTANCE == NULL) {
        M_INSTANCE = new Singleton();
    }
    
    return M_INSTANCE;
}

string Singleton::getValue() {
    return m_Value;
}

void Singleton::setValue(string value) {
    m_Value = value;
}
