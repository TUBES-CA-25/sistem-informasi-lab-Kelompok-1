<?php
/**
 * ICLABS - Router Class
 * Handles routing and request dispatching
 */

class Router {
    private $routes = [];
    private $params = [];
    
    /**
     * Add GET route
     */
    public function get($uri, $controller) {
        $this->addRoute('GET', $uri, $controller);
    }
    
    /**
     * Add POST route
     */
    public function post($uri, $controller) {
        $this->addRoute('POST', $uri, $controller);
    }
    
    /**
     * Add route to routes array
     */
    private function addRoute($method, $uri, $controller) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }
    
    /**
     * Dispatch request to controller
     */
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $this->getRequestUri();
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            if ($this->matchRoute($route['uri'], $requestUri)) {
                return $this->callController($route['controller']);
            }
        }
        
        // 404 Not Found
        $this->notFound();
    }
    
    /**
     * Get request URI
     */
    private function getRequestUri() {
        $uri = $_GET['url'] ?? '/';
        $uri = '/' . trim($uri, '/');
        
        // Remove query string
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        
        return $uri;
    }
    
    /**
     * Match route pattern with URI
     */
    private function matchRoute($pattern, $uri) {
        // Convert :param to regex
        $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $uri, $matches)) {
            // Extract parameters
            $this->params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }
        
        return false;
    }
    
    /**
     * Call controller method
     */
    private function callController($controllerString) {
        list($controllerName, $method) = explode('@', $controllerString);
        
        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            die("Controller not found: $controllerName");
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerName)) {
            die("Controller class not found: $controllerName");
        }
        
        $controller = new $controllerName();
        
        if (!method_exists($controller, $method)) {
            die("Method not found: $method in $controllerName");
        }
        
        // Call method with params
        call_user_func_array([$controller, $method], $this->params);
    }
    
    /**
     * 404 Not Found
     */
    private function notFound() {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        exit;
    }
}
