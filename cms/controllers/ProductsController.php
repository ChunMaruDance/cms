<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

//models
use models\Accessory;
use models\AccessoryCategories;
use models\Categories;

class ProductsController extends Controller{

    public function actionAccessory($params){

        $id = $params[0];
        $accessory = Accessory::findById($id);
        $accessory->category = AccessoryCategories::getCategoryByAccessoryId($id);
        $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   

        return $this->render(null,['accessory'=>$accessory]);
    }

    public function actionIndex($params){
       return $this->render();
    }

    public function actionView($params){

        if(empty($params)){
            return $this->redirect('/');
        }

        $cateogry = $params[0];
        $categoryId = Categories::findIdByTitle($cateogry);
        
        if($categoryId == null){
            return $this->redirect('/');
        }

        $res = AccessoryCategories::getAccessoriesByCategoryId($categoryId);
        var_dump($res);
        die;
        return $this->render();
    }



}

?>