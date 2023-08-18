cmake_minimum_required(VERSION 3.14)

project(qt-playback LANGUAGES CXX)

set(CMAKE_INCLUDE_CURRENT_DIR ON)

set(CMAKE_AUTOUIC ON)
set(CMAKE_AUTOMOC ON)
set(CMAKE_AUTORCC ON)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

file(COPY test.wav DESTINATION ${CMAKE_BINARY_DIR})

find_package(QT NAMES Qt6 Qt5 REQUIRED COMPONENTS Core Multimedia)
find_package(Qt${QT_VERSION_MAJOR} REQUIRED COMPONENTS Core Multimedia)

add_executable(qt-playback
  main.cpp
)
target_link_libraries(qt-playback Qt${QT_VERSION_MAJOR}::Core
    Qt${QT_VERSION_MAJOR}::Multimedia)

install(TARGETS qt-playback
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
