local f = io.open("input.txt", "r")

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
    local was_updated = false
    for i, v in ipairs(seeds) do
        was_updated = false
        for _, m in pairs(map) do
            if was_updated then
                goto continue
            end

            local range = m[3]
            local dest = m[1]
            local source = m[2]
            local max_source = source + range

            if v >= source and v <= max_source then
                was_updated = true
                local diff = v - source
                local new_val = dest + diff
                seeds[i] = new_val
            end

            ::continue::
        end
    end
end

local function print_seeds(seeds)
    local cs = ""
    for _, s in pairs(seeds) do
        cs = cs .. " " .. s
    end
    print(cs .. " ")
end

local first = f:read()
local raw_seeds = first:match("seeds:%s(.*)")
local seeds = toList(raw_seeds)
local map = {}

-- print_seeds(seeds)

-- used to skip empty line
first = f:read()

for l in f:lines() do
    if string.len(l) == 0 then
        -- process maps per seed
        update(seeds, map)
        -- print_seeds(seeds)
        map = {}

        goto continue
    end

    local first_char = string.sub(l, 1, 1)

    -- skip non number lines
    if tonumber(first_char, 10) == nil then
        goto continue
    end

    table.insert(map, toList(l))

    ::continue::
end

f:close()

update(seeds, map)
-- print_seeds(seeds)

local closest = table.remove(seeds, 1)

for _, v in pairs(seeds) do
    if v < closest then
        closest = v
    end
end

print(closest)
