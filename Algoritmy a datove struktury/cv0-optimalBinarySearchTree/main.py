import pandas
import time
import sys

# ZDROJ:
# Introduction to algorithms-3rd Edition, Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein


class Node:
    word = ''
    right = ''
    left = ''

    def __init__(self, name):
        self.word = name


def makeTree(rootTable, row, col, keyTable):
    if col - row < 0:
        return 0
    node = Node(keyTable.at[rootTable.at[row, col] - 1, 'word'])
    node.left = makeTree(rootTable, row, rootTable.at[row, col] - 1, keyTable)
    node.right = makeTree(rootTable, rootTable.at[row, col] + 1, col, keyTable)
    return node


def pocetPorovnani(subTrees, searchedWord):
    if subTrees.word == searchedWord:
        return 1
    if searchedWord < subTrees.word:
        if subTrees.left == 0:
            return 1
        return pocetPorovnani(subTrees.left, searchedWord) + 1
    if searchedWord > subTrees.word:
        if subTrees.right == 0:
            return 1
        return pocetPorovnani(subTrees.right, searchedWord) + 1


if __name__ == '__main__':
    print('\nNacitanie a upravenie dat')
    tic = time.perf_counter()
    sys.setrecursionlimit(5000)
    data = open("dictionary.txt").read().split("\n")
    wordSum = 0
    for i in range(len(data)):
        x = data[i].split(" ")
        x[0] = int(x[0])
        wordSum = wordSum + x[0]
        data[i] = x

    dataDF = pandas.DataFrame(data, columns=['wordCount', 'word'])
    dataDF['prob'] = dataDF['wordCount'] / wordSum
    dataDF = dataDF.sort_values(by=['word'], ignore_index=True)

    keys = pandas.DataFrame(columns=['wordCount', 'word', 'prob'])
    dummy = pandas.DataFrame()
    p = []
    q = []
    probSum = 0.0
    wordCountSum = 0
    first = ''
    for i in range(len(dataDF)):
        if dataDF['wordCount'][i] >= 50000:
            keys = keys.append(dataDF.loc[[i]], ignore_index=True)
            p.append(dataDF['prob'][i])

            dummy = dummy.append([[wordCountSum, first + '-' + dataDF['word'][i], probSum]], ignore_index=True)
            first = dataDF['word'][i]
            q.append(probSum)
            probSum = 0.0
            wordCountSum = 0
        else:
            probSum = probSum + dataDF['prob'][i]
            wordCountSum = wordCountSum + dataDF['wordCount'][i]
    dummy = dummy.append([[wordCountSum, first + '-' + '', probSum]], ignore_index=True)
    q.append(probSum)
    toc = time.perf_counter()
    print(f"{toc - tic:0.4f} seconds")

    # p = [0.15, 0.10, 0.05, 0.10, 0.20]
    # q = [0.05, 0.10, 0.05, 0.05, 0.05, 0.10]
    n = len(p)

    e = pandas.DataFrame(0.0, index=range(1, n + 2), columns=range(0, n + 1))
    w = pandas.DataFrame(0.0, index=range(1, n + 2), columns=range(0, n + 1))
    root = pandas.DataFrame(0.0, index=range(1, n + 1), columns=range(1, n + 1))

    print('\nPocita sa strom')
    tic = time.perf_counter()
    for i in range(1, n + 2):
        e[i - 1][i] = q[i - 1]
        w[i - 1][i] = q[i - 1]
    # print()
    for x in range(1, n + 1):
        for i in range(1, n - x + 2):
            j = i + x - 1
            e[j][i] = 9999999999
            w[j][i] = w[j - 1][i] + p[j - 1] + q[j]
            for r in range(i, j + 1):
                t = e[r - 1][i] + e[j][r + 1] + w[j][i]
                if t < e[j][i]:
                    e[j][i] = t
                    root[j][i] = r

    toc = time.perf_counter()
    print(f"{toc - tic:0.4f} seconds")

    print('\nRobi sa strom')
    tic = time.perf_counter()
    tree = makeTree(root, 1, len(keys), keys)
    toc = time.perf_counter()
    print(f"{toc - tic:0.4f} seconds")
    print(pocetPorovnani(tree, 'study'))
    print()
