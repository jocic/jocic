cmake_minimum_required(VERSION 3.5)

project(int-data-types LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(int-data-types main.cpp)

install(TARGETS int-data-types
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
