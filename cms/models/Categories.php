<?php

namespace models;

use core\Model;
use core\Core;

class Categories extends Model {

    public static $table = 'categories';

    public function __construct(){}

    public function save(){
        if(!isset($this->fieldsArray['id'])){
            Core::get()->db->insert(static::$table, $this->fieldsArray);
        }else{

            $id = $this->fieldsArray['id'];
            unset($this->fieldsArray['id']);
            Core::get()->db->update(static::$table, $this->fieldsArray,[
                static::$primaryKey => $id
            ]);
        }
      
    }
    
    public static function findIdByTitle($title){
      return self::findByCondition(['title' => $title])[0]->id;
    } 

    public static function getAllWithEncodeImage(){
        $categories = self::getAll();
        foreach ($categories as $category) {
            $category->image = 'data:image/png;base64,' . base64_encode($category->image);   
         }
         return $categories;
    } 


}

?>