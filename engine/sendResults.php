<?php
require_once 'connect.php';
session_start();

$newJson = [
    4 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    6 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    8 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    10 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    12 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    14 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    16 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    18 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ],

    20 => [
        0 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        1 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ],
        2 => [
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000],
            ['00:00:00.00', 1200000]
        ]
    ]
];

$fieldSize = $_POST['size'];
$diff = $_POST['diff'];
$strScore = $_POST['read'];
$score = $_POST['score'];

$nickname = $_SESSION['user']['nickname'];

$query = "SELECT `records` FROM `verified_users` WHERE `nickname` = '$nickname'";
$json_records = mysqli_query($connect, $query);

$json_records = mysqli_fetch_assoc($json_records);

if ($json_records['records'] === NULL) {

    $newJson[$fieldSize][$diff][0][0] = $strScore;
    $newJson[$fieldSize][$diff][0][1] = $score;

    $newJson = json_encode($newJson);
    echo $newJson;
    $query = "UPDATE `verified_users` SET `records` = '$newJson' WHERE `nickname` = '$nickname'";

    mysqli_query($connect, $query);

} else {

    $newJson = json_decode($json_records['records'], true);

    if ($score < $newJson[$fieldSize][$diff][0][1]) {
        $temp = [
            [$newJson[$fieldSize][$diff][0][0], $newJson[$fieldSize][$diff][1][0]],
            [$newJson[$fieldSize][$diff][0][1], $newJson[$fieldSize][$diff][1][1]]
        ];

        $newJson[$fieldSize][$diff][0][0] = $strScore;
        $newJson[$fieldSize][$diff][1][0] = $temp[0][0];
        $newJson[$fieldSize][$diff][2][0] = $temp[0][1];

        $newJson[$fieldSize][$diff][0][1] = $score;
        $newJson[$fieldSize][$diff][1][1] = $temp[1][0];
        $newJson[$fieldSize][$diff][2][1] = $temp[1][1];

        $newJson = json_encode($newJson);
        echo $newJson;
        $query = "UPDATE `verified_users` SET `records` = '$newJson' WHERE `nickname` = '$nickname'";
        mysqli_query($connect, $query);

    } elseif ($score > $newJson[$fieldSize][$diff][0][1] && $score < $newJson[$fieldSize][$diff][1][1]) {
        $temp = [$newJson[$fieldSize][$diff][1][0], $newJson[$fieldSize][$diff][1][1]];

        $newJson[$fieldSize][$diff][1][0] = $strScore;
        $newJson[$fieldSize][$diff][2][0] = $temp[0];

        $newJson[$fieldSize][$diff][1][1] = $score;
        $newJson[$fieldSize][$diff][2][1] = $temp[1];

        $newJson = json_encode($newJson);
        echo $newJson;
        $query = "UPDATE `verified_users` SET `records` = '$newJson' WHERE `nickname` = '$nickname'";
        mysqli_query($connect, $query);

    } elseif ($score > $newJson[$fieldSize][$diff][1][1] && $score < $newJson[$fieldSize][$diff][2][1]) {
        $newJson[$fieldSize][$diff][2][0] = $strScore;
        $newJson[$fieldSize][$diff][2][1] = $score;

        $newJson = json_encode($newJson);
        echo $newJson;
        $query = "UPDATE `verified_users` SET `records` = '$newJson' WHERE `nickname` = '$nickname'";
        mysqli_query($connect, $query);
    }
}
