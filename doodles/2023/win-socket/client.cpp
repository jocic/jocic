#include <iostream>
#include <winsock2.h>
#include <ws2tcpip.h>

#define SERVER_HOST "localhost"
#define SERVER_PORT "1234"

#define ERR_NONE        0
#define ERR_WSA_STARTUP 1
#define ERR_GET_ADDR    2
#define ERR_SOCKET      3
#define ERR_CONNECT     4
#define ERR_SEND        5
#define ERR_SHUTDOWN    6

using namespace std;

int main(int argc, char *argv[]) {
    
    int i_result = 0;
    
    struct addrinfo* result = NULL;
    
    ///////////////////////////////////
    
    WSADATA wsa_data;
    
    if ((i_result = WSAStartup(MAKEWORD(2, 2), &wsa_data)) != 0) {
        cerr << "[x] WSA startup failed..." << endl;
        return ERR_WSA_STARTUP;
    }
    
    ///////////////////////////////////
    
    struct addrinfo hints;
    
    ZeroMemory(&hints, sizeof(hints));
    
    hints.ai_family   = AF_UNSPEC;
    hints.ai_socktype = SOCK_STREAM;
    hints.ai_protocol = IPPROTO_TCP;
    
    if ((i_result = getaddrinfo(SERVER_HOST, SERVER_PORT, &hints, &result)) != 0) {
        cerr << "[x] Couldn't get an address..." << endl;
        WSACleanup();
        return ERR_GET_ADDR;
    }
    
    ///////////////////////////////////
    
    SOCKET server_socket;
    
    struct addrinfo* next;
    
    for (next = result; next != NULL; next = next->ai_next) {
        
        cout << "[x] Attempting to connect..." << endl;
        
        server_socket = socket(next->ai_family,
            next->ai_socktype, next->ai_protocol);
    
        if (server_socket == INVALID_SOCKET) {
            cerr << "[x] Couldn't get socket: " << WSAGetLastError() << endl;
            freeaddrinfo(result);
            WSACleanup();
            return ERR_SOCKET;
        }
        
        if ((i_result = connect(server_socket,
            next->ai_addr, next->ai_addrlen)) != 0) {
            cerr << "[x] Connection failed..." << endl;
            closesocket(server_socket);
            continue;
        }
        
        break;
    }
    
    freeaddrinfo(result);
    
    if (server_socket == INVALID_SOCKET) {
        cerr << "[x] Couldn't connect to the server..." << endl;
        WSACleanup();
        return ERR_CONNECT;
    }
    
    ///////////////////////////////////
    
    if ((i_result = send( server_socket, "QUIT", 4, 0 )) == SOCKET_ERROR) {
        printf("send failed with error: %d\n", WSAGetLastError());
        closesocket(server_socket);
        WSACleanup();
        return ERR_SEND;
    }
    
    cout << "[*] Bytes sent: " << i_result << endl;
    
    ///////////////////////////////////
    
    if ((i_result = shutdown(server_socket, SD_SEND)) != 0) {
        cerr << "[x] Couldn't close connection:" << WSAGetLastError() << endl;
        closesocket(server_socket);
        WSACleanup();
        return ERR_SHUTDOWN;
    }
    
    ///////////////////////////////////
    
    closesocket(server_socket);
    WSACleanup();
    
    return ERR_NONE;
}
