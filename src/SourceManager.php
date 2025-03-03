<?php

class SourceManager {
    private array $sources = [];

    public function __construct() {
        $this->sources = [
            new MatomoAnalytics(),
            new OpenWebAnalytics(),
            new CloudflareAnalytics()
        ];
    }

    public function getAggregatedData(): array {
        $result = [];
        foreach ($this->sources as $source) {
            try {
                $result = array_merge($result, $source->getData());
            } catch (Exception $e) {
                $result[get_class($source)] = "Error retrieving data";
            }
        }
        return $result;
    }
}