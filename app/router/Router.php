<?php

final class Router
{
    private $controller = "UserController";
    private $action = "login";
    private $params = [];

    public function dispatch($controller, $action, $params = [])
    {
        // Update the controller and action only if provided
        if (!empty($controller) && preg_match("/^[a-z]+$/", $controller)) {
            $this->controller = ucfirst($controller) . 'Controller';
        }

        if (!empty($action) && preg_match("/^[a-zA-Z]+$/", $action)) {
            $this->action = $action;
        }

        // Get the rest of the parameters, if any
        if (!empty($params)) {
            $this->params = $params;
        }

        // Check if the specified controller class exists
        if (class_exists($this->controller)) {
            $controllerObj = new $this->controller();

            // Handle the "index" action explicitly for admin controllers
            if (strtolower($controller) === 'admin' && strtolower($action) === 'index' && !empty($this->params)) {
                // The third element in the URL is the actual action, e.g., deleteEvent
                $actualAction = $this->params[0] ?? null;
                $entityId = $this->params[1] ?? null;

                if (!empty($actualAction) && is_callable([$controllerObj, $actualAction])) {
                    $controllerObj->{$actualAction}([$entityId]);
                    return;
                }
            }

            // Handle the default or specific action
            if (is_callable([$controllerObj, $this->action])) {
                $controllerObj->{$this->action}($this->params);
            } else {
                throw new Exception("Method '$action' in controller '$controller' not found");
            }
        } else {
            throw new Exception("Controller class '$controller' not found");
        }
    }
}
