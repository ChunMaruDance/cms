<?php

namespace models;

use core\Model;
use core\Core;  

class Orders extends Model {

    // public $id;
    // public $order_number;
    // public $user_email;
    // public $user_name;
    // public $user_phone;
    // public $payment_method;
    // public $post_office;
    // public $total_amount;

    public static $table = 'orders';

    public function __construct(){}

    public static function getOrderIdByOrderNumber($order_number){
     return self::findByCondition(['order_number'=>$order_number])[0]->id;
    }

    public static function searchByOrderNumber($order_number){
        return self::findByCondition(['order_number'=>$order_number]);
    }

    public function save(){
        Core::get()->db->insert(static::$table, $this->fieldsArray);
    }

    public function update(){
        Core::get()->db->update(static::$table, $this->fieldsArray,[
            static::$primaryKey => $this->{static::$primaryKey}
        ]);
    }

}

?>