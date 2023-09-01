#include <iostream>
#include <cstring>
#include <winsock2.h>
#include <ws2tcpip.h>

using namespace std;

#define SERVER_PORT  "1234"
#define CMD_BUFF_LEN 100

#define ERR_NONE        0
#define ERR_WSA_STARTUP 1
#define ERR_GET_ADDR    2
#define ERR_SOCKET      3
#define ERR_BIND        4
#define ERR_LISTEN      5

int main(int argc, char *argv[]) {
    
    int i_result = 0;
    
    struct addrinfo* result = NULL;
    
    ///////////////////////////////////
    
    WSADATA wsa_data;
    
    if ((i_result = WSAStartup(MAKEWORD(2,2), &wsa_data)) != 0) {
        cerr << "[x] WSA startup failed..." << endl;
        return ERR_WSA_STARTUP;
    }
    
    ///////////////////////////////////
    
    struct addrinfo hints;
    
    ZeroMemory(&hints, sizeof(hints));
    
    hints.ai_family   = AF_INET;
    hints.ai_socktype = SOCK_STREAM;
    hints.ai_protocol = IPPROTO_TCP;
    hints.ai_flags    = AI_PASSIVE;
    
    if ((i_result = getaddrinfo(NULL, SERVER_PORT, &hints, &result)) != 0) {
        cerr << "[x] Couldn't get an address..." << endl;
        WSACleanup();
        return ERR_GET_ADDR;
    }
    
    ///////////////////////////////////
    
    SOCKET server_socket = socket(result->ai_family,
        result->ai_socktype, result->ai_protocol);
    
    if (server_socket == INVALID_SOCKET) {
        cerr << "[x] Couldn't create a socket: " << WSAGetLastError() << endl;
        freeaddrinfo(result);
        WSACleanup();
        return ERR_SOCKET;
    }
    
    ///////////////////////////////////
    
    if ((i_result = bind(server_socket,
        result->ai_addr, result->ai_addrlen)) != 0) {
        cerr << "[x] Bind failed: " << WSAGetLastError() << endl;
        freeaddrinfo(result);
        closesocket(server_socket);
        WSACleanup();
        return ERR_BIND;
    }
    
    ///////////////////////////////////
    
    freeaddrinfo(result);
    
    ///////////////////////////////////
    
    if ((i_result = listen(server_socket, SOMAXCONN)) == SOCKET_ERROR) {
        cerr << "[x] Listen failed: " << WSAGetLastError() << endl;
        closesocket(server_socket);
        WSACleanup();
        return ERR_LISTEN;
    }
    
    ///////////////////////////////////
    
    while (true) {
        
        SOCKET client_socket = accept(server_socket, NULL, NULL);
        
        char cmd_buffer[CMD_BUFF_LEN];
        
        do {
            
            i_result = recv(client_socket, cmd_buffer, CMD_BUFF_LEN, 0);
            
            if (strstr(cmd_buffer, "QUIT") == cmd_buffer) {
                cout << "[*] Quitting..." << endl;
                goto end;
            } else {
                cout << "[x] Unknown command..." << endl;
            }
        }
        while (i_result != 0);
        
        closesocket(client_socket);
    }
    
    end:
    
    closesocket(server_socket);
    WSACleanup();
    
    return 0;
}
