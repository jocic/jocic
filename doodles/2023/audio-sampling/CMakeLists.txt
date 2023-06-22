cmake_minimum_required(VERSION 3.5)

project(audio-sampling LANGUAGES CXX)

add_executable(audio-sampling src/main.cpp)

install(TARGETS audio-sampling
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
