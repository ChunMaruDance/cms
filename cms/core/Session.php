<?php

namespace core;

class Session {

    public function set($name, $value){
        $_SESSION[$name] = $value;
    }

    public function get($name){
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    public function remove($name){
        if(empty($_SESSION[$name])){
            return null;
        }
        unset($_SESSION[$name]);
    }


}



?>