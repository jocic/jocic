#include <iostream>
#include <vector>

using namespace std;

int kaden(vector<int>& arr) {
    
    int global_max = INT_MIN;
    int local_max  = 0;
    
    for (const auto& n : arr) {
        
        local_max += n;
        
        if (local_max > global_max) {
            global_max = local_max;
        }
        
        if (local_max < 0) {
            local_max = 0;
        }
    }
    
    return global_max;
}

int main() {
    
    vector<int> input = { -2, -3, 4, -1, -2, 1, 5, -3 };
    
    cout << "RES: " << kaden(input) << endl;
    
    return 0;
}
