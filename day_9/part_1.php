<?php

$lines = preg_split(
    "/\n/",
    file_get_contents(__DIR__.'/input.txt')
);

function tree($ns, $c = []) {
    $nset = [];

    for ($i = 0; $i < count($ns) - 1; $i++) {
        $nset[] = $ns[$i+1] - $ns[$i];
    }

    $c[] = $nset;

    if (! array_filter($nset)) {
        return $c;
    }

    return tree($nset, $c);
}

function next_val($tree, $nv = 0) {
    $ct = array_pop($tree);
    $treec = count($tree);
    $tprev = $tree[$treec-1];

    $nv = end($ct) + end($tprev);

    if ($treec === 1) {
        return $nv;
    }

    $tree[$treec-1][] = $nv;

    return next_val($tree, $nv);
}

$sum = 0;

foreach ($lines as $line) {
    $nums = array_map('intval', explode(' ', $line));
    $tree = tree($nums, [$nums]);
    $sum += next_val($tree);
}

echo "SUM: $sum\n";