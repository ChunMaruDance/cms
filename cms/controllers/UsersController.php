<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Users;
use models\Accessory;

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
                        //todo 
                    }

                }
        
             
            }
        }

        return $this->render();
    }


}

?>