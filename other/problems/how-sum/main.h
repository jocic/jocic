#ifndef HOW_SUM_H

#define HOW_SUM_H

#include <iostream>
#include <map>
#include <vector>
#include <cstdint>
#include <vcruntime.h>

using namespace std;

typedef struct {
    bool reset;
    bool kill;
} howsum_dp_t;

vector<int> how_sum_dp(int target, vector<int> nums,
    howsum_dp_t dp = { true, false });

vector<int> how_sum_dp_memo(int target, vector<int> nums,
    howsum_dp_t dp = { true, false });

vector<int> how_sum_dp_tab(int target, vector<int> nums);

#endif
