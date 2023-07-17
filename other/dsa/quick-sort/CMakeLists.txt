cmake_minimum_required(VERSION 3.5)

project(quick-sort LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(quick-sort main.cpp)

install(TARGETS quick-sort
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
