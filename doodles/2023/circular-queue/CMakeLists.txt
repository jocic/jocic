cmake_minimum_required(VERSION 3.5)

project(circular-queue LANGUAGES C)

add_executable(circular-queue main.c)

install(TARGETS circular-queue
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
