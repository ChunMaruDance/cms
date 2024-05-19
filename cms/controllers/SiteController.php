<?php
namespace controllers;

use core\Controller;
use core\Template;
use models\Categories;

class SiteController extends Controller
{
    public function actionIndex()
    {   
        $categories = Categories::getAll();
        foreach ($categories as $category) {
            $category->image = 'data:image/png;base64,' . base64_encode($category->image);   
         }

        return $this->render(null,['categories'=>$categories]);
    }
}

?>