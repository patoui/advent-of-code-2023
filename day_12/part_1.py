import re

input = open('example.txt', 'r')
lines = input.readlines()

def can_replace(rec, i, c):
    recp = rec[i-1] if 0 <= i-1 < len(rec) else None

    # check prev char
    if recp is not None and recp != '.' and recp != '?':
        return False

    recn = rec[i+c] if i+c < len(rec) else None

    # check next char
    if recn is not None and recn != '.' and recn != '?':
        return False

    exp = r'[#|?]{' + re.escape(str(c)) + r'}'
    pattern = re.compile(exp)

    # retrieve substring to check
    r = rec[i:i+c]

    # check substring pattern is replaceable
    return bool(pattern.search(r))

def possible_variations(sets, conditions):
    if len(conditions) == 0:
        return sets

    c = int(conditions.pop(0))
    prev_record = [s[0] for s in sets]
    new_sets = []

    for s in sets:
        (record, start_index) = s

        # calculate number of possible variations
        for i in range(start_index, len(record)):
            if can_replace(record, i, c):
                new_record = record[:i] + ('$' * c) + record[i+c:]
                if new_record not in prev_record:
                    prev_record.append(new_record)
                    new_sets.append((new_record, i+c))

    return possible_variations(new_sets, conditions)

sum = 0

for line in lines:
    parts = line.strip().split(' ')
    record = parts[0]
    conditions = parts[1].split(',')

    pvars = possible_variations([(record, 0)], conditions)

    sum += len(pvars)

# 11025, too high
# 11253, too high
# 13948, too high
print("SUM {}".format(sum))
