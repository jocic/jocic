cmake_minimum_required(VERSION 3.5)

project(microphone-access LANGUAGES C CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_subdirectory(lib/portaudio)

add_executable(microphone-access src/main.cpp)

target_link_libraries(microphone-access PRIVATE portaudio)

file(COPY assets/test.wav  DESTINATION ${CMAKE_BINARY_DIR})

install(TARGETS microphone-access
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})
