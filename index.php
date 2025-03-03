<?php

header('Content-Type: application/json');

$response = [
    "error" => false,
    "message" => "API is working",
    "data" => []
];

echo json_encode($response);