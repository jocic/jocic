#define PI_VAL 3.14F

#define ADC_REFERENCE_V           3.3F
#define ADC_RESOLUTION            10
#define ADC_SAMPLING_RATE         5000
#define ADC_SAMPLING_DURATION_SEC 10

#define SINE_FREQUENCY_HZ 500
#define SINE_VPP_MV       200
#define SINE_DC_OFFSET_V  1.65F

#include <iostream>
#include <cstdint>
#include <cmath>
#include <algorithm>

using namespace std;

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
    
    uint16_t  sample_size = 100;
    uint16_t* sample_data = generate_samples(sample_size);
    
    generate_matlab_array(sample_data, sample_size);
    
    return 0;
}
