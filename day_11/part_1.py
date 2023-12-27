from collections import defaultdict

input = open('input.txt', 'r')
lines = input.readlines()

grid = []
galaxies = []
erows = defaultdict(int)
ecols = defaultdict(int)

# find empty rows and columns
for y in range(0, len(lines)):
    erows[y] += 0
    cols = list(lines[y].strip())
    grid.append(cols)
    for x in range(0, len(cols)):
        ecols[x] += 0
        if cols[x] == '#':
            erows[y] += 1
            ecols[x] += 1

# remove non-zero dictionary entries
erows = {k:v for (k,v) in erows.items() if v == 0}
ecols = {k:v for (k,v) in ecols.items() if v == 0}
# print("EROWS {} | ECOLS {}".format(erows, ecols))

# expand grid horitonzally
for y in range(0, len(grid)):
    xo = 0
    for x in ecols.keys():
        grid[y].insert(x + xo, '.')
        xo += 1

colcount = len(grid[0])

yo = 0

# expand grid vertically
for k in erows.keys():
    grid.insert(k + yo, ['.'] * colcount)
    yo += 1

# for g in grid:
#     print(''.join(g))

# find galaxy positions
for y in range(0, len(grid)):
    for x in range(0, len(grid[y])):
        if grid[y][x] == '#':
            galaxies.append((x, y))

total = 0
gc = 0

# calculate galaxy distances
for g in galaxies:
    for ig in range(gc + 1, len(galaxies)):
        x = abs(g[0] - galaxies[ig][0])
        y = abs(g[1] - galaxies[ig][1])
        total += x + y
    gc += 1

# print("GALAXIES {}".format(galaxies))
print("TOTAL {}".format(total))