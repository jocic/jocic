/********************************************************************************\
|* Write a function `howSum(targetSum, numbers)` that takes in a `targetSum`    *|
|* and an array of numbers as arguments. The function should return an array    *|
|* containing any combination of elements that add up to exactly the targetSum. *|
|*                                                                              *|
|* If there is no combination that adds up to the targetSum, then return an     *|
|* empty array of elements.                                                     *|
|*                                                                              *|
|* If there are multiple combinations possible, you may return any single one.  *|
|* ---------------------------------------------------------------------------- *|
|* Problem Source: freecodecamp.org                                             *|
\********************************************************************************/

#include "main.h"

/**
 * Generic Dynamic Programming implementation.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int target
 *   Target sum that is being searched for.
 * @param vector<int> nums
 *   Array of numbers that should be checked.
 * @param howsum_dp_t actions
 *   Optional parameter used in DP logic for controlling recursive flow.
 * @return vector<int>
 *   Array of numbers  which sum is equal to the provided target. Empty
 *   array will be provided there is no possible solution.
 */
vector<int> how_sum_dp(int target, vector<int> nums, howsum_dp_t actions) {

    static int root_case;

    vector<int> res;

    if (actions.reset) {
        root_case = target;
    }

    if (target == INT_MAX) {
        throw std::invalid_argument("[x] No no no, you flew too high...");
    }

    if (target == 0) {
        return actions.kill ? vector<int>{ INT_MAX } : vector<int>{};
    }

    for (size_t i = 0; i < nums.size(); i++) {

        if (target >= nums[i]) {
            res = how_sum_dp(target - nums[i], nums, { false, false });
        } else {
            res = how_sum_dp(0, nums, { false, true });
        }

        if (res.size() == 0 || res[0] != INT_MAX) {

            res.push_back(nums[i]);

            return res;
        }
    }

    if (target == root_case && res.size() > 0 && res[0] == INT_MAX) {
        res.clear();
    }

    return res;
}

/**
 * DP implementation optimized with the Memoization pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int target
 *   Target sum that is being searched for.
 * @param vector<int> nums
 *   Array of numbers that should be checked.
 * @param howsum_dp_t actions
 *   Optional parameter used in DP logic for controlling recursive flow.
 * @return vector<int>
 *   Array of numbers  which sum is equal to the provided target. Empty
 *   array will be provided there is no possible solution.
 */
vector<int> how_sum_dp_memo(int target, vector<int> nums, howsum_dp_t actions) {

    static map<int, vector<int>> memo;

    static int root_case;

    vector<int> res;

    if (actions.reset) {

        root_case = target;

        memo.clear();
    }

    if (target == INT_MAX) {
        throw std::invalid_argument("[x] No no no, you flew too high...");
    }

    auto search = memo.find(target);

    if (search != memo.end()) {
        return search->second;
    }

    if (target == 0) {
        return actions.kill ? vector<int>{ INT_MAX } : vector<int>{};
    }

    for (size_t i = 0; i < nums.size(); i++) {

        if (target >= nums[i]) {
            res = how_sum_dp_memo(target - nums[i], nums, { false, false });
        } else {
            res = how_sum_dp_memo(0, nums, { false, true });
        }

        if (res.size() == 0 || res[0] != INT_MAX) {

            res.push_back(nums[i]);

            return res;
        }
    }

    if (target == root_case && res.size() > 0 && res[0] == INT_MAX) {
        res.clear();
    }

    memo.insert_or_assign(target, res);

    return res;
}

/**
 * DP implementation optimized with the Tabulation pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int target
 *   Target sum that is being searched for.
 * @param vector<int> nums
 *   Array of numbers that should be checked.
 * @return vector<int>
 *   Array of numbers  which sum is equal to the provided target. Empty
 *   array will be provided there is no possible solution.
 */
vector<int> how_sum_dp_tab(int target, vector<int> nums) {

    size_t tab_len = target + 1;

    vector<int>* tab = new vector<int>[tab_len + 1];

    int i, j;

    int curr_num, next_num;

    // Seed Tab

    tab[0].push_back(0);

    for (i = 0; i < nums.size(); i++) {

        curr_num = nums[i];

        tab[curr_num].push_back(curr_num);
    }

    // Process Tab

    for (i = 1; i < tab_len; i++) {

        if (tab[i].size() > 0) {

            for (j = 0; j < nums.size(); j++) {

                curr_num = nums[j];
                next_num = i + curr_num;

                if (next_num < tab_len && tab[next_num].empty()) {
                    tab[next_num] = tab[i];
                    tab[next_num].push_back(curr_num);
                }

                if (next_num == target) {
                    break;
                }
            }
        }
    }

    return tab[target];
}
