#define PI_VAL 3.14F

#define SIGNAL_BUFFER_LEN 4e6

#define ADC_REFERENCE_V           3.3F
#define ADC_RESOLUTION            10
#define ADC_SAMPLING_RATE         5000
#define ADC_SAMPLING_DURATION_SEC 10

#define SINE_FREQUENCY_HZ 500
#define SINE_VPP_MV       400
#define SINE_DC_OFFSET_V  1.65F

#include <iostream>
#include <fstream>
#include <cstdint>
#include <cmath>
#include <algorithm>
#include <vector>

#include <pff.h>

using namespace std;

const uint8_t WAV_HEADER[44] = {
    0x52, 0x49, 0x46, 0x46, 0xC4, 0x86, 0x01, 0x00, 0x57, 0x41, 0x56, 0x45,
    0x66, 0x6D, 0x74, 0x20, 0x10, 0x00, 0x00, 0x00, 0x01, 0x00, 0x01, 0x00,
    0x88, 0x13, 0x00, 0x00, 0x10, 0x27, 0x00, 0x00, 0x02, 0x00, 0x10, 0x00,
    0x64, 0x61, 0x74, 0x61, 0xA0, 0x86
};

vector<uint16_t> generate_samples() {
    
    uint32_t samples_total = ADC_SAMPLING_RATE * ADC_SAMPLING_DURATION_SEC;
    uint32_t adc_range     = pow(2, ADC_RESOLUTION);
    double   volts_per_bit = ADC_REFERENCE_V / adc_range;
    
    vector<uint16_t> samples(samples_total, 0);
    
    uint32_t  signal_data_len = ADC_SAMPLING_DURATION_SEC * SIGNAL_BUFFER_LEN;
    uint16_t* signal_data     = new uint16_t[signal_data_len];
    
    uint32_t  period_samples_len = SIGNAL_BUFFER_LEN / SINE_FREQUENCY_HZ;
    uint16_t* period_samples     = new uint16_t[period_samples_len];
    
    double radian_increment = (2 * PI_VAL) / period_samples_len;
    
    uint32_t i, j = 0;
    
    for (float radian = 0; radian < 2 * PI_VAL; radian += radian_increment) {
        period_samples[j++] = min(uint32_t((sin(radian) * ((SINE_VPP_MV / 1e3) / volts_per_bit)) + (SINE_DC_OFFSET_V / volts_per_bit)), adc_range);
    }
    
    j = 0;
    
    for (i = 0; i < signal_data_len; i++) {
        
        signal_data[i] = period_samples[j++];
        
        if (j == period_samples_len) {
            j = 0;
        }
    }
    
    uint32_t sample_increment = SIGNAL_BUFFER_LEN / ADC_SAMPLING_RATE;
    
    for (i = 0, j = 0; i < samples_total; i++, j += sample_increment) {
        samples[i] = signal_data[j];
    }
    
    return samples;
}

vector<uint8_t> generate_wave_binaries(vector<uint16_t>& samples) {
    
    vector<uint8_t> bin(WAV_HEADER, WAV_HEADER + 44);
    
    for (uint32_t i = 0; i < samples.size(); i++) {
        
        int16_t sample = samples[i] - 1024;
        
        bin.push_back((sample >> 8) & 0xFF);
        bin.push_back(sample & 0xFF);
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
    
    uint32_t subchunk_size = samples.size() * 1 * 2;
    
    bin[40] = (subchunk_size & 0xFF);
    bin[41] = ((subchunk_size >> 8) & 0xFF);
    bin[42] = ((subchunk_size >> 16) & 0xFF);
    bin[43] = ((subchunk_size >> 24) & 0xFF);
    
    return bin;
}

void generate_matlab_array(const char* filename, vector<uint16_t>& samples) {
    
    ofstream of(filename, ios_base::out);
    
    if (of.is_open()) {
        
        of << "ARR = [ ";
        
        for (uint16_t i = 0, j = samples.size() - 1; i < samples.size(); i++) {
            
            of << samples[i];
            
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

void generate_wave_file(const char* filename, vector<uint16_t>& samples) {
    
    ofstream of(filename, ios_base::binary | ios_base::out);
    
    if (of.is_open()) {
        
        vector<uint8_t> binary_wave = generate_wave_binaries(samples);
        
        for (auto n : binary_wave) {
            of << n;
        }
        
        cout << "[*] File \"" << filename << "\" has been successfully generated..." << endl;
    }
    else {
        throw runtime_error("[x] Couldn't generate the file...");
    }
}

void write_to_fat_volume(const char* filename, vector<uint16_t>& samples) {
    
    FATFS   fs;
    UINT    bw;
    FRESULT res;
    
    res = pf_mount(&fs);
    if (res != FR_OK) {
        throw runtime_error("[x] Volume not prepared...");
    }
    
    res = pf_open(filename);
    if (res != FR_OK) {
        throw runtime_error("[x] File couldn't be open...");
    }
    
    vector<uint8_t> wav_bin = generate_wave_binaries(samples);
    
    res = pf_lseek(0);
    if (res != FR_OK) {
        throw runtime_error("[x] Write initialization failedd...");
    }
    
    for (int i = 0; i < wav_bin.size(); i += 512) {
        
        res = pf_write((void*)(&wav_bin[0] + i), 512, &bw);
        if (res != FR_OK) {
            throw runtime_error("[x] Write error occured...");
        }
    }
    
    res = pf_write(0, 0, &bw);
    if (res != FR_OK) {
        throw runtime_error("[x] Write finalization error occured...");
    }
    
    cout << "[*] File \"" << filename << "\" has been updated..." << endl;
}

int main() {
    
    vector<uint16_t> samples = generate_samples();
    
    string option;
    
    cout << "1 - Generate MatLab Data" << endl
         << "2 - Generate Wave File" << endl
         << "3 - Write Wave File to FAT12 Image" << endl;
    
    cout << endl << "Option: ";
    cin  >> option;
    cout << endl;
    
    if (option == "1") {
        generate_matlab_array("data.m", samples);
    } else if (option == "2") {
        generate_wave_file("sine.wav", samples);
    } else if (option == "3") {
        write_to_fat_volume("TEST.WAV", samples);
    } else {
        cerr << "[x] Not implemented yet..." << endl;
    }
    
    return 0;
}
