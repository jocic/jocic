#include <iostream>
#include <vector>
#include <algorithm>

using namespace std;

void selection_sort(vector<int>& arr) {
    
    for (int i = 0; i < arr.size(); i++) {
        for (int j = i + 1; j < arr.size(); j++) {
            
            if (arr[j] < arr[i]) {
                swap(arr[i], arr[j]);
            }
        }
    }
}

void print_array(vector<int>& arr) {
    
    cout << "ARR = [ ";
    
    for (const auto& n : arr) {
        cout << n << " ";
    }
    
    cout << "]" << endl;
}

int main() {
    
    vector<int> arr = { 4, 1, 3, 9, 6, 4, 2, 1 };
    
    print_array(arr);
    
    selection_sort(arr);
    
    print_array(arr);
    
    return 0;
}
