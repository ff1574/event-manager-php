<?php

class Controller {

    public function model() {
        $model = str_replace("Controller", "Model", get_class($this));
        require_once 'app/model/' . $model . '.php';
        return new $model();
    }

    public function view($template, $data = []) {
        if (!file_exists('app/view/' . $template . '.php')) {
            throw new Exception("Template file " . $template . " doesn't exist.");
        }
        require 'app/view/inc/header.php';
        require 'app/view/' . $template . '.php';
        require 'app/view/inc/footer.php';
    }
}