<?php

require_once __DIR__ . '/../src/SourceInterface.php';
require_once __DIR__ . '/../src/MatomoAnalytics.php';
require_once __DIR__ . '/../src/OpenWebAnalytics.php';
require_once __DIR__ . '/../src/CloudflareAnalytics.php';
require_once __DIR__ . '/../src/SourceManager.php';
require_once __DIR__ . '/../src/Response.php';
require_once __DIR__ . '/../src/Router.php';

$router = new Router();

$router->add('/stats', function () {
    $sourceManager = new SourceManager();
    Response::json([
        "error" => false,
        "message" => "Aggregated statistics",
        "data" => $sourceManager->getAggregatedData()
    ]);
});

$router->dispatch($_SERVER['REQUEST_URI']);