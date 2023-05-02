<?php

namespace App\Kernel;

class Router
{
    private array $routes = [];

    /**
     * Adds a route to the routing table.
     *
     * @param string $route The URI route to add.
     * @param callable $function The function to call when this route is accessed.
     *
     * @return void
     */
    public function add(string $route, callable $function)
    {
        $this->routes[$route] = $function;
    }

    /**
     * Runs the router.
     *
     * This function checks the current URI against the routing table and calls the appropriate function.
     * If no matching route is found, it sends a 404 response.
     *
     * @return void
     */
    public function run()
    {
        // Get the current path
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Check if path exists
        if (isset($this->routes[$path])) {
            $this->routes[$path]();
        } else {
            // Тhe path does not exist, respond with "Not Found".
            Response::notFound();
        }
    }
}
