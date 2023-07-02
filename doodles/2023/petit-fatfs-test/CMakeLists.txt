cmake_minimum_required(VERSION 3.5)

project(petit-fatfs-test LANGUAGES C)

include_directories(lib)

add_library(lib STATIC

    lib/diskio.h
    lib/pff.h
    lib/pffconf.h

    lib/diskio.c
    lib/pff.c
)

add_executable(petit-fatfs-test
    src/main.c)

target_link_libraries(petit-fatfs-test PRIVATE lib)

install(TARGETS petit-fatfs-test
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
