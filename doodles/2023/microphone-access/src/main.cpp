#include <iostream>
#include <fstream>
#include <cstdint>
#include <cstdlib>
#include <vector>
#include <utility>
#include <portaudio.h>

using namespace std;

void play_wav_file(const char* filename) {
    
    vector<uint32_t> samples;
    
    uint8_t  buffer[4];
    char     format[4];
    uint16_t channel_count;
    uint32_t sample_rate;
    uint16_t bits_per_sample;
    uint32_t subchunk2_size;
    uint32_t sample_count;
    float    duration_sec;
    
    ifstream fs(filename, ios_base::in | ios_base::binary);
    
    if (fs.is_open()) {
        
        fs.seekg(8);
        fs.read(format, 4);
        
        if (string(format, format + 4) != "WAVE") {
            throw runtime_error("Specifie file isn't a WAVE file...");
        }
        
        channel_count = 0;
        fs.seekg(22);
        fs.read((char*)&channel_count, 2);
        
        sample_rate = 0;
        fs.seekg(24);
        fs.read((char*)&sample_rate, 4);
        
        bits_per_sample = 0;
        fs.seekg(34);
        fs.read((char*)&bits_per_sample, 2);
        
        subchunk2_size = 0;
        fs.seekg(40);
        fs.read((char*)&subchunk2_size, 4);
        
        sample_count = subchunk2_size / (channel_count * bits_per_sample / 8);
        
        samples.resize(sample_count / (32 / bits_per_sample));
        
        fs.seekg(44);
        fs.read((char*)&samples.at(0), subchunk2_size);
        
        duration_sec = float(sample_count) / sample_rate;
        
    } else {
        throw runtime_error("Couldn't open the specified WAV file...");
    }
    
    cout << "Wave File Details: " << endl
         << "Number of Channels: " << channel_count << endl
         << "Sample Rate: " << sample_rate << endl
         << "Total Samples: " << sample_count << endl
         << "Bits per Sample: " << bits_per_sample << endl
         << "Subchunk2 Size: " << subchunk2_size << endl
         << "Duration: " << duration_sec << endl;
    
    PaError             err;
    PaDeviceIndex       device_index;
    PaDeviceInfo*       device_info;
    PaStream*           device_stream;
    PaStreamParameters  device_params;
    
    auto playback_fn = [](const void *input, void *output,
            unsigned long frame_count,
            const PaStreamCallbackTimeInfo* time_info,
            PaStreamCallbackFlags status_flags,
            void *user_data) -> PaError {
        
        vector<uint32_t> samples = *((vector<uint32_t>*)user_data);
        
        int32_t* wptr = (int32_t*)output;
        
        for (const auto& sample : samples) {
            *wptr++ = (sample & 0xFFFF);
        }
        
        return paContinue;
    };
    
    err = Pa_Initialize();
    if (err != paNoError) {
        throw runtime_error("Initialization error...");
    }
    
    device_index = Pa_GetDefaultOutputDevice();
    if (device_index == paNoDevice) {
        throw runtime_error("No output device found...");
    }
    
    device_info = (PaDeviceInfo*)Pa_GetDeviceInfo(device_index);
    if (device_info == NULL) {
        throw runtime_error("Device infor couldn't be fetched...");
    }
    
    if (bits_per_sample == 8) {
        device_params.sampleFormat = paInt8;
    } else if (bits_per_sample == 16) {
        device_params.sampleFormat = paInt16;
    } else {
        device_params.sampleFormat = paInt32;
    }
    
    device_params.device                    = device_index;
    device_params.channelCount              = channel_count;
    device_params.suggestedLatency          = device_info->defaultLowOutputLatency;
    device_params.hostApiSpecificStreamInfo = NULL;
    
    err = Pa_OpenStream(&device_stream, NULL, &device_params, sample_rate,
        sample_count, paNoFlag, playback_fn, &samples);
    
    if (err != paNoError) {
        throw runtime_error("Couldn't open the stream...");
    }
    
    cout << "Initiating playback..." << endl;
    
    err = Pa_StartStream(device_stream);
    if (err != paNoError) {
        throw runtime_error("Couln't start the stream...");
    }
    
    while (Pa_IsStreamActive(device_stream)) {
        Pa_Sleep(1000);
    }
    
    cout << "Stopping playback..." << endl;
    
    err = Pa_CloseStream(device_stream);
    if (err != paNoError) {
        throw runtime_error("Couldn't stop the stream...");
    }
    
    err = Pa_Terminate();
    if (err != paNoError) {
        throw runtime_error("Termination error...");
    }
}

void record_wav_file(const char* filename, uint32_t duration) {
    
}

int main() {
    
    play_wav_file("test.wav");
    
    record_wav_file("recording.wav", 15);
    
    return 0;
}
