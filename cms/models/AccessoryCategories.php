<?php

namespace models;

use core\Model;
use core\Core; 

class AccessoryCategories extends Model {

    public static $table = 'category_accessory';

    public function __construct(){
        
    }

    function saveModel(){
        Core::get()->db->insert(static::$table, $this->fieldsArray);
    }

    static function getCategoryByAccessoryId($id){

        $categoryId = Core::get()->db->selectOne(self::$table,'*',[],['accessory_id' => $id]);
        
        $category = Categories::findById($categoryId->category_id); 
        return $category->title;
    }


}

?>