<?php


namespace core;

class Model {

    protected $fieldsArray;
    protected static $primaryKey = 'id';
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

    public function __isset($name) {
        return isset($this->fieldsArray[$name]);
    }
    
    public function save(){
        $key = $this->{static::$primaryKey};
        if(empty($key)){
            //insert
            Core::get()->db->insert(static::$table, $this->fieldsArray);
        }else{
            //update
            Core::get()->db->update(static::$table, $this->fieldsArray,[
                static::$primaryKey=> $this->{static::$primaryKey}
            ]);
        }
    
    }
    public static function getIdByTitle($title){
        return Core::get()->db->select(static::$table,'id',[],['title'=>$title]);
    }
    public static function getAll(){
        return Core::get()->db->select(static::$table,'*',[],null);
    }

    public static function deleteById($id){
        Core::get()->db->delete(static::$table,[static::$primaryKey => $id]);
    }

    public static function deleteByCondition($conditiobArray){
        Core::get()->db->delete(static::$table,$conditiobArray);
    }

    public static function findByConditionAndJoin($conditionArray,$joins){

        $conditions = [];
        foreach ($conditionArray as $column => $value) {
            $conditions[] = "$column = :$column";
        }

        $whereClause = implode(" AND ", $conditions);
        $joinsQuery = implode(" ", $joins);
    
        $results = Core::get()->db->select(
            'accessory a',
            'a.*',
            $joins,
            $conditionArray
        );
    
        return $results;
    }

    public static function findByCondition($conditionArray){
        $arr = Core::get()->db->select(static::$table,'*',[],$conditionArray);
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

    public static function searchByTitle($title){
        $sql = "SELECT * FROM " . static::$table . " WHERE title LIKE :title";
        $sth = Core::get()->db->pdo->prepare($sql);
        $sth->bindValue(':title', $title . '%', \PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }


}


?>