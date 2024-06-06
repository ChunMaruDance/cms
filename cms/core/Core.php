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

    public $mailing;

    private function __construct(){
    
        $this->session = new Session();
        $this->mailing = new Mailing();
        session_start();

        $host = Config::get()->dbHost;
        $name = Config::get()->dbName;
        $login = Config::get()->dbLogin;
        $pass = Config::get()->dbPassword;
    
        $this->db = new DB($host, $name, $login, $pass);
        $this->template = new \core\Template($this->defaultLayoutPath);
        
        $basket = $this->session->get('basket', []);
        $basketItemCount = 0;
        foreach ($basket as $itemId => $quantity) {
            $basketItemCount += $quantity;
        }
        $this->template->setParam('basketItemCount', $basketItemCount);
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