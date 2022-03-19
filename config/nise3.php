<?php


return [
    "is_dev_mode" => env("IS_DEVELOPMENT_MODE", false),
    'http_debug' => env("HTTP_DEBUG_MODE", false),
    "should_ssl_verify" => env("IS_SSL_VERIFY", false),
    "http_timeout" => env("HTTP_TIMEOUT", 60),
    "user_cache_ttl" => 86400,

    'nationalities' => [
        '1' => ['en' => 'Bangladeshi', 'bn' => 'Bangladeshi'],
        '2' => ['en' => 'Indian', 'bn' => 'Indian'],
        '3' => ['en' => 'Pakistani', 'bn' => 'Pakistani'],
        '4' => ['en' => 'Nepali', 'bn' => 'Nepali'],
    ],
    'relationship_types' => [
        '1' => "Father",
        '2' => "Mother",
        '3' => "Uncle",
        '4' => "Aunt",
        '5' => "Other",
    ],
    'education_levels' => [
        1 => ['en' => 'PSC/5 Pass', 'bn' => 'PSC/5 Pass'],
        2 => ['en' => 'JSC/JDC/8 Pass', 'bn' => 'JSC/JDC/8 Pass'],
        3 => ['en' => 'Secondary', 'bn' => 'Secondary'],
        4 => ['en' => 'Higher Secondary', 'bn' => 'Higher Secondary'],
        5 => ['en' => 'Diploma', 'bn' => 'Diploma'],
        6 => ['en' => 'Bachelor/Honors', 'bn' => 'Bachelor/Honors'],
        7 => ['en' => 'Masters', 'bn' => 'Masters'],
        8 => ['en' => 'PhD', 'bn' => 'PhD'],
    ]
];
