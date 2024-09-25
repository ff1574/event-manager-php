<?php

final class Router {

    // Default controller to use if no controller is specified in the URL.
    private $controller = "UserController";
    // Default action to use if no action is specified in the URL.
    private $action = "login";
    // Array to hold parameters extracted from the URL.
    private $params = [];

    /**
     * Dispatches the incoming request. This method works with query parameters to
     * determine the controller and action, then instantiates the controller and
     * calls the action method with any parameters.
     *
     * @param string $controller The query parameter that identifies the controller
     * @param string $action The query parameter that identifies the action
     * @throws Exception If the controller class or action method is not found.
     */
    public function dispatch($controller, $action) {
        // Check if 'controller' and 'action' parameters consist of only lowercase letters
        if (preg_match("/^[a-z]+$/", $controller) && preg_match("/^[a-z]+$/", $action)) {
            // Capitalize the first letter of the 'controller' parameter and
            // append 'Controller' to form the class name
            // Example: if 'controller' is 'user', the resulting class will be 'UserController'
            $this->controller = ucfirst($controller) . 'Controller';
            // Assign the 'action' parameter to the $action property (e.g., 'login' or 'welcome')
            $this->action = $action;
        }
        // Check if the specified controller class exists
        if (class_exists($this->controller)) {
            // Instantiate the controller class
            // (e.g. creating a new instance of 'UserController')
            $controllerObj = new $this->controller();
            // Check if the specified action method exists & is callable within the controller
            if (is_callable([$controllerObj, $this->action])) {
                // Call the method on the controller object, passing any parameters ($params)
                $controllerObj->{$this->action}($this->params);
            } else {
                // Throw an exception if the specified method is not found in the controller
                throw new Exception("Method '$action' in controller '$controller' not found");
            }
        } else {
            // Throw an exception if the controller class is not found
            throw new Exception("Controller class '$controller' not found");
        }
    }
}
