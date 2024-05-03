<?php

namespace core;

class Config{


    protected $params;
    protected static $instance;

    public function __construct(){

        $config_files = scandir('config');
        $directory = 'config';
      
        foreach($config_files as $config_file)  {

                if(substr($config_file, -4) === '.php'){
                    $path =  $directory.'/'.$config_file;  
                    include($path);
                }
        }
        $this->params = [];
        
        foreach($Config as $config){
            foreach($config as $key => $value){
                $this->$key = $value;
            }
        
        }

       
    }

    public function __set($name,$value){
            $this->params[$name] = $value;
    }

    public function __get($name){
        return $this->params[$name];
    }

    public static function get(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }


}

?>