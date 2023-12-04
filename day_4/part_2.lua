local f = io.open("input.txt", "r")

if f == nil then
    error("Unable to open file")
end

local function has(l, s)
    for _, v in ipairs(l) do
        if v == s then
            return true
        end
    end

    return false
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

local cards = {}
local total = 0
local index = 1

for l in f:lines() do
    local w, y = l:match(".*:%s(.*)%s|%s(.*)")
    local wl = toList(w)
    local yl = toList(y)
    local count = 0

    for _, v in ipairs(yl) do
        if has(wl, v) then
            count = count + 1
        end
    end

    if cards[index] ~= nil then
        cards[index] = cards[index] + 1
    else
        cards[index] = 1
    end

    if count > 0 then
        local addition = cards[index]

        for i = index + 1, index + count, 1 do
            if cards[i] ~= nil then
                cards[i] = cards[i] + addition
            else
                cards[i] = 1 * addition
            end
        end
    end

    index = index + 1
end

for _, v in pairs(cards) do
    total = total + v
end

f:close()

print(math.floor(total))

