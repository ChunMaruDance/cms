<?php

namespace models;

use core\Model;
use core\Core;  

class OrderItems extends Model {


    public static $table = 'order_items';

    public function __construct(){}

    public function save(){
        Core::get()->db->insert(static::$table, $this->fieldsArray);
    }


}


?>