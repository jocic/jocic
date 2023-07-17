#include <iostream>
#include <vector>
#include <algorithm>

using namespace std;

void print_arr(vector<int>& arr) {
    
    for (const auto& n : arr) {
        cout << n << " ";
    }
    
    cout << endl;
}

void quick_sort(vector<int>& arr, int left = -1, int right = -1) {
    
    if (left  == -1) { left = 0; }
    if (right == -1) { right = arr.size(); }
    
    if (left >= right) { return; }
    
    int i, j,  p = right - 1;
    
    for (i = left, j = 0; i < right; i++) {
        if (arr[i] < arr[p]) {
            swap(arr[i], arr[j++]);
        }
    }
    
    swap(arr[j], arr[p]);
    
    quick_sort(arr, left, p);
    quick_sort(arr, p + 1, right);
}

int main() {
    
    vector<int> arr = { 5, 3, 1, 8, 4, 4, 12, 15, 0, 2, 8 };
    
    quick_sort(arr);
    print_arr(arr);
    
    return 0;
}
