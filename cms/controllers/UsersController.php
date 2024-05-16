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
                  AccessoryCategories::deleteByCondition(['accessory_id'=>$id]);
                  echo json_encode(["message" => "Delete Success"]);
                  exit;
              }
          }
    
    }

    public function actionAddAccessory(){
        if($this->isPost){
            if(is_null($this->post->name) || is_null($this->post->name) || is_null($this->post->description) || is_null($this->post->short_description) || is_null($this->post->price)) {
                $this->setErrorMessage("All fields are required.");
                return $this->render();
            } else {
              
                if(empty($_FILES['image']['name'])) {
                    $this->setErrorMessage("Please select an image file.");
                    return $this->render();
                }else{

                    if(!is_numeric($this->post->price)) {
                        $this->setErrorMessage("Price must be a numeric value.");
                    }else{
                        
                        //data
                        $name = $this->post->name;
                        $description = $this->post->description;
                        $short_description = $this->post->short_description;
                        $price = $this->post->price;
                        $category = $this->post->category;

                        //accessy model
                        $accessory = new Accessory();
                        $accessory->title = $name;
                        $accessory->description = $description;
                        $accessory->short_description =  $short_description ;
                        $accessory->date = date('Y-m-d H:i:s'); 
                        $accessory->price = $price;

                        $image_data = file_get_contents($_FILES['image']['tmp_name']);

                        $accessory->image = $image_data;
                        
                        $accessory->save();
                        
                        // 
                        $AccessoryCategories = new AccessoryCategories();

                        $AccessoryCategories->category_id = (Categories::findByCondition(['title'=>$category]))[0]->id;
                        $AccessoryCategories->accessory_id = (Accessory::getIdByTitle($name))[0]->id;
                       
                        $AccessoryCategories->save();

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



