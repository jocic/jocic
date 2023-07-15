/******************************************************\
|* Problem: Write a function `fib(n)` that takes in a *|
|* number as an argument. The function should return  *|
|* the n-th number of the Fibonacci sequence.         *|
|* -------------------------------------------------- *|
|* Problem Source: freecodecamp.org                   *|
\******************************************************/

#include "main.h"

using namespace std;

/**
 * Generic Dynamic Programming implementation.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int n
 *   N-th number of element in the Fibonacci sequence
 *   that the function should return.
 * @return int
 *   Value of the N-th element in the Fibonacci sequence.
 */
int fib_dp(int n) {

    if (n <= 2) {
        return 1;
    }

    return fib_dp(n - 1) + fib_dp(n - 2);
}

/**
 * DP implementation optimized with the Memoization pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int n
 *   N-th number of element in the Fibonacci sequence
 *   that the function should return.
 * @return int
 *   Value of the N-th element in the Fibonacci sequence.
 */
int fib_dp_memo(int n) {

    static map<int, int> m = {};

    auto search = m.find(n);

    if (search != m.end()) {
        return search->second;
    }

    if (n <= 2) {
        return 1;
    }

    int result = fib_dp_memo(n - 1) + fib_dp_memo(n - 2);

    m.insert({ n, result });

    return result;
}

/**
 * DP implementation optimized with the Tabulation pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int n
 *   N-th number of element in the Fibonacci sequence
 *   that the function should return.
 * @return int
 *   Value of the N-th element in the Fibonacci sequence.
 */
int fib_dp_tab(int n) {

    int n_max = n + 1;

    int* tab = new int[n_max];

    // Init Tab

    for (int i = 0; i < n_max; i++) {
        tab[i] = 0;
    }

    tab[1] = 1;

    // Determine Result

    for (int i = 0, j = 1, k = 2;
         i < n; i++, j = i + 1, k = i + 2) {
;
        if (j < n_max) {
            tab[j] += tab[i];
        }

        if (k < n_max) {
            tab[k] += tab[i];
        }
    }

    return tab[n];
}

/**
 * Arbitrary solution to the problem.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int n
 *   N-th number of element in the Fibonacci sequence
 *   that the function should return.
 * @return int
 *   Value of the N-th element in the Fibonacci sequence.
 */
int fib_reg(int n) {
    \
    int prev = 1;
    int curr = 1;

    int temp;

    for (int i = 2; i < n; i++) {
        temp  = curr;
        curr += prev;
        prev  = temp;
    }

    return curr;
}
