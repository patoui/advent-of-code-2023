<?php

$lines = preg_split(
    "/\n/",
    file_get_contents(__DIR__.'/input.txt')
);

$moves = [
    'S' => [['x' => -1],['x' => 1],['y' => -1],['y' => 1]],
    'F' => [['y' => 1],['x' => 1]],
    '7' => [['y' => 1],['x' => -1]],
    '|' => [['y' => -1],['y' => 1]],
    '-' => [['x' => -1],['x' => 1]],
    'L' => [['y' => -1],['x' => 1]],
    'J' => [['x' => -1],['y' => -1]],
];

$tiles = [];
$pos = [];

// setup tiles and start position
for ($i = 0; $i < count($lines); $i++) { 
    $line = $lines[$i];
    $row_tiles = str_split($line);

    if (empty($pos)) {
        $s = array_search('S', $row_tiles);
        if ($s !== false) {
            $pos['v'] = 'S';
            $pos['x'] = $s;
            $pos['y'] = $i;
        }
    }

    $tiles[] = $row_tiles;
}

function next_tile($tiles, $c, $p = [], $steps = 0) {
    global $moves;

    $cx = $c['x'];
    $cy = $c['y'];
    $px = $p['x'] ?? null;
    $py = $p['y'] ?? null;

    $out = $moves[$c['v']];

    foreach ($out as $check) {
        $ockx = $check['x'] ?? 0;
        $nx = $ockx + $cx;
        $ocky = $check['y'] ?? 0;
        $ny = $ocky + $cy;

        // check for previous tile
        if ($nx === $px && $ny === $py) {
            continue;
        }

        $nt = $tiles[$ny][$nx] ?? '.';

        // invalid tile
        if ($nt === '.') {
            continue;
        }

        // looped back to the beginning
        if ($nt === 'S') {
            ++$steps;
            return $steps;
        }

        $is_valid = false;
        $in = $moves[$nt];

        foreach ($in as $cin) {
            $ckx = -1 * ($cin['x'] ?? 0);
            $cky = -1 * ($cin['y'] ?? 0);

            if ($ckx === $ockx || $cky === $ocky) {
                $is_valid = true;
                break;
            }
        }

        // invalid neighbouring tile
        if ($is_valid === false) {
            continue;
        }

        return next_tile($tiles, ['v' => $nt, 'x' => $nx, 'y' => $ny], $c, ++$steps);
    }

    return $steps;
}

$steps = next_tile($tiles, $pos);
$farthest = ceil($steps / 2);

echo "STEPS: $steps\n";

// 6768, correct
echo "FARTHEST: $farthest\n";