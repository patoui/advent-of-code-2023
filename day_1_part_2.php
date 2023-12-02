<?php

$calibrations = preg_split(
        "/\r\n|\n|\r/",
        file_get_contents(__DIR__.'/day_1_input.txt')
);

$r = 'one|two|three|four|five|six|seven|eight|nine|1|2|3|4|5|6|7|8|9';
$rr = strrev($r);
$f = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
$b = array_map('strrev', $f);

$total = 0;
foreach ($calibrations as $calibration) {
        preg_match_all("/($r)/", $calibration, $forward);
        $first = $forward[0][0] ?? '';

        if (strlen($first) > 1) {
                $idx = array_search($first, $f);
                if ($idx !== false) {
                        $first = $idx + 1;
                }
        }

        preg_match_all("/($rr)/", strrev($calibration), $backwards);
        $last = $backwards[0][0] ?? '';

        if (strlen($last) > 1) {
                $idx = array_search($last, $b);
                if ($idx !== false) {
                        $last = $idx + 1;
                }
        }

        $num = sprintf('%s%s', $first, $last);
        $total += (int) $num;
}

echo "TOTAL: $total\n";

