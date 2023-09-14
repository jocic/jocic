#include <iostream>
#include <iomanip>

using namespace std;

typedef union {
    
    unsigned int conversion;
    
    int i4 : 4;
    int i5 : 5;
    int i6 : 6;
    int i7 : 7;
    int i8 : 8;
    
} adc_val;

int main() {
    
    adc_val sample;
    
    sample.conversion = 0xAA;
    
    cout << "Raw Value: " << hex << uppercase << "0x" << sample.conversion << endl;
    
    cout << endl;
    
    cout << "4-bit value: " << dec << sample.i4 << endl;
    cout << "5-bit value: " << dec << sample.i5 << endl;
    cout << "6-bit value: " << dec << sample.i6 << endl;
    cout << "7-bit value: " << dec << sample.i7 << endl;
    cout << "8-bit value: " << dec << sample.i8 << endl;
    
    return 0;
}
