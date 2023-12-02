<?php

$calibrations = preg_split(
        "/\r\n|\n|\r/",
        file_get_contents(__DIR__.'/day_1_input.txt')
);

$total = 0;
foreach ($calibrations as $calibration) {
	$nums = preg_replace('/[^0-9]/', '', $calibration);
        $first = $nums[0] ?? '';
        $last = $nums[strlen($nums)-1] ?? '';
        $num = sprintf('%s%s', $first, $last);
        $total += (int) $num;
}

echo "TOTAL: $total\n";

