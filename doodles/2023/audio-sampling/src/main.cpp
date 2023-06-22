#define PI_VAL 3.14F

#define ADC_REFERENCE_V           3.3F
#define ADC_RESOLUTION            10
#define ADC_SAMPLING_RATE         5000
#define ADC_SAMPLING_DURATION_SEC 10

#define SINE_FREQUENCY_HZ 500
#define SINE_VPP_MV       200
#define SINE_DC_OFFSET_V  1.65F

#include <iostream>
#include <fstream>
#include <cstdint>
#include <cmath>
#include <algorithm>

using namespace std;

const uint8_t WAV_HEADER[44] = {
    0x52, 0x49, 0x46, 0x46, 0xC4, 0x86, 0x01, 0x00, 0x57, 0x41, 0x56, 0x45, 0x66, 0x6D, 0x74, 0x20, 0x10, 0x00, 0x00, 0x00, 0x01, 0x00, 0x01, 0x00, 0x88, 0x13, 0x00, 0x00, 0x10, 0x27, 0x00, 0x00, 0x02, 0x00, 0x10, 0x00, 0x64, 0x61, 0x74, 0x61, 0xA0, 0x86
};

uint16_t* generate_samples(uint16_t& size) {
    
    uint16_t samples_total = ADC_SAMPLING_RATE * ADC_SAMPLING_DURATION_SEC;
    uint16_t adc_range     = pow(2, ADC_RESOLUTION);
    double   volts_per_bit = ADC_REFERENCE_V / adc_range;
    
    uint16_t* samples = new uint16_t[samples_total];
    
    fill(samples, samples + samples_total, 0);
    
    double time_constant = pow(SINE_FREQUENCY_HZ, -1);
    
    uint32_t  signal_data_len = ADC_SAMPLING_DURATION_SEC * 500e3;
    uint16_t* signal_data     = new uint16_t[signal_data_len];
    
    uint32_t  period_samples_len = 500e3 / SINE_FREQUENCY_HZ;
    uint16_t* period_samples     = new uint16_t[period_samples_len];
    
    double radian_increment = (2 * PI_VAL) / period_samples_len;
    
    int j = 0;
    
    for (float radian = 0; radian < 2 * PI_VAL; radian += radian_increment) {
        period_samples[j++] = (sin(radian) * ((SINE_VPP_MV / 1e3) / volts_per_bit)) + (SINE_DC_OFFSET_V / volts_per_bit);
    }
    
    j = 0;
    
    for (int i = 0; i < signal_data_len; i++) {
        
        signal_data[i] = period_samples[j++];
        
        if (j == period_samples_len) {
            j = 0;
        }
    }
    
    size = samples_total;
    
    uint32_t sample_increment = 500e3 / ADC_SAMPLING_RATE;
    
    for (int i = 0, j = 0; i < samples_total; i++, j += sample_increment) {
        samples[i] = signal_data[j];
    }
    
    return samples;
}

void generate_matlab_array(uint16_t* data, uint16_t& size) {
    
    cout << "ARR = [ ";
    
    for (uint16_t i = 0, j = size - 1; i < size; i++) {
        
        cout << data[i];
        
        if (i != j) {
            cout << ", ";
        }
    }
    
    cout << " ];" << endl;
}

int main() {
    
    uint16_t  sample_size;
    uint16_t* sample_data = generate_samples(sample_size);
    
    //generate_matlab_array(sample_data, sample_size);
    
    ofstream of;
    
    of.open("test.wav", ios_base::out | ios_base::binary);
    cout << sample_size << endl;
    if (of.is_open()) {
        of.write((char*)WAV_HEADER, 44);
        
        for (int i = 0; i < sample_size; i++) {
            
            int test = sample_data[i] - 1024;
            
            of << (unsigned char)((test >> 8) & 0xFF);
            of << (unsigned char)(test & 0xFF);
            
        }
        
        of.seekp(4);
    }
    
    return 0;
}
