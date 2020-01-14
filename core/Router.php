<?php

class Router
{
    public $routes = [];

    /**
     * Initializes the defined Routes
     * in the file routes.php
     *
     * @param $routes
     */
    public function define($routes)
    {
        $this->routes = $routes;
    }

    /**
     * Searched to a passed URI ($uri) the
     * Path to the Controller
     *
     * @param $uri
     * @return mixed
     */
    public function parse($uri)
    {
        if (array_key_exists($uri, $this->routes)) {
            return $this->routes[$uri];
        }

        http_response_code(404);
        die('Page not found!<a href="javascript:history.back()">Back</a>');
    }

}
