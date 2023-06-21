cmake_minimum_required(VERSION 3.5)

project(petit-fatfs LANGUAGES C)

include_directories(lib)

add_library(lib STATIC

    lib/diskio.h
    lib/pff.h
    lib/pffconf.h

    lib/diskio.c
    lib/pff.c
)

add_executable(petit-fatfs
    src/main.c)

target_link_libraries(petit-fatfs PRIVATE lib)

install(TARGETS petit-fatfs
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
