<?php

class CloudflareAnalytics implements SourceInterface {
    private string $url = "https://api.cloudflare.com/client/v4/graphql";
    private string $zoneId = "your-cloudflare-zone-id"; // Replace with your actual Cloudflare Zone ID
    private string $apiKey = "your-cloudflare-api-key"; // Replace with your actual Cloudflare API Key
    private string $email = "your-email@example.com"; // Associated email for Cloudflare

    public function getData(): array {
        $query = json_encode([
            "query" => "query {
                viewer {
                    zones(filter: {zoneTag: \"{$this->zoneId}\"}) {
                        httpRequests1dGroups(limit: 1, filter: {date_geq: \"2024-03-01\"}) {
                            sum {
                                requests
                            }
                        }
                    }
                }
            }"
        ]);

        $response = $this->fetchData($query);
        return ["Cloudflare" => $response ?? "Error fetching data"];
    }

    private function fetchData(string $query): ?int {
        try {
            $opts = [
                "http" => [
                    "method" => "POST",
                    "header" => [
                        "Content-Type: application/json",
                        "X-Auth-Email: {$this->email}",
                        "X-Auth-Key: {$this->apiKey}"
                    ],
                    "content" => $query
                ]
            ];
            $context = stream_context_create($opts);
            $data = file_get_contents($this->url, false, $context);
            $json = json_decode($data, true);

            return $json["data"]["viewer"]["zones"][0]["httpRequests1dGroups"][0]["sum"]["requests"] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }
}