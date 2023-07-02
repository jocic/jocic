cmake_minimum_required(VERSION 3.5)

project(fatfs-test LANGUAGES C CXX)

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

add_executable(fatfs-test src/main.cpp)

target_link_libraries(fatfs-test PRIVATE fatfs-lib)

install(TARGETS fatfs-test
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
