cmake_minimum_required(VERSION 3.5)

project(fatfs LANGUAGES C CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

include_directories(lib)

add_library(fatfs-lib STATIC
    lib/diskio.h
    lib/ff.h
    lib/ffconf.h
    lib/diskio.c
    lib/ffsystem.c
    lib/ffunicode.c
    lib/ff.c
)

add_executable(fatfs src/main.cpp)

target_link_libraries(fatfs PRIVATE fatfs-lib)

install(TARGETS fatfs
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
