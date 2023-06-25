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
        
        if (channel_count > 1) {
            throw runtime_error("Two channel WAVE files aren't supported...");
        }
        
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
        
        fs.close();
        
        duration_sec = float(sample_count) / sample_rate;
        
    } else {
        throw runtime_error("Couldn't open the specified WAV file...");
    }
    
    cout << "Number of Channels: " << channel_count << endl
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
        
        static bool initiated = false;
        
        int32_t* wptr = (int32_t*)output;
        
        vector<uint32_t> samples = *((vector<uint32_t>*)user_data);
        
        for (const auto& sample : samples) {
            *wptr++ = sample;
        }
        
        if (initiated) { // Windows Workaround
            return paComplete;
        }
        
        initiated = true;
        
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
        sample_count, paClipOff, playback_fn, &samples);
    
    if (err != paNoError) {
        throw runtime_error("Couldn't open the stream...");
    }
    
    cout << "[*] Initiating playback..." << endl;
    
    err = Pa_StartStream(device_stream);
    if (err != paNoError) {
        throw runtime_error("Couln't start the stream...");
    }
    
    while (Pa_IsStreamActive(device_stream)) {
        Pa_Sleep(100);
    }
    
    cout << "[*] Stopping playback..." << endl;
    
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
    
    typedef struct {
        vector<int16_t> buffer;
        size_t          length;
        size_t          pointer;
    } AUDIO_DATA;
    
    const uint8_t WAV_HEADER[44] = {
        0x52, 0x49, 0x46, 0x46, 0xC4, 0x86, 0x01, 0x00, 0x57, 0x41, 0x56, 0x45,
        0x66, 0x6D, 0x74, 0x20, 0x10, 0x00, 0x00, 0x00, 0x01, 0x00, 0x01, 0x00,
        0x88, 0x13, 0x00, 0x00, 0x10, 0x27, 0x00, 0x00, 0x02, 0x00, 0x10, 0x00,
        0x64, 0x61, 0x74, 0x61, 0xA0, 0x86
    };    
    
    PaError            err;
    PaDeviceIndex      device_index;
    PaDeviceInfo*      device_info;
    PaStream*          device_stream;
    PaStreamParameters stream_params;
    
    AUDIO_DATA samples;
    
    err = Pa_Initialize();
    if (err != paNoError) {
        throw runtime_error("Initialization failed...");
    }
    
    device_index = Pa_GetDefaultInputDevice();
    if (device_index == paNoDevice) {
        throw runtime_error("Input device not found...");
    }
    
    device_info = (PaDeviceInfo*)Pa_GetDeviceInfo(device_index);
    if (device_info == NULL) {
        throw runtime_error("Device info unavailable...");
    }
    
    auto recoring_fn = [](
        const void *input, void *output,
        unsigned long frame_count,
        const PaStreamCallbackTimeInfo* time_info,
        PaStreamCallbackFlags status_flags,
        void *user_data) -> PaError {
        
        static bool init = false;
        
        AUDIO_DATA* data = (AUDIO_DATA*)user_data;
        
        int16_t* iptr = (int16_t*)input;
        
        while (data->pointer++ < data->length) {
            int16_t sample = *iptr++;
            data->buffer.push_back(sample);
        }
        
        return paComplete;
    };
    
    cout << "Device Name: " << device_info->name << endl
         << "Sample Rate " << device_info->defaultSampleRate << endl
         << "Max Input Channels: " << device_info->maxInputChannels << endl;
    
    samples.length  = device_info->defaultSampleRate * duration;
    samples.pointer = 0;
    
    stream_params.device                    = device_index;
    stream_params.channelCount              = 1;
    stream_params.sampleFormat              = paInt16;
    stream_params.suggestedLatency          = device_info->defaultLowInputLatency;
    stream_params.hostApiSpecificStreamInfo = NULL;
    
    err = Pa_OpenStream(&device_stream, &stream_params, NULL,
        device_info->defaultSampleRate, samples.length,
        paNoFlag, recoring_fn, &samples);
    
    if (err != paNoError) {
        throw runtime_error("Couln't open stream...");
    }
    
    cout << "[*] Starting to record..." << endl;
    
    err = Pa_StartStream(device_stream);
    if (err != paNoError) {
        throw runtime_error("Coulnd't start stream...");
    }
    
    while (Pa_IsStreamActive(device_stream)) {
        Pa_Sleep(100);
    }
    
    cout << "[*] Stopping to record..." << endl;
    
    err = Pa_CloseStream(device_stream);
    if (err != paNoError) {
        throw runtime_error("Couldn't close stream...");
    }
    
    err = Pa_Terminate();
    if (err != paNoError) {
        throw runtime_error("Termination failed...");
    }
    
    uint8_t  buffer[4];
    uint8_t  channel_count;
    uint32_t sample_rate;
    uint16_t bits_per_sample;
    uint32_t byte_rate;
    uint32_t subchunk2_size;
    uint32_t chunk_size;
    
    ofstream of(filename, ios_base::binary | ios_base::out);
    if (!of.is_open()) {
        throw runtime_error("Couldn't open a file...");
    }
    
    of.write((char*)WAV_HEADER, 44);
    
    of.seekp(22);
    
    channel_count = 1;
    buffer[0] = (channel_count >> 0 ) & 0xFF;
    buffer[1] = (channel_count >> 8 ) & 0xFF;
    buffer[2] = (channel_count >> 16) & 0xFF;
    buffer[3] = (channel_count >> 24) & 0xFF;
    of.write((char*)buffer, 2);
    
    of.seekp(24);
    
    sample_rate = uint32_t(device_info->defaultSampleRate);
    buffer[0] = (sample_rate >> 0 ) & 0xFF;
    buffer[1] = (sample_rate >> 8 ) & 0xFF;
    buffer[2] = (sample_rate >> 16) & 0xFF;
    buffer[3] = (sample_rate >> 24) & 0xFF;
    of.write((char*)buffer, 4);
    
    of.seekp(34);
    
    bits_per_sample = 16;
    buffer[0] = (bits_per_sample >> 0 ) & 0xFF;
    buffer[1] = (bits_per_sample >> 8 ) & 0xFF;
    buffer[2] = (bits_per_sample >> 16) & 0xFF;
    buffer[3] = (bits_per_sample >> 24) & 0xFF;
    of.write((char*)buffer, 2);
    
    of.seekp(28);
    
    byte_rate = sample_rate * channel_count * (bits_per_sample / 8);
    buffer[0] = (byte_rate >> 0 ) & 0xFF;
    buffer[1] = (byte_rate >> 8 ) & 0xFF;
    buffer[2] = (byte_rate >> 16) & 0xFF;
    buffer[3] = (byte_rate >> 24) & 0xFF;
    of.write((char*)buffer, 4);
    
    of.seekp(40);
    
    subchunk2_size = samples.length * channel_count * (bits_per_sample / 8);
    buffer[0] = (subchunk2_size >> 0 ) & 0xFF;
    buffer[1] = (subchunk2_size >> 8 ) & 0xFF;
    buffer[2] = (subchunk2_size >> 16) & 0xFF;
    buffer[3] = (subchunk2_size >> 24) & 0xFF;
    of.write((char*)buffer, 4);
    
    of.seekp(4);
    
    chunk_size = 36 + subchunk2_size;
    buffer[0] = (chunk_size >> 0 ) & 0xFF;
    buffer[1] = (chunk_size >> 8 ) & 0xFF;
    buffer[2] = (chunk_size >> 16) & 0xFF;
    buffer[3] = (chunk_size >> 24) & 0xFF;
    of.write((char*)buffer, 4);
    
    of.seekp(44);
    of.write((char*)&samples.buffer.at(0), samples.buffer.size() * 2);
    
    of.close();
    
    cout << "[*] File \"" << filename << "\" generated..." << endl;
}

int main() {
    
    string option;
    
    cout << "1 - Play WAV File" << endl
         << "2 - Record WAV File" << endl;
    
    cout << endl << "Option: ";
    cin  >> option;
    
    if (option == "1") {
        play_wav_file("test.wav");
    } else if (option == "2") {
        record_wav_file("test.wav", 10);
    } else {
        cerr << "[x] Invalid option selected..." << endl;
    }
    
    return 0;
}
