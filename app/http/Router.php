<?php

namespace App\Http;

use \Closure;
use \Exception;
use Reflection;
use  \ReflectionFunction;

class Router{
    private $url = '';

    private $prefix = '';

    private $routes = [];

    private $request = [];

    public function __construct($url)
    {
        $this->request = new Request($this);
        $this->url = $url;        
        $this->setPrefix();
    }
    private function setPrefix()
    {
      
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';     
         
    }

    private function addRoute($method, $route, $params = [])
    {

        foreach ($params as $key=>$value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        } 
        $params['variables'] =[];

        $patternVariable = '/{(.*?)}/';
         

        if(preg_match_all($patternVariable,$route,$matches)){

           
        $route = preg_replace($patternVariable,'(.*?)', $route);

        
        $params['variables'] = $matches[1];
        }
       
      
        $patternRoute = '/^' .str_replace('/', '\/', $route). '$/';     
        
      
        $this->routes[$patternRoute][$method] = $params;  
        
    }
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    private function getUri()
    {
        $uri = $this->request->getUri();

        $xUri = strlen($this->prefix)? explode($this->prefix, $uri):[$uri];  
       
        return end($xUri);       
    }
    private function getRoute()
    {
        $uri = $this->getUri();


        $httpMethod = $this->request->getHttpMethod();
        // echo '<pre>';
        // print_r($uri);
        // exit;
        

        foreach ($this->routes as $patternRoute=>$methods) {
         
            if (preg_match($patternRoute, $uri, $matches)) {
            if (isset($methods[$httpMethod])) {
            
                unset($matches[0]);
                $keys = $methods[$httpMethod]['variables'];
                $methods[$httpMethod]['variables']= array_combine($keys, $matches);
                $methods[$httpMethod]['variables']['request'] = $this->request; 
           
                return $methods[$httpMethod];
            }           
            throw new Exception('Metodo não permitido', 405);

            }
          
        }
        throw new Exception('Url não encontrada', 404);
    }

    public function run()
    {
        try {
           
            //Obtem a rota atual
            $route = $this->getRoute();

        
         
            if (!isset($route['controller'])) {               
             
                throw  new Exception('A url não pode ser processada', 500);  
            }   
           
            $args=[];

            $refleciton = new ReflectionFunction($route['controller']);

           
            foreach($refleciton->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name]?? '';
            }
            return call_user_func_array($route['controller'], $args);
          
            throw new Exception("Página não encontrada", 1);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }


}