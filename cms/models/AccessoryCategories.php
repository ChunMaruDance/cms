<?php

namespace models;

use core\Model;
use core\Core; 

class AccessoryCategories extends Model {

    public static $table = 'category_accessory';

    public function __construct(){
        
    }

    static function getCategoryByAccessoryId($id){
        $categoryId = Categories::get
        Core::get()->db
    }


}

?>