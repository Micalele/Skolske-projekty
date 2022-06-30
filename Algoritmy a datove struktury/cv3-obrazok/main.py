if __name__ == '__main__':
    file = open("data.txt", "r")
    data = file.read().split("\n")

    for i in range(len(data)):
        row = data[i].split(" ")
        for j in range(len(row)):
            row[j] = int(row[j])
        data[i] = row

    matrix = []
    for row in range(len(data)):
        if row == 0:
            matrix.append(data[row])
        else:
            rowSummed = []
            for col in range(len(data[row - 1])):
                if 0 < col < 49:
                    left = matrix[row - 1][col - 1] + data[row][col]
                    mid = matrix[row - 1][col] + data[row][col]
                    right = matrix[row - 1][col + 1] + data[row][col]
                    rowSummed.append(min(left, mid, right))
                elif col == 0:
                    mid = matrix[row - 1][col] + data[row][col]
                    right = matrix[row - 1][col + 1] + data[row][col]
                    rowSummed.append(min(mid, right))
                elif col == 49:
                    left = matrix[row - 1][col - 1] + data[row][col]
                    mid = matrix[row - 1][col] + data[row][col]
                    rowSummed.append(min(left, mid))
            matrix.append(rowSummed)

    print(sorted(matrix[len(matrix)-1]))
