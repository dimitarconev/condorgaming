<?php

class OpenWebAnalytics implements SourceInterface {
    private string $url = "https://your-owa-domain.com";
    private string $siteId = "your-site-id";
    private string $apiKey = "your-owa-api-key"; // Replace with actual key

    public function getData(): array {
        $endpoint = "{$this->url}/api.php?method=visitors.getSummary&idSite={$this->siteId}&format=json&apiKey={$this->apiKey}";

        $response = $this->fetchData($endpoint);
        return ["OWA" => $response ?? "Error fetching data"];
    }

    private function fetchData(string $url): ?int {
        try {
            $data = file_get_contents($url);
            $json = json_decode($data, true);
            return $json["results"]["visits"] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }
}
