-- CURRENTLY BROKEN
local f = io.open("example.txt", "r")

if f == nil then
    error("Unable to open file")
end

local function toList(s)
    local l = {}

    for m in string.gmatch(s, "%S+") do
        local n = tonumber(m)
        if n == nil then
            error("Unable to cast string to number")
        end
        table.insert(l, n)
    end

    return l
end

local function update(seeds, map)
    for _, seed in ipairs(seeds) do
        local was_updated = false
        local seed_start = seed[1]
        local seed_range = seed[2]
        local seed_max = seed_start + seed_range - 1

        if seed_range < 0 or seed_start < 0 then
            print("NEGATIVE SEED RANGE: mistakes were made...")
            for i, s in ipairs(seeds) do
                print("IDX: " .. i .. " | START: " .. s[1] .. " | RNG: " .. s[2])
            end
            os.exit()
        end

        print("MAX SEED: " .. seed_max)

        for _, m in pairs(map) do
            if was_updated then
                goto continue
            end

            local range = m[3]
            local dest = m[1]
            local source = m[2]
            local source_max = source + range - 1
            local diff = dest - source

            local is_seed_start = seed_start >= source and seed_start <= source_max
            local is_seed_max = seed_max >= source and seed_max <= source_max

            -- convert source values to dest values
            if is_seed_start and is_seed_max then
                -- all seed values within source range, no new ranges required
                -- update the start seed to it's new value
                seed[1] = seed_start + diff

                print("BOTH")
                was_updated = true
            elseif is_seed_start then
                -- find the range of seeds within the current map range
                local start_diff = source_max - seed_start

                -- update seed to new value
                seed[1] = seed_start - diff

                -- update seed range to only include items within current map range
                seed[2] = start_diff + 1

                -- create new seed with seeds outside of current range
                table.insert(seeds, {source_max + 1, seed_range - seed[2]})

                print("START")
                was_updated = true
            elseif is_seed_max then
                -- find the range of seeds within the current map range
                local start_diff = seed_max - source_max

                -- update seed to new value
                seed[1] = seed_max + diff
                print("NEW SEED START: " .. seed[1])
                print("OLD SEED START: " .. seed_start)

                -- update seed range to only include items within current map range
                seed[2] = start_diff + 1

                -- create new seed with seeds outside of current range
                table.insert(seeds, {seed_start, seed_range - seed[2]})

                print("MAX")
                was_updated = true
            end

            ::continue::
        end
    end
end

local function expand(seeds)
    local new_seeds = {}
    local seed_range = {}
    local seed_range_count = 0

    for m in string.gmatch(seeds, "%S+") do
        local n = tonumber(m)

        if n == nil then
            error("Unable to cast string to number")
        end

        if seed_range_count < 2 then
            table.insert(seed_range, n)
            seed_range_count = seed_range_count + 1
        end

        if seed_range_count == 2 then
            table.insert(new_seeds, seed_range)
            seed_range = {}
            seed_range_count = 0
        end
    end

    if seed_range_count == 2 then
        table.insert(new_seeds, seed_range)
    end

    return new_seeds
end

local function print_seeds(seeds)
    for i, s in ipairs(seeds) do
        print("IDX: " .. i .. " | START: " .. s[1] .. " | RNG: " .. s[2])
    end
end

local first = f:read()
local raw_seeds = first:match("seeds:%s(.*)")
local seeds = expand(raw_seeds)
local map = {}

print_seeds(seeds)
-- os.exit()

-- used to skip empty line
first = f:read()

for l in f:lines() do
    if string.len(l) == 0 then
        -- print("=============== LINE ===============")
        -- process maps per seed
        update(seeds, map)
        print_seeds(seeds)
        map = {}

        goto continue
    end

    local first_char = string.sub(l, 1, 1)

    -- skip non number lines
    if tonumber(first_char, 10) == nil then
        print("\n" .. l)
        goto continue
    end

    table.insert(map, toList(l))

    ::continue::
end

f:close()

update(seeds, map)
print_seeds(seeds)

local seed = table.remove(seeds, 1)
local closest = seed[1]

for _, v in ipairs(seeds) do
    if v[1] < closest then
        closest = v[1]
    end
end

-- 1339903174, too high
print(closest)
