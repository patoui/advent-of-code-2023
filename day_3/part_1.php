<?php

declare(strict_types=1);

$lines = preg_split(
    "/\r\n|\n|\r/",
    file_get_contents(__DIR__.'/input.txt')
);

function is_valid(?string $s) {
    return $s && $s !== '.' && !is_numeric($s);
}

function find_schematics(array $s): array {
    $a = $s['above'];
    $c = $s['current'];
    $b = $s['below'];

    $parts = [];
    $cn = '';
    $is_valid = false;

    for ($i = 0; $i < strlen($c); $i++) {
        if (is_numeric($c[$i])) {
            $cn .= $c[$i];

            if (!$is_valid) {
                $is_valid = is_valid($a[$i-1] ?? null)
                    || is_valid($a[$i] ?? null)
                    || is_valid($a[$i+1] ?? null)
                    || is_valid($b[$i-1] ?? null)
                    || is_valid($b[$i] ?? null)
                    || is_valid($b[$i+1] ?? null)
                    || is_valid($c[$i-1] ?? null)
                    || is_valid($c[$i+1] ?? null);
            }
        } else {
            if ($is_valid) {
                $parts[] = (int) $cn;
                $is_valid = false;
            }
            $cn = '';
        }
    }

    if ($is_valid) {
        $parts[] = (int) $cn;
    }

    return $parts;
}

$parts = [];
$comp = [
    'above' => '',
    'current' => '',
    'below' => '',
];

for ($i = 0; $i < count($lines); $i++) {
    $comp['above'] = $lines[$i-1] ?? '';
    $comp['current'] = $lines[$i];
    $comp['below'] = $lines[$i+1] ?? '';

    $parts = array_merge($parts, find_schematics($comp));
}

echo sprintf("TOTAL: %s\n", array_sum($parts));

