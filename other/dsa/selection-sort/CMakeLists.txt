cmake_minimum_required(VERSION 3.5)

project(selection-sort LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(selection-sort main.cpp)

install(TARGETS selection-sort
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
