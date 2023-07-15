#include <iostream>
#include <vector>

using namespace std;

void print_arr(vector<int>& arr) {
    
    for (const auto& n : arr) {
        cout << n << " ";
    }
    
    cout << endl;
}

vector<int> merge_arr(vector<int> left, vector<int> right) {
    
    if (right.size() == 0) {
        return left;
    }
    
    if (left.size() == 0) {
        return right;
    }
    
    vector<int> res;
    
    int i = 0, j = 0;
    
    while (i < left.size() || j < right.size()) {
        
        if (i == left.size()) {
            res.push_back(right[j++]);
            continue;
        }
        
        if (j == right.size()) {
            res.push_back(left[i++]);
            continue;
        }
        
        if (left[i] <= right[j]) {
            res.push_back(left[i++]);
            continue;
        }
        
        if (right[j] < left[i]) {
            res.push_back(right[j++]);
            continue;
        }
    }
    
    return res;
}

vector<int> merge_sort(vector<int> arr) {
    
    if (arr.size() <= 1) {
        return arr;
    }
    
    int mid = arr.size() / 2;
    
    vector<int> left  = merge_sort(vector<int>(arr.begin(), arr.begin() + mid));
    vector<int> right = merge_sort(vector<int>(arr.begin() + mid, arr.end()));
    
    return merge_arr(left, right);
}

int main() {
    
    vector<int> arr = {
        4, 1, 0, -4, 10, 5, 4, 100, 20, 13, 5, 8, 9
    };
    
    vector<int> arr_sorted = merge_sort(arr);
    
    print_arr(arr);
    print_arr(arr_sorted);
    
    return 0;
}
