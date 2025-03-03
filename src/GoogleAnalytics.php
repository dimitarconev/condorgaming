<?php

class GoogleAnalytics implements SourceInterface {
    public function getData(): array {
        return ["Google Analytics" => rand(100, 500)];
    }
}