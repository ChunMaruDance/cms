<?php

namespace core;

class Core{

    public $defaultLayoutPath  = 'views/layouts/index.php';

    public $moduleName;
    public $actionName;
    public $router;

    public $template;
    private static $instance;

    public $db;
    public $session;

    private function __construct(){
    
        $this->session = new Session();

        $this->template = new \core\Template($this->defaultLayoutPath);
        
        $host = Config::get()->dbHost;
        $name = Config::get()->dbName;
        $login = Config::get()->dbLogin;
        $pass = Config::get()->dbPassword;
        
        $this->db = new DB($host, $name, $login, $pass);
        session_start();
    }

    public function run($route){
      $this->router = new \core\Router($route);
      $params = $this->router->run();
      if(!empty($params)){
        $this->template->setParams($params);
      }
    
    }

    public function done(){
        $this->template->display();   
    }

    public static function get(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }


}


?>