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
$key = 'AAA';
$steps = 0;
$instructions = 0;

foreach ($lines as $line) {
    preg_match('/(\w*)\s=\s\((\w*),\s(\w*)\)/', $line, $parts);

    $k = $parts[1];
    $l = $parts[2];
    $r = $parts[3];

    $map[$k] = ['L' => $l, 'R' => $r];
}

while ($key !== 'ZZZ') {
    $key = $map[$key][$dir];

    if (!isset($directions[$instructions+1])) {
        $instructions = 0;
    } else {
        $instructions++;
    }

    $dir = $directions[$instructions];

    $steps++;
}

echo "STEP: $steps\n";