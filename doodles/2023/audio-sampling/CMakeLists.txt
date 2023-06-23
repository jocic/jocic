cmake_minimum_required(VERSION 3.5)

project(audio-sampling LANGUAGES C CXX)

include_directories(lib/petit-fatfs)

add_library(petit-fatfs STATIC
    lib/petit-fatfs/pffconf.h
    lib/petit-fatfs/diskio.h
    lib/petit-fatfs/pff.h
    lib/petit-fatfs/diskio.c
    lib/petit-fatfs/pff.c
)

add_executable(audio-sampling src/main.cpp)

target_link_libraries(audio-sampling PRIVATE petit-fatfs)

install(TARGETS audio-sampling
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
