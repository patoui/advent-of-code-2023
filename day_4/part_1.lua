local f = io.open("input.txt", "r")

if f == nil then
    error("Unable to open file")
end

local function listHas(l, s)
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

local total = 0

for l in f:lines() do
    local w, y = l:match(".*:%s(.*)%s|%s(.*)")
    local wl = toList(w)
    local yl = toList(y)
    local count = 0

    for _, v in ipairs(yl) do
        if listHas(wl, v) then
            count = count + 1
        end
    end

    if count > 0 then
        total = total + (2 ^ (count-1))
    end
end

f:close()

print(math.floor(total))

