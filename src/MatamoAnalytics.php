<?php

class MatomoAnalytics implements SourceInterface {
    private string $url = "https://your-matomo-domain.com";
    private string $siteId = "1";
    private string $token = "your-matomo-token"; // Replace with your actual token

    public function getData(): array {
        $endpoint = "{$this->url}/index.php?module=API&method=VisitsSummary.getVisits&idSite={$this->siteId}&period=month&date=today&format=json&token_auth={$this->token}";

        $response = $this->fetchData($endpoint);
        return ["Matomo" => $response ?? "Error fetching data"];
    }

    private function fetchData(string $url): ?int {
        try {
            $data = file_get_contents($url);
            $json = json_decode($data, true);
            return $json ?? null;
        } catch (Exception $e) {
            return null;
        }
    }
}