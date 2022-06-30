# zdroj https://www.geeksforgeeks.org/extended-knapsack-problem/

class Item:
    itemId = ''
    value = ''
    weight = ''
    fragility = ''

    def __init__(self, itemId, value, weight, fragility):
        self.itemId = itemId
        self.value = value
        self.weight = weight
        self.fragility = fragility


if __name__ == '__main__':
    # parseFile
    fileName = 'zadanie2data3.txt'
    file = open('resources/' + fileName)
    maxItems = int(file.readline())
    maxWeight = int(file.readline())
    maxFragItems = int(file.readline())
    listOfItems = []
    for line in file:
        if line[-1] == '\n':
            line = line[:-1].split(' ')
        else:
            line = line.split(' ')
        listOfItems.append(Item(int(line[0]), int(line[1]), int(line[2]), int(line[3])))
    file.close()

    # fillTheMatrix
    T = [[[0 for k in range(maxFragItems+1)] for j in range(maxWeight+1)] for i in range(maxItems+1)]
    # T = np.zeros((maxItems+1, maxWeight+1, maxFragItems+1))
    print()
    for pcItems in range(maxItems + 1):
        for pcWeight in range(maxWeight + 1):
            for pcFrag in range(maxFragItems + 1):
                if pcItems == 0 or pcWeight == 0:
                    T[pcItems][pcWeight][pcFrag] = 0
                elif listOfItems[pcItems - 1].weight > pcWeight or listOfItems[pcItems - 1].fragility > pcFrag:
                    T[pcItems][pcWeight][pcFrag] = T[pcItems - 1][pcWeight][pcFrag]
                else:
                    # a = listOfItems[pcItems - 1].value
                    # b = listOfItems[pcItems - 1].weight
                    # c = listOfItems[pcItems - 1].fragility
                    T[pcItems][pcWeight][pcFrag] = max(listOfItems[pcItems - 1].value +
                                                       T[pcItems - 1]
                                                        [pcWeight - listOfItems[pcItems - 1].weight]
                                                        [pcFrag - listOfItems[pcItems - 1].fragility],
                                                       T[pcItems - 1][pcWeight][pcFrag])

    # findChosenItems
    chosenItems = []
    j = maxWeight
    k = maxFragItems
    for i in range(maxItems, 0, -1):
        if T[i][j][k] == T[i - 1][j][k]:
            continue
        chosenItems.append(listOfItems[i - 1])
        j = j - listOfItems[i - 1].weight
        k = k - listOfItems[i - 1].fragility

    # reverseList
    chosenItems.reverse()

    # saveToFile
    outFile = open('resources/out.txt', 'w')
    outFile.write(str(T[maxItems][maxWeight][maxFragItems]) + '\n')
    outFile.write(str(len(chosenItems)) + '\n')
    for item in chosenItems:
        outFile.write(str(item.itemId)+'\n')

    print()
