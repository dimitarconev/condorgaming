<?php

class Router {
    private array $routes = [];

    public function add(string $path, callable $callback): void {
        $this->routes[$path] = $callback;
    }

    public function dispatch(string $path): void {
        if (isset($this->routes[$path])) {
            call_user_func($this->routes[$path]);
        } else {
            Response::json(["error" => true, "message" => "Route not found"], 404);
        }
    }
}