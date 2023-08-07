cmake_minimum_required(VERSION 3.5)

project(cpp-singleton LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(cpp-singleton singleton.h singleton.cpp main.cpp)

install(TARGETS cpp-singleton
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
