cmake_minimum_required(VERSION 3.5)

project(adc-to-wav LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(adc-to-wav main.cpp)

install(TARGETS adc-to-wav
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
