#define FRAMES_PER_BUFFER 512

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
    
    char     format[4];
    uint16_t channel_count;
    uint32_t sample_rate;
    uint16_t bits_per_sample;
    uint32_t subchunk2_size;
    
    ifstream fs(filename, ios_base::in | ios_base::binary);
    
    if (fs.is_open()) {
        
        fs.seekg(8);
        fs.read(format, 4);
        
        if (string(format, format + 4) != "WAVE") {
            throw runtime_error("Specifie file isn't a WAVE file...");
        }
        
        fs.seekg(22);
        fs.read((char*)&channel_count, 2);
        
        fs.seekg(24);
        fs.read((char*)&sample_rate, 4);
        
        fs.seekg(34);
        fs.read((char*)&bits_per_sample, 4);
        
        fs.seekg(40);
        fs.read((char*)&subchunk2_size, 4);
        
        samples.resize(subchunk2_size / (channel_count * bits_per_sample / 8));
        
        fs.seekg(44);
        fs.read((char*)&samples.at(0), subchunk2_size);
        
    } else {
        throw runtime_error("Couldn't open the specified WAV file...");
    }
    
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
        
        pair<vector<uint32_t>, PaSampleFormat> playback_data =
            *((pair<vector<uint32_t>, PaSampleFormat>*)user_data);
        
        vector<uint32_t>& samples = playback_data.first;
        PaSampleFormat&   format  = playback_data.second;
        
        if (format == paInt32) {
            
            int32_t* wptr = (int32_t*)output;
            
            for (const auto& sample : samples) {
                *wptr++ = sample & 0xFFFFFFFF;
            }
        }
        else if (format == paInt16) {
            
            int16_t* wptr = (int16_t*)output;
            
            for (const auto& sample : samples) {
                *wptr++ = (sample >> 16)  & 0xFFFF;
                *wptr++ = (sample >> 0 )  & 0xFFFF;
            }
        }
        else {
            
            int8_t* wptr = (int8_t*)output;
            
            for (const auto& sample : samples) {
                *wptr++ = (sample >> 24) & 0xFF;
                *wptr++ = (sample >> 16) & 0xFF;
                *wptr++ = (sample >> 8 ) & 0xFF;
                *wptr++ = (sample >> 0 ) & 0xFF;
            }
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
    
    uint8_t size_modifier = 32 / bits_per_sample;
    
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
    
    pair<vector<uint32_t>, PaSampleFormat> playback_data = {
        samples, device_params.sampleFormat
    };
    
    err = Pa_OpenStream(&device_stream, NULL, &device_params, sample_rate * 1.75F, samples.size() * size_modifier, paNoFlag, playback_fn, &playback_data);
    if (err != paNoError) {
        throw runtime_error("Couldn't open the stream...");
    }
    
    cout << "Initiating playback..." << endl;
    
    err = Pa_StartStream(device_stream);
    if (err != paNoError) {
        throw runtime_error("Couln't start the stream...");
    }
    
    while (Pa_IsStreamActive(device_stream)) {
        Pa_Sleep(100);
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

int main() {
    
    play_wav_file("test.wav");
    
    return 0;
}
