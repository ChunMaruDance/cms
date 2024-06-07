<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

//models
use models\Users;
use models\Accessory;
use models\AccessoryCategories;
use models\Categories;
use models\OrderItems;
use models\Orders;

//validators
use utils\AccessoryValidator;
use utils\CategoryValidator;

class UsersController extends Controller {
  
    public function actionLogin($params){

        if(Users::isUserLogged()){
            return $this->redirect('/users/dashboard');
        }else{
            if($this->isPost){
                $user = Users::fingByLoginAndPassword($this->post->login,$this->post->password);
              if(!empty($user)){
              Users::userLogin($user);
              return $this->redirect('/users/dashboard');
                } else{
                     $this->setErrorMessage('Uncorect Login');
                }
             
            }
          
           return $this->render();
        }
      
    }
    

    public function actionLogout(){
        Users::userLogout();
        return $this->redirect('/users/login');
    }


    public function actionDashboard(){

        $this->checkIsUserLoggin();

        $configFile = 'files/mainPageConfig.json';
        $config = json_decode(file_get_contents($configFile), true);
            
        return $this->render(null,['config'=>$config]);
    }


    public function actionAccessories(){

        $this->checkIsUserLoggin();

        $accessories = Accessory::getAll();
        foreach ($accessories as $accessory) {
                $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
        }

        return $this->render(null,["accessories"=>  $accessories]);
     
    }


