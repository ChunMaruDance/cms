<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Users;
use models\Accessory;
use models\AccessoryCategories;
use models\Categories;

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
            
        return $this->render();
    }

    public function actionAccessory(){

        $accessories = Accessory::getAll();
        foreach ($accessories as $accessory) {
                $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
        }

        return $this->render(null,["accessories"=>  $accessories]);
     
    }

    public function actionDeleteAccessory(){
        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            $id = htmlspecialchars($data['accessory_id']);
              if(!empty($id)){
                  Accessory::deleteById($id);
                  AccessoryCategories::deleteByCondition(['accessory_id'=> $id]);
                  echo json_encode(["message" => "Delete Success"]);
                  exit;
              }
          }
    
    }

    private function validateFields() {
        $errors = [];
        
        if (is_null($this->post->name) || empty(trim($this->post->name))) {
            $errors[] = "Name is required.";
        }
        if (is_null($this->post->description) || empty(trim($this->post->description))) {
            $errors[] = "Description is required.";
        }
        if (is_null($this->post->short_description) || empty(trim($this->post->short_description))) {
            $errors[] = "Short description is required.";
        }
        if (is_null($this->post->price) || !is_numeric($this->post->price)) {
            $errors[] = "Price must be a numeric value.";
        }
        if (empty($_FILES['image']['name']) && empty($this->post->id)) {
            $errors[] = "Please select an image file.";
        }
    
        return $errors;
    }

    private function validateFieldsWithoutImage() {
        $errors = [];
        
        if (is_null($this->post->name) || empty(trim($this->post->name))) {
            $errors[] = "Name is required.";
        }
        if (is_null($this->post->description) || empty(trim($this->post->description))) {
            $errors[] = "Description is required.";
        }
        if (is_null($this->post->short_description) || empty(trim($this->post->short_description))) {
            $errors[] = "Short description is required.";
        }
        if (is_null($this->post->price) || !is_numeric($this->post->price)) {
            $errors[] = "Price must be a numeric value.";
        }
    
        return $errors;
    }


    private function updateAccessory($accessory) {
        
        $id = null;
        if(isset($accessory->id)){
            $id = $accessory->id;
        }

        // Отримання та встановлення даних
        $name = $this->post->name;
        $description = $this->post->description;
        $short_description = $this->post->short_description;
        $price = $this->post->price;
        $category = $this->post->category;
        
        $accessory->title = $name;
        $accessory->description = $description;
        $accessory->short_description = $short_description;
        $accessory->date = date('Y-m-d H:i:s');
        $accessory->price = $price;
    
        if (!empty($_FILES['image']['tmp_name'])) {
            $image_data = file_get_contents($_FILES['image']['tmp_name']);
            $accessory->image = $image_data;
        }

        $accessory->save();

        if ($id == null) {
         
            $AccessoryCategories = new AccessoryCategories();
            $AccessoryCategories->category_id = (Categories::findByCondition(['title' => $category]))[0]->id;
            $AccessoryCategories->accessory_id = (Accessory::getIdByTitle($name))[0]->id;
        
            $AccessoryCategories->saveModel();
        } 
      
    }

    public function actionAddAccessory($params){

        // Якщо є параметр id в URL
        if (!empty($params[0])) {
    
            if ($this->isPost) {
                $errors = $this->validateFieldsWithoutImage();
                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    $categories = Categories::getAll();
                    return $this->render(null, ['accessory' => $accessory, 'categories' => $categories]);
                }
                
                // Оновлення аксесуару
                $accessoryStd = Accessory::findById($params[0]);
                $accessory = new Accessory();
                $accessory->id = $accessoryStd->id;  
                $this->updateAccessory($accessory);
    
                return $this->redirect('/users/accessory');
            }
            
            // Завантаження існуючого аксесуара для редагування
            $accessory = Accessory::findById($params[0]);
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);
            $categories = Categories::getAll();
            $accessory->category = AccessoryCategories::getCategoryByAccessoryId($params[0]);
    
            return $this->render(null, ['accessory' => $accessory, 'categories' => $categories]);
        }
    
        // Якщо немає параметру id в URL, створюємо новий аксесуар
        if ($this->isPost) {
            // Валідація полів
            $errors = $this->validateFields();
            if (!empty($errors)) {
                $this->setErrorMessage(implode('<br>', $errors));
                $categories = Categories::getAll();
                return $this->render(null, ['categories' => $categories]);
            }
    
            // Створення нового аксесуара
            $accessory = new Accessory();
            $this->updateAccessory($accessory);
            return $this->redirect('/users/accessory');
        } else {
            $categories = Categories::getAll();
            return $this->render(null, ['categories' => $categories]);
        }
    }

}

?>



