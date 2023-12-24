<?php

$lines = preg_split(
    "/\n/",
    file_get_contents(__DIR__.'/input.txt')
);

// directions
$directions = str_split(array_shift($lines));
array_shift($lines);

$map = [];
$dir = $directions[0];
$keys = [];
$instructions = 0;

foreach ($lines as $line) {
    preg_match('/(\w*)\s=\s\((\w*),\s(\w*)\)/', $line, $parts);

    $k = $parts[1];
    $l = $parts[2];
    $r = $parts[3];

    $map[$k] = ['L' => $l, 'R' => $r];

    if ($k[2] === 'A') {
        $keys[] = ['key' => $k, 'dir' => $directions[0], 'steps' => 0, 'ins' => 0];
    }
}

$steps = 0;
$ended = count($keys);
$highest = 0;

while (true) {
    for ($i = 0; $i < count($keys); $i++) { 
        $dir = $keys[$i]['dir'];
        $key = $keys[$i]['key'];

        $keys[$i]['key'] = $map[$key][$dir];

        if (!isset($directions[$keys[$i]['ins']+1])) {
            $keys[$i]['ins'] = 0;
        } else {
            $keys[$i]['ins']++;
        }

        $keys[$i]['dir'] = $directions[$keys[$i]['ins']];
        $steps++;
    }

    $matches = 0;
    foreach ($keys as $key) {
        if ($key['key'][2] === 'Z') {
            $matches++;
        }
    }

    if ($matches > $highest) {
        $highest = $matches;
        echo sprintf('HIGHEST: %s  - %s', $highest, date('c')) . PHP_EOL;
    }

    if ($matches === $ended) {
        break;
    }
}

// 22411, too low
echo sprintf("STEP: %s\n", $steps);