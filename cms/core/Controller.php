<?php

namespace core;

use models\Users;

class Controller {

    protected $template;
    public $isPost = false;
    public $isGet = false;
    
    public $post;
    public $get;

    public function __construct(){
        
        $action = \core\Core::get()->actionName;
        $module = \core\Core::get()->moduleName;
        $path = "views/{$module}/{$action}.php"; 
        $this->template = new Template($path);

        switch($_SERVER['REQUEST_METHOD']){
            case 'POST' : $this->isPost = true;
            break;
            case 'GET' : $this->isGet = true;
            break;
        }

        $this->post = new Post();
        $this->get = new Get();

    }

    public function render($pathToView = null, $data = []){
       
        if($pathToView != null){
            $this->template->setTemplateFilePath($pathToView);
        }

        foreach ($data as $key => $value) {
            $this->template->setParam($key, $value);
        }
        return [   
            'Content'=> $this->template->getHTML()
        ];
    }

    public function redirect($path){
        header("Location: {$path}");
        die;
    }

    public function checkIsUserLoggin(){
        if(!Users::isUserLogged()){
            return $this->redirect('/');
            exit;
        }
    }

    public function setErrorMessage($message = null){
        $this->template->setParam('error_message', $message);
    }


}


?>