#include <stdio.h>
#include <stdlib.h>

#define QUEUE_SIZE 5

int* queue_buffer;
int  queue_head, queue_tail;
int  queue_capacity;

void queue_init() {
    
    queue_buffer = (int*)calloc(QUEUE_SIZE, sizeof(int));
    
    queue_head = queue_tail = queue_capacity = 0;
}

void queue_push(int val) {
    
    if (queue_capacity == QUEUE_SIZE) {
        return;
    }
    
    if (queue_tail == QUEUE_SIZE) {
        queue_tail = 0;
    }
    
    queue_buffer[queue_tail] = val;
    
    queue_tail++;
    queue_capacity++;
}

void queue_pop() {
    
    if (queue_capacity == 0) {
        return;
    }
    
    queue_head++;
    queue_capacity--;
    
    if (queue_head == QUEUE_SIZE) {
        queue_head = 0;
    }
}

int queue_top() {
    
    if (queue_capacity == 0) {
        return -1;
    }
    
    return queue_buffer[queue_head];
}

int main()
{
    queue_init();
    
    queue_push(1);
    queue_push(2);
    queue_push(3);
    queue_push(4);
    queue_push(5);
    
    queue_pop();
    queue_pop();
    queue_pop();
    queue_pop();
    
    queue_push(6);
    queue_push(7);
    queue_push(8);
    queue_push(9);
    
    queue_pop();
    queue_pop();
    queue_pop();
    queue_pop();
    
    queue_push(10);
    queue_push(11);
    queue_push(12);
    queue_push(13);
    queue_push(13);
    queue_push(13);
    
    while (queue_capacity > 0) {
        printf("TOP: %d\n", queue_top());
        queue_pop();
    }
    
    return 0;
}
