<?php

namespace models;

use core\Model;
use core\Core; 

class AccessoryCategories extends Model {

    public static $table = 'category_accessory';

    public function __construct(){}

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
        $conditions = ['ca.category_id' => $categoryId];
    
        return self::findByConditionAndJoin($conditions, $joins);
    }

    public static function searchByCategoryAndTitle($category, $title, $minPrice, $maxPrice, $colors = [], $materials = []) {
        $db = Core::get()->db;
        $tableName = self::$table;
    
        // Початковий SQL запит
        $sql = "
        SELECT a.*
        FROM accessory a
        JOIN category_accessory ca ON ca.accessory_id = a.id
        JOIN categories c ON c.id = ca.category_id
        WHERE c.title = :category";
    
        // Умови фільтрації
        $conditions = [];
        $params = [':category' => $category];
    
        if ($title !== null) {
            $conditions[] = "a.title LIKE :title";
            $params[':title'] = '%' . $title . '%';
        }
    
        if ($minPrice !== null) {
            $conditions[] = "a.price >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }
    
        if ($maxPrice !== null) {
            $conditions[] = "a.price <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }
    
        // Умови для кольорів
        if (!empty($colors)) {
            $colorConditions = [];
            foreach ($colors as $i => $color) {
                $colorConditions[] = "a.color = :color_$i";
                $params[":color_$i"] = $color;
            }
            $conditions[] = '(' . implode(' OR ', $colorConditions) . ')';
        }
    
        // Умови для матеріалів
        if (!empty($materials)) {
            $materialConditions = [];
            foreach ($materials as $i => $material) {
                $materialConditions[] = "a.material = :material_$i";
                $params[":material_$i"] = $material;
            }
            $conditions[] = '(' . implode(' OR ', $materialConditions) . ')';
        }
    
        // Додаємо умови в запит
        if (!empty($conditions)) {
            $sql .= ' AND (' . implode(' AND ', $conditions) . ')';
        }
    
        $sth = $db->pdo->prepare($sql);
    
        foreach ($params as $key => $value) {
            $sth->bindValue($key, $value);
        }
    
        $sth->execute();
    
        return $sth->fetchAll();
    }
    
       
    


}

?>