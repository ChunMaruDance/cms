<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Users;
use models\Accessory;
use models\AccessoryImage;

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
        return $this->render(null,['accessories' => $accessories]);
    }

    public function actionDeleteAccessory(){
        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            $id = htmlspecialchars($data['accessory_id']);
              if(!empty($id)){
                  Accessory::deleteById($id);
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
                        
                        // $accessory_image = new AccessoryImage();
                        
                        // $accessory_image->accessory_id = $accessory_id;
                        // $accessory_image->image = $image_data;

                        // $accessory_image->save();

                        Core::get()->db->insertWithBlob('accessory_image', [
                            'accessory_id' => $accessory_id,
                            'image' => $image_data
                        ]);

                    }

                }
        
             
            }
        }

        return $this->render();
    }


}

?>