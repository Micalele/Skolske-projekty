import pandas as pd


def optimalStrategyOfGame(arr):
    n = len(arr)
    table = [[0 for i in range(n)]
             for i in range(n)]
    print()
    for gap in range(n):
        for j in range(gap, n):
            i = j - gap
            x = 0
            if (i + 2) <= j:
                x = table[i + 2][j]
            y = 0
            if (i + 1) <= (j - 1):
                y = table[i + 1][j - 1]
            z = 0
            if i <= (j - 2):
                z = table[i][j - 2]

            daco1 = -1
            daco2 = -1
            if i - j <= -3 and arr[i] == arr[j - 1] and z > y:
                daco1 = arr[j] + z
            if i - j <= -3 and arr[i + 1] == arr[j] and x > y:
                daco2 = arr[i] + x
            table[i][j] = max(max(arr[i] + min(x, y), daco1), max(arr[j] + min(y, z), daco2))
    print()
    return table[0][n - 1]


def fun(arr):
    n = len(arr)
    table0 = [[0 for i in range(n)] for i in range(n)]
    table1 = [[0 for i in range(n)] for i in range(n)]

    for i in range(n):
        table0[i][i] = arr[i]
        table1[i][i] = 0
    c1 = 0
    c2 = 0
    for i in range(1, n):
        for j in range(i - 1, -1, -1):
            if (i - j) % 2 == 1:
                c1 = arr[i] + table1[i - 1][j]
                c2 = arr[j] + table1[i][j + 1]
                if c1 > c2:
                    table0[i][j] = c1
                    table1[i][j] = table0[i - 1][j]
                else:
                    table0[i][j] = c2
                    table1[i][j] = table0[i][j + 1]

            if (i - j) % 2 == 0:
                if arr[i] >= arr[j]:
                    table0[i][j] = arr[i] + table1[i - 1][j]
                    table1[i][j] = table0[i - 1][j]
                else:
                    table0[i][j] = arr[j] + table1[i][j + 1]
                    table1[i][j] = table0[i][j + 1]
    t1 = pd.DataFrame(table0)
    t2 = pd.DataFrame(table1)
    print(table0[n - 1][0])


if __name__ == '__main__':
    data = open('data.txt', 'r').readline()
    listOfData = []
    for num in data:
        listOfData.append(int(num))

    # listOfData = [2, 6, 9, 1, 2, 9, 2, 8]
    fun(listOfData)
    # print(optimalStrategyOfGame(listOfData))
