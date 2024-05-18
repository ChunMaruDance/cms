<?php

namespace models;

use core\Model;
use core\Core;  
/**
 * @property string $title,
 * @property string $description,
 * @property string $short_description,
 * @property string $date,
 * @property int $id,
 * @property double $price,
 */
class Accessory extends Model {

    // public $id;
    // public $title;
    // public $description;
    // public $short_description;
    // public $date;
    // public $price;

    public static $table = 'accessory';

    public function __construct(){
        
    }

    public static function findByCategories($category){
        $tableName = self::$table;
         return Core::get()->db->select(
            "{$tableName} a",
            'a.*', 
            [
                'JOIN category_accessory ca ON ca.accessory_id = a.id',
                'JOIN categories c ON c.id = ca.category_id'
            ], 
            [
                'c.title'=> $category
            ]
        );
    }

    public function save(){
        if(!isset($this->fieldsArray['id'])){
            var_dump('h2');
            Core::get()->db->insert(static::$table, $this->fieldsArray);
        }else{

            $id = $this->fieldsArray['id'];
            unset($this->fieldsArray['id']);

            Core::get()->db->update(static::$table, $this->fieldsArray,[
                static::$primaryKey => $id
            ]);
        }
      
    }


}


?>