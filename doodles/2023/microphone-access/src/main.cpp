#include <iostream>

#include <portaudio.h>

using namespace std;

int main()
{
    PaError err;
    
    err = Pa_Initialize();
    
    cout << err << endl;
    
    return 0;
}
