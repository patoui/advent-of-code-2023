<?php

$lines = preg_split(
    "/\n/",
    file_get_contents(__DIR__.'/input.txt')
);

$hands = array_map(fn($l) => explode(' ', $l), $lines);

$cr = [
    'A' => 14,
    'K' => 13,
    'Q' => 12,
    'J' => 11,
    'T' => 10,
    '9' => 9,
    '8' => 8,
    '7' => 7,
    '6' => 6,
    '5' => 5,
    '4' => 4,
    '3' => 3,
    '2' => 2,
];

$hr = [
    '5' => 500,
    '41' => 400,
    '32' => 350,
    '311' => 300,
    '221' => 200,
    '2111' => 100,
    '11111' => 0,
];

$card_scores = [];

foreach ($hands as $h) {
    $first = 0;
    $cc = [];
    for ($i = 0; $i < strlen($h[0]); $i++) { 
        $cv = $cr[$h[0][$i]];
        if ($i === 0) {
            $first = $cv;
        }

        if (isset($cc[$cv])) {
            $cc[$cv]++;
        } else {
            $cc[$cv] = 1;
        }
    }
    
    $ccv = array_values($cc);
    rsort($ccv);
    $sk = array_reduce($ccv, static function ($c, $ccc) {
        $c .= (string) $ccc;
        return $c;
    }, '');
    $score = $hr[$sk];

    $card_scores[] = [
        'bid' => $h[1],
        'score' => $score,
        'cards' => $h[0],
        'first' => $first,
    ];
}

usort($card_scores, static function ($a, $b) use ($cr) {
    if ($a['score'] === $b['score']) {
        for ($i = 0; $i < 5; $i++) { 
            if ($a['cards'][$i] !== $b['cards'][$i]) {
                $av = $cr[$a['cards'][$i]];
                $bv = $cr[$b['cards'][$i]];

                return $av < $bv ?  -1 : 1;
            }
        }
        return 1;
    }

    return $a['score'] < $b['score'] ? -1 : 1;
});

$results = 0;

for ($i = 0; $i < count($card_scores); $i++) { 
    $results += $card_scores[$i]['bid'] * ($i+1);
}

// 250474325
echo "TOTAL: $results\n";