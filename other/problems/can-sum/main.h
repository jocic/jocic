#ifndef CAN_SUM_H

#define CAN_SUM_H

#include <iostream>
#include <map>
#include <vector>
#include <vcruntime.h>

using namespace std;

bool can_sum_dp(int target, vector<int> nums);
bool can_sum_dp_memo(int target, vector<int> nums, bool clear = true);
bool can_sum_dp_tab(int target, vector<int> nums);

#endif
