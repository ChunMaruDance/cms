<?php
namespace controllers;

use core\Controller;
use core\Template;
use models\Categories;

class SiteController extends Controller
{
    public function actionIndex()
    {   
        $categories = Categories::getAllWithEncodeImage();
        return $this->render(null,['categories' => $categories]);
    }
}

?>