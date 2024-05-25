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
        $categoryObj = Categories::findIdByTitle($cateogry);
        
        if($categoryObj == null){
            return $this->redirect('/');
        }
       
        $accessories = AccessoryCategories::getAccessoriesByCategoryId($categoryObj[0]->id);
        foreach ($accessories as $accessory) {
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
         }
      
        return $this->render(null,['accessories'=> $accessories,'category'=>$cateogry,'description'=>$categoryObj[0]->description]);
    }



}

?>