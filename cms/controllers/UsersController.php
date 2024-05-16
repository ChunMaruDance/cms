<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Users;
use models\Accessory;
use models\AccessoryImage;
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
        $accessories_images = AccessoryImage::getAll();
      
        $accessory_images_map = [];
        foreach ($accessories_images as $image) {
            $accessory_id = $image->accessory_id;
            if (!isset($accessory_images_map[$accessory_id])) {
                $accessory_images_map[$accessory_id] = [];
            }
            $accessory_images_map[$accessory_id][] = $image;
        }

        foreach ($accessories as $accessory) {
            $accessory_id = $accessory->id;
            if (isset($accessory_images_map[$accessory_id])) {
                $accessory->images = $accessory_images_map[$accessory_id];
            } else {
                $accessory->images = [];
            }
        }

        foreach ($accessories as $accessory) {
            foreach ($accessory->images as $image) {
                $image->image = 'data:image/png;base64,' . base64_encode($image->image);
            }
        }
        return $this->render(null,["accessories"=>  $accessories]);
     
    }

    public function actionDeleteAccessory(){
        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            $id = htmlspecialchars($data['accessory_id']);
              if(!empty($id)){
                  Accessory::deleteById($id);
                  AccessoryImage::deleteByCondition(['accessory_id' => $id]);
                  echo json_encode(["message" => "Delete Success"]);
                  exit;
              }
          }
    
    }

    public function actionAddAccessory(){
        if($this->isPost){
            if(is_null($this->post->name) || is_null($this->post->description) || is_null($this->post->short_description) || is_null($this->post->price)) {
                $this->setErrorMessage("All fields are required.");
            } else {

                if(empty($_FILES['image']['name'])) {
                    $this->setErrorMessage("Please select an image file.");
                }else{

                    if(!is_numeric($this->post->price)) {
                        $this->setErrorMessage("Price must be a numeric value.");
                    }else{
                         
                        $name = $this->post->name;
                        $description = $this->post->description;
                        $short_description = $this->post->short_description;
                        $price = $this->post->price;
                        
                        $accessory = new Accessory();
                        $accessory->title = $name;
                        $accessory->description = $description;
                        $accessory->short_description =  $short_description ;
                        $accessory->date = date('Y-m-d H:i:s'); 
                        $accessory->price = $price;
                        
                        $accessory->save();
                        
                        $accessory_id = Accessory::getIdByTitle($name);
                        $image_data = file_get_contents($_FILES['image']['tmp_name']);
                        
                        $accessoryImage = new AccessoryImage();
                        $accessoryImage->accessory_id = $accessory_id;
                        $accessoryImage->image = $image_data;

                        $accessoryImage->save();

                        return $this->redirect('/users/accessory');

                    }

                }

             
            }
        }else{
            $categories = Categories::getAll();

            return $this->render(null,['categories'=> $categories]);
        }

    
    }


}

?>



