#include <iostream>
#include <cstdint>
#include <cstdlib>
#include <vector>
#include <fstream>
#include <algorithm>
#include <cmath>
#include <numeric>

using namespace std;

const uint8_t WAV_HEADER[44] = {
    0x52, 0x49, 0x46, 0x46, 0xC4, 0x86, 0x01, 0x00, 0x57, 0x41, 0x56, 0x45,
    0x66, 0x6D, 0x74, 0x20, 0x10, 0x00, 0x00, 0x00, 0x01, 0x00, 0x01, 0x00,
    0x88, 0x13, 0x00, 0x00, 0x10, 0x27, 0x00, 0x00, 0x02, 0x00, 0x10, 0x00,
    0x64, 0x61, 0x74, 0x61, 0xA0, 0x86
};   

int main() {
    
    vector<int16_t> samples;
    
    int16_t sample;
    uint8_t in_buffer[255];
    
    ifstream dump("putty.log", ios_base::in | ios_base::binary);
    
    if (!dump.is_open()) {
        throw runtime_error("Couldn't open the specified file...");
    }
    
    while (!dump.eof()) {
        dump.read((char*)&sample, 2);
        samples.push_back(sample);
    }
    
    int dc_bias = accumulate(samples.begin(), samples.end(), 0) / samples.size();
    
    for (auto& sample : samples) {
        sample -= dc_bias;
    }
    
    int min_val = *min_element(samples.begin(), samples.end());
    int max_val = *max_element(samples.begin(), samples.end());
    
    int auto_gain = pow(2, 16) / (abs(min_val) + abs(max_val));
    
    for (auto& sample : samples) {
        sample *= (auto_gain * 0.8F);
    }
    
    dump.close();
    
    uint8_t  out_buffer[4];
    uint8_t  channel_count;
    uint32_t sample_rate;
    uint16_t bits_per_sample;
    uint32_t byte_rate;
    uint32_t subchunk2_size;
    uint32_t chunk_size;
    
    ofstream wav("reconstruction.wav", ios_base::out | ios_base::binary);
    
    if (!wav.is_open()) {
        throw runtime_error("Couldn't create the specified file...");
    }
    
    wav.write((char*)WAV_HEADER, 44);
    wav.write((char*)&samples.at(0), samples.size() * 2);
    
    wav.seekp(22);
    
    channel_count = 1;
    out_buffer[0] = (channel_count >> 0 ) & 0xFF;
    out_buffer[1] = (channel_count >> 8 ) & 0xFF;
    out_buffer[2] = (channel_count >> 16) & 0xFF;
    out_buffer[3] = (channel_count >> 24) & 0xFF;
    wav.write((char*)out_buffer, 2);
    
    wav.seekp(24);
    
    sample_rate = uint32_t(12500);
    out_buffer[0] = (sample_rate >> 0 ) & 0xFF;
    out_buffer[1] = (sample_rate >> 8 ) & 0xFF;
    out_buffer[2] = (sample_rate >> 16) & 0xFF;
    out_buffer[3] = (sample_rate >> 24) & 0xFF;
    wav.write((char*)out_buffer, 4);
    
    wav.seekp(34);
    
    bits_per_sample = 16;
    out_buffer[0] = (bits_per_sample >> 0 ) & 0xFF;
    out_buffer[1] = (bits_per_sample >> 8 ) & 0xFF;
    out_buffer[2] = (bits_per_sample >> 16) & 0xFF;
    out_buffer[3] = (bits_per_sample >> 24) & 0xFF;
    wav.write((char*)out_buffer, 2);
    
    wav.seekp(28);
    
    byte_rate = sample_rate * channel_count * (bits_per_sample / 8);
    out_buffer[0] = (byte_rate >> 0 ) & 0xFF;
    out_buffer[1] = (byte_rate >> 8 ) & 0xFF;
    out_buffer[2] = (byte_rate >> 16) & 0xFF;
    out_buffer[3] = (byte_rate >> 24) & 0xFF;
    wav.write((char*)out_buffer, 4);
    
    wav.seekp(40);
    
    subchunk2_size = samples.size() * channel_count * (bits_per_sample / 8);
    out_buffer[0] = (subchunk2_size >> 0 ) & 0xFF;
    out_buffer[1] = (subchunk2_size >> 8 ) & 0xFF;
    out_buffer[2] = (subchunk2_size >> 16) & 0xFF;
    out_buffer[3] = (subchunk2_size >> 24) & 0xFF;
    wav.write((char*)out_buffer, 4);
    
    wav.seekp(4);
    
    chunk_size = 36 + subchunk2_size;
    out_buffer[0] = (chunk_size >> 0 ) & 0xFF;
    out_buffer[1] = (chunk_size >> 8 ) & 0xFF;
    out_buffer[2] = (chunk_size >> 16) & 0xFF;
    out_buffer[3] = (chunk_size >> 24) & 0xFF;
    wav.write((char*)out_buffer, 4);
    
    wav.close();
    
    return 0;
}
