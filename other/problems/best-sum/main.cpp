/******************************************************************************\
|* Write a function `bestSum(targetSum, numbers)` that takes in a `targetSum` *|
|* and an array of numbers as arguments.                                      *|
|*                                                                            *|
|* The function should return an array containing the shortest combination of *|
|* numbers that add up to exactly the target sum.                             *|
|*                                                                            *|
|* If there is a tie for the shortest combination, you may return any one of  *|
|* the shortest.                                                              *|
|* -------------------------------------------------------------------------- *|
|* Problem Source: freecodecamp.org                                           *|
\******************************************************************************/

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
vector<int> best_sum_dp(int target, vector<int> nums, bestdsum_dp_t actions) {

    static int root_case;

    vector<int> res, temp;

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
            temp = best_sum_dp(target - nums[i], nums, { false, false });
        } else {
            temp = best_sum_dp(0, nums, { false, true });
        }

        if (res.size() == 0 || res.size() > temp.size()) {
            temp.push_back(nums[i]);

            res = temp;
        }
    }

    return res;//(res.size() != temp.size()) ? temp : res;
}

/**
 * DP implementation with the Memoization pattern.
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
vector<int> best_sum_dp_memo(int target, vector<int> nums, bestdsum_dp_t actions) {

    return {};
}

/**
 * DP implementation with the Tabulation pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int target
 *   Target sum that is being searched for.
 * @param vector<int> nums
 *   Array of numbers that should be checked.
 * @param vector<int> sum
 *   Variable used by the DP algorithm - should be left as is.
 * @return vector<int>
 *   Array of numbers  which sum is equal to the provided target. Empty
 *   array will be provided there is no possible solution.
 */
vector<int> best_sum_dp_tab(int target, vector<int> nums) {

    return {};
}
