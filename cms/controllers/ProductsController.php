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

    public function actionAddToBasket(){

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['accessory_id'])) {
          
            $accessoryId = $data['accessory_id'];
           
            $session = Core::get()->session;
            $basket = $session->get('basket', []);

            if (!isset($basket[$accessoryId])) {
                $basket[$accessoryId] = 1;
            } else {
                $basket[$accessoryId]++;
            }

            $session->set('basket', $basket);
            echo json_encode(["accessories" => $basket, "cartItemCount" => array_sum($basket)]);
        } else {
            echo json_encode(["error" => "No search query provided"]);
        }
        exit;

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

    public function actionSearchAccessory(){
        
        $data = json_decode(file_get_contents('php://input'), true);
        $searchQuery = $data['search_query'];
        $category = $data['category'];
     
        $accessories = AccessoryCategories::searchByCategoryAndTitle($category, $searchQuery);
        foreach ($accessories as $accessory) {
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
        }
        
        echo json_encode(["accessories" => $accessories]);
        exit;
    }


    public function actionOrder(){

        $basket = Core::get()->session->get('basket', []);
        $accessoriesAndCount =  [];

        if(empty($basket)){
            return $this->redirect('/');
        } 

        foreach ($basket as $accessoryId => $count) {

            $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
            if ($accessory) {
                $accessoriesAndCount[] = [
                    'accessory' => $accessory,
                    'count' => $count
                ];
            }
        } 
        return $this->render(null,['accesories'=>$accessoriesAndCount]);
    }


}

?>