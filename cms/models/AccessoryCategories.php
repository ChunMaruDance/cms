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

    function updateModel(){
        $where = [
            'accessory_id' => $this->accessory_id
        ];
        Core::get()->db->update(self::$table, $this->fieldsArray, $where);
    }

    static function getCategoryByAccessoryId($id){
        $categoryId = Core::get()->db->selectOne(self::$table,'*',[],['accessory_id' => $id]);
        
        if(!$categoryId){
            return null;
        }

        $category = Categories::findById($categoryId->category_id); 
        return $category->title;
    }


    static function getAccessoriesByCategoryId($categoryId){
        $joins = ['JOIN category_accessory ca ON ca.accessory_id = a.id'];
        $conditionArray = ['ca.category_id' => $categoryId];
    
        return self::findByConditionAndJoin($conditionArray, $joins);
    }


}

?>