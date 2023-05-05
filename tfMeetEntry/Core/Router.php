<?php

//Set the namespace of the class
namespace Core;

class Router{
    //Create a protected array that stores the routes created within the program
    protected $routes = [];

    //Add to the routes array with the given method, uri, and controller
    public function add($method,$uri,$controller){
        $this->routes[] = compact('method','uri','controller');
    }
    //get, post, delete, patch, and put are functions to create paths for uris to their controller with a preset method
    //It is decided which to used based on the context of how the user access the page/file
    public function get($uri, $controller){
        $this->add("GET",$uri,$controller);
    }
    public function post($uri, $controller){
        $this->add("POST",$uri,$controller);
    }
    public function delete($uri, $controller){
        $this->add("DELETE",$uri,$controller);
    }
    public function patch($uri, $controller){
        $this->add("PATCH",$uri,$controller);
    }
    public function put($uri, $controller){
        $this->add("PUT",$uri,$controller);
    }
    //Send the user to the desired controller based on the given uri and method
    public function route($uri,$method){
        foreach($this->routes as $route){
            if($route['uri'] === $uri && $route['method'] === strtoupper($method)){
                return require base_path($route['controller']);
            }
        }
        $this->abort();
    }
    //This is the same abort function found in function.php
    //The program has run an issue, so set the error code, import the view page of the code, and kill the program
    protected function abort($code = 404) {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}

