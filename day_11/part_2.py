from collections import defaultdict

input = open('input.txt', 'r')
lines = input.readlines()

grid = []
galaxies = []
erows = defaultdict(int)
ecols = defaultdict(int)
multiplier = 1000000

# find empty rows and columns
for y in range(0, len(lines)):
    erows[y] += 0
    cols = list(lines[y].strip())
    for x in range(0, len(cols)):
        ecols[x] += 0
        if cols[x] == '#':
            erows[y] += 1
            ecols[x] += 1
            galaxies.append((x, y))

# remove non-zero dictionary entries
erows = {k:v for (k,v) in erows.items() if v == 0}
ecols = {k:v for (k,v) in ecols.items() if v == 0}

total = 0
gc = 0

# calculate galaxy distances
for g in galaxies:
    for ig in range(gc + 1, len(galaxies)):
        xmax = max(g[0], galaxies[ig][0])
        xmin = min(g[0], galaxies[ig][0])
        x = xmax - xmin
        for k in range(xmin, xmax):
            if k in ecols:
                x += (multiplier - 1)

        ymax = max(g[1], galaxies[ig][1])
        ymin = min(g[1], galaxies[ig][1])
        y = galaxies[ig][1] - g[1]
        for k in range(ymin, ymax):
            if k in erows:
                y += (multiplier - 1)

        total += x + y
    gc += 1

print("TOTAL {}".format(total))