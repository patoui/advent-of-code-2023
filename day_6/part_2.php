<?php

$lines = preg_split(
    "/\n/",
    file_get_contents(__DIR__.'/input.txt')
);

$concat = static function ($c, $v) {
    $c .= $v;
    return $c;
};

preg_match_all('/\d+/', $lines[0], $m);
$time = (int) array_reduce($m[0], $concat, '');

preg_match_all('/\d+/', $lines[1], $m);
$max_distance = (int) array_reduce($m[0], $concat, '');

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

echo "TOTAL: $r\n";