    public function actionDeleteAccessory(){
      
        $this->checkIsUserLoggin();

        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            $id = htmlspecialchars($data['accessory_id']);
              if(!empty($id)){
                  
                Accessory::deleteById($id);
                AccessoryCategories::deleteByCondition(['accessory_id'=> $id]);

                // $ordersIds = OrderItems::deleteByAccesoryIdAndGetOrdersIds($id);
                // foreach($ordersIds as $orderId){
                // $orderStd = Orders::findById($orderId);
                // $order = new Orders();

                // foreach($orderStd as $key => $value){
                //     $order->$key = $value;
                // }
                // $order->canceled = true;
                // $order->update();
                // }
                  http_response_code(200);
                  echo json_encode(["message" => "Delete Success"]);
                  exit;
              }
          }
    
    }


    public function actionDeleteCategory(){
       
        $this->checkIsUserLoggin();

        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            $id = htmlspecialchars($data['category_id']);
              if(!empty($id)){
                Categories::deleteById($id);
                  AccessoryCategories::deleteByCondition(['category_id'=> $id]);
                  http_response_code(200);
                  echo json_encode(["message" => "Delete Success"]);
                  exit;
              }else{
                http_response_code(400);
                echo json_encode(["message" => "Error, Category not removed"]);
                exit;
              }
          }
    }


    public function actionCategories(){

        $this->checkIsUserLoggin();

        $categories = Categories::getAllWithEncodeImage();
        return $this->render(null,["categories"=>  $categories]);
    }


    public function actionAddCategory($params){

        $this->checkIsUserLoggin();

        if (!empty($params[0])) {
            $categoryStd = Categories::findById($params[0]);
            if (!$categoryStd) {
                $this->setErrorMessage("Category with ID {$params[0]} not found.");
                return $this->redirect('/users/categories');
            }
    
            if ($this->isPost) {

                $errors = CategoryValidator::validateFieldsWithoutImage($this->post);
    
                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    return $this->render(null, ['category' => $category]);
                }
                
                $category = new Categories();
                $category->id = $params[0];
             
                $category->title = $this->post->name;
                $category->description = $this->post->description;
    
                if (!empty($_FILES['image']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image']['tmp_name']);
                    $category->image = $image_data;
                }
    
             
                $category->save();
    
                return $this->redirect('/users/categories');
            } else {
                
                $categoryStd->image ='data:image/png;base64,' . base64_encode($categoryStd->image);  
                return $this->render(null, ['category' => $categoryStd]);
            }
        } else {
            if ($this->isPost) {
               
                $errors = CategoryValidator::validateFields($this->post,$_FILES);

                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    return $this->render();
                }
    
                $category = new Categories();
                $category->title = $this->post->name;
                $category->description = $this->post->description;
    
                if (!empty($_FILES['image']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image']['tmp_name']);
                    $category->image = $image_data;
                }
    
                $category->save();
    
                return $this->redirect('/users/categories');
            } else {
                return $this->render();
            }
        }
    }


    public function actionSearchAccessory(){

        $this->checkIsUserLoggin();

        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['search_query'])) {
            $searchQuery = $data['search_query'];
            
            $accessories = Accessory::searchByTitle($searchQuery);
    
            foreach ($accessories as $accessory) {
                $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
            }
            http_response_code(200);
            echo json_encode(["accessories" => $accessories]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "No search query provided"]);
        }
        exit;
    }


    private function updateAccessory($accessory) {

      
        $this->checkIsUserLoggin();
        
        $id = null;
        if(isset($accessory->id)){
            $id = $accessory->id;
        }
      
        $name = $this->post->name;
        $description = $this->post->description;
        $short_description = $this->post->short_description;
        $price = $this->post->price;
        $category = $this->post->category;
        $manufacturer = $this->post->manufacturer;
        $sizes = $this->post->sizes;
        $color = $this->post->color;
        $material = $this->post->material;
        $quantity = $this->post->quantity;

        $accessory->title = $name;
        $accessory->description = $description;
        $accessory->short_description = $short_description;
        $accessory->date = date('Y-m-d H:i:s');
        $accessory->price = $price;
        $accessory->manufacturer = $manufacturer;
        $accessory->sizes = $sizes;
        $accessory->color = $color;
        $accessory->material = $material;
        $accessory->quantity = $quantity;
    
        if (!empty($_FILES['image']['tmp_name'])) {
            $image_data = file_get_contents($_FILES['image']['tmp_name']);
            $accessory->image = $image_data;
        }

        $accessory->save();
    
        $AccessoryCategories = new AccessoryCategories();
        $AccessoryCategories->category_id = (Categories::findByCondition(['title' => $category]))[0]->id;
        if ($id == null || Core::get()->session->get('accessory')->category === 'none') {
            $AccessoryCategories->accessory_id = (Accessory::getIdByTitle($name))[0]->id;
            $AccessoryCategories->saveModel();
        }else{
            $AccessoryCategories->accessory_id = $id;
            
            $AccessoryCategories->updateModel();
        }
 
    }


    public function actionAddAccessory($params){

        $this->checkIsUserLoggin();
        $categories = Categories::getAll();
        $colors = json_decode(file_get_contents("files/colors.json"), true);
        $materials = json_decode(file_get_contents("files/materials.json"), true);

        if (!empty($params[0])) {
    
            if ($this->isPost) {
               $errors = AccessoryValidator::validateFieldsWithoutImage($this->post);
                
                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    return $this->render(null, ['accessory' =>  Core::get()->session->get('accessory'), 'materials'=>$materials,'colors'=>$colors,'categories' => $categories]);
                }
                         
                $accessoryStd = Accessory::findById($params[0]);
                $accessory = new Accessory();
                $accessory->id = $accessoryStd->id;  
                $this->updateAccessory($accessory);
    
                return $this->redirect('/users/accessories');
            }
            
            $accessory = Accessory::findById($params[0]);
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);
            $accessory->category = AccessoryCategories::getCategoryByAccessoryId($params[0]);
            
            if($accessory->category === null){
                $accessory->category = 'none';
            }

            Core::get()->session->set('accessory', $accessory);
            return $this->render(null, ['accessory' => $accessory, 'materials'=>$materials,'colors'=>$colors,'categories' => $categories]);
        }
    
        if ($this->isPost) {
          
            $errors = AccessoryValidator::validateFields($this->post,$_FILES);

            if (!empty($errors)) {
                $this->setErrorMessage(implode('<br>', $errors));
                return $this->render(null, ['categories' => $categories,'materials' => $materials,'colors' => $colors]);
            }
    
            $accessory = new Accessory();
            $this->updateAccessory($accessory);
            return $this->redirect('/users/accessories');
        } else {
            return $this->render(null, ['categories' => $categories,'materials'=>$materials, 'colors'=>$colors]);
        }
    }

}

?>



