<?php
namespace controllers;

use core\Controller;
use core\Template;

//models
use models\Categories;
use models\MainBanner;
use models\Trends;

class SiteController extends Controller
{
        public function actionIndex()
        {   
            $categories = Categories::getAllWithEncodeImage();
            $bannerItems = MainBanner::getAllWithEncodeImage();
            $trendsItems = Trends::getAllWithEncodeImage();
            return $this->render(null,
            [
                'categories' => $categories,
                'bannerItems' => $bannerItems,
                'trendsItems' =>$trendsItems]);
        }
}

?>