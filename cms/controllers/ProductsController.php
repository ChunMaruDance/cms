<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Accessory;
use models\AccessoryCategories;

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
           return $this->render();
    }


}

?>