import re

input = open('input.txt', 'r')
lines = input.readlines()

# TODO: simplify and clean up
def can_replace(rec, i, c, is_last = False):
    recp = rec[i-1] if i-1 >= 0 else None

    # check prev char
    if recp is not None and recp != '.' and recp != '?':
        return False

    recn = rec[i+c] if i+c < len(rec) else None

    # check next char
    if recn is not None and recn != '.' and recn != '?':
        return False

    # retrieve substring to check
    r = rec[i:i+c]

    # check substring pattern is replaceable
    is_valid = re.compile(r'[#|?]{' + re.escape(str(c)) + r'}').search(r)

    if is_valid is None:
        return False

    if i == 0:
        return True

    # retrieve everything before current index
    b = rec[0:i-1]

    # check no values before current index have not been replaced
    if re.compile(r'#+').search(b) is not None:
        return False

    if is_last == True:
        # retrieve everything after current index + condition count
        a = rec[i+c:len(rec)-1]

        if len(a) > 0:
            ac = re.compile(r'#+').search(a)
            return ac is None

    return True

def possible_variations(sets, conditions):
    if len(conditions) == 0:
        return [x for x in sets if '#' not in x[0]]

    c = int(conditions.pop(0))
    prev_record = [s[0] for s in sets]
    new_sets = []
    is_last = len(conditions) == 0

    for record, start_index in sets:
        # calculate number of possible variations
        for i in range(start_index, len(record)):
            if can_replace(record, i, c, is_last):
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

# 8270, correct
# 8451, too high
# 10761, incorrect
# 11025, too high
# 11253, too high
# 13948, too high
print("SUM {}".format(sum))
