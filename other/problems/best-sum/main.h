#ifndef MAIN_005_H

#define MAIN_005_H

#include <iostream>
#include <map>
#include <vector>
#include <list>
#include <vcruntime.h>

using namespace std;

typedef struct {
    bool reset;
    bool kill;
} bestdsum_dp_t;

vector<int> best_sum_dp(int target, vector<int> nums,
    bestdsum_dp_t dp = { true, false });

vector<int> best_sum_dp_memo(int target, vector<int> nums,
    bestdsum_dp_t dp = { true, false });

vector<int> best_sum_dp_tab(int target, vector<int> nums);

#endif
