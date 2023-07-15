/***********************************************************\
|* Problem: Say that you are a traveler on a 2D grid. You  *|
|* begin in the top-left corner and your goal is to travel *|
|* to the bottom-right corner. You may only move down or   *|
|* right. In how many ways can you travel to the goal on   *|
|* a grid with dimensions m * n?                           *|
|* ------------------------------------------------------- *|
|* Problem Source: freecodecamp.org                        *|
\***********************************************************/

#include "main.h"

using namespace std;

/**
 * Generic Dynamic Programming implementation.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int m
 *   Numer of rows the imaginary grid contains.
 * @param int n
 *   Numer of columns the imaginary grid contains.
 * @return int
 *   Number of possible paths within the grid given
 *   the movement constraints.
 */
int grid_traveler_dp(int m, int n) {

    if (m == 0 || n == 0) {
        return 0;
    }

    if (m == 1 || n == 1) {
        return 1;
    }

    return grid_traveler_dp(m - 1, n) + grid_traveler_dp(m, n - 1);
}

/**
 * DP implementation optimized with the Memoization pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int m
 *   Numer of rows the imaginary grid contains.
 * @param int n
 *   Numer of columns the imaginary grid contains.
 * @return int
 *   Number of possible paths within the grid given
 *   the movement constraints.
 */
int grid_traveler_dp_memo(int m, int n) {

    static map<string, int> memo;

    stringstream key_stream;

    int result;

    key_stream << m << "," << n;

    auto search = memo.find(key_stream.str());

    if (search != memo.end()) {
        return search->second;
    }

    if (m == 0 || n == 0) {
        return 0;
    }

    if (m == 1 || n == 1) {
        return 1;
    }

    result = grid_traveler_dp_memo(m - 1, n) + grid_traveler_dp_memo(m, n - 1);

    memo.insert({ key_stream.str(), result });

    return result;
}

/**
 * DP implementation optimized with the Tabulation pattern.
 *
 * @author    Djordje Jocic <office@djordjejocic.com>
 * @copyright 2022 All Rights Reserved
 * @version   1.0.0
 *
 * @param int m
 *   Numer of rows the imaginary grid contains.
 * @param int n
 *   Numer of columns the imaginary grid contains.
 * @return int
 *   Number of possible paths within the grid given
 *   the movement constraints.
 */
int grid_traveler_dp_tab(int m, int n) {

    int i, j, k, l;

    int m_max = m + 1;
    int n_max = n + 1;

    int** tab = new int*[m_max];

    // Init Tab

    for (i = 0; i < m_max; i++) {

        tab[i] = new int[n_max];

        for (j = 0; j < n_max; j++) {
            tab[i][j] = 0;
        }
    }

    tab[1][1] = 1;

    // Determine Result

    for (i = 0, k = 1; i < m_max; i++, k = i + 1) {

        for (j = 0, l = 1; j < n_max; j++, l = j + 1) {

            if (k < m_max) {
                tab[k][j] += tab[i][j];
            }

            if (l < n_max) {
                tab[i][l] += tab[i][j];
            }
        }
    }

    return tab[m][n];
}
