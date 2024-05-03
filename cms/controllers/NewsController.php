<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

class NewsController extends Controller{

    public function actionAdd(){
        return $this->render();
    }

    public function actionIndex($params){
        $db = Core::get()->db;

        $val = $db->select(
            'accessory a',
            'a.*', 
            [
                'JOIN category_accessory ca ON ca.accessory_id = a.id',
                'JOIN categories c ON c.id = ca.category_id'
            ], 
            [
                'c.title'=> $params[0]
            ]
        );

       return $this->render();
    }

    public function actionView($params){
           return $this->render();
    }
}

?>