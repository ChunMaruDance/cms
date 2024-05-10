<?php


namespace core;

class Model {

    protected $fieldsArray;
    protected static $primaryKey  = 'id';
    public static $table = 'accessory';

    public function __construct() {
        $this->fieldsArray = [];
    }

    public function __set($name, $value){
        $this->fieldsArray[$name] = $value;
    }

    public function __get($name){
        return $this->fieldsArray[$name];
    }

    public function save(){
        $val = $this->{static::$primaryKey};
        if(empty($val)){
            //insert
            Core::get()->db->insert(static::$table, $this->fieldsArray);
        }else{
            //update
            Core::get()->db->update(static::$table, $this->fieldsArray,[
                static::$primaryKey=> $this->{static::$primaryKey}
            ]);
        }
    
    }

    public static function deleteById($id){
        Core::get()->db->delete(static::$table,[static::$primaryKey => $id]);
    }

    public static function deleteByCondition($conditiobArray){
        Core::get()->db->delete(static::$table,$conditiobArray);
    }

    public static function findByCondition($conditiobArray){
        $arr = Core::get()->db->select(static::$table,'*',[],$conditiobArray);
        if(count($arr) > 0){
            return $arr;
        }else{
            return null;
        }
    }

    public static function findById($id){
        $arr = Core::get()->db->select(static::$table,'*',[],[static::$primaryKey => $id]);
        
        if(count($arr)){
            return $arr[0];
        }else{
            return null;
        }

    }




}



?>