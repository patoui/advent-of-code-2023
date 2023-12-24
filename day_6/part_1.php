<?php

$lines = preg_split(
    "/\n/",
    file_get_contents(__DIR__.'/input.txt')
);

preg_match_all('/\d+/', $lines[0], $m);
$times = array_map('intval', $m[0]);

preg_match_all('/\d+/', $lines[1], $m);
$max_distances = array_map('intval', $m[0]);

$results = 1;

for ($i = 0; $i < count($times); $i++) { 
    $time = $times[$i];
    $max_distance = $max_distances[$i];

    $r = 0;
    $s = 0;
    for ($t = 0; $t <= $time; $t++) {
        $tr = $time - $t;
        $d = $s * $tr;
        if ($d > $max_distance) {
            $r++;
        }
        $s++;
    }

    $results *= $r;
}

echo "TOTAL: $results\n";