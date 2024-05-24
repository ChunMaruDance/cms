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
use models\MainBanner;

//validators
use utils\AccessoryValidator;
use utils\CategoryValidator;
use utils\BannerItemValidator;

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


    public function checkIsUserLoggin(){
        if(!Users::isUserLogged()){
            return $this->redirect('/');
            exit;
        }
    }


    public function actionLogout(){
        Users::userLogout();
        return $this->redirect('/users/login');
    }


    public function actionDashboard(){

        $this->checkIsUserLoggin();
            
        return $this->render();
    }


    public function actionAccessories(){

        $this->checkIsUserLoggin();

        $accessories = Accessory::getAll();
        foreach ($accessories as $accessory) {
                $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
        }
        return $this->render(null,["accessories"=>  $accessories]);
     
    }


    public function actionRenderBanner(){
        
        $this->checkIsUserLoggin();

        $bannerItems = MainBanner::getAllWithEncodeImage();
        return $this->render(null,['bannerItems' => $bannerItems]);
    }


    public function actionDeleteBannerItem(){

        $this->checkIsUserLoggin();
        
        return $this->redirect('/');
    } 


    public function actionCreateBannerItem(){

        $this->checkIsUserLoggin();

        $errors = BannerItemValidator::validateFields($this->post,$_FILES);
        
        if (!empty($errors)) {
            $this->setErrorMessage($errors);
            return $this->render('views/users/renderBanner.php');
        }

        // model
        $bannerItem = new MainBanner();
        $bannerItem->link = $this->post->link;
        $bannerItem->image =  file_get_contents($_FILES['image']['tmp_name']);

        $bannerItem->save();
        
        return $this->redirect('/users/renderBanner');

    } 


    public function actionDeleteAccessory(){
      
        $this->checkIsUserLoggin();

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


    public function actionDeleteCategory(){
       
        $this->checkIsUserLoggin();

        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            $id = htmlspecialchars($data['category_id']);
              if(!empty($id)){
                Categories::deleteById($id);
                  AccessoryCategories::deleteByCondition(['category_id'=> $id]);
                  echo json_encode(["message" => "Delete Success"]);
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
    
            // Перевіряємо, чи надіслана форма
            if ($this->isPost) {

                $errors = CategoryValidator::validateFieldsWithoutImage($this->post);
    
                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    return $this->render(null, ['category' => $category]);
                }
                
                $category = new Categories();
                $category->id = $params[0];
                // Оновлюємо дані категорії
                $category->title = $this->post->name;
                $category->description = $this->post->description;
    
                // Перевіряємо, чи було вибрано нове зображення
                if (!empty($_FILES['image']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image']['tmp_name']);
                    $category->image = $image_data;
                }
    
                // Зберігаємо зміни
                $category->save();
    
                return $this->redirect('/users/categories');
            } else {
                
                $categoryStd->image ='data:image/png;base64,' . base64_encode($categoryStd->image);  
                return $this->render(null, ['category' => $categoryStd]);
            }
        } else {
            // Якщо не передано параметр id, це створення нової категорії
            if ($this->isPost) {
               
                //todo
                $errors = CategoryValidator::validateFields($this->post,$_FILES);

                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    return $this->render();
                }
    
                // Створюємо нову категорію
                $category = new Categories();
                $category->title = $this->post->name;
                $category->description = $this->post->description;
    
                // Зберігаємо зображення, якщо воно було вибрано
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

            echo json_encode(["accessories" => $accessories]);
        } else {
            echo json_encode(["error" => "No search query provided"]);
        }
        exit;
      
        echo json_encode(["message" => $data]);
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
        // Якщо є параметр id в URL
        if (!empty($params[0])) {
    
            if ($this->isPost) {
               $errors = AccessoryValidator::validateFieldsWithoutImage($this->post);
                
                if (!empty($errors)) {
                    $this->setErrorMessage(implode('<br>', $errors));
                    $categories = Categories::getAll();
                    return $this->render(null, ['accessory' =>  Core::get()->session->get('accessory'), 'categories' => $categories]);
                }
                         
                // Оновлення аксесуару
                $accessoryStd = Accessory::findById($params[0]);
                $accessory = new Accessory();
                $accessory->id = $accessoryStd->id;  
                $this->updateAccessory($accessory);
    
                return $this->redirect('/users/accessories');
            }
            
            // Завантаження існуючого аксесуара для редагування
            $accessory = Accessory::findById($params[0]);
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);
            $categories = Categories::getAll();
            $accessory->category = AccessoryCategories::getCategoryByAccessoryId($params[0]);
            
            if($accessory->category === null){
                $accessory->category = 'none';
            }

            Core::get()->session->set('accessory', $accessory);
            return $this->render(null, ['accessory' => $accessory, 'categories' => $categories]);
        }
    
        // Якщо немає параметру id в URL, створюємо новий аксесуар
        if ($this->isPost) {
          
            $errors = AccessoryValidator::validateFields($this->post,$_FILES);

            if (!empty($errors)) {
                $this->setErrorMessage(implode('<br>', $errors));
                $categories = Categories::getAll();
                return $this->render(null, ['categories' => $categories]);
            }
    
            // Створення нового аксесуара
            $accessory = new Accessory();
            $this->updateAccessory($accessory);
            return $this->redirect('/users/accessories');
        } else {
            $categories = Categories::getAll();
            return $this->render(null, ['categories' => $categories]);
        }
    }

}

?>



