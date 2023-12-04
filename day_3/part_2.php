<?php

declare(strict_types=1);

$lines = preg_split(
    "/\r\n|\n|\r/",
    file_get_contents(__DIR__.'/input.txt')
);

function find_number_indexes(string $line, array $indexes): array {
    $matches = [];

    foreach ($indexes as $index) {
        if (is_numeric($line[$index] ?? null)) {
            $matches[] = $index;
        }   
    }

    return $matches;
}

function retrieve_full_number(string $line, int $index): int {
    $nums = $line[$index];

    $bi = $index - 1;
    $num = $line[$bi] ?? null;
    while (is_numeric($num)) {
        $nums = $num.$nums;
        $bi--;
        $num = $line[$bi] ?? null;
    }

    $fi = $index + 1;
    $num = $line[$fi] ?? null;
    while (is_numeric($num)) {
        $nums = $nums.$num;
        $fi++;
        $num = $line[$fi] ?? null;
    }

    return (int) $nums;
}

function find_gears(array $s): int {
    $a = $s['above'];
    $c = $s['current'];
    $b = $s['below'];

    $total = 0;
    $indexes = [];

    for ($i = 0; $i < strlen($c); $i++) {
        $indexes = [];
        if ($c[$i] === '*') {
            $ai = find_number_indexes($a, [$i-1, $i, $i+1]);
            $ci = find_number_indexes($c, [$i-1, $i+1]);
            $bi = find_number_indexes($b, [$i-1, $i, $i+1]);

            if ($ai) {
                $indexes['a'] = $ai;
            }
            if ($ci) {
                $indexes['c'] = $ci;
            }
            if ($bi) {
                $indexes['b'] = $bi;
            }

            $total_count = count($indexes['a'] ?? [])
                + count($indexes['c'] ?? [])
                + count($indexes['b'] ?? []);

            if ($total_count > 1) {
                $nums = [];
                foreach ($indexes as $k => $idx) {
                    foreach ($idx as $j) {
                        $n = retrieve_full_number(${$k}, $j);
                        if (!in_array($n, $nums)) {
                            $nums[] = $n;
                        }
                    }
                }

                if (count($nums) > 1) {
                    $total += array_product($nums);
                }
            }
        }
    }

    return $total;
}

$total = 0;
$comp = [
    'above' => '',
    'current' => '',
    'below' => '',
];

for ($i = 0; $i < count($lines); $i++) {
    $comp['above'] = $lines[$i-1] ?? '';
    $comp['current'] = $lines[$i];
    $comp['below'] = $lines[$i+1] ?? '';
    $total += find_gears($comp);
}

echo sprintf("TOTAL: %s\n", $total);

