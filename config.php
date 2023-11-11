<?php

return [
    "app" => [
        "url" => $_ENV["APP_URL"]
    ],
    "database" => [
        'DB_HOST' => $_ENV["DB_HOST"],
        "DB_NAME" => $_ENV["DB_NAME"],
        "DB_USERNAME" => $_ENV["DB_USERNAME"],
        "DB_PASSWORD" => $_ENV["DB_PASSWORD"],
    ]
];
