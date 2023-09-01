cmake_minimum_required(VERSION 3.5)

project(win-socket LANGUAGES CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_executable(win-server server.cpp)
add_executable(win-client client.cpp)

install(TARGETS win-server
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})

install(TARGETS win-client
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})

target_link_libraries(win-server PRIVATE wsock32 ws2_32)
target_link_libraries(win-client PRIVATE wsock32 ws2_32)
