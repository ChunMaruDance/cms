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

    public static function findByOrderId($order_id){
        return self::findByCondition(['order_id'=>$order_id]);
    }

    public static function deleteByAccesoryIdAndGetOrdersIds($id){
      $orders = self::findByCondition(['accessory_id' => $id]);
      if($orders ==null){
        return [];
      }
      
      $orders_ids = [];
  
      foreach ($orders as $order) {
          $orders_ids[] = $order->order_id;
      }
      
      self::deleteByCondition(['accessory_id' => $id]);
      
      return $orders_ids;
    }

}


?>