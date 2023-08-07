#include <iostream>
#include "singleton.h"

using namespace std;

int main()
{
    Singleton* i1 = Singleton::getInstance();
    Singleton* i2 = Singleton::getInstance();
    
    i1->setValue(":D");
    
    cout << i2->getValue() << endl;
    
    return 0;
}
