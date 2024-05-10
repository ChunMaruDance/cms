<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Accessory;

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

        var_dump($val);
        var_dump($val);
        var_dump($val);
        var_dump($val);
        // $db->insert('accessory',
        //     ['title'=>'New 2',
        //     'description' => 'desc test',
        //     'short_description' => 'desc short',
        //     'date'=>'2024-04-22 19:00:00',
        //     'price'=>32.12]
        // );

        // $db->delete('accessory',
        // ['title'=>'New 2']);


        //   $db->update('accessory',
        //   ['price' => 12.0],
        //     ['id'=>1]);
                
        // var_dump(Accessory::findByCategories('watch'));

        // Core::get()->session->set('');
       return $this->render();
    }

    public function actionView($params){
           return $this->render();
    }


}

?>