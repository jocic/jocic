cmake_minimum_required(VERSION 3.5)

project(khan-algo LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(khan-algo main.cpp)

install(TARGETS khan-algo
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
