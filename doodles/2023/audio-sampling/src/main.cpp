#define PI_VAL 3.14F

#define ADC_REFERENCE_V           3.3F
#define ADC_RESOLUTION            10
#define ADC_SAMPLING_RATE         5000
#define ADC_SAMPLING_DURATION_SEC 25

#define SINE_FREQUENCY_HZ 500
#define SINE_VPP_MV       400
#define SINE_DC_OFFSET_V  1.65F

#include <iostream>
#include <fstream>
#include <cstdint>
#include <cmath>
#include <algorithm>
#include <vector>

using namespace std;

const uint8_t WAV_HEADER[44] = {
    0x52, 0x49, 0x46, 0x46, 0xC4, 0x86, 0x01, 0x00, 0x57, 0x41, 0x56, 0x45,
    0x66, 0x6D, 0x74, 0x20, 0x10, 0x00, 0x00, 0x00, 0x01, 0x00, 0x01, 0x00,
    0x88, 0x13, 0x00, 0x00, 0x10, 0x27, 0x00, 0x00, 0x02, 0x00, 0x10, 0x00,
    0x64, 0x61, 0x74, 0x61, 0xA0, 0x86
};

uint16_t* generate_samples(uint16_t& size) {
    
    uint32_t samples_total = ADC_SAMPLING_RATE * ADC_SAMPLING_DURATION_SEC;
    uint32_t adc_range     = pow(2, ADC_RESOLUTION);
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
        period_samples[j++] = min(uint32_t((sin(radian) * ((SINE_VPP_MV / 1e3) / volts_per_bit)) + (SINE_DC_OFFSET_V / volts_per_bit)), adc_range);
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

vector<uint8_t> generate_wave_binaries(uint16_t* data, uint16_t& size) {
    
    vector<uint8_t> bin;
    
    for (int i = 0; i < 44; i++) {
        bin.push_back(WAV_HEADER[i]);
    }
    
    for (uint32_t i = 0; i < size; i++) {
        
        int16_t test = data[i] - 1024;
        
        bin.push_back((test >> 8) & 0xFF);
        bin.push_back(test & 0xFF);
    }
    
    uint32_t rate = ADC_SAMPLING_RATE;
    
    bin[24] = (rate & 0xFF);
    bin[25] = ((rate >> 8) & 0xFF);
    bin[26] = ((rate >> 16) & 0xFF);
    bin[27] = ((rate >> 24) & 0xFF);
    
    uint32_t byte_rate = ADC_SAMPLING_RATE * 1 * 2;
    
    bin[28] = (byte_rate & 0xFF);
    bin[29] = ((byte_rate >> 8) & 0xFF);
    bin[30] = ((byte_rate >> 16) & 0xFF);
    bin[31] = ((byte_rate >> 24) & 0xFF);
    
    uint32_t subchunk_size = size * 1 * 2;
    
    bin[40] = (subchunk_size & 0xFF);
    bin[41] = ((subchunk_size >> 8) & 0xFF);
    bin[42] = ((subchunk_size >> 16) & 0xFF);
    bin[43] = ((subchunk_size >> 24) & 0xFF);
    
    return bin;
}

void generate_matlab_array(const char* filename, uint16_t* data, uint16_t& size) {
    
    ofstream of(filename, ios_base::out);
    
    if (of.is_open()) {
        
        of << "ARR = [ ";
        
        for (uint16_t i = 0, j = size - 1; i < size; i++) {
            
            of << data[i];
            
            if (i != j) {
                of << ", ";
            }
        }
        
        of << " ];" << endl;
        
        cout << "[*] File \"" << filename << "\" has been successfully generated..." << endl;
    }
    else {
        throw runtime_error("[x] Couldn't generate the file...");
    }
}

void generate_wave_file(const char* filename, uint16_t* data, uint16_t& size) {
    
    ofstream of("sine.wav", ios_base::binary | ios_base::out);
    
    if (of.is_open()) {
        
        vector<uint8_t> binary_wave = generate_wave_binaries(data, size);
        
        for (auto n : binary_wave) {
            of << n;
        }
        
        cout << "[*] File \"" << filename << "\" has been successfully generated..." << endl;
    }
    else {
        throw runtime_error("[x] Couldn't generate the file...");
    }
}

int main() {
    
    uint16_t  sample_size;
    uint16_t* sample_data = generate_samples(sample_size);
    
    string option;
    
    cout << "1 - Generate MatLab Data" << endl
         << "2 - Generate Wave File" << endl
         << "3 - Write Wave File to FAT12 Image" << endl;
    
    cout << endl << "Option: ";
    cin  >> option;
    cout << endl;
    
    if (option == "1") {
        generate_matlab_array("data.m", sample_data, sample_size);
    } else if (option == "2") {
        generate_wave_file("sine.wav", sample_data, sample_size);
    } else {
        cerr << "[x] Not implemented yet..." << endl;
    }
    
    return 0;
}